<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\PriceListHeader;
use App\Models\OM\Settings\PriceListLine;
use App\Models\OM\Settings\Currency;
use App\Models\OM\Settings\ItemV;
use App\Models\OM\Settings\UOMV;
use App\Models\OM\Settings\SequenceEcom;

class PriceListController extends Controller
{
    public function index()
    {
        $headers = PriceListHeader::where('attribute1', 'DOMESTIC')->orderBy('list_header_id', 'asc')->get();

        return view('om.settings.price-list.domestic.index', compact('headers'));
    }

    public function create()
    {
        // dd('create');
        $currencies  = Currency::all();
        // $items       = ItemV::all();
        $uoms        = UOMV::where('domestic', 'Y')->get();

        // $items1  = SequenceEcom::when('start_date' != '', function ($q) {
        //             return $q->where('start_date', '<=', date("Y-m-d"));
        //         })
        //         ->when('end_date' != '', function ($q) {
        //             return $q->where('end_date', '>=', date("Y-m-d"));
        //         })
        //         ->where('sale_type_code', 'DOMESTIC')
        //         ->orWhere('start_date', null)
        //         ->orWhere('end_date', null)
        //         ->get();

        $items =  \DB::table('ptom_sequence_ecoms')
                    ->select('ptom_sequence_ecoms.item_id', 'ptom_sequence_ecoms.item_code', 'ptom_sequence_ecoms.ecom_item_description', 'ptom_sequence_ecoms.start_date', 'ptom_sequence_ecoms.end_date', 'ptom_sequence_ecoms.sale_type_code', 'ptom_item_v.uom')
                    ->join('ptom_item_v', 'ptom_item_v.inventory_item_id','=','ptom_sequence_ecoms.item_id')
                    ->when('start_date' != '', function ($q) {
                        return $q->where('start_date', '<=', date("Y-m-d"));
                    })
                    ->when('end_date' != '', function ($q) {
                        return $q->where('end_date', '>=', date("Y-m-d"));
                    })
                    ->orWhere('start_date', null)
                    ->orWhere('end_date', null)
                    ->where('sale_type_code', 'DOMESTIC')
                    ->orderBy('item_code', 'asc')
                    ->get();

        $header      = new PriceListHeader;

        return view('om.settings.price-list.domestic.create', compact('header', 'currencies', 'items', 'uoms'));
    }

