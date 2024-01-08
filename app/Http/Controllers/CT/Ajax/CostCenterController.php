<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Models\CT\CostCenter;
use App\Models\CT\CostCenterCategory;
use App\Models\CT\ProductGroup;
use App\Models\CT\PeriodYear;
use App\Models\CT\CostCenterOrg;
use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\CostCenterGroupV;
use App\Models\CT\OrgInv;
use App\Models\CT\PtInvUomV;
use App\Models\CT\PtctCostRm;
use PDO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostCenterController extends Controller
{
    public function index(Request $request)
    {
        $costCenter = CostCenter::with('costCenterCategory', 'measureVl', 'productGroups', 'costCenterOrg')
            ->where(function ($q) {
                $query = request()->fiscal_year;
                if ($query) {
                    $q->where('fiscal_year', 'like', "%{$query}%");
                }
            })
            ->orderBy('code')
            ->get();
        return response()->json($costCenter);
    }

    public function invOrg()
    {
      $rs = OrgInv::whereNotNull('source_item_cost')->select('organization_code', 'organization_name')->orderBy('organization_code')->get();

      return response()->json([
        "data" => $rs,
        "status" => true,
        "message" => "success"
      ], 200);
    }

    public function uomV()
    {
      $rs = PtInvUomV::get();
      return response()->json([
        "data" => $rs,
        "status" => true,
        "message" => "success"
      ], 200);
    }


    public function costCenterGroupV()
    {
      $rs = CostCenterGroupV::get();
      
      return response()->json([
        "data" => $rs,
        "status" => true,
        "message" => "success"
      ], 200);
    }

    public function getCostCenterView()
    {
        return DB::table('ptct_cost_center_v')->get();
    }

    public function find(Request $request)
    {
        $res = CostCenter::query()
            ->with(['productGroups.productGroupDetails', 'productGroups.productGroupLots'])
            ->when($request, function ($q) use ($request) {
                $q->where('ptct_cost_centers.code',  $request->query('code'));
            })
            ->when($request, function ($q) use ($request) {
                $q->where('ptct_cost_centers.fiscal_year',  $request->query('year'));
            })
            ->first();

        return response()->json($res);
    }

    public function getPtpmItemForDropdown()
    {
        $user = getDefaultData('/users');

        $res = PtpmItemNumberV::query()
            ->select('item_number', 'item_desc')
            ->where('organization_code', $user->organization_code)
            ->where('organization_id', $user->organization_id)
            ->get();

        return response()->json($res);
    }

    public function getYearForDropdown(Request $request)
    {
        $res = CostCenter::select('fiscal_year')->selectRaw('fiscal_year + 543 AS label_year')
            ->when($request->query('cost_center_id'), function ($q) use ($request) {
                if ($request->query('cost_center_id')) {
                    $cost_center = CostCenter::where('cost_center_id', $request->query('cost_center_id'))->first();
                    $q->where('code', $cost_center->code);
                    $q->orWhere('name', $cost_center->name);
                }
            })
            ->when($request->query('cost_center_code'), function ($q) use ($request) {
                if ($request->query('cost_center_code')) {
                    $cost_center = CostCenter::where('code', $request->query('cost_center_code'))->first();
                    $q->orWhere('name', $cost_center->name);
                }
            })
            ->groupBy('fiscal_year')
            ->orderBy('fiscal_year', 'desc')
            ->get();
        return response()->json($res);
    }

    public function getPeriodYearForDropdown()
    {
        $database = env('DB_DATABASE_ORACLE');

        switch ($database) {
            case 'DEV2':
                $periodSetName = 'TTM_Calendar';
                break;
            case 'DEV3':
                $periodSetName = 'TOAT_Calendar';
                break;

            default:
                $periodSetName = 'TOAT_Calendar';
                break;
        }

        $periodYear = PeriodYear::selectRaw('period_year AS period_year, period_year + 543 AS label_year')
            ->where('period_set_name', $periodSetName)
            ->groupBy('period_year')
            ->orderBy('period_year', 'desc')
            ->get();

        return response()->json($periodYear);
    }

    public function getCodeForDropdown(Request $request)
    {
        $costCenters = CostCenter::select('code', 'name')
                ->where(function ($q) {
                $query = request()->text;
                $from_year = request()->from_year;
                $to_year = request()->to_year;
                if ($query) {
                    $q->where('code', 'like', "%{$query}%")
                        ->orWhere('name', 'like', "%{$query}%");
                }
                if ($from_year && $to_year) {
                    $q->orWhereBetween('fiscal_year', [$from_year, $to_year]);
                }
            })
            ->when($request->query('fiscal_year'), function ($q) use ($request) {
                $q->where('fiscal_year',  $request->query('fiscal_year'));
            })
            ->groupBy('code', 'name')
            ->get();

        return response()->json($costCenters);
    }

    public function storePackage(Request $request)
    {
      if ($request['type'] == "UPDATE") {
        $type = "UPDATE";
      }
      else if($request['type'] == "DELETE") {
        $type = "DELETE";
        $itemCostCenter = PtctCostRm::where('cost_code', $request['cost_code'])->count();
        if ($itemCostCenter > 0) {
          return response()->json([
              'msg' => "success",
              'status' => false
          ], 200);
        }
      } 
      else {
        $type = "ADD";
      }
      
      $orgInv = OrgInv::where('organization_code', $request->organization_code)->first();
      $costGroup = CostCenterGroupV::where('cost_group_code', $request->cost_group_code)->first();
      $result = [];
      $db     =   DB::connection('oracle')->getPdo();
      $sql    =   "
      declare
          v_rec       PTCT_UPDATE_MASTER_PKG.CT01_PARAM_REC;

      begin
              v_rec.INTERFACE_NAME     :=  'WEB_CREATE_FLEXVALUE';
              v_rec.CREATED_BY         := -1;
              v_rec.DATA_TYPE          := '${type}'; 
                      
              v_rec.COST_CODE         := '{$request['code']}';
              v_rec.COST_DESC          := '{$request['name']}';
              v_rec.COST_GROUP_CODE    := '{$request['cost_group_code']}';    
              v_rec.QUANTITY           := {$request['qty']};    
              v_rec.UOM_CODE           := '{$request['uom_code']}';    

              v_rec.INV_ORG_CODE       := '{$request['organization_code']}';   

              v_rec.COST_GROUP_DESC    := '{$costGroup['description']}';
              v_rec.ENABLED_FLAG       := 'Y';      
              v_rec.ORGANIZATION_ID    := {$orgInv['organization_id']};
          PTCT_UPDATE_MASTER_PKG.WEB_CTM01_CC(v_rec);
          
          dbms_output.put_line('RETURN_STATUS : ' || v_rec.RETURN_STATUS);
          dbms_output.put_line('RETURN_MESSAGE : ' || v_rec.RETURN_MESSAGE);

          :P_RETURN_STATUS :=  v_rec.RETURN_STATUS;
          :P_RETURN_MESSAGE :=  v_rec.RETURN_MESSAGE;

        end;
        ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();


        if ($result['status'] === "C") {
            return response()->json([
                'msg' => "success"
            ], 200);
        } else {
            return response()->json([
                'error' => $result,
                'msg' => "error"
            ], 404);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            'name' => ['required', 'string'],
            'cost_center_category_id' => 'required',
            'inv_org' => 'required',
            'org_material' => 'nullable',
            'qty' => 'required',
            'unit_id' => 'required',
            'fiscal_year' => 'required',
            'group_production' => 'required',
            'group_production.*.code' => 'required',
            'group_production.*.name' => 'required',
        ]);
        $cost_center = CostCenter::where('code', $request->code)->where('fiscal_year', $request->fiscal_year)->first();
        if ($cost_center) {
            return response()->json(
                [
                    "message" => "This code has been used in fiscal year."
                ],
                403
            );
        }
        \DB::beginTransaction();
        try {
            $cost_center = CostCenter::create([
                'code' => $request->code,
                'name' => $request->name,
                'cost_center_category_id' => $request->cost_center_category_id,
                'fiscal_year' => $request->fiscal_year,
                'qty' => $request->qty,
                'unit_id' => $request->unit_id,
                'is_active' => 1
            ]);

            foreach ($request->inv_org as $inv_org) {
                CostCenterOrg::create([
                    'cost_center_id' => $cost_center->cost_center_id,
                    'org_code' => $inv_org['organization_code'],
                    'description' => $inv_org['organization_name'],
                    'type' => 'INV_ORG'
                ]);
            }

            foreach ($request->org_material as $org_material) {
                CostCenterOrg::create([
                    'cost_center_id' => $cost_center->cost_center_id,
                    'org_code' => $org_material['organization_code'],
                    'description' => $org_material['organization_name'],
                    'type' => 'ORG'
                ]);
            }

            foreach ($request->group_production as $group_production) {
                $group_production['cost_center_id'] = $cost_center->cost_center_id;
                $group_production['unit_group_code'] = isset($group_production['unit_group']) ? $group_production['unit_group'] : null;
                $group_production['unit_cost_center_code'] = isset($group_production['unit_cost_center']) ? $group_production['unit_cost_center'] : null;
                ProductGroup::create($group_production);
            }
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
    public function updateCostCenter(Request $request)
    {
        $request->validate([
            'cost_center_id' => 'required',
            'code' => ['required', 'string'],
            'name' => ['required', 'string'],
            'cost_center_category_id' => 'required',
            'inv_org' => 'required',
            'org_material' => 'nullable',
            'qty' => 'required',
            'unit_id' => 'required',
            'fiscal_year' => 'required',
            'group_production' => 'required',
            'group_production.*.code' => 'required',
            'group_production.*.name' => 'required',
        ]);

        $cost_center = CostCenter::find($request->cost_center_id);
        if ($cost_center) {
            $check_same_code = CostCenter::where('code', $request->code)
                ->where('fiscal_year', $request->fiscal_year)
                ->where('cost_center_id', '!=', $cost_center->cost_center_id)
                ->first();
            if ($check_same_code) {
                return response()->json(
                    [
                        "message" => "This code has been used in fiscal year"
                    ],
                    403
                );
            }

            \DB::beginTransaction();
            try {
                $cost_center->code = $request->code;
                $cost_center->name = $request->name;
                $cost_center->cost_center_category_id = $request->cost_center_category_id;
                $cost_center->fiscal_year = $request->fiscal_year;
                $cost_center->qty = $request->qty;
                $cost_center->unit_id = $request->unit_id;
                $cost_center->save();

                CostCenterOrg::where('cost_center_id', $cost_center->cost_center_id)->delete();

                foreach ($request->inv_org as $inv_org) {
                    CostCenterOrg::create([
                        'cost_center_id' => $cost_center->cost_center_id,
                        'org_code' => $inv_org['organization_code'],
                        'description' => $inv_org['organization_name'],
                        'type' => 'INV_ORG'
                    ]);
                }

                foreach ($request->org_material as $org_material) {
                    CostCenterOrg::create([
                        'cost_center_id' => $cost_center->cost_center_id,
                        'org_code' => $org_material['organization_code'],
                        'description' => $org_material['organization_name'],
                        'type' => 'ORG'
                    ]);
                }
    
                foreach ($request->group_production as $group_production) {
                    $isExist =  ProductGroup::where('cost_center_id', $cost_center->cost_center_id)
                        ->where('code', $group_production['code'])
                        ->where('name', $group_production['name'])
                        ->count();

                    $group_production['cost_center_id'] = $cost_center->cost_center_id;
                    $group_production['unit_group_code'] = isset($group_production['unit_group']) ? $group_production['unit_group'] : null;
                    $group_production['unit_cost_center_code'] = isset($group_production['unit_cost_center']) ? $group_production['unit_cost_center'] : null;
                    
                    if ($isExist > 0) {
                        ProductGroup::find($group_production['id'])->update($group_production);
                    }
                    elseif ($isExist == 0) {
                        ProductGroup::create($group_production);
                    }
                }

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
    }

    public function updateIsActive(Request $request)
    {
        $cost_center = CostCenter::updateOrCreate(
            ['cost_center_id' => $request->input('cost_center_id')],
            [
                'is_active' => $request->input('is_active')
            ]
        );
        return response()->json($cost_center);
    }
}
