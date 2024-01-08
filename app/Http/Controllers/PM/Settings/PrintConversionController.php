<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Arr;

use App\Models\PM\Settings\PrintConversion;
use App\Models\PM\Settings\PrintProductType;
use App\Models\PM\Settings\LookupValues;
use App\Models\PM\Settings\PrintItemCatV;

class PrintConversionController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $userOrganizationId = getDefaultData('/pm/settings/print-conversion')->organization_id;
        $printTypeCode = (new \App\Repositories\PM\PmPrintRepo)->getPrintTypeCode();
        $defaultPrintItemCat = PrintItemCatV::selectRaw('distinct cost_segment1,cost_description')
                                            ->where('cost_segment1', $printTypeCode->gravure)
                                            ->value('cost_segment1');
        if(request()->search == null){
            $search['printItemCat'] = $defaultPrintItemCat;
            $search['category'] = null;
            $search['tobaccoSize'] = null;
        }else{
            $search = request()->search;
        }
        $listConversion = PrintConversion::search($search)
                                        ->orderBy('category_segment2')
                                        ->with('lookupValues')
                                        ->paginate('20');
        $printItemCatList = PrintItemCatV::selectRaw('distinct cost_segment1,cost_description')
                                        ->get();
        $listConversion->map(function ($item, $key) {
            $item->e00_to_bobbin = (int) $item->e00_to_bobbin;
            $item->bobbin_to_rol = (int) $item->bobbin_to_rol;
            $item->e00_to_rol = (int) $item->e00_to_rol;
            $item->e00_to_ca1 = (int) $item->e00_to_ca1;
            $item->ca1_to_rol = (int) $item->ca1_to_rol;
            $item->cg_to_e18 = (int) $item->cg_to_e18;
            $item->meter_to_rol = (int) $item->meter_to_rol;
            $item->is_select = true;
            $item->enableFlag = $item->enable_flag == 'Y' ? true : false;
        });
        $tableLookupValues = (new LookupValues)->getTable();
        $lookupValues = \DB::select("   select  lookup_code,
                                                meaning 
                                        from    {$tableLookupValues}
                                        where   lookup_type = 'PTPP_PRODUCT_TYPES' 
                                        and attribute1 = 'MG6'                           ");
            
        return  view('pm.settings.print-conversion.index', 
                compact('listConversion', 'lookupValues', 
                        'btnTrans', 'printItemCatList', 'search',
                        'defaultPrintItemCat', 'printTypeCode'));
    }

    public function createOrUpdate (Request $request)
    {
        $profile = getDefaultData('/pm/settings/print-conversion');
        // $this->validate($request,[
        //     'newDataGroup.*.category' => 'required',
        //     'newDataGroup.*.lookupValues' => 'required',
        // ],[
        //     'newDataGroup.*.category.required' => 'กรุณาเลือก ประเภทสิ่งพิมพ์', 
        //     'newDataGroup.*.lookupValues.required' => 'กรุณาเลือก ขนาดบุหรี่', 
        // ]);
        $this->validate($request,[
            'newDataGroup.*.category' => 'required',
        ],[
            'newDataGroup.*.category.required' => 'กรุณาเลือก ประเภทสิ่งพิมพ์', 
        ]);

        \DB::beginTransaction();
        try {
            
            if($request->newDataGroup){
                foreach ($request->newDataGroup as $key => $data) {
                    $printItemCatDescription = PrintItemCatV::selectRaw('distinct cost_segment1,cost_description')
                                                            ->where('cost_segment1', $data['printItemCat'])
                                                            ->value('cost_description');
                    $segment = explode('.', $data['category']);
                    $segment1 = Arr::get($segment, '0');
                    $segment2 = Arr::get($segment, '1');
                    $categorySetName = PrintProductType::where('category_segment', $data['category'])
                                                        ->value('description');

                    $checkDuplicateData = PrintConversion::where('category_set_name', $categorySetName)
                                                        ->where('category_segment1',  $segment1)
                                                        ->where('category_segment2',  $segment2)
                                                        ->where('cost_category_segment1',  $data['printItemCat'])
                                                        ->where('tobacco_size', $data['lookupValues'])
                                                        ->first();
                    if($checkDuplicateData){
                        return redirect()->back()->with('error','มีการแปลงหน่วยสิ่งพิมพ์อยู่แล้ว');
                    }

                    $conversion                         = new PrintConversion();
                    $conversion->category_set_name      = $categorySetName;
                    $conversion->category_segment1      = $segment1;
                    $conversion->category_segment2      = $segment2;
                    $conversion->tobacco_size           = $data['lookupValues'];
                    $conversion->e00_to_bobbin          = array_key_exists('e00_to_bobbin', $data) ? $data['e00_to_bobbin'] : '';
                    $conversion->bobbin_to_rol          = array_key_exists('bobbin_to_rol', $data) ? $data['bobbin_to_rol'] : '';
                    $conversion->e00_to_rol             = array_key_exists('e00_to_rol', $data) ? $data['e00_to_rol'] : '';
                    $conversion->e00_to_ca1             = array_key_exists('e00_to_ca1', $data) ? $data['e00_to_ca1'] : '';
                    $conversion->ca1_to_rol             = array_key_exists('ca1_to_rol', $data) ? $data['ca1_to_rol'] : '';
                    $conversion->cg_to_e18              = array_key_exists('cg_to_e18', $data) ? $data['cg_to_e18'] : '';
                    $conversion->meter_to_rol           = array_key_exists('meter_to_rol', $data) ? $data['meter_to_rol'] : '';
                    $conversion->st_to_pg               = array_key_exists('st_to_pg', $data) ? $data['st_to_pg'] : '';
                    $conversion->molding_layout         = array_key_exists('molding_layout', $data) ? $data['molding_layout'] : '';
                    $conversion->paper_layout           = array_key_exists('paper_layout', $data) ? $data['paper_layout'] : '';
                    $conversion->enable_flag            = $data['enable_flag'] == 'true' ? 'Y' : 'N';
                    $conversion->cost_category_set_name = $printItemCatDescription;
                    $conversion->cost_category_segment1 = $data['printItemCat'];
                    $conversion->program_id             = $profile->program_code;
                    $conversion->last_updated_by        = $profile->user_id;
                    $conversion->last_update_date       = now();
                    $conversion->created_by_id          = $profile->user_id;
                    $conversion->updated_by_id          = $profile->user_id;

                    $conversion->save();
                }

                if($request->updateDataGroup){
                    foreach ($request->updateDataGroup as $key => $data) {
                        // $conversion = PrintConversion::where('category_segment1', $data['category_segment1'])
                        //                                 ->where('category_segment2', $data['category_segment2'])
                        //                                 ->where('tobacco_size', $data['tobacco_size'])
                        //                                 ->where('cost_category_segment1', $data['cost_category_segment1'])
                        //                                 ->update([  'e00_to_bobbin'     => $data['e00_to_bobbin'] ? $data['e00_to_bobbin'] : '',
                        //                                             'bobbin_to_rol'     => $data['bobbin_to_rol'] ? $data['bobbin_to_rol'] : '',
                        //                                             'e00_to_rol'        => $data['e00_to_rol'] ? $data['e00_to_rol'] : '',
                        //                                             'e00_to_ca1'        => $data['e00_to_ca1'] ? $data['e00_to_ca1'] : '',
                        //                                             'ca1_to_rol'        => $data['ca1_to_rol'] ? $data['ca1_to_rol'] : '',
                        //                                             'cg_to_e18'         => $data['cg_to_e18'] ? $data['cg_to_e18'] : '',
                        //                                             'enable_flag'       => $data['enable_flag'] == 'true' ? 'Y' : 'N',
                        //                                             'last_updated_by'   => $profile->user_id,
                        //                                             'last_update_date'  => now(),
                        //                                             'updated_by_id'     => $profile->user_id]);
                        $conversion = PrintConversion::where('id', $data['id'])                                                    
                                                    ->update([  'e00_to_bobbin'     => array_key_exists('e00_to_bobbin', $data) ? $data['e00_to_bobbin'] : '',
                                                                'bobbin_to_rol'     => array_key_exists('bobbin_to_rol', $data) ? $data['bobbin_to_rol'] : '',
                                                                'e00_to_rol'        => array_key_exists('e00_to_rol', $data) ? $data['e00_to_rol'] : '',
                                                                'e00_to_ca1'        => array_key_exists('e00_to_ca1', $data) ? $data['e00_to_ca1'] : '',
                                                                'ca1_to_rol'        => array_key_exists('ca1_to_rol', $data) ? $data['ca1_to_rol'] : '',
                                                                'cg_to_e18'         => array_key_exists('cg_to_e18', $data) ? $data['cg_to_e18'] : '',
                                                                'meter_to_rol'      => array_key_exists('meter_to_rol', $data) ? $data['meter_to_rol'] : '',
                                                                'st_to_pg'          => array_key_exists('st_to_pg', $data) ? $data['st_to_pg'] : '',
                                                                'molding_layout'    => array_key_exists('molding_layout', $data) ? $data['molding_layout'] : '',
                                                                'paper_layout'      => array_key_exists('paper_layout', $data) ? $data['paper_layout'] : '',
                                                                'enable_flag'       => $data['enable_flag'] == 'true' ? 'Y' : 'N',
                                                                'last_updated_by'   => $profile->user_id,
                                                                'last_update_date'  => now(),
                                                                'updated_by_id'     => $profile->user_id]);
                    }
                }
            }else {
                foreach ($request->updateDataGroup as $key => $data) {
                    // $conversion = PrintConversion::where('category_segment1', $data['category_segment1'])
                    //                                 ->where('category_segment2', $data['category_segment2'])
                    //                                 ->where('tobacco_size', $data['tobacco_size'])
                    //                                 ->where('cost_category_segment1', $data['cost_category_segment1'])
                    //                                 ->update([  'e00_to_bobbin'     => $data['e00_to_bobbin'] ? $data['e00_to_bobbin'] : '',
                    //                                             'bobbin_to_rol'     => $data['bobbin_to_rol'] ? $data['bobbin_to_rol'] : '',
                    //                                             'e00_to_rol'        => $data['e00_to_rol'] ? $data['e00_to_rol'] : '',
                    //                                             'e00_to_ca1'        => $data['e00_to_ca1'] ? $data['e00_to_ca1'] : '',
                    //                                             'ca1_to_rol'        => $data['ca1_to_rol'] ? $data['ca1_to_rol'] : '',
                    //                                             'cg_to_e18'         => $data['cg_to_e18'] ? $data['cg_to_e18'] : '',
                    //                                             'enable_flag'       => $data['enable_flag'] == 'true' ? 'Y' : 'N',
                    //                                             'last_updated_by'   => $profile->user_id,
                    //                                             'last_update_date'  => now(),
                    //                                             'updated_by_id'     => $profile->user_id]);
                    $conversion = PrintConversion::where('id', $data['id'])                                                    
                                                    ->update([  'e00_to_bobbin'     => array_key_exists('e00_to_bobbin', $data) ? $data['e00_to_bobbin'] : '',
                                                                'bobbin_to_rol'     => array_key_exists('bobbin_to_rol', $data) ? $data['bobbin_to_rol'] : '',
                                                                'e00_to_rol'        => array_key_exists('e00_to_rol', $data) ? $data['e00_to_rol'] : '',
                                                                'e00_to_ca1'        => array_key_exists('e00_to_ca1', $data) ? $data['e00_to_ca1'] : '',
                                                                'ca1_to_rol'        => array_key_exists('ca1_to_rol', $data) ? $data['ca1_to_rol'] : '',
                                                                'cg_to_e18'         => array_key_exists('cg_to_e18', $data) ? $data['cg_to_e18'] : '',
                                                                'meter_to_rol'      => array_key_exists('meter_to_rol', $data) ? $data['meter_to_rol'] : '',
                                                                'st_to_pg'          => array_key_exists('st_to_pg', $data) ? $data['st_to_pg'] : '',
                                                                'molding_layout'    => array_key_exists('molding_layout', $data) ? $data['molding_layout'] : '',
                                                                'paper_layout'      => array_key_exists('paper_layout', $data) ? $data['paper_layout'] : '',
                                                                'enable_flag'       => $data['enable_flag'] == 'true' ? 'Y' : 'N',
                                                                'last_updated_by'   => $profile->user_id,
                                                                'last_update_date'  => now(),
                                                                'updated_by_id'     => $profile->user_id]);
                }
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }
        return redirect()->route('pm.settings.print-conversion.index')->with('success','ทำการเปลี่ยนแปลง การแปลงหน่วยสิ่งพิมพ์ เรียบร้อยแล้ว');
    }
}