    public function store(Request $request)
    {
        // $num = '1,200.50';
        // $test = explode(',', $num);

        // dd(request()->all());
        $old = PriceListHeader::where('name', request()->nameHeader)->first();

        if ($old) {
            return redirect()->back()->with('error', 'ชื่อรายการสินค้าซ้ำกับในระบบ');
        }

        $user = auth()->user();

        $dates_from       = request()->effective_dates_from ? date('Y-m-d', strtotime(request()->effective_dates_from)) : '';
        $dates_to         = request()->effective_dates_to   ? date('Y-m-d', strtotime(request()->effective_dates_to))   : '';
        // $dates_from       = request()->effective_dates_from ? parseFromDateTh(request()->effective_dates_from) : '';
        // $dates_to         = request()->effective_dates_to   ? parseFromDateTh(request()->effective_dates_to)   : '';

        if ($dates_from && $dates_to) {
            if ($dates_to < $dates_from) {
                return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
            }
        }

        
        
        // sleep(5);

        // $header->interface($header->web_batch_no);

        \DB::beginTransaction();
        try {

            $header                        = new PriceListHeader;
            $header->name                  = request()->nameHeader;
            $header->description           = request()->description;
            $header->currency              = request()->currency_code;
            $header->effective_dates_from  = $dates_from;
            $header->effective_dates_to    = $dates_to;
            $header->round_to              = '-2';
            $header->comments              = request()->comments;
            $header->active_flag           = request()->active_flag ? 'Y' : 'N';
            $header->attribute1            = 'DOMESTIC';
            $header->program_code          = 'OMS0012';
            $header->created_by            = $user->user_id;
            $header->last_updated_by       = $user->user_id;
            $header->web_batch_no          = uniqid();
            $header->interface_status      = 'N'; // N or U
            $header->save();
            // \DB::commit();

            // -----------------------------------------Line--------------------------------------------------------------------

            if (request()->listLine) {
                foreach (request()->listLine as $key => $data) {
                    $itemData = SequenceEcom::where('item_id', $data['item_id'])->first();   
        
                    $line = new PriceListLine;
                    $line->list_header_id          = $header->list_header_id;
                    $line->product_context         = 'Item';
                    $line->product_attribute       = 'Item Number';
                    $line->product_value           = $itemData->item_id;
                    $line->product_description     = $itemData->item_description;
                    $line->product_code            = $itemData->item_code;
                    $line->uom                     = $data['uom_code'];
                    $line->value                   = str_replace(',', '', $data['price']);
                    
                    // $line->start_date              = $data['start_date'] ? parseFromDateTh($data['start_date']) : '';
                    // $line->end_date                = $data['end_date']   ? parseFromDateTh($data['end_date'])   : '';

                    $line->start_date              = $data['start_date'] ? date('Y-M-d', strtotime($data['start_date'])) : '';
                    $line->end_date                = $data['end_date']   ? date('Y-M-d', strtotime($data['end_date']))   : '';

                    $line->program_code            = 'OMS0012';
                    $line->created_by              = $user->user_id;
                    $line->last_updated_by         = $user->user_id;
                    $line->web_batch_no            = $header->web_batch_no;
                    $line->interface_status        = 'N';
                    $line->primary_flag            = 'Y';
                    $line->line_type_id            = 0;
                    $line->line_type_name          = 'Price List Line';
                    $line->application_method_id   = 0;
                    $line->application_method      = 'Unit Price';
                    $line->save();
                }
            }


            // $header->interface($header->web_batch_no);

            $result = $header->interface($header->web_batch_no);
            // dd($header);

            if ($result['v_message']) {

                \DB::rollback();

                return redirect()->route('om.settings.price-list.index')->with('error', $result['v_message']);

            } else {

                \DB::commit();

                return redirect()->route('om.settings.price-list.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');
            }

        }  catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => [$e->getMessage()]], 422);
        }
    }

    public function show($id)
    {
        $header = PriceListHeader::find($id);

        return view('om.settings.price-list.domestic.show', compact('header'));
    }

    public function edit($id)
    {
        // $header      = PriceListHeader::where('list_header_id', $id)->with('listLines')->first();

        $header      = PriceListHeader::where('list_header_id', $id)->with('listLines', function ($q) {
                            $q->orderBy('product_code', 'asc')
                            ->orderBy('list_line_id', 'asc');
                        })->first();
        
        // dd($header);

        $currencies  = Currency::all();
        // $items       = ItemV::all();
        $uoms        = UOMV::where('domestic', 'Y')->get();

        // $items  = SequenceEcom::when('start_date' != '', function ($q) {
        //             return $q->where('start_date', '<=', date("Y-m-d"));
        //         })
        //         ->when('end_date' != '', function ($q) {
        //             return $q->where('end_date', '>=', date("Y-m-d"));
        //         })
        //         ->orWhere('start_date', null)
        //         ->orWhere('end_date', null)
        //         ->get();

        $items =  \DB::table('ptom_sequence_ecoms')
                ->select('ptom_sequence_ecoms.item_id', 'ptom_sequence_ecoms.item_code', 'ptom_sequence_ecoms.ecom_item_description', 'ptom_sequence_ecoms.start_date', 'ptom_sequence_ecoms.end_date', 'ptom_sequence_ecoms.sale_type_code', 'ptom_item_v.uom')
                ->join('ptom_item_v', 'ptom_item_v.inventory_item_id','=','ptom_sequence_ecoms.item_id')
                ->when('start_date' != '', function ($q) {
                    return $q->where('start_date', '<=', date("Y-m-d"));
                })
                ->when('end_date' != '', function ($q) {
                    return $q->where('end_date', '>=', date("Y-m-d"));
                })
                ->orWhere('start_date', null)
                ->orWhere('end_date', null)
                ->where('sale_type_code', 'DOMESTIC')
                ->orderBy('item_code', 'asc')
                ->get();

        $itemAlls =  \DB::table('ptom_sequence_ecoms')
                ->select('ptom_sequence_ecoms.item_id', 'ptom_sequence_ecoms.item_code', 'ptom_sequence_ecoms.ecom_item_description', 'ptom_sequence_ecoms.start_date', 'ptom_sequence_ecoms.end_date', 'ptom_sequence_ecoms.sale_type_code', 'ptom_item_v.uom')
                ->join('ptom_item_v', 'ptom_item_v.inventory_item_id','=','ptom_sequence_ecoms.item_id')
                ->where('sale_type_code', 'DOMESTIC')
                ->orderBy('item_code', 'asc')
                ->get();
                
        // dd($header, $items);

        return view('om.settings.price-list.domestic.edit', compact('header', 'currencies', 'items', 'uoms', 'itemAlls'));
    }

    public function update(Request $request, $id)
    {
        // dd('update', request()->all());

        $old = PriceListHeader::where('list_header_id', '!=', $id)->where('name', request()->nameHeader)->first();

        if ($old) {
            return redirect()->back()->with('error', 'ชื่อรายการสินค้าซ้ำกับในระบบ');
        }

        $user = auth()->user();

        $dates_from       = request()->effective_dates_from ? date('Y-m-d', strtotime(request()->effective_dates_from)) : '';
        $dates_to         = request()->effective_dates_to   ? date('Y-m-d', strtotime(request()->effective_dates_to))   : '';

        // $dates_from       = request()->effective_dates_from ? parseFromDateTh(request()->effective_dates_from) : '';
        // $dates_to         = request()->effective_dates_to   ? parseFromDateTh(request()->effective_dates_to)   : '';


        if ($dates_from && $dates_to) {
            if (request()->effective_dates_to < request()->effective_dates_from) {
                return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
            }
        }

        \DB::beginTransaction();
        try {
            // $startDate  = request()->effective_dates_from ? date('Y-M-d', strtotime(request()->effective_dates_from)) : '';
            // $endDate    = request()->effective_dates_to   ? date('Y-M-d', strtotime(request()->effective_dates_to))   : '';

            // $startDate  = request()->effective_dates_from ? parseFromDateTh(request()->effective_dates_from) : '';
            // $endDate    = request()->effective_dates_to   ? parseFromDateTh(request()->effective_dates_to)   : '';

            $activeFlag  = request()->active_flag ? 'Y' : 'N';

            $header                        = PriceListHeader::find($id);
            $header->name                  = request()->nameHeader;
            $header->description           = request()->description;
            $header->currency              = request()->currency_code;
            $header->effective_dates_from  = $dates_from;
            $header->effective_dates_to    = $dates_to;
            $header->round_to              = '-2';
            $header->comments              = request()->comments;
            $header->active_flag           = request()->active_flag ? 'Y' : 'N';
            $header->last_updated_by       = $user->user_id;
            $header->web_batch_no          = uniqid();
            $header->interface_status      = 'U'; // N or U
            $header->save();

            // \DB::commit();


             // -----------------------------------------Line--------------------------------------------------------------------

             if (request()->listLine) {
                foreach (request()->listLine as $key => $data) {
                    if ($data['status'] == 'update') {
        
                        $oldLine = PriceListLine::where('list_line_id', $key)->first();
                        $oldLine->list_header_id          = $header->list_header_id;
                        $oldLine->product_context         = 'Item';
                        $oldLine->product_attribute       = 'Item Number';
                        $oldLine->value                   = str_replace(',', '', $data['price']);

                        // $oldLine->start_date              = $data['start_date'] ? parseFromDateTh($data['start_date']) : '';
                        // $oldLine->end_date                = $data['end_date']   ? parseFromDateTh($data['end_date'])   : '';

                        $oldLine->start_date              = $data['start_date'] ? date('Y-M-d', strtotime($data['start_date'])) : '';
                        $oldLine->end_date                = $data['end_date']   ? date('Y-M-d', strtotime($data['end_date']))   : '';
                        
                        $oldLine->last_updated_by         = $user->user_id;
                        $oldLine->web_batch_no            = $header->web_batch_no;
                        $oldLine->interface_status        = $oldLine->price_list_line_id ? 'U' : 'N';
                        $oldLine->primary_flag            = 'Y';
                        $oldLine->line_type_id            = 0;
                        $oldLine->line_type_name          = 'Price List Line';
                        $oldLine->application_method_id   = 0;
                        $oldLine->application_method      = 'Unit Price';
                        $oldLine->save();

                    } else {
                        $itemData = SequenceEcom::where('item_id', $data['item_id'])->first();   
        
                        $newLine = new PriceListLine;
                        $newLine->list_header_id          = $header->list_header_id;
                        $newLine->product_context         = 'Item';
                        $newLine->product_attribute       = 'Item Number';
                        $newLine->product_value           = $itemData->item_id;
                        $newLine->product_description     = $itemData->item_description;
                        $newLine->product_code            = $itemData->item_code;
                        $newLine->uom                     = $data['uom_code'];
                        $newLine->value                   = str_replace(',', '', $data['price']);

                        // $newLine->start_date              = $data['start_date'] ? parseFromDateTh($data['start_date']) : '';
                        // $newLine->end_date                = $data['end_date']   ? parseFromDateTh($data['end_date'])   : '';

                        $newLine->start_date              = $data['start_date'] ? date('Y-M-d', strtotime($data['start_date'])) : '';
                        $newLine->end_date                = $data['end_date']   ? date('Y-M-d', strtotime($data['end_date']))   : '';

                        $newLine->program_code            = 'OMS0012';
                        $newLine->created_by              = $user->user_id;
                        $newLine->last_updated_by         = $user->user_id;
                        $newLine->web_batch_no            = $header->web_batch_no;
                        $newLine->interface_status        = 'N';
                        $newLine->primary_flag            = 'Y';
                        $newLine->line_type_id            = 0;
                        $newLine->line_type_name          = 'Price List Line';
                        $newLine->application_method_id   = 0;
                        $newLine->application_method      = 'Unit Price';
                        $newLine->save();
        
                        // dd(request()->listLine, $key, $data, $data['status']);
                    }
                    
                }
            }     

            // \DB::commit();

            // $header->interface($header->web_batch_no);
            $result = $header->interface($header->web_batch_no);

            if ($result['v_message']) {

                \DB::rollback();

                return redirect()->route('om.settings.price-list.index')->with('error', $result['v_message']);

            } else {

                \DB::commit();
                
                return redirect()->route('om.settings.price-list.index')->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');
            }

        }  catch (\Exception $e) {
            \DB::rollback();
            return response()->json(['errors' => [$e->getMessage()]], 422);
        }

        
    }
}
