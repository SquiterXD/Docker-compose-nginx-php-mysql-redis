<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Models\CT\AccountCodeLedger;
use App\Models\CT\AccountCodeLedgerDetail;
use App\Models\CT\AccountCodeDetailsV;
use App\Models\CT\ProductGroupV;
use App\Models\CT\TobaccoItemcatSeg1V;
use App\Models\CT\PtinvOrganizationsInfo;
use App\Models\CT\PtglAccountsInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountCodeLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'account_seq' => 'required',
    //         'remark_reason' => 'required',
    //         'res1' => 'required',
    //         'res2' => 'required',
    //         'ledger_details' => 'required',
    //     ]);

    //     \DB::beginTransaction();
    //     try {
    //         $accountCodeLedger = AccountCodeLedger::create([
    //             'account_seq' => $request->account_seq,
    //             'remark_reason' => $request->remark_reason,
    //             'res1' => $request->res1,
    //             'res2' => $request->res2,
    //         ]);

    //         foreach ($request->ledger_details as $ledger_detail) {
    //             $ledger_detail['ac_ledger_id'] = $accountCodeLedger->ac_ledger_id;
    //             AccountCodeLedgerDetail::create($ledger_detail);
    //         }

    //         \DB::commit();

    //         return response()->json(['msg' => 'success'], 200);
    //     } catch (\Exception $e) {
    //         \DB::rollBack();

    //         return response()->json([
    //             'msg' => 'error',
    //             'error' => $e->getMessage()
    //         ], 403);
    //     }

    // }
    public function store(Request $request)
    {
        // dd('store', request()->all());
        $request->validate([
            'account_seq' => 'required',
            'organization_id' => 'required',
        ]);

        \DB::beginTransaction();
        try {
            $checkHeader = AccountCodeLedger::where('account_id', $request->account_seq)->first();
            if ($checkHeader) {
                $accountCodeLedger = AccountCodeLedger::where('account_id', $request->account_seq)->first();
            } else {
                $accountCodeLedger = AccountCodeLedger::create([
                    'account_seq'  => $request->account_seq,
                    'program_code' => 'CTM0006'
                ]);
            }

            // dd($request->product_group_id);

            $org = PtinvOrganizationsInfo::where('organization_id', $request->organization_id)->first();
            // dd($org);
            $line = new AccountCodeLedgerDetail;
            $line->ac_ledger_id       = $accountCodeLedger->ac_ledger_id;
            $line->code_segment1      = $request->code_segment1; 
            $line->code_segment2      = $request->code_segment2; 
            $line->code_segment3      = $request->code_segment3;
            $line->code_segment4      = $request->code_segment4;
            $line->code_segment5      = $request->code_segment5;
            $line->code_segment6      = $request->code_segment6;
            $line->code_segment7      = $request->code_segment7;
            $line->code_segment8      = $request->code_segment8;
            $line->code_segment9      = $request->code_segment9;
            $line->code_segment10     = $request->code_segment10;
            $line->code_segment11     = $request->code_segment11; 
            $line->code_segment12     = $request->code_segment12;
            $line->enable_flag        = $request->enable_flag ? 'Y' : 'N';
            $line->organization_id    = $request->organization_id;
            $line->tobacco_group_code = $request->tobacco_group_code;
            $line->product_group      = $request->product_group;
            $line->start_date         = $request->start_date ? date('Y-M-d', strtotime($request->start_date)) : '';
            $line->end_date           = $request->end_date   ? date('Y-M-d', strtotime($request->end_date)) : '';
            $line->program_code       = 'CTM0006';
            $line->department_code    = $org ? $org->department_code : '';
            $line->cost_code          = $org ? $org->cost_code : '';
            $line->save();
            
            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }

    }

    public function update(Request $request)
    {
        $request->validate([
            'organization_id' => 'required',
        ]);
        
        \DB::beginTransaction();
        try {

            $org = PtinvOrganizationsInfo::where('organization_id', $request->organization_id)->first();
            // dd($org);
            $detail = AccountCodeLedgerDetail::find(request()->ac_ledger_detail_id);
            // dd('update', request()->all(), $detail, $org);
            $detail->code_segment1      = $request->code_segment1; 
            $detail->code_segment2      = $request->code_segment2; 
            $detail->code_segment3      = $request->code_segment3;
            $detail->code_segment4      = $request->code_segment4;
            $detail->code_segment5      = $request->code_segment5;
            $detail->code_segment6      = $request->code_segment6;
            $detail->code_segment7      = $request->code_segment7;
            $detail->code_segment8      = $request->code_segment8;
            $detail->code_segment9      = $request->code_segment9;
            $detail->code_segment10     = $request->code_segment10;
            $detail->code_segment11     = $request->code_segment11; 
            $detail->code_segment12     = $request->code_segment12;
            $detail->enable_flag        = $request->enable_flag ? 'Y' : 'N';
            $detail->organization_id    = $request->organization_id;
            $detail->tobacco_group_code = $request->tobacco_group_code;
            $detail->product_group      = $request->product_group;
            $detail->start_date         = $request->start_date ? date('Y-M-d', strtotime($request->start_date)) : '';
            $detail->end_date           = $request->end_date   ? date('Y-M-d', strtotime($request->end_date)) : '';
            $detail->program_code       = 'CTM0006';
            $detail->department_code    = $org ? $org->department_code : '';
            $detail->cost_code          = $org ? $org->cost_code : '';
            $detail->save();
            
            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    // public function getDetail(Request $request)
    // {
    //     $acLedgerId = request()->get('ac_ledger_id', false);
       
    //     // W. 11/07/22 -เพิ่มค้นหารหัสบัญชีและหน่วยงานได้
    //     $accountCode    = request()->get('account_code', false);
    //     $departmentCode = request()->get('department_code', false);
    //     $accounts    = [];
    //     $departments = [];

    //     if ($acLedgerId) {
    //         // W. 11/07/22 -เพิ่มค้นหารหัสบัญชีและหน่วยงานได้

    //         $list = AccountCodeDetailsV::where('ac_ledger_id', $acLedgerId)
    //                     ->when($accountCode, function($q) use($accountCode) {
    //                         $q->where('code_segment9', $accountCode);
    //                     })
    //                     ->when($departmentCode, function($q) use($departmentCode) {
    //                         $q->where('code_segment3', $departmentCode);
    //                     })
    //                     ->with('acLedger')
    //                     ->orderBy('ac_ledger_detail_id', 'asc')
    //                     ->get();

            
    //         $accounts = AccountCodeDetailsV::selectRaw('distinct code_segment9 as value, segment9_desc as label')
    //                     ->where('ac_ledger_id', $acLedgerId)
    //                     ->orderBy('code_segment9', 'asc')
    //                     ->get();

    //         $departments = AccountCodeDetailsV::selectRaw('distinct code_segment3 as value, segment3_desc as label')
    //                     ->where('ac_ledger_id', $acLedgerId)
    //                     ->orderBy('code_segment3', 'asc')
    //                     ->get();
    //     }else {
    //         $list = AccountCodeDetailsV::with('acLedger')
    //                 ->orderBy('ac_ledger_id', 'asc')
    //                 ->orderBy('ac_ledger_detail_id', 'asc')
    //                 ->get();
    //     }

    //     $data = [
    //         'data'        => $list,
    //         'accounts'    => $accounts,
    //         'departments' => $departments,
    //     ];

    //     return response()->json($data);
    // }

    public function getDetail(Request $request)
    {
        $acLedgerId     = request()->get('ac_ledger_id', false);
        $accountCode    = request()->get('account_code', false);
        $departmentCode = request()->get('department_code', false);
        $costCenter = request()->get('cost_center', false);

        $acLedgerList    = [];
        $accountList     = [];
        $departmentList  = [];
        $costCenterList  = [];

        $list = AccountCodeDetailsV::query();

        if ($acLedgerId || $accountCode || $departmentCode || $costCenter) {

            $list = $list->when($acLedgerId, function($q) use($acLedgerId) {
                            $q->where('ac_ledger_id', $acLedgerId);
                        })
                        ->when($accountCode, function($q) use($accountCode) {
                            $q->where('code_segment9', $accountCode);
                        })
                        ->when($departmentCode, function($q) use($departmentCode) {
                            $q->where('code_segment3', $departmentCode);
                        })
                        ->when($costCenter, function($q) use($costCenter) {
                            $q->where('code_segment4', $costCenter);
                        })
                        ->with('acLedger');

            $dataTable = AccountCodeDetailsV::when($acLedgerId, function($q) use($acLedgerId) {
                            $q->where('ac_ledger_id', $acLedgerId);
                        })
                        ->when($accountCode, function($q) use($accountCode) {
                            $q->where('code_segment9', $accountCode);
                        })
                        ->when($departmentCode, function($q) use($departmentCode) {
                            $q->where('code_segment3', $departmentCode);
                        })
                        ->when($costCenter, function($q) use($costCenter) {
                            $q->where('code_segment4', $costCenter);
                        })
                        ->with('acLedger')
                        ->orderBy('ac_ledger_detail_id', 'asc')
                        ->get();
        }else {
            $dataTable = AccountCodeDetailsV::with('acLedger')
                    ->orderBy('ac_ledger_id', 'asc')
                    ->orderBy('ac_ledger_detail_id', 'asc')
                    ->get();
        }

        $acLedgerData     = clone $list;
        $accountData      = clone $list;
        $departmentData   = clone $list;
        $costCenterData   = clone $list;

        $list = $list->count();
        if ($list) {

            $acLedgerData    = $acLedgerData->selectRaw("distinct ac_ledger_id")->get();
            
            if (count($acLedgerData)) {
                $query = (new AccountCodeDetailsV)->acLedger()->getRelated()->selectRaw("
                    distinct ac_ledger_id value,
                    seq || ' : ' || name as label
                ")
                ->orderBy("value")
                ->whereIn('ac_ledger_id', $acLedgerData->pluck('ac_ledger_id', 'ac_ledger_id'))
                ->get();

                $acLedgerList = array_merge($acLedgerList, $query->toArray());
            }

            $accountData = $accountData->selectRaw("distinct code_segment9 value, segment9_desc as label")
                ->orderBy("value")
                ->get();
            
            $accountList = array_merge($accountList, $accountData->toArray());

            $departmentData = $departmentData->selectRaw("distinct code_segment3 value, segment3_desc as label")
                ->orderBy("value")
                ->get();
            
            $departmentList = array_merge($departmentList, $departmentData->toArray());

            $costCenterData = $costCenterData->selectRaw("distinct code_segment4 value, segment4_desc as label")
                ->orderBy("value")
                ->get();
            
            $costCenterList = array_merge($costCenterList, $costCenterData->toArray());
        }

        $data = [
            'data'        => $dataTable,
            'acLedgers'   => $acLedgerList,
            'accounts'    => $accountData,
            'departments' => $departmentData,
            'costCenters' => $costCenterData,
        ];

        return response()->json($data);
    }

    public function getDataList()
    {
        $parent = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', request()->segment_parent)
            ->where('ptgl_coa_v.flex_value', request()->parent)
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->orderBy('flex_value', 'asc')
            ->first();

        $res = PtglAccountsInfo::select('ptgl_coa_v.flex_value_set_id', 'ptgl_coa_v.description', 'ptgl_coa_v.flex_value_id', 'ptgl_coa_v.flex_value', 'ptgl_coa_v.parent_flex_value_low')
            ->join('ptgl_coa_v', 'ptgl_accounts_info.flex_value_set_id', '=', 'ptgl_coa_v.flex_value_set_id')
            ->where('application_column_name', request()->segment)
            ->where('ptgl_coa_v.parent_flex_value_low', $parent->flex_value)
            ->groupBy('ptgl_coa_v.parent_flex_value_low')
            ->groupBy('ptgl_coa_v.flex_value_set_id')
            ->groupBy('ptgl_coa_v.flex_value_id')
            ->groupBy('ptgl_coa_v.flex_value')
            ->groupBy('ptgl_coa_v.description')
            ->orderBy('flex_value', 'asc')
            ->get();

        return response()->json($res);

        // dd('getDataList', request()->all(), $parent, $res);
    }

    public function getProductGroup()
    {
        $org = PtinvOrganizationsInfo::where('organization_id', request()->organization_id)->first();
        $res = ProductGroupV::where('cost_code', $org->cost_code)->get();
        // dd($res);

        return response()->json($res);
    }

    public function getCategory()
    {
        $res = TobaccoItemcatSeg1V::all();

        return response()->json($res);
    }

    public function getOrganizations()
    {
        $res = PtinvOrganizationsInfo::orderBy('organization_code')->get();

        return response()->json($res);
    }

    public function getDataListSegments()
    {
        $text  = request()->get('query');
        $segment = request()->segment;

        $res = PtglAccountsInfo::select('ptgl_accounts_info.application_column_name', 'pcv.flex_value', 'pcv.description')
        ->join('ptgl_coa_v AS pcv', 'ptgl_accounts_info.flex_value_set_id', '=', 'pcv.flex_value_set_id')
        ->where('ptgl_accounts_info.application_column_name', $segment)
        ->when($text, function ($query, $text) {
            return $query->where(function($r) use ($text) {
               $r->where('pcv.flex_value', 'like', "%${text}%")
                  ->orWhere('pcv.description', 'like', "${text}%");
            });
        })
        ->groupBy('ptgl_accounts_info.application_column_name','pcv.flex_value','pcv.description')
        ->orderBy('flex_value', 'asc')
        ->limit(20)
        ->get();

        return response()->json($res);
    }
    
}
