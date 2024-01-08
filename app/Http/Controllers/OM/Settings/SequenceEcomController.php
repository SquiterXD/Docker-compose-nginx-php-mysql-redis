<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Settings\ItemV;
use App\Models\OM\Settings\SequenceEcom;
use App\Models\OM\Settings\SalesTypeV;
use App\Models\OM\Settings\TasteV;
use App\Models\OM\Settings\ProductTypeDomestic;
use App\Models\OM\Settings\ProductTypeExport;
use App\Models\OM\Settings\MappingAccount;
use App\Models\OM\Settings\MainAccount;
use App\Models\OM\Settings\SubAccount;
use App\Models\OM\Settings\ItemCategory;
use App\Models\OM\Settings\ItemGroup;

class SequenceEcomController extends Controller
{
    public function index()
    {
        $status = request()->status;

        $searchData = [
            'item_id'      => request()->item_id,
            'ecom_item'    => request()->ecom_item,
            'sales_type'   => request()->sales_type,
            'status'       => request()->status,
            'product_type' => request()->product_type,
        ];

        // dd(request()->all());
        // if (!canEnter('/om/settings/sequence-ecom') || !canView('/om/settings/sequence-ecom')) {
        //     return redirect()->back()->withError(trans('403'));
        // }
        $ecoms = SequenceEcom::search(request()->all())->orderBy('sequence_ecom_id', 'asc')->paginate(25);

        // dd(request()->all(), $ecoms);

        $sequenceEcoms         = SequenceEcom::get();
        $salesTypes            = SalesTypeV::all();
        $productTypeDomestics  = ProductTypeDomestic::all();
        $productTypeExports    = ProductTypeExport::all();

        return view('om.settings.sequence-ecom.index', compact('ecoms', 'salesTypes', 'sequenceEcoms', 'productTypeDomestics', 'productTypeExports', 'searchData'));
    }

    public function create()
    {
        $ItemCategories        = ItemCategory::all();
        // $items                 = ItemV::all();
        $salesTypes            = SalesTypeV::all();
        $tastes                = TasteV::all();
        $productTypeDomestics  = ProductTypeDomestic::all();
        $productTypeExports    = ProductTypeExport::all();
        $mainAccounts          = MainAccount::where('main_account', 'LIKE',  '4' . '%')->get();

        $setName = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        // dd($mainAccounts);
        $items = ItemV::orderBy('item_code')->limit(30)->get(); 

        return view('om.settings.sequence-ecom.create', compact('ItemCategories', 'items', 'salesTypes', 'tastes', 'productTypeDomestics', 'productTypeExports', 'mainAccounts', 'setName'));
    }

    public function store(Request $request)
    {
        // dd(request()->all());
        $user = auth()->user();
        $item = ItemV::find(request()->item_id);

        request()->validate([
            'item_id'               => 'required',
            'ecom_item_description' => 'required',
            'report_item_display'   => 'required',
            'sales_type'            => 'required',
            'product_type'          => 'required',
            'filter_flag'           => 'required',
        ], [
            'item_id.required'               => 'เลือกรหัสผลิตภัณฑ์',
            'ecom_item_description.required' => 'ระบุชื่อที่ปรากฏในหน้าจอ E-Commerce',
            'report_item_display.required'   => 'ระบุชื่อที่ปรากฏในรายงาน',
            'sales_type.required'            => 'เลือกประเภทการขาย',
            'product_type.required'          => 'เลือกชนิดผลิตภัณฑ์',
            'filter_flag.required'           => 'เลือกก้นกรอง',
        ]);

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $old = SequenceEcom::where('item_id', request()->item_id)->orderBy('sequence_ecom_id', 'desc')->first();
        
        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) <= date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);
            }
        }

        // dd('store', request()->all(), $old);
        
        $ecom                        = new SequenceEcom;
        $ecom->item_id               = request()->item_id;
        $ecom->item_code             = $item->item_code;
        $ecom->item_description      = $item->item_description;
        $ecom->item_category         = request()->item_category;
        $ecom->item_group            = request()->item_group;
        $ecom->ecom_item_description = request()->ecom_item_description;
        $ecom->report_item_display   = request()->report_item_display;
        $ecom->sale_type_code        = request()->sales_type;
        $ecom->product_type_code     = request()->product_type;
        $ecom->screen_number         = request()->screen_number;
        $ecom->filter_flag           = request()->filter_flag;
        $ecom->taste_code            = request()->taste_code;
        $ecom->main_account_code     = request()->main_account;
        $ecom->sub_account_code      = request()->sub_account;
        $ecom->program_code          = 'OMS0026';
        $ecom->created_by            = $user->user_id;
        $ecom->last_updated_by       = $user->user_id;
        $ecom->start_date            = $startDate;
        $ecom->end_date              = $endDate;
        $ecom->attribute1            = request()->out_of_stock ? 'Y' : 'N';
        $ecom->color_code            = request()->color_code;
        $ecom->save();

        return redirect()->route('om.settings.sequence-ecom.index')->with('success', 'บันทึกรายการเรียบร้อย');
    }

    public function edit($id)
    {
        // dd('edit');
        $ecom                  = SequenceEcom::find($id);
        $ItemCategories        = ItemCategory::all();
        $items                 = ItemV::all();
        $salesTypes            = SalesTypeV::all();
        $tastes                = TasteV::all();
        $productTypeDomestics  = ProductTypeDomestic::all();
        $productTypeExports    = ProductTypeExport::all();
        $mainAccounts          = MainAccount::where('main_account', 'LIKE',  '4' . '%')->get();
        $setName               = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';


        return view('om.settings.sequence-ecom.edit', compact('ecom', 'ItemCategories', 'items', 'salesTypes', 'tastes', 'productTypeDomestics', 'productTypeExports', 'mainAccounts', 'setName'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $item = ItemV::find(request()->item_id);

        request()->validate([
            // 'item_id'               => 'required',
            'ecom_item_description' => 'required',
            'report_item_display'   => 'required',
            'sales_type'            => 'required',
            'product_type'          => 'required',
            'filter_flag'           => 'required',
        ], [
            // 'item_id.required'               => 'เลือกรหัสผลิตภัณฑ์',
            'ecom_item_description.required' => 'ระบุชื่อที่ปรากฏในหน้าจอ E-Commerce',
            'report_item_display.required'   => 'ระบุชื่อที่ปรากฏในรายงาน',
            'sales_type.required'            => 'เลือกประเภทการขาย',
            'product_type.required'          => 'เลือกชนิดผลิตภัณฑ์',
            'filter_flag.required'           => 'เลือกก้นกรอง',
        ]);

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        // $old = SequenceEcom::where('sequence_ecom_id', '!=', $id)->orderBy('sequence_ecom_id', 'desc')->first();
        
        // if ($old) {
        //     if ($old->end_date) {
        //         if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($old->end_date))) {
        //             request()->validate([
        //                 'check_date'    => 'required',
        //             ], [
        //                 'check_date.required'    => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
        //             ]);
        //         }
        //     } else {
        //         request()->validate([
        //             'check_date'    => 'required',
        //         ], [
        //             'check_date.required'    => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
        //         ]);
        //     }
        // }

        // dd('store', request()->all());
        $ecom                        = SequenceEcom::find($id);
        $ecom->ecom_item_description = request()->ecom_item_description;
        $ecom->report_item_display   = request()->report_item_display;
        $ecom->sale_type_code        = request()->sales_type;
        $ecom->product_type_code     = request()->product_type;
        $ecom->screen_number         = request()->screen_number;
        $ecom->filter_flag           = request()->filter_flag;
        $ecom->taste_code            = request()->taste_code;
        $ecom->main_account_code     = request()->main_account;
        $ecom->sub_account_code      = request()->sub_account;
        $ecom->program_code          = 'OMS0026';
        $ecom->created_by            = $user->user_id;
        $ecom->last_updated_by       = $user->user_id;
        $ecom->start_date            = $startDate;
        $ecom->end_date              = $endDate;
        $ecom->attribute1            = request()->out_of_stock ? 'Y' : 'N';
        $ecom->color_code            = request()->color_code;
        $ecom->save();

        return redirect()->route('om.settings.sequence-ecom.index')->with('success', 'แก้ไขรายการเรียบร้อย');
    }
}
