<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Settings\ThailandTerritory;
use App\Models\OM\Settings\PtomNodeHeader;
use App\Models\OM\Settings\PtomNodeLine;

class NodeProvincesController extends Controller
{
    public function index()
    {
        $provinces = ThailandTerritory::
                        selectRaw('DISTINCT  province_thai, province_id')
                        ->orderBy('province_id')
                        ->get();
        $nodeHeaders = PtomNodeHeader::orderBy('node_name')
            ->get(['node_header_id','node_name','start_date','end_date','status']);
        $nodeHeaders->map(function($item){
            $item->province_ids = $item->lines()->pluck('province_id');
            $item->can_edit = false;
        });


        // dd($nodeHeaders);
        $userProfile = getDefaultData('/om/settings/node-province');
        return view('om.settings.node-province.index', compact('userProfile', 'provinces', 'nodeHeaders'));
    }

    public function store()
    {

        if(count(request()->province_ids) == 0){
            return response()->json(['status' => 'error']);
        }
        $ptomNodeHeader  = new  PtomNodeHeader;
        $ptomNodeHeader->node_name =  request()->node_name;
        $ptomNodeHeader->start_date  = now();
        $ptomNodeHeader->status     = 'active';
        $ptomNodeHeader->program_code = 'OMS0042';
        $ptomNodeHeader->created_at  = now();
        $ptomNodeHeader->created_by_id = 1;
        $ptomNodeHeader->created_by = 1;
        $ptomNodeHeader->last_updated_by = 1;
        $ptomNodeHeader->save();

        foreach (request()->province_ids as $key => $provinceId) {
            $province = ThailandTerritory::where('province_id', $provinceId)->first();
            $ptomNodeLine = new  PtomNodeLine;
            $ptomNodeLine->node_header_id   = $ptomNodeHeader->node_header_id;
            $ptomNodeLine->province_id      = $province->province_id;
            $ptomNodeLine->province_name    = $province->province_thai;
            $ptomNodeLine->program_code = 'OMS0042';
            $ptomNodeLine->created_at  = now();
            $ptomNodeLine->created_by_id = 1;
            $ptomNodeLine->created_by =1;
            $ptomNodeLine->last_updated_by = 1;
            $ptomNodeLine->save();
        }
        $ptomNodeHeader = PtomNodeHeader::where('node_header_id',  $ptomNodeHeader->node_header_id)
                        ->orderBy('node_name')
                        ->get(['node_header_id','node_name','start_date','end_date','status']);

        $ptomNodeHeader->map(function($item){
            $item->province_ids = $item->lines()->pluck('province_id');
            $item->can_edit = false;
        });

        return response()->json(['ptomNodeHeader' => $ptomNodeHeader]);
 
    }

    public function update($id)
    {
        $ptomNodeHeader  = PtomNodeHeader::find($id);
        $ptomNodeHeader->node_name =  request()->node_name;
        $ptomNodeHeader->start_date  = now();
        $ptomNodeHeader->status     = 'active';
        $ptomNodeHeader->last_updated_by = 1;
        $ptomNodeHeader->save();

        $ptomNodeHeader->lines()->delete();
        foreach (request()->province_ids as $key => $provinceId) {
            $province = ThailandTerritory::where('province_id', $provinceId)->first();
            $ptomNodeLine = new  PtomNodeLine;
            $ptomNodeLine->node_header_id   = $ptomNodeHeader->node_header_id;
            $ptomNodeLine->province_id      = $province->province_id;
            $ptomNodeLine->province_name    = $province->province_thai;
            $ptomNodeLine->program_code = 'OMS0042';
            $ptomNodeLine->created_at  = now();
            $ptomNodeLine->created_by_id = 1;
            $ptomNodeLine->created_by =1;
            $ptomNodeLine->last_updated_by = 1;
            $ptomNodeLine->save();
                
        }

        $ptomNodeHeader = PtomNodeHeader::where('node_header_id',  $ptomNodeHeader->node_header_id)
                        ->orderBy('node_name')
                        ->get(['node_header_id','node_name','start_date','end_date','status']);
        $ptomNodeHeader->map(function($item){
            $item->province_ids = $item->lines()->pluck('province_id');
            $item->can_edit = false;
        });

        return response()->json(['ptomNodeHeader' => $ptomNodeHeader]);
    }

