<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Models\INV\AliasNameV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PtglAliasNameVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aliasNames = AliasNameV::query()
            ->where(function ($q) {
                $query = strtoupper(request()->text);
                if ($query) {
                    $q->whereRaw('UPPER(alias_name) like ?', "%{$query}%")
                        ->orWhereRaw('UPPER(description)  like ?', "%{$query}%");
                }
            })
            ->when("prefix", function ($q) {
                $prefixText = request()->prefix;
                $q->where('description', 'like', "{$prefixText}%");
            })
            ->limit(20)
            ->get();
        return response()->json($aliasNames);
    }
}
