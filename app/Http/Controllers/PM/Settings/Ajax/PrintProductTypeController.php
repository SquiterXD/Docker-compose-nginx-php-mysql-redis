<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PrintProductType;

class PrintProductTypeController extends Controller
{
    public function destroy(Request $request)
    {
        $productType = PrintProductType::find($request['flexValueId']);
        $productType -> delete();
    }
}
