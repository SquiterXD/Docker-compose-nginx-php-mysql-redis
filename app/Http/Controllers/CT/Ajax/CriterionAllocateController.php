<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\CriterionAllocate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriterionAllocateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = CriterionAllocate::all();
        return response()->json($result);
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $criterionAllocate = CriterionAllocate::find($request->criterion_allocate_id);

        DB::beginTransaction();
        try {
            $criterionAllocate->is_active = $request->is_active;
            $criterionAllocate->save();

            DB::commit();
            return response()->json(['msg' => "success"], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }
}
