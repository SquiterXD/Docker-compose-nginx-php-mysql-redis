<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\ItemWeight;
use App\Models\OM\Settings\SequenceEcom;
use App\Models\OM\Settings\UOMV;

class ItemWeightController extends Controller
{
    public function index()
    {
        // if (!canEnter('/om/settings/item-weight') || !canView('/om/settings/item-weight')) {
        //     return redirect()->back()->withError(trans('403'));
        // }
        $itemWeights = ItemWeight::orderBy('item_code', 'asc')->paginate(15);

        return view('om.settings.item-weight.index', compact('itemWeights'));
    }

    public function create()
    {

        $sequenceEcoms  = SequenceEcom::when('start_date' != '', function ($q) {
                return $q->where('start_date', '<=', date("Y-m-d"));
            })
            ->when('end_date' != '', function ($q) {
                return $q->where('end_date', '>=', date("Y-m-d"));
            })
            ->orWhere('start_date', null)
            ->where('sale_type_code', 'EXPORT')
            ->orWhere('end_date', null)
            ->where('sale_type_code', 'EXPORT')
            ->get();

        $uoms = UOMV::where('export', 'Y')->get();

        return view('om.settings.item-weight.create', compact('sequenceEcoms', 'uoms'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'item_id'     => 'required',
            'uom_code'    => 'required',
        ], [
            'item_id.required'      => 'เลือกรหัสสินค้า',
            'uom_code.required'     => 'เลือก uom',
        ]);

        $user = auth()->user();

        $startDate       = request()->start_date ? date(trans('date.format-date'), strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date(trans('date.format-date'), strtotime(request()->end_date))   : '';

        if (request()->start_date && request()->end_date) {
            if (date(trans('date.format-date'), strtotime(request()->end_date)) < date(trans('date.format-date'), strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $old = ItemWeight::where('item_id', request()->item_id)->orderBy('weight_id', 'desc')->first();

        if ($old) {
            if ($old->end_date) {
                if (date(trans('date.format-date'), strtotime(request()->start_date)) < date(trans('date.format-date'), strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ไม่สามารถเลือกสิ้นค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกสิ้นค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);
            }
        }

        $sequenceEcom = SequenceEcom::where('item_id', request()->item_id)->first();

        $itemWeight = new ItemWeight;
        $itemWeight->item_id          = $sequenceEcom->item_id;
        $itemWeight->item_code        = $sequenceEcom->item_code;
        $itemWeight->item_description = $sequenceEcom->ecom_item_description;
        $itemWeight->uom              = request()->uom_code;
        $itemWeight->net_weight       = request()->net_weight;
        $itemWeight->net_gross        = request()->net_gross;
        $itemWeight->active_flag      = request()->active_flag ? 'Y' : 'N';
        $itemWeight->program_code     = 'OMS0031';
        $itemWeight->created_by       = $user->user_id;
        $itemWeight->last_updated_by  = $user->user_id;
        $itemWeight->start_date       = $startDate;
        $itemWeight->end_date         = $endDate;

        $itemWeight->length           = str_replace(',', '', request()->length);
        $itemWeight->width            = str_replace(',', '', request()->width);
        $itemWeight->height           = str_replace(',', '', request()->height);
        $itemWeight->save();

        return redirect()->route('om.settings.item-weight.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');

    }
    
    public function edit($id)
    {
        $itemWeight = ItemWeight::find($id);
        
        $sequenceEcoms  = SequenceEcom::when('start_date' != '', function ($q) {
                    return $q->where('start_date', '<=', date("Y-m-d"));
                })
                ->when('end_date' != '', function ($q) {
                    return $q->where('end_date', '>=', date("Y-m-d"));
                })
                ->orWhere('start_date', null)
                ->where('sale_type_code', 'EXPORT')
                ->orWhere('end_date', null)
                ->where('sale_type_code', 'EXPORT')
                ->get();

        $uoms = UOMV::where('export', 'Y')->get();

        return view('om.settings.item-weight.edit', compact('itemWeight', 'sequenceEcoms', 'uoms'));
        
    }
    
    public function update(Request $request, $id)
    {
        request()->validate([
            'item_id'      => 'required',
            'uom_code'     => 'required',
        ], [
            'item_id.required'     => 'เลือกรหัสสินค้า',
            'uom_code.required'    => 'เลือก uom',
        ]);
        $user = auth()->user();

        $startDate       = request()->start_date ? date(trans('date.format-date'), strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date(trans('date.format-date'), strtotime(request()->end_date))   : '';

        if (request()->start_date && request()->end_date) {
            if (date(trans('date.format-date'), strtotime(request()->end_date)) < date(trans('date.format-date'), strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }
        $old = ItemWeight::where('weight_id', '!=', $id)
                            ->where('item_id', request()->item_id)
                            ->orderBy('weight_id', 'desc')
                            ->first();
        
        if ($old) {
            if ($old->end_date) {
                if (date(trans('date.format-date'), strtotime(request()->start_date)) < date(trans('date.format-date'), strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ไม่สามารถเลือกสิ้นค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกสิ้นค้าเดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);
            }
        }

        $itemWeight = ItemWeight::find($id);
        $itemWeight->uom              = request()->uom_code;
        $itemWeight->net_weight       = request()->net_weight;
        $itemWeight->net_gross        = request()->net_gross;
        $itemWeight->active_flag      = request()->active_flag ? 'Y' : 'N';
        $itemWeight->last_updated_by  = $user->user_id;
        $itemWeight->start_date       = $startDate;
        $itemWeight->end_date         = $endDate;

        $itemWeight->length           = str_replace(',', '', request()->length);
        $itemWeight->width            = str_replace(',', '', request()->width);
        $itemWeight->height           = str_replace(',', '', request()->height);
        $itemWeight->save();

        return redirect()->route('om.settings.item-weight.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');

    }
    
}
