<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PrintConversion;
use App\Models\PM\Settings\PrintItemCatV;

class PrintConversionController extends Controller
{
    public function destroy(Request $request)
    {
        $conversion = PrintConversion::query()
                                    ->where('category_segment1', $request['segment1'])
                                    ->where('category_segment2', $request['segment2'])
                                    ->where('tobacco_size', $request['tobaccoSize'])
                                    ->delete();
    }

    public function getPrintType(Request $request)
    {
        $printItemCat = $request['printItemCat'];
        $printTypeList = PrintItemCatV::selectRaw('distinct toat_segment1, toat_segment2, 
                                                            toat_description, cost_segment1, 
                                                            cost_description'                   )
                                        ->where('cost_segment1', $printItemCat)
                                        ->get();
        return response()->json(['printTypeList' => $printTypeList]);
    }
}
