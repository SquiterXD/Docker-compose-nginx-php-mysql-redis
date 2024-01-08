<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\ProductTypeExport;

class ProductTypeExportController extends Controller
{
    public function index()
    {
        $product_type = ProductTypeExport::get();
        return response()->json(['data' => $product_type]);
    }
}