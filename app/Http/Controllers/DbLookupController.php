<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PM\Lookup\PtpmMaterialGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DbLookupController extends Controller
{
    public function lookup(Request $request)
    {
        $tableName = $request->get('tableName');
        $searchKeys = $request->get('searchKeys', []);
        $query = $request->get('query', '');
        $maxResults = $request->get('maxResults', 50);
        $filterBy = json_decode($request->get('filterBy', "{}"), true);

        $class = "App\\Models\\Lookup\\$tableName";
        if (!class_exists($class)) {
            return response()->json([
                'class' => $class,
                'message' => 'lookup_table_not_exist',
            ], 400);
        }

//        print_r("\n\ntableName");
//        print_r($tableName);
//
//        print_r("\n\npayload");
//        print_r($payload);
//
//        print_r("\n\nsearchKeys");
//        print_r($searchKeys);
//
//        print_r("\n\nquery");
//        print_r($query);

        $builder = $class::query();
        foreach ($filterBy as $field => $val) {
            $builder = $builder->where($field, $val);
        }

        if (trim($query) === '' || empty($searchKeys)) {
            $rows = $builder
                ->take($maxResults)
                ->get();
        } else {
            if (stripos($query, '%') === false) $query = "%$query%";
            $builder->where(function (Builder $builder) use ($searchKeys, $query) {
                foreach ($searchKeys as $searchKey) {
                    $builder = $builder->orWhereRaw(
                        "LOWER($searchKey) like ?",
                        [strtolower("%$query%")]
                    );
                }
            });
            $rows = $builder
                ->take($maxResults)
                ->get();
        }

        //return $builder->toSql();

        //remove row number (rn) which polluted our data object
        //the (rn) will be add to objects if take() is invoked
        foreach ($rows as $row) {
            unset($row['rn']);
        }

        return response()->json($rows);
    }
}
