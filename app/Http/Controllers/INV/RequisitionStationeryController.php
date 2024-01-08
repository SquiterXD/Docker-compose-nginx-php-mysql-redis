<?php

namespace App\Http\Controllers\INV;

use PDO;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\INV\IssueDetail;
use App\Models\INV\IssueHeader;
use App\Models\INV\CoaDeptCodeV;
use App\Models\PtglCoaDeptCodeV;
use App\Models\INV\LotOnhandSumV;
use App\Models\INV\GenerateNumber;
use App\Models\INV\CstItemCostType;
use App\Models\INV\FndLookupTypeVL;
use App\Models\PtglCoaDeptCodeAllV;
use App\Http\Controllers\Controller;
use App\Models\INV\FndLookupValueVL;
use App\Models\INV\PoDistributionsAll;
use App\Models\INV\WebStationeryPackage;

class RequisitionStationeryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userDepartment = PtglCoaDeptCodeAllV::firstWhere('department_code', $user->department_code);
        $lookupValuesExists = FndLookupValueVL::selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('lookup_type', 'lookup_code', 'meaning', 'tag', 'description', 'enabled_flag', 'start_date_active', 'end_date_active')
            ->where('enabled_flag', 'Y')
            ->whereHas('fndLookupTypes', function($q) {
                $q->where('lookup_type', 'TOAT_INV_STATIONERY_ISSUER');
            })
            ->where('meaning', $user->username)
            ->exists();
        
        if ($lookupValuesExists) {
            $coaDeptCodeVs = PtglCoaDeptCodeAllV::select('department_code', 'meaning', 'description')
                ->where('flex_value_set_name', 'TOAT_GL_ACCT_CODE-DEPT_CODE')
                ->get();

            if (!request()->issue_status && !request()->issue_number && !request()->department_code && !request()->start_date && !request()->end_date) {
                $issueHeaders = IssueHeader::query()
                    ->where('issue_status', 'WAITING')
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);
            }
            if (request()->issue_status == 'ALL') {
                $issueHeaders = IssueHeader::query()
                    ->when(request()->issue_number, function ($q) {
                        $q->where('issue_number', request()->issue_number);
                    })
                    ->when(request()->department_code, function ($q) {
                        $q->where('department_code', request()->department_code);
                    })
                    ->when(request()->start_date, function ($q) {
                        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date);
                        $q->whereDate('created_at', '>=', $startDate);
                    })
                    ->when(request()->end_date, function ($q) {
                        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date);
                        $q->whereDate('created_at', '<=', $endDate);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);
            }
            if (request()->issue_status && request()->issue_status != 'ALL') {
                $issueHeaders = IssueHeader::query()
                    ->when(request()->issue_number, function ($q) {
                        $q->where('issue_number', request()->issue_number);
                    })
                    ->when(request()->issue_status, function ($q) {
                        $q->where('issue_status', request()->issue_status);
                        
                    })
                    ->when(request()->department_code, function ($q) {
                        $q->where('department_code', request()->department_code);
                    })
                    ->when(request()->start_date, function ($q) {
                        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date);
                        $q->whereDate('created_at', '>=', $startDate);
                    })
                    ->when(request()->end_date, function ($q) {
                        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date);
                        $q->whereDate('created_at', '<=', $endDate);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(25);
            }

        } elseif (!$lookupValuesExists) {
            if (request()->issue_status == "ALL") {
                request()->issue_status = "";
            }

            $subDepartmentCode = substr($user->department_code, 0, 6).'%';
            $coaDeptCodeVs = PtglCoaDeptCodeAllV::select('department_code', 'meaning', 'description')
                ->where('flex_value_set_name', 'TOAT_GL_ACCT_CODE-DEPT_CODE')
                ->where('department_code', 'like', $subDepartmentCode)
                ->get();

            $issueHeaders = IssueHeader::query()
                ->when(request()->issue_number, function ($q) {
                    $q->where('issue_number', request()->issue_number);
                })
                ->when(request()->issue_status, function ($q) {
                    $q->where('issue_status', request()->issue_status);
                })
                ->when(request()->department_code, function ($q) {
                    $q->where('department_code', request()->department_code);
                })
                ->when(request()->start_date, function ($q) {
                    $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date);
                    $q->whereDate('created_at', '>=', $startDate);
                })
                ->when(request()->end_date, function ($q) {
                    $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date);
                    $q->whereDate('created_at', '<=', $endDate);
                })
                ->where('department_code', 'like', $subDepartmentCode)
                ->orderBy('created_at', 'desc')
                ->paginate(25);
        }

        return view('inv.requisition_stationery.index', [
            "coaDeptCodeVs" => $coaDeptCodeVs,
            "issueHeaders" => $issueHeaders,
            "userDepartment" => $userDepartment,
            "lookupValuesExists" => $lookupValuesExists
        ]);
    }

    public function create()
    {
        $user = getDefaultData('/inv/requisition_stationery');
        $departmentUser = $user->department;

        return view('inv.requisition_stationery.create', [
            "departmentUser" => $departmentUser,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'required',
            'description' => 'required|string',
            'department_code' => 'required|string',
            'subinventory_code' => 'required|string',
            'issue_status' => 'required|string',
            'organization_id' => 'required|numeric',
            'gl_alias_name' => 'required|string',
            'account_code' => 'required|string',
            'items.*' => 'required',
            'items.*.item' => 'required|string',
            'items.*.description' => 'required|string',
            'items.*.onhand_quantity' => 'required|numeric',
            'items.*.transaction_quantity' => 'required|numeric',
            'items.*.primary_unit_of_measure' => 'required|string',
            'items.*.transaction_uom' => 'required|string',
            'items.*.transaction_account' => 'required|string',
            'items.*.inventory_item_id' => 'required|numeric',
            'items.*.item_cost' => 'required|numeric',
        ]);
        $user = getDefaultData('/inv/requisition_stationery');
        $programCode =  $user->program_code;
        $dataIssueHeader  =  $request->all();
        $dataIssueDetails  =  $request->items;
        $departmentCode = request()->department_code;
        $costCenter = request()->cost_center;

        unset($dataIssueHeader['items']);

        $subAccountCode = explode(".", $dataIssueHeader["account_code"]);
        $subAccountCode[2] = $departmentCode;
        $subAccountCode[3] = $costCenter;
        $newAccCombine = implode(".", $subAccountCode);
        $dataIssueHeader["account_code"] = $newAccCombine;
        
        $dataIssueHeader['ISSUE_STATUS'] = 'WAITING';
        $dataIssueHeader['transaction_date'] = Carbon::now();
        $dataIssueHeader['gl_date'] = Carbon::now();
        $dataIssueHeader["created_by"] = $user->fnd_user_id;
        $dataIssueHeader["created_by_id"] = $user->user_id; // created_by_id ==> web user
        $dataIssueHeader["creation_date"] = Carbon::now();
        $dataIssueHeader["updated_by_id"] = $user->user_id; // updated_by_id ==> web user
        $dataIssueHeader["last_update_date"] = Carbon::now();
        $dataIssueHeader["last_updated_by"] = $user->fnd_user_id;
        $dataIssueHeader["last_update_login"] = null;
        $dataIssueHeader["program_code"] = $programCode;
        $dataIssueHeader["acc_segment1"] = $subAccountCode['0'];
        $dataIssueHeader["acc_segment2"] = $subAccountCode['1'];
        $dataIssueHeader["acc_segment3"] = $subAccountCode['2'];
        $dataIssueHeader["acc_segment4"] = $subAccountCode['3'];
        $dataIssueHeader["acc_segment5"] = $subAccountCode['4'];
        $dataIssueHeader["acc_segment6"] = $subAccountCode['5'];
        $dataIssueHeader["acc_segment7"] = $subAccountCode['6'];
        $dataIssueHeader["acc_segment8"] = $subAccountCode['7'];
        $dataIssueHeader["acc_segment9"] = $subAccountCode['8'];
        $dataIssueHeader["acc_segment10"] = $subAccountCode['9'];
        $dataIssueHeader["acc_segment11"] = $subAccountCode['10'];
        $dataIssueHeader["acc_segment12"] = $subAccountCode['11'];

        $currentDate = (Carbon::now()->format('Y-m-d'));
        $documentNumber = new GenerateNumber;
        $number = $documentNumber->generateNumber($departmentCode, $currentDate);
        $dataIssueHeader['issue_number'] = $number;

        foreach ($dataIssueDetails as $dataIssueDetail) {
            if ($dataIssueDetail['transaction_quantity'] > $dataIssueDetail['onhand_quantity']) {
                return response()->json([
                    'msg' => 'จำนวนขอเบิกมีมากกว่าจำนวนคงเหลือ'
                ], 403);
            }
        }

        \DB::beginTransaction();
        try {
            $issueHeader = IssueHeader::create($dataIssueHeader);

            foreach ($dataIssueDetails as $key => $value) {
                $lineNo = $key + 1;

                IssueDetail::create([
                    'issue_header_id' => $issueHeader->issue_header_id,
                    'line_no' => $lineNo,
                    'description' => $value['description'],
                    'inventory_item_id' => $value['inventory_item_id'],
                    'organization_id' => $issueHeader->organization_id,
                    'onhand_quantity' => $value['onhand_quantity'],
                    'transaction_quantity' => $value['transaction_quantity'],
                    'transaction_uom' => $value['transaction_uom'],
                    'transaction_account' => $value['transaction_account'],
                    'transaction_account_id' => "41017",
                    'transaction_cost' => $value['item_cost'],
                    'transaction_amount' => ($value['transaction_quantity'] * $value['item_cost']),
                    'program_code' => $programCode,
                    'created_by' => $user->fnd_user_id,
                ]);
            }
            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function show($id)
    {
        $lookupValues = FndLookupValueVL::selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('lookup_type', 'lookup_code', 'meaning', 'tag', 'description', 'enabled_flag', 'start_date_active', 'end_date_active')
            ->where('enabled_flag', 'Y')
            ->whereHas('fndLookupTypes', function($q) {
                $q->where('lookup_type', 'TOAT_INV_STATIONERY_ISSUER');
            })
            ->get();
        
        $issueHeader = IssueHeader::query()
            ->with("details.inventoryItem:inventory_item_id,description,segment1,primary_unit_of_measure",
                "coaDeptCode:department_code,description", 
                "issueProgramProfileV", 
                "organizationUnits:organization_id,name", 
                "secondaryInventory:secondary_inventory_name,description",
                "cancelUser")
            ->find($id);

        foreach ($issueHeader->details as $detail) {
            $detail->lot_onhand = LotOnhandSumV::query()
                ->where('inventory_item_id', $detail->inventory_item_id)
                ->get();
        };

        return view('inv.requisition_stationery.show', [
            "issueHeader" => $issueHeader,
            "user" => auth()->user(),
            "lookupValues" => $lookupValues,
        ]);
    }

    public function edit($id)
    {
        $user = getDefaultData('/inv/requisition_stationery');
        $departmentUser = $user->department;
        $issueHeader = IssueHeader::with("details.inventoryItem:inventory_item_id,description,segment1,primary_unit_of_measure")->find($id);
        $issueHeader->issue_status = "DRAFT";
        $issueHeader->save();

        return view('inv.requisition_stationery.edit', [
            "issueHeader" => $issueHeader,
            "departmentUser" => $departmentUser,
        ]);
    }

    public function copy($id)
    {
        $user = getDefaultData('/inv/requisition_stationery');
        $departmentUser = $user->department;

        $issueHeader = IssueHeader::with("details.inventoryItem:inventory_item_id,description,segment1,primary_unit_of_measure")->find($id);

        foreach ($issueHeader->details as $detail) {
            $detail->onhand_quantity = \DB::select( \DB::raw("select PTINV_ONHAND_QTY_PKG.GET_ITEM_ONHAND(P_ORGANIZATION_ID => ?, P_ITEM_ID => ?, P_SUBINVENTORY_CODE => ?) as onhand from dual"), [$detail->organization_id, $detail->inventory_item_id, $issueHeader->subinventory_code]);
            $detail->onhand_quantity = $detail->onhand_quantity[0]->onhand;
        }

        return view('inv.requisition_stationery.copy', [
            "issueHeader" => $issueHeader,
            "departmentUser" => $departmentUser,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_date' => 'required',
            'description' => 'required',
            'department_code' => 'required',
            'subinventory_code' => 'required',
            'issue_status' => 'required',
            'organization_id' => 'required',
            'gl_alias_name' => 'required',
            'account_code' => 'required',
            'items.*' => 'required',
        ]);

        $issueHeader = IssueHeader::find($id);

        $user = getDefaultData('/inv/requisition_stationery');
        $productCode = $user->program_code;
        $dataIssueHeader  =  $request->all();
        $dataIssueDetails  =  $request->items;
        $departmentCode = request()->department_code;
        $costCenter = request()->cost_center;

        unset($dataIssueHeader['items']);

        $subAccountCode = explode(".", $dataIssueHeader["account_code"]);
        $subAccountCode[2] = $departmentCode;
        $subAccountCode[3] = $costCenter;
        $newAccCombine = implode(".", $subAccountCode);
        $dataIssueHeader["account_code"] = $newAccCombine;

        $dataIssueHeader['transaction_date'] = Carbon::now();
        $dataIssueHeader['gl_date'] = Carbon::now();
        $dataIssueHeader["creation_date"] = $issueHeader->creation_date;
        $dataIssueHeader["updated_by_id"] = $user->user_id; // updated_by_id ==> web user
        $dataIssueHeader["last_update_date"] = Carbon::now();
        $dataIssueHeader["last_updated_by"] = $user->fnd_user_id;
        $dataIssueHeader["last_update_login"] = null;
        $dataIssueHeader["program_code"] = $productCode;
        $dataIssueHeader["acc_segment1"] = $subAccountCode['0'];
        $dataIssueHeader["acc_segment2"] = $subAccountCode['1'];
        $dataIssueHeader["acc_segment3"] = $subAccountCode['2'];
        $dataIssueHeader["acc_segment4"] = $subAccountCode['3'];
        $dataIssueHeader["acc_segment5"] = $subAccountCode['4'];
        $dataIssueHeader["acc_segment6"] = $subAccountCode['5'];
        $dataIssueHeader["acc_segment7"] = $subAccountCode['6'];
        $dataIssueHeader["acc_segment8"] = $subAccountCode['7'];
        $dataIssueHeader["acc_segment9"] = $subAccountCode['8'];
        $dataIssueHeader["acc_segment10"] = $subAccountCode['9'];
        $dataIssueHeader["acc_segment11"] = $subAccountCode['10'];
        $dataIssueHeader["acc_segment12"] = $subAccountCode['11'];

        $dataIssueHeader['issue_number'] = $issueHeader->issue_number;
        $dataIssueHeader['issue_status'] = 'WAITING';
        
        foreach ($dataIssueDetails as $dataIssueDetail) {
            if ($dataIssueDetail['transaction_quantity'] > $dataIssueDetail['onhand_quantity']) {
                return response()->json([
                    'msg' => 'จำนวนขอเบิกมีมากกว่าจำนวนคงเหลือ'
                ], 403);
            }
        }

        \DB::beginTransaction();
        try {
            $issueHeader->update($dataIssueHeader);
            $issueHeader->details()->delete();

            foreach ($dataIssueDetails as $key => $value) {
                $lineNo = $key + 1;

                IssueDetail::create([
                    'issue_header_id' => $issueHeader->issue_header_id,
                    'line_no' => $lineNo,
                    'description' => $value['description'],
                    'inventory_item_id' => $value['inventory_item_id'],
                    'organization_id' => $issueHeader->organization_id,
                    'onhand_quantity' => $value['onhand_quantity'],
                    'transaction_quantity' => $value['transaction_quantity'],
                    'transaction_uom' => $value['transaction_uom'],
                    'transaction_account' => $value['transaction_account'],
                    'transaction_account_id' => "41017",
                    'transaction_cost' => $value['item_cost'],
                    'transaction_amount' => ($value['transaction_quantity'] * $value['item_cost']),
                    'program_code' => $productCode,
                    'created_by' => $user->fnd_user_id,
                ]);
            }
            \DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            \DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function approve($id)
    {
        $issueHeader = IssueHeader::query()
            ->with('details')
            ->find($id);

        foreach ($issueHeader->details as $detail) {
            $onhand = \DB::select( \DB::raw("select PTINV_ONHAND_QTY_PKG.GET_ITEM_ONHAND(P_ORGANIZATION_ID => ?, P_ITEM_ID => ?, P_SUBINVENTORY_CODE => ?) as onhand from dual"), [$issueHeader->organization_id, $detail->inventory_item_id, $issueHeader->subinventory_code]);
            if ((int)($detail->transaction_quantity) > (int)($onhand[0]->onhand) || empty($onhand[0]->onhand) ) {
                return response()->json([
                    'msg' => "จำนวนสินค้า" . $detail->description . "ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ",
                ], 403);
            }
        }

        if ($issueHeader->issue_status != "WAITING" && $issueHeader->issue_status != 'UPDATE') {
            return back()->withErrors("Failed: Only WAITING status can be approve");
        }
        if (!$issueHeader->details) {
            return back()->withErrors("ไม่มีรายการสินค้า กรุณาใส่รายการสินค้า");
        }

        $issueHeader->transaction_date = Carbon::now();
        $issueHeader->gl_date = Carbon::now();
        $issueHeader->last_update_date = Carbon::now();
        $issueHeader->save();
        
        $result = $this->updateIssueStationeryInterface($issueHeader->issue_number);

        if ($result['status'] != 'C') {
            return response()->json([
                'status' => $result['status'],
                'msg' => $result['message'],
            ], 403);
        }
        
        $issueHeader->issue_status = "APPROVED";
        $issueHeader->save();

        return response()->json(['msg' => 'success'], 200);
    }

    public function destroy($id)
    {
        # code...
    }

    public function cancel($id)
    {
        $issueHeader = IssueHeader::find($id);
        $issueHeader->issue_status = "CANCELLED";
        $issueHeader->transaction_date = Carbon::now();
        $issueHeader->gl_date = Carbon::now();
        $issueHeader->last_update_date = Carbon::now();
        $issueHeader->save();

        return response()->json(['msg' => 'success'], 200);
    }

    public function updateIssueStationeryInterface($issueNumber)
    {
        $issueHeader = IssueHeader::firstWhere('issue_number', $issueNumber);
        $result = (new WebStationeryPackage())->interface($issueHeader);

        return $result;
    }
}