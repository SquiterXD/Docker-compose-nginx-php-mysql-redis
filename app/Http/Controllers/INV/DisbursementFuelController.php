<?php

namespace App\Http\Controllers\INV;

use Carbon\Carbon;
use App\Models\INV\CarInfoV;
use Illuminate\Http\Request;
use App\Models\INV\AliasNameV;
use App\Models\INV\WebFuelOil;
use App\Models\INV\CstItemCost;
use App\Models\INV\SystemItemB;
use App\Models\INV\WebFuelDist;
use App\Models\INV\CoaDeptCodeV;
use App\Models\INV\ItemLocation;
use App\Models\INV\SubinventortV;
use App\Models\INV\WebOilPackage;
use App\Http\Controllers\Controller;
use App\Models\INV\CarInfoInterface;
use App\Models\INV\GeneratePoNumber;
use App\Models\INV\OrganizationUnits;
use App\Models\INV\SecondaryInventory;
use App\Models\INV\GlCodeCombinationsKfv;
use App\Models\INV\GenerateDocumentNumber;
use App\Models\INV\PtPeriodV;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class DisbursementFuelController extends Controller
{
    public function index()
    {
        $user = getDefaultData('/inv/requisition_stationery');
        $departmentUser = $user->department;
        $coaDeptCodeVs = CoaDeptCodeV::select('department_code', 'description')->get();
        $subInventories = SecondaryInventory::with(['parameters'])
            ->whereHas('parameters.organizationUnit', function($r) {
                return $r->where("attribute2", 'Yes');
            })
            ->whereHas('materialStatus', function($q) {
                $q->where('status_code', 'Active');
            })
            ->limit(10)
            ->get();
        $carInfos = CarInfoV::with(['department'])
            ->orderBy('car_license_plate')
            ->get();
        $carFuels = SystemItemB::select('segment1', 'description')
            ->whereHas('parameters', function($q) {
                $q->where('organization_code', 'A32');
            })
            ->where('attribute5', 'Y')
            ->orderBy('segment1')
            ->get();
        $organizationUnits = OrganizationUnits::selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('organization_id', 'name')
            ->where('attribute2', 'Yes')
            ->get();
        
        $webFuelOils = WebFuelOil::query()
            ->when(request()->start_date, function ($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date);
                $q->whereDate('gl_date', '>=', $startDate);
            })
            ->when(request()->end_date, function ($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date);
                $q->whereDate('gl_date', '<=', $endDate);
            })
            ->when(request()->department_code, function ($q) {
                $q->whereHas('carInfos.department', function($r) {
                    $r->where('department_code', request()->department_code);
                });
            })
            ->when(request()->subinventory_code, function($q) {
                $q->whereHas('webFuelDists', function($r) {
                    $r->where('subinventory_code', request()->subinventory_code);
                });
            })
            ->when(request()->car_fuel, function($q) {
                $q->whereHas('carInfos', function($r) {
                    $r->where('car_fuel', request()->car_fuel);
                });
            })
            ->when(request()->car_license_plate, function($q) {
                $q->whereHas('carInfos', function($r) {
                    $r->where('car_license_plate', request()->car_license_plate);
                });
            })
            ->when(request()->organization_id, function ($q) {
                $q->where('organization_id', request()->organization_id);
            })
            ->when(request()->show == 'active', function ($q) {
                $q->where('deleted_at', null);
            })
            ->whereNotNull('tran_id')
            ->orderBy('transaction_date', 'desc')
            ->withTrashed()
            ->paginate(14);
        
        return view('inv.disbursement_fuel.index', [
            "coaDeptCodeVs" => $coaDeptCodeVs,
            "departmentUser" => $departmentUser,
            "subInventories" => $subInventories,
            "carInfos" => $carInfos,
            "webFuelOils" => $webFuelOils,
            'organizationUnits' => $organizationUnits,
            "carFuels"  => $carFuels,
        ]);
    }

    public function edit($carLicensePlate)
    {
        $carInfo = CarInfoV::query()
            ->with(['aliasName', 'department'])
            ->where('car_license_plate', $carLicensePlate)
            ->first();

        return view('inv.disbursement_fuel.edit', [
            "carInfo" => $carInfo,
        ]);
    }

    public function editNonFa($carLicensePlate)
    {
        $carInfo = CarInfoV::query()
            ->with(['aliasName', 'department'])
            ->where('car_license_plate', $carLicensePlate)
            ->first();

        return view('inv.disbursement_fuel.edit-non-fa', [
            "carInfo" => $carInfo,
        ]);
    }

    public function create()
    {
        $webFuelOils = WebFuelOil::with('carInfos')->get();
        return view('inv.disbursement_fuel.create', [
            "webFuelOils" => $webFuelOils
        ]);
    }

    public function store(Request $request)
    {
        $dataWebFuel = $request->all();
        $number = null;

        $request->validate([
            'gl_alias_name'         => 'required',
            'transaction_quantity'  => 'required|numeric',
            'gl_date'               => 'required|date',
            'subinventory_code'     => 'required',
            'inventory_location_id' => 'required',
            'locator'               => 'required',
            'car_license_plate'     => 'required',
        ]);

        $webFuelOilExisting = WebFuelOil::firstWhere('document_number', $dataWebFuel['document_number']);
        if ($webFuelOilExisting) {
            return response()->json([
                'msg' => 'มีเลขที่เอกสารนี้แล้ว'
            ], 403);
        }

        $period = PtPeriodV::query()
            ->where(function($q) {
                $glDate = \Carbon\Carbon::parse(request()->gl_date)->format('Y-m-d');
                $q->where('start_date', '<=', $glDate);
            })
            ->where(function($q) {
                $glDate = \Carbon\Carbon::parse(request()->gl_date)->format('Y-m-d');
                $q->where('end_date', '>=', $glDate);
            })
            ->where('period_status', 'OPEN')
            ->exists();

        if (!$period) {
            return response()->json([
                'msg' => 'วันที่ ' . \Carbon\Carbon::parse(request()->gl_date)->format('d-m-Y') . ' Period ไม่ได้อยู่ในสถานะเปิด กรุณาติดต่อฝ่ายบัญชีและการเงิน'
            ], 403);
        }

        $now = \Carbon\Carbon::now();

        $dataWebFuel['program_code'] = "INP0004";
        $dataWebFuel['transaction_date'] = $now;
        
        $dataWebFuel['gl_date'] = \Carbon\Carbon::parse($dataWebFuel['gl_date'])
            ->setHour($now->hour)
            ->setMinute($now->minute)
            ->setSecond($now->second);

        if ($dataWebFuel['gl_date'] > $now) {
            return response()->json([
                'msg' => 'วันที่เติมน้ำมันจะต้องไม่เกินวันที่ปัจจุบัน'
            ], 403);
        }

        $carInfo = CarInfoV::firstWhere("car_license_plate", request()->car_license_plate);

        $aliasNameV = AliasNameV::firstWhere('alias_name', request()->gl_alias_name);

        $carFuelOnhand = \DB::select( \DB::raw("select PTINV_ONHAND_QTY_PKG.GET_ITEM_ONHAND(P_ORGANIZATION_ID => ?, P_ITEM_ID => ?, P_SUBINVENTORY_CODE => ?) as onhand from dual"), [$carInfo->organization_id, $carInfo->inventory_item_id, request()->subinventory_code]);
        if ($dataWebFuel['transaction_quantity'] > $carFuelOnhand[0]->onhand) {
            return response()->json([
                'msg' => 'จำนวนน้ำมันในคลังมีไม่เพียงพอ'
            ], 403);
        }

        \DB::beginTransaction();
        try {
            if ($carInfo->source_data == 'FA' && $carInfo->additions->attribute22 === 'N') {
                $timestamp = $dataWebFuel['transaction_date'];
                $month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp)->format('m');
                $receiptNumber = new GeneratePoNumber;
                $number = $receiptNumber->generatePoNumber($month);
            }

            if ($carInfo->source_data == 'NON_FA' && $carInfo->tax_refund_yn === 'N') {
                $timestamp = $dataWebFuel['transaction_date'];
                $month = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp)->format('m');
                $receiptNumber = new GeneratePoNumber;
                $number = $receiptNumber->generatePoNumber($month);
            }

            $documentNumber = (new GenerateDocumentNumber())->generateDocumentNumber();

            $coas = explode(".", $aliasNameV->template);
            $coas[2] = $carInfo->default_dept_code;
            $newCoaCombine = implode(".", $coas);

            $webFuelOil = WebFuelOil::create([
                'organization_id' => $dataWebFuel['organization_id'],
                'transaction_date' => \Carbon\Carbon::now(),
                'gl_date' => $dataWebFuel['gl_date'],
                'document_number' => $documentNumber,
                'account_code' => $aliasNameV->template,
                'transaction_quantity' => $dataWebFuel['transaction_quantity'],
                'gl_alias_name' => $aliasNameV->alias_name,
                'inventory_item_id' => $carInfo->inventory_item_id,
                'car_license_plate' => $carInfo->car_license_plate,
                'transaction_uom' => $carInfo->uom_code,
                'transaction_account' => $aliasNameV->template,
                'transaction_account_id' => 9999,
                'program_code' => $dataWebFuel['program_code'],
                'acc_segment1' => $coas[0],
                'acc_segment2' => $coas[1],
                'acc_segment3' => $coas[2],
                'acc_segment4' => $coas[3],
                'acc_segment5' => $coas[4],
                'acc_segment6' => $coas[5],
                'acc_segment7' => $coas[6],
                'acc_segment8' => $coas[7],
                'acc_segment9' => $coas[8],
                'acc_segment10' => $coas[9],
                'acc_segment11' => $coas[10],
                'acc_segment12' => $coas[11],
                'receipt_number' => $number,
                'subinventory_code' => $dataWebFuel['subinventory_code'],
                'locator_id' => $dataWebFuel['inventory_location_id'],
                'locator' => $dataWebFuel['locator'],
            ]);

            \DB::commit();

            $result = (new WebOilPackage())->interface($webFuelOil->transaction_id);

            if ($result['status'] == 'C') {
                return response()->json(['msg' => 'success'], 200);
            } else {
                return response()->json([
                    'status' => $result['status'],
                    'msg' => $result['message']
                ], 403);
            }
            
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'error' => $e->getMessage()
            ], 403);
        }

    }

    public function save()
    {
        return view('inv.disbursement_fuel.add_new_car');
    }

    public function addNonFa()
    {
        return view('inv.disbursement_fuel.add_non_fa');
    }

    public function report()
    {
        return view('inv.disbursement_fuel.report');
    }
    
    public function show()
    {
        $carInfos = CarInfoV::with(['department'])
            ->when(request()->car_license_plate, function($q) {
                $q->where('car_license_plate', request()->car_license_plate);
            })
            ->paginate(50);

        return view('inv.disbursement_fuel.show', [
            "carInfos" => $carInfos,
        ]);
    }

    public function updateCarInfoInterface()
    {
        request()->validate([
            'car_license_plate' => 'required|string',
            'asset_id' => 'required',
            'car_group' => 'required',
            'car_brand' => 'required',
            'car_fuel' => 'required',
            'account_code' => 'required|string',
            'quota_per_month' => 'required|numeric',
            'tax_refund_yn' => 'required|string'
        ]);
        $carInfo = request()->all();
        $carInfo = (object)$carInfo;
        $result = (new WebOilPackage())->updateCarInfoInterface($carInfo);

        if ($result['status'] == 'C') {
            return response()->json([
                'msg' => $result['message']
            ], 403);
            return response()->json(['msg' => 'success'], 200);
        }
        if ($result['status'] == 'E') {
            return response()->json([
                'msg' => $result['message']
            ], 403);
        }
    }

    public function updateNonFaInterface()
    {
        request()->validate([
            'car_license_plate' => 'required',
            'car_group' => 'required',
            'car_fuel' => 'required',
            'account_code' => 'required',
            'quota_per_month' => 'required|numeric',
            'default_dept_code' => 'required',
        ]);
        $nonFaItem = request()->all();
        $nonFaItem = (object)$nonFaItem;

        $existingCarNonFa = CarInfoV::where('car_license_plate', request()->car_license_plate)->exists();

        if ($existingCarNonFa) {

            $result = (new WebOilPackage())->updateNonFaInterface($nonFaItem);
            if ($result['status'] == 'C') {
                return response()->json(['msg' => 'success'], 200);
            }
            if ($result['status'] == 'E') {
                return response()->json([
                    'msg' => $result['message']
                ], 403);
            }
        }

        if (!$existingCarNonFa) {
            
            $result = (new WebOilPackage())->addNonFaInterface($nonFaItem);
            if ($result['status'] == 'C') {
                return response()->json(['msg' => 'success'], 200);
            }
            if ($result['status'] == 'E') {
                return response()->json([
                    'msg' => $result['message']
                ], 403);
            }
        }
        
    }

    public function destroy($id)
    {
        $validateData = request()->validate([
            'return_date'       => 'required',
            'reason_name'   => 'required|string',
        ]);

        $validateData['return_date'] = \Carbon\Carbon::createFromFormat('d/m/Y', $validateData['return_date']);

        $webFuelOil = WebFuelOil::find($id);
        $transactionDate = \Carbon\Carbon::parse($webFuelOil->transaction_date)->format('Y-m-d');

        $period = PtPeriodV::query()
            ->where(function($q) use ($transactionDate) {
                $q->whereDate('start_date', '<=', $transactionDate);
            })
            ->where(function($q) use ($transactionDate) {
                $q->whereDate('end_date', '>=', $transactionDate);
            })
            ->where('period_status', 'OPEN')
            ->exists();

        if (!$period) {
            return response()->json([
                'msg' => 'วันที่ ' . \Carbon\Carbon::parse($webFuelOil->transaction_date)->format('d-m-Y') . ' Period ไม่ได้อยู่ในสถานะเปิด กรุณาติดต่อฝ่ายบัญชีและการเงิน'
            ], 403);
        }

        $now = \Carbon\Carbon::now();
        $returnDate = \Carbon\Carbon::parse($validateData['return_date'])
            ->setHour($now->hour)
            ->setMinute($now->minute)
            ->setSecond($now->second);

        if ($returnDate >= $now) {
            return response()->json([
                'msg' => 'วันที่ยกเลิกจะต้องไม่เกินวันที่ปัจจุบัน'
            ], 403);
        }

        $originWebFuelOil = WebFuelOil::find($id);
        $returnWebFuelOil = $originWebFuelOil->replicate();

        $documentNumber = $originWebFuelOil->document_number . "RE";
        $isDocumentNumberExists = WebFuelOil::where('document_number', $documentNumber)->exists();
        if ($isDocumentNumberExists) {
            return redirect()->back()->with('success', 'มีเลขที่เอกสารนี้แล้ว');
        }

        $checkReturnDate = $returnDate
            ->setHour()
            ->setMinute()
            ->setSecond();
        $checkOriginDate = Carbon::parse($originWebFuelOil->gl_date)
            ->setHour()
            ->setMinute()
            ->setSecond();

        if ($checkReturnDate == $checkOriginDate) {
            $returnWebFuelOil['gl_date'] = Carbon::parse($originWebFuelOil->gl_date);
        } 
        if ($checkReturnDate != $checkOriginDate) {
            $returnWebFuelOil['gl_date'] = Carbon::parse($validateData['return_date'])
                ->setHour($now->hour)
                ->setMinute($now->minute)
                ->setSecond($now->second);
        }

        $userId = optional(auth()->user())->user_id ?? -1;
        $originWebFuelOil->delete();
        $originWebFuelOil->last_updated_by = $userId;
        $originWebFuelOil->last_update_date = Carbon::now();

        $returnWebFuelOil['document_number'] = $documentNumber;
        $returnWebFuelOil['issue_transaction_id'] = $originWebFuelOil->transaction_id;
        $returnWebFuelOil['issue_document_number'] = $originWebFuelOil->document_number;
        $returnWebFuelOil['deleted_at'] = Carbon::now();
        $returnWebFuelOil['last_update_date'] = Carbon::now();
        $returnWebFuelOil['creation_date'] = Carbon::now();
        $returnWebFuelOil['tran_id'] = null;
        $returnWebFuelOil['reason_name'] = $validateData['reason_name'];

        \DB::beginTransaction();
        try {
            $originWebFuelOil->save();
            $originWebFuelOil->fresh();

            $returnWebFuelOil->save();

            $result = (new WebOilPackage())->returnInterface($returnWebFuelOil->transaction_id);

            if ($result['status'] == 'C') {
                return response()->json(['msg' => 'success'], 200);
            }
            if ($result['status'] == 'E') {
                return response()->json([
                    'msg' => $result['message']
                ], 403);
            }

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