    public function updateForm()
    {
        $request =  (object)request()->all();
        foreach ($request->nodeHeaders as $header) {
            $header = (object)$header;

            if(!$header->node_header_id){
                //  new Header
                $ptomNodeHeader  = new  PtomNodeHeader;
                $ptomNodeHeader->node_name =  $header->node_name;
                $ptomNodeHeader->start_date  =   $header->start_date ?  date('Y-M-d', strtotime($header->start_date))  : now();
                $ptomNodeHeader->end_date   =    $header->end_date ?  date('Y-M-d', strtotime($header->end_date))  : "";
                $ptomNodeHeader->status     = 'active';
                $ptomNodeHeader->program_code = 'OMS0042';
                $ptomNodeHeader->created_at  = now();
                $ptomNodeHeader->created_by_id = 1;
                $ptomNodeHeader->created_by = 1;
                $ptomNodeHeader->last_updated_by = 1;
                $ptomNodeHeader->save();

                    foreach ($header->province_ids as $key => $provinceId) {
                        $province = ThailandTerritory::where('province_id', $provinceId)->first();
                        $ptomNodeLine = new  PtomNodeLine;
                        $ptomNodeLine->node_header_id   = $ptomNodeHeader->node_header_id;
                        $ptomNodeLine->province_id      = $province->province_id;
                        $ptomNodeLine->province_name    = $province->province_thai;
                        $ptomNodeLine->program_code = 'OMS0042';
                        $ptomNodeLine->created_at  = now();
                        $ptomNodeLine->created_by_id = 1;
                        $ptomNodeLine->created_by =1;
                        $ptomNodeLine->last_updated_by = 1;
                        $ptomNodeLine->save();
                    }
            }else{
                //  update Header
                $ptomNodeHeader  = PtomNodeHeader::find($header->node_header_id);
                $ptomNodeHeader->node_name =  $header->node_name;
                $ptomNodeHeader->start_date  =  date('Y-M-d', strtotime($header->start_date)); 
                $ptomNodeHeader->end_date  =   $header->end_date ?  date('Y-M-d', strtotime($header->end_date)): "";
                // date('Y-M-d', strtotime($header->start_date));
                $ptomNodeHeader->status     = 'active';
                $ptomNodeHeader->last_updated_by = 1;
                $ptomNodeHeader->save();
        
                $ptomNodeHeader->lines()->delete();
                foreach ($header->province_ids as $key => $provinceId) {
                    $province = ThailandTerritory::where('province_id', $provinceId)->first();
                    $ptomNodeLine = new  PtomNodeLine;
                    $ptomNodeLine->node_header_id   = $ptomNodeHeader->node_header_id;
                    $ptomNodeLine->province_id      = $province->province_id;
                    $ptomNodeLine->province_name    = $province->province_thai;
                    $ptomNodeLine->program_code = 'OMS0042';
                    $ptomNodeLine->created_at  = now();
                    $ptomNodeLine->created_by_id = 1;
                    $ptomNodeLine->created_by =1;
                    $ptomNodeLine->last_updated_by = 1;
                    $ptomNodeLine->save();
                }
            }
        }

        $ptomNodeHeaders = PtomNodeHeader::orderBy('node_name')->get(['node_header_id','node_name','start_date','end_date','status']);
        $ptomNodeHeaders->map(function($item){
            $item->province_ids = $item->lines()->pluck('province_id');
            $item->can_edit = false;
        });

        return response()->json(['ptomNodeHeaders' => $ptomNodeHeaders]);

    }

    
    public function delete($id)
    {
        $ptomNodeHeader  = PtomNodeHeader::find($id);
        $ptomNodeHeader->lines()->delete();
        $ptomNodeHeader->delete();

        return response()->json(['status' => 'success']);
    }

    public function search()
    {
        $request = (object)request()->all();
        $node = $request->node;
        $province = $request->province;
        $ptomNodeHeaders = PtomNodeHeader::when($node , function($q) use ($node) {
                    $q->where('node_name' , $node);
                })
                ->when($province , function($q) use ($province) {
                    $q->whereHas('lines', function($line) use ($province){
                        $line->where('province_id', $province);
                    });
                })
                ->orderBy('node_name')
                ->get(['node_header_id','node_name','start_date','end_date','status']);

        $ptomNodeHeaders->map(function($item){
            $item->province_ids = $item->lines()->pluck('province_id');
            $item->can_edit = false;
        });

        return response()->json(['ptomNodeHeaders' => $ptomNodeHeaders]);
    }

    // public function fitter()
    // {
    //     $request =  (object)request()->all();

    // }

}
