<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\MaxStorage;
use App\Models\PM\Settings\ItemGroup;

class MaxStorageController extends Controller
{
    public function index(Request $request)
    {
        $maxStorages = MaxStorage::with(['itemGroup', 'uom', 'organization'])->skip($request->start)->take($request->length)->get();
        if ($request->ajax()) {
            $recordsFiltered =  MaxStorage::count();

            $recordsTotal =  MaxStorage::count();
            $maxStorages = $maxStorages->map(function ($item) {
                $item->max_qty = number_format($item->max_qty);
                $item->_html_enable_flag = view('shared._status_active', ['isActive' => $item->enable_flag == 'Y'])->render();
                $item->organization_label = $item->organization ? $item->organization->organization_code . ' : ' . $item->organization->organization_name : '';
                $item->action = $item->id ? '<a href="' . route('pm.settings.max-storage.edit', $item->id) . '" class="btn btn-warning btn-xs">
                <i class="fa fa-edit m-r-xs"></i> แก้ไข
            </a>' : '';
                return $item;
            });

            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $maxStorages,
            ]);
        }
        return view('pm.settings.max-storage.index', compact('maxStorages'));
    }

    public function create()
    {
        $itemGroups = ItemGroup::where('enabled_flag', 'Y')->get();

        return view('pm.settings.max-storage.create', compact('itemGroups'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $checkDuplicate  = MaxStorage::where('item_cat_code', request()->item_cat_code)->first();

        if ($checkDuplicate) {
            request()->validate([
                'check_dup'  => 'required',
            ], [
                'check_dup.required'  => 'ไม่สามารถเลือกประเภทวัตถุดิบซ้ำกับในระบบ',
            ]);
        }

        $maxStorage = new MaxStorage;
        $maxStorage->organization_id = $user->organization_id;
        $maxStorage->item_cat_code   = request()->item_cat_code;
        $maxStorage->max_qty         = str_replace(',','',request()->max_qty);
        $maxStorage->uom_code        = request()->uom_code;
        $maxStorage->enable_flag     = request()->enable_flag ? 'Y' : 'N';
        $maxStorage->program_id      = 'PMS0030';
        $maxStorage->created_by      = $user->user_id;
        $maxStorage->save();

        return redirect()->route('pm.settings.max-storage.index')->with('success', 'ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $itemGroups = ItemGroup::where('enabled_flag', 'Y')->get();

        $maxStorage = MaxStorage::find($id);


        return view('pm.settings.max-storage.edit', compact('itemGroups', 'maxStorage'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $checkDuplicate  = MaxStorage::where('id', '!=', $id)->where('item_cat_code', request()->item_cat_code)->first();

        if ($checkDuplicate) {
            request()->validate([
                'check_dup'  => 'required',
            ], [
                'check_dup.required'  => 'ไม่สามารถเลือกประเภทวัตถุดิบซ้ำกับในระบบ',
            ]);
        }

        $maxStorage = MaxStorage::find($id);
        $maxStorage->item_cat_code    = request()->item_cat_code;
        $maxStorage->max_qty         = str_replace(',','',request()->max_qty);
        $maxStorage->uom_code         = request()->uom_code;
        $maxStorage->enable_flag      = request()->enable_flag ? 'Y' : 'N';
        $maxStorage->last_updated_by  = $user->user_id;
        $maxStorage->save();

        return redirect()->route('pm.settings.max-storage.index')->with('success', 'ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
