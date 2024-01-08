<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\TerritoryV;

class TerritoryVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function province()
    {
        $province = TerritoryV::distinct('province_id')
        ->orderBy('province_thai','ASC')
        ->get(['province_id as id','province_thai as name_th','province_eng as name_en']);

        return response()->json(['data' => $province]);
    }

    public function district($province_id)
    {
        $district = TerritoryV::distinct('district_id')
        ->where('province_id',$province_id)
        ->orderBy('district_thai','ASC')
        ->get(['district_id as id','district_thai as name_th','district_eng as name_en']);

        return response()->json(['data' => $district]);
    }

    public function tambon($district_id)
    {
        $tambon = TerritoryV::distinct('tambon_id')
        ->where('district_id',$district_id)
        ->orderBy('tambon_thai','ASC')
        ->get(['tambon_id as id','tambon_thai as name_th','tambon_eng as name_en']);

        return response()->json(['data' => $tambon]);
    }

    public function postcode($tambon_id)
    {
        $postcode = TerritoryV::where('tambon_id',$tambon_id)->get(['postcode_all']);
        return response()->json(['data' => $postcode]);
    }

}