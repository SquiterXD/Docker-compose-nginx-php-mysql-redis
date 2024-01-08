<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\Ingredient;
use App\Models\PM\Settings\IngredientStep;
use App\Models\PM\Settings\IngredientItem;

use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\Settings\MachineType;
use App\Models\FndUser;
use App\Models\PM\Settings\OpmRoutingV;
use App\Models\PM\Settings\OpenClassV;
use App\Models\PM\Settings\OrganizationCodeV;
use App\Models\PM\Settings\FmOprnCls;
use App\Models\PM\Settings\FormulaStatus;

use App\Models\PM\PtpmManufactureStep;

use App\Models\PM\PtpmMfgFormulaV;

use App\Models\PM\Settings\RecipesV;
use App\Models\PM\Settings\FormulaType;
use App\Models\PM\Settings\YearsV;

//Page
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Http;

use App\Models\PM\Settings\ItemConvUomV;
use App\Models\PM\Settings\MachineGroupF;

class ProductionFormulaController extends Controller
{
    const url = '/pm/settings/production-formula';

    public function index(Request $request)
    {
        if (request()->action === 'search_get_param') {
            return $this->getParam(request());
        }
        // $test = Http::get(env('APP_WEBSERVICE').'/pm/settings/production-formula');

        // $testx2 = url()->current();

        // dd($testx2);
        // dd(request()->all());
        $user = auth()->user();
        $organizationCode  = $user->organization ? $user->organization->organization_code : '';
        $organizationId  = $user->organization ? $user->organization->organization_id : '';

        // dd($organizationCode);

        $formulaTypes = FormulaType::get();
        $wipSteps     = PtpmManufactureStep::where('owner_organization', $organizationCode)->get();
        $machineTypes = MachineType::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $periodYears  = YearsV::orderBy('year_thai', 'asc')->get();

        // $status         = request()->status;
        // $folmulaType     = request()->folmula_type;
        $wipStep         = request()->wip_step;
        // $machine         = request()->machine;
        // $inventoryItemId = request()->inventory_item_id;

        $status             = request()->get('status', false);
        $inventoryItemId    = request()->get('inventory_item_id', false);
        $folmulaType        = request()->get('folmula_type', false);
        $wip                = request()->get('wip', false);
        $machine            = request()->get('machine', false);
        $version            = request()->get('version', false);
        $periodYear         = request()->get('period_year', false);
        $url                = self::url;

        $searchData = [
            'status'              => $status,
            'folmula_type'        => $folmulaType,
            'wip_step'            => $wipStep,
            'machine'             => $machine,
            'inventory_item_id'   => $inventoryItemId,
            'wip'                 => $wip,
            'version'             => $version,
            'period_year'         => $periodYear,
            'search_url'          => route('pm.settings.production-formula.index')
        ];

        // dd($searchData);

        $dataLists = [];

        if ($status || $inventoryItemId || $folmulaType || $wip || $machine || $version || $periodYear) {

            $headerNews = RecipesV::selectRaw('distinct recipe_id, inventory_item_id, org_id, organization_code, qty,	
                                        version, folmula_type, machine,	status,	invoice_flag, period_year, start_date,	
                                        end_date, wip, routing_id,	creation_date')
                            ->where('organization_code', $organizationCode)
                            ->when($status, function($q) use ($status) {
                                $q->where('status', $status);
                            })->when($inventoryItemId, function($q) use ($inventoryItemId) {
                                $q->where('inventory_item_id', $inventoryItemId);
                            })->when($folmulaType, function($q) use ($folmulaType) {
                                $q->where('folmula_type', $folmulaType);
                            })->when($wip, function($q) use ($wip) {
                                $q->where('wip', $wip);
                            })->when($machine, function($q) use ($machine) {
                                $q->where('machine', $machine);
                            })->when($version, function($q) use ($version) {
                                $q->where('version', $version);
                            })->when($periodYear, function($q) use ($periodYear) {
                                $q->where('period_year', $periodYear);
                            })
                            ->orderBy('recipe_id', 'desc');
                            // ->get();

            // $dataLists = $this->paginate($headerNews);

            
        } else {
            $headerNews = RecipesV::selectRaw('distinct recipe_id, inventory_item_id, org_id, organization_code, qty,	
                                        version, folmula_type, machine,	status,	invoice_flag, period_year, start_date,	
                                        end_date, wip, routing_id,	creation_date')
                            ->where('organization_code', $organizationCode)
                            ->orderBy('recipe_id', 'desc');
            //                 ->get();
            // $dataLists = $this->paginate($headerNews);
        }
        if($request->ajax()) {
            $filterTotal = clone $headerNews;
            $filterTotal = $filterTotal->get()->count();
            $results = $headerNews
            ->skip($request->start)->take($request->length)->get()
            ;
            foreach($results as $item) {
                $item->_item_number = $item->item->item_number ?? '';
                $item->_item_desc = $item->item->item_desc ?? '';
                $item->_f_description = $item->FormulaType->description ?? '';
                $item->_routing_desc = $item->routing->routing_desc ?? '';
                $item->_oprn_desc = $item->opmRouting->oprn_desc ?? '';
                $item->_start_date = $item->start_date ? parseToDateTh(date('Y-m-d', strtotime($item->start_date))) : '';
                $item->_end_date = $item->end_date ? parseToDateTh(date('Y-m-d', strtotime($item->end_date))) : '';
                $item->_action = '';
                if ($item->recipe_id) : 
                    $item->_action .= '<a href="'. route('pm.settings.production-formula.show', $item->secure_id) .'" class="btn btn-white btn-xs pull-left">
                                <i class="fa fa-file-text-o"></i> รายละเอียด
                            </a>';
                            if ($item->status == 'New' || $item->status == 'สร้างใหม่'):
                                $item->_action .= '<a href="'. route('pm.settings.production-formula.edit', $item->recipe_id) .'" class="btn btn-warning btn-xs pull-right">
                                    <i class="fa fa-edit m-r-xs"></i> แก้ไข
                                </a>';
                        endif;
                endif;
                if ($organizationCode == 'M05') {
                   $item->_machineGroupF = $item->machineGroupF ? $item->machineGroupF->description : '';
                }else {
                    $item->_machineGroupF = $item->machineType ? $item->machineType->description : ''; 
                }
                if ($item->status == 'Approved for General Use') {
                    $item->_label_status = 'อนุมัติ';
                }else if ($item->status == 'New') {
                    $item->_label_status = 'สร้างใหม่';
                    
                }else if ($item->status == 'Obsolete/Archived') { 
                    $item->_label_status = 'ยกเลิก';
                }
            }
            return ["draw"=> $request->draw,
            "recordsTotal"=> $filterTotal,
            "recordsFiltered"=> $filterTotal,
            "data"=> $results];
        }
        // $dataLists = $this->paginate($headerNews->get());

        // dd(request()->all());



        // $data = RecipesV::where('organization_code', $org)->get()->groupBy('recipe_id');

        // $xxx = RecipesV::limit(10)->get();
        // $xxx = RecipesV::where('organization_code', $org)
        //                     ->distinct('recipe_id')
        //                     ->orderBy('recipe_id', 'desc')
        //                     ->paginate(25);

        // dd($xxx);

        // $headerNews = RecipesV::selectRaw('distinct recipe_id, inventory_item_id, org_id, organization_code, qty,	
        //                                 version, folmula_type, machine,	status,	start_date,	
        //                                 end_date, wip, routing_id,	creation_date')
        //                     ->where('organization_code', $org)
        //                     ->orderBy('recipe_id', 'desc')
        //                     ->paginate(25);
                            // ->limit(10)
                            // ->get();
        
        // dd($headerNews);
        // dd(getDefaultData('/users')->organization_code);
        $headers = Ingredient::where('org_id', $user->organization_id)->orderBy('ingredient_id', 'desc')->paginate(25);

        // $headers = Ingredient::orderBy('ingredient_id', 'desc')->paginate(25);
        $url = self::url;
        return view('pm.settings.production-formula.index', compact('headers', 'headerNews', 'formulaTypes', 'wipSteps', 'machineTypes', 'organizationId', 'organizationCode', 'dataLists', 'folmulaType', 'wipStep', 'machine', 'inventoryItemId', 'searchData', 'url', 'periodYears'));
    }
    
    public function create()
    {
        // dd('create', auth()->user(), auth());
        $user          = auth()->user();        
        $organizationCode = $user->organization ? $user->organization->organization_code : '';
        $orgM06 = $organizationCode == 'M06' ? true : false;
        // $itemHeaders   = PtpmItemNumberV::whereIn('user_item_type', ['Finished good', 'Semi Finished Goods'])->where('organization_id', $user->organization_id)->orderBy('item_number', 'asc')->get()->take(100);
        // $items         = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])->where('organization_id', $user->organization_id)->orderBy('item_number', 'asc')->get()->take(100);
        $users          = FndUser::get();
        $machineTypes   = MachineType::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $routings       = OpmRoutingV::where('owner_organization_id', $user->organization_id)->orderBy('routing_desc', 'asc')->get()->groupBy('routing_desc');
        $wipSteps       = OpmRoutingV::where('owner_organization_id', $user->organization_id)
                                        ->when($orgM06, function($q) {
                                            $q->where('attribute4', 'Y');
                                         })
                                        ->active()
                                        ->orderBy('oprn_class_desc', 'asc')
                                        ->get();
        // dd($wipSteps);

        $oprns          = $wipSteps->unique('oprn_id')->all();
        $organizations  = OrganizationCodeV::all();
        $oprnClass      = FmOprnCls::all();
        $formulaStatus  = FormulaStatus::where('enabled_flag', 'Y')->get();



        $wipStepHeaders = PtpmManufactureStep::where('owner_organization', $organizationCode)->get();

        $formulaTypes = FormulaType::get();
        // dd($routings);
        // $routings     = $wipSteps->unique('routing_no')->all();


        $uomLists     =  \DB::select("select c.unit_of_measure,c.uom_code,c.uom_class
                                from MTL_UOM_CONVERSIONS c
                                where c.uom_class in(select x.uom_class 
                                                    from MTL_UOM_CONVERSIONS x)");

        // dd($oprnClass);

        // dd($itemHeaders);
        $header = (object) [];
        $header->creation_date_format = parseToDateTh(now());
        $header->start_date = date('Y-m-d');
        $header->creation_year = date('Y') + 543;

        $years = YearsV::orderBy('year_thai', 'asc')->get();

        $wipSteps = $wipSteps->groupBy('routing_desc')->mapWithKeys(function ($item, $group) {
            return [$group => $item];
        });
        $url = self::url;

        return view('pm.settings.production-formula.create', compact('users', 'machineTypes', 'routings', 'wipSteps', 'oprns', 'uomLists', 
                    'organizations', 'oprnClass', 'formulaStatus', 'wipStepHeaders', 'organizationCode', 'formulaTypes', 'header', 'years', 'url'));
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $org  = $user->organization ? $user->organization->organization_code : '';
        $year = YearsV::where('year_thai', request()->period_year)->first();
        
        // dd('store', request()->all());
        if ($org == 'MPG' || $org == 'M12') {
            $wipStep = null;
        } else if ($org == 'M06'){
            $wipStep = request()->multi_wip_step;
        } else {
            $wipStep = request()->wip_step;
        }
        // dd('store', request()->all(), $wipStep);

        $old = RecipesV::where('inventory_item_id', request()->inventory_item_id)
                    ->where('folmula_type', request()->folmula_type)
                    ->where('machine', request()->machine)
                    ->where('wip', $wipStep)
                    ->where('period_year', request()->period_year)
                    ->orderBy('version', 'desc')
                    ->first();

        if ($old) {
            $version = $old->version + 1;
        } else {
            $version = 1;
        }

        // dd(request()->all(), $version);

        $routing = OpmRoutingV::where('owner_organization_id', $user->organization_id)->where('routing_desc', request()->routing_desc)->first();

        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = request()->inventory_item_id;
        $ingredient->org_id            = $user->organization_id;
        $ingredient->qty               = str_replace(',', '', request()->qty);
        $ingredient->uom               = request()->uom_code;         
        $ingredient->version           = $version;
        $ingredient->folmula_type      = request()->folmula_type;
        $ingredient->machine           = request()->machine;
        $ingredient->status            = 'New';
        $ingredient->wip               = $wipStep;
        $ingredient->routing_id        = $routing->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->period_year       = request()->period_year;
        $ingredient->start_date        = $year ? date('Y-m-d', strtotime($year->start_date)) : '';
        $ingredient->end_date          = $year ? date('Y-m-d', strtotime($year->end_date))   : '';
        $ingredient->comments          = request()->comments;
        $ingredient->save();


        foreach (request()->dataGroupAll as $key => $data) {

            $step = OpmRoutingV::where('oprn_id', $key)->where('routing_desc', request()->routing_desc)->first();

            foreach ($data as $dataKey => $value) {
                // dd(request()->dataGroup, $data, $dataKey, $value, $value['ingredient_loss']);
                $item = PtpmItemNumberV::where('organization_id', $user->organization_id)->where('inventory_item_id', $value['ingredient_item_id'])->first();
                
                $ingredientItem                         = new IngredientItem;
                $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                $ingredientItem->ingredient_step_line   = $step->routingstep_no;
                $ingredientItem->ingredient_item_id     =  str_replace(',', '', $value['ingredient_item_id']);
                $ingredientItem->ingredient_folmula_qty =  str_replace(',', '', $value['ingredient_folmula_qty']);
                $ingredientItem->ingredient_loss        =  str_replace(',', '', $value['ingredient_loss']);
                $ingredientItem->ingredient_qty         = (str_replace(',', '', $value['ingredient_folmula_qty']) * str_replace(',', '', $value['ingredient_loss']) / 100) + str_replace(',', '', $value['ingredient_folmula_qty']);
                // $ingredientItem->ingredient_folmula_qty = str_replace(',', '', $value['ingredient_folmula_qty']);
                // $ingredientItem->ingredient_loss        = str_replace(',', '', $value['ingredient_loss']);
                // $ingredientItem->ingredient_qty         = str_replace(',', '', $value['ingredient_folmula_qty']) + str_replace(',', '', $value['ingredient_loss']);
                // $ingredientItem->ingredient_qty         = ((str_replace(',', '', $value['ingredient_folmula_qty']) * str_replace(',', '', $value['ingredient_loss'])) / 100) + str_replace(',', '', $value['ingredient_folmula_qty']);
                $ingredientItem->ingredient_uom         = $item->primary_uom_code;
                $ingredientItem->status                 = $value['active_flag'] ? 'Y' : 'N';
                $ingredientItem->created_by             = $user->user_id;
                $ingredientItem->routingstep_id         = $step->routingstep_id;
                $ingredientItem->save();
            }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'NEW');

        if ($interface['status'] == 'E') {

            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $interface['message'];

            return redirect()->back()->withInput()->with('error', $errormsg);
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);
        } else {

            $result = Ingredient::where('ingredient_id', $ingredient->ingredient_id)->first();

            return redirect()->route('pm.settings.production-formula.edit', $result->recipe_id)->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
            // return redirect()->route('pm.settings.production-formula.create')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
        }        
        
    }

    public function edit($id)
    {
        $user            = auth()->user();

        $header = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->first();
        $lines  = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();

        // dd('edit', $id, $header);
        $orgM06 = $header->organization_code == 'M06' ? true : false;

        $ingredient      = Ingredient::where('ingredient_id', $id)->first();
        $ingredientStep  = IngredientStep::where('ingredient_id', $id)->first();
        $ingredientSteps = IngredientStep::where('ingredient_id', $id)->get();
        $ingredientItems = IngredientItem::where('ingredient_id', $id)->orderBy('ingredient_line_id','asc')->get();
        $organizations   = OrganizationCodeV::all();

        $items        = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])->where('organization_id', $header->org_id)->get();
        $users        = FndUser::get();
        $machineTypes = MachineType::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $routings     = OpmRoutingV::where('owner_organization_id', $header->org_id)->orderBy('routing_desc', 'asc')->get()->groupBy('routing_desc');
        $wipSteps     = OpmRoutingV::where('owner_organization_id', $header->org_id)
                                    ->when($orgM06, function($q) {
                                        $q->where('attribute4', 'Y');
                                    })->orderBy('oprn_class_desc', 'asc')
                                    ->get();
        $oprns        = $wipSteps->unique('oprn_id')->all();
        $oprnClass    = FmOprnCls::all();

        $formulaStatus    = FormulaStatus::where('enabled_flag', 'Y')->get();
        $organizationCode = $user->organization ? $user->organization->organization_code : '';
        $wipStepHeaders   = PtpmManufactureStep::where('owner_organization', $organizationCode)->get();

        $formulaTypes = FormulaType::get();

        $years = YearsV::orderBy('year_thai', 'asc')->get();
        $wipSteps = $wipSteps->groupBy('routing_desc')->mapWithKeys(function ($item, $group) {
            return [$group => $item];
        });

        $routingDesc = OpmRoutingV::where('routing_id', $header->routing_id)->first();
        $header->routing_desc = optional($routingDesc)->routing_desc;
        $url = self::url;

        // $uomHeaderDesc   = optional($header->uomHeader)->from_unit_of_measure;
        // $formulaTypeDesc = optional($header->FormulaType)->description;
        $formulaTypeDesc = FormulaType::where('lookup_code', $header->folmula_type)->first();
        $uomHeader       = ItemConvUomV::where('from_uom_code', $header->uom)->where('organization_id', $header->org_id)->first();
        
        $uomHeaderDesc   = optional($uomHeader) ? optional($uomHeader)->from_uom_code . ' : ' . optional($uomHeader)->from_unit_of_measure : '';

        if ($header->organization_code == 'M05') {
            $machine = MachineGroupF::where('lookup_code', $header->machine)->first();
            $machineDesc = optional($machine)->description;
        }else {
            
            $machine = MachineType::where('lookup_code', $header->machine)->first();
            $machineDesc = optional($machine)->description;
        }

        $header->formula_type_desc = optional($formulaTypeDesc)->description;
        $header->uom_header_desc   = $uomHeaderDesc;
        $header->machine_desc      = $machineDesc;
        

        return view('pm.settings.production-formula.edit', compact('ingredient', 'ingredientStep', 'ingredientItems', 'users', 
                    'machineTypes', 'routings', 'wipSteps', 'oprns', 'ingredientSteps', 'organizations', 'oprnClass', 'items',
                    'formulaStatus', 'organizationCode', 'wipStepHeaders', 'formulaTypes', 'header', 'lines', 'years', 'url'));
        
    }

    public function update(Request $request, $id)
    {
        // dd('update', $id, request()->all());
        $user    = auth()->user();
        $userOrg = $user->organization ? $user->organization->organization_code : '';

        $header  = RecipesV::where('recipe_id', $id)->first();
        $lines   = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();


        $orgCode = $header ? $header->organization_code : $userOrg;

        
        // dd('update xx', $orgCode);

        if ($orgCode == 'MPG' || $orgCode == 'M12') {
            $wipStep = null;
        } else if ($orgCode == 'M06'){
            $wipStep = request()->multi_wip_step;
        } else {
            $wipStep = request()->wip_step;
        }

        // dd('update xx', request()->all(), $wipStep);

        $checkTemp = Ingredient::where('recipe_id', $id)->first();

        $checkOldVersion = RecipesV::where('recipe_id', $id)
                                        ->where('inventory_item_id', request()->inventory_item_id)
                                        ->where('folmula_type', request()->folmula_type)
                                        ->where('machine', request()->machine)
                                        ->where('wip', $wipStep)
                                        ->where('period_year', request()->period_year)
                                        ->first();

        if ($checkOldVersion) {
            $version = $checkOldVersion->version;
        } else {
            $old = RecipesV::where('recipe_id', '!=', $id)
                            ->where('inventory_item_id', request()->inventory_item_id)
                            ->where('folmula_type', request()->folmula_type)
                            ->where('machine', request()->machine)
                            ->where('wip', $wipStep)
                            ->where('period_year', request()->period_year)
                            ->orderBy('version', 'desc')
                            ->first();
            if ($old) {
                $version = $old->version + 1;
            } else {
                $version = 1;
            }
        }

        $year = YearsV::where('year_thai', request()->period_year)->first();
        $routing = OpmRoutingV::where('owner_organization_id', $user->organization_id)->where('routing_id', $header->routing_id)->first();
        // $routing = OpmRoutingV::where('owner_organization_id', $user->organization_id)->where('routing_desc', request()->routing_desc)->first();

        // dd('update', request()->all(), request()->routing_desc, $header);

        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = $header->inventory_item_id;
        $ingredient->org_id            = $user->organization_id;
        $ingredient->qty               = $header->qty;
        $ingredient->uom               = $header->uom;         
        $ingredient->version           = $header->version;
        $ingredient->folmula_type      = $header->folmula_type;
        $ingredient->machine           = $header->machine;
        $ingredient->status            = 'New';
        $ingredient->wip               = $header->wip;
        $ingredient->routing_id        = $header->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->recipe_id         = $header->recipe_id;
        $ingredient->period_year       = $header->period_year;
        $ingredient->start_date        = $header->start_date ? date('Y-m-d', strtotime($header->start_date)) : '';
        $ingredient->end_date          = $header->end_date   ? date('Y-m-d', strtotime($header->end_date))   : '';
        $ingredient->comments          = $header->comments;
        $ingredient->save();

        foreach (request()->dataGroupAll as $key => $data) {
            $step = OpmRoutingV::where('oprn_id', $key)->where('routing_id', $header->routing_id)->first();
            // $step = OpmRoutingV::where('oprn_id', $key)->where('routing_desc', request()->routing_desc)->first();

            // dd(request()->all(), request()->dataGroup, $key, $data, $step);
            // if ($step) {
                foreach ($data as $dataKey => $value) {
    
                    // $activeFlag = array_key_exists('active_flag', $value) ? 'Y' : 'N';
                    if (array_key_exists('active_flag', $value)) {
                        // $activeFlag = $value['active_flag'] == 'true' || $value['active_flag'] == true ? 'Y' : 'N';
                        // if ($value['active_flag'] == 'true') {
                        //    $activeFlag = 'Y';
                        // } elseif ($value['active_flag'] == true) {
                        //     $activeFlag = 'Y';
                        // } else {
                        //    $activeFlag = 'N';
                        // }

                        $activeFlag = !$value['active_flag'] || $value['active_flag'] == 'false' ? 'N' : 'Y';
                        

                        // dd('xxc', array_key_exists('active_flag', $value), $value['active_flag'], $activeFlag);
                    } else {
                        $activeFlag = 'N';
                    }
                    
                    
                    // dd(request()->dataGroupAll, $data, $dataKey, $value, $activeFlag, array_key_exists('active_flag', $value));
                    $item = PtpmItemNumberV::where('organization_id', $user->organization_id)->where('inventory_item_id', $value['ingredient_item_id'])->first();
                    
                    $ingredientItem                         = new IngredientItem;
                    $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                    $ingredientItem->ingredient_step_line   = $step ? $step->routingstep_no : '';
                    $ingredientItem->ingredient_item_id     = $value['ingredient_item_id'];
                    // $ingredientItem->ingredient_folmula_qty = $value['ingredient_folmula_qty'];
                    // $ingredientItem->ingredient_loss        = $value['ingredient_loss'];
                    // $ingredientItem->ingredient_qty         = ($value['ingredient_folmula_qty'] * $value['ingredient_loss'] / 100) + $value['ingredient_folmula_qty'];

                    $ingredientItem->ingredient_folmula_qty = str_replace(',', '', $value['ingredient_folmula_qty']);
                    $ingredientItem->ingredient_loss        = str_replace(',', '', $value['ingredient_loss']);
                    $ingredientItem->ingredient_qty         = ((str_replace(',', '', $value['ingredient_folmula_qty']) * str_replace(',', '', $value['ingredient_loss'])) / 100) + str_replace(',', '', $value['ingredient_folmula_qty']);
                    
                    $ingredientItem->ingredient_uom         = $item->primary_uom_code;
                    // $ingredientItem->status                 = $value['active_flag'] ? 'Y' : 'N';
                    // $ingredientItem->status                 = !$value['active_flag'] ? 'N' : ($value['active_flag'] == 'true' ? 'Y' : 'N');
                    $ingredientItem->status                 = $activeFlag;
                    $ingredientItem->created_by             = $user->user_id;
                    $ingredientItem->routingstep_id         = $step ? $step->routingstep_id : '';
                    $ingredientItem->save();
                    // $stepLine += 10;
                }
            // } else {
            //     // dd(request()->all(), request()->dataGroup, $key, $data, $step);
            //     $activeFlag = array_key_exists('active_flag', $value) ? 'Y' : 'N';

            //     $item = PtpmItemNumberV::where('organization_id', $user->organization_id)->where('inventory_item_id', $value['ingredient_item_id'])->first();
                    
            //     $ingredientItem                         = new IngredientItem;
            //     $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
            //     $ingredientItem->ingredient_step_line   = $step->routingstep_no;
            //     $ingredientItem->ingredient_item_id     = $value['ingredient_item_id'];

            //     // $ingredientItem->ingredient_folmula_qty = $value['ingredient_folmula_qty'];
            //     // $ingredientItem->ingredient_loss        = $value['ingredient_loss'];
            //     // $ingredientItem->ingredient_qty         = ($value['ingredient_folmula_qty'] * $value['ingredient_loss'] / 100) + $value['ingredient_folmula_qty'];

            //     $ingredientItem->ingredient_folmula_qty = str_replace(',', '', $value['ingredient_folmula_qty']);
            //     $ingredientItem->ingredient_loss        = str_replace(',', '', $value['ingredient_loss']);
            //     $ingredientItem->ingredient_qty         = ((str_replace(',', '', $value['ingredient_folmula_qty']) * str_replace(',', '', $value['ingredient_loss'])) / 100) + str_replace(',', '', $value['ingredient_folmula_qty']);
                
            //     $ingredientItem->ingredient_uom         = $item->primary_uom_code;
            //     // $ingredientItem->status                 = $value['active_flag'] ? 'Y' : 'N';
            //     // $ingredientItem->status                 = !$value['active_flag'] ? 'N' : ($value['active_flag'] == 'true' ? 'Y' : 'N');
            //     $ingredientItem->status                 = $activeFlag;
            //     $ingredientItem->created_by             = $user->user_id;
            //     $ingredientItem->routingstep_id         = $step->routingstep_id;
            //     $ingredientItem->save();
            // }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'UPDATE');

        if ($interface['status'] == 'E') {
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);

            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $interface['message'];
            
            return redirect()->back()->withInput()->with('error', $errormsg);

        } else {
           
            return redirect()->route('pm.settings.production-formula.edit', $header->recipe_id)->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');

            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
        }  
    }

    public function show($id)
    {
        $user               = auth()->user();
        $organizationCode   = $user->organization ? $user->organization->organization_code : '';
        $userOrganizationId = $user->organization ? $user->organization->organization_id : '';
        if (is_string($id) && !is_numeric($id)) {
            $id = \Crypt::decryptString($id);
        }

        $header = RecipesV::where('recipe_id', $id)->with('organization')->where('org_id', $userOrganizationId)->firstOrFail();
        $header->creation_year = date('Y') + 543;

        // $lines = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();
        $lines = RecipesV::where('recipe_id', $id)->with('item')->orderBy('segment1', 'asc')->get();
        // dd($id, $header);
        $orgId = $header ? $header->org_id : $userOrganizationId;

        $orgCode = \App\Models\MtlParameter::selectRaw('organization_code')
                    ->where('organization_id', $orgId)
                    ->first();
        $orgCode = $orgCode->organization_code;

        $ingredient       = Ingredient::where('ingredient_id', $id)->with('organization')->first();
        $items            = PtpmItemNumberV::whereIn('user_item_type', ['Finished good', 'Semi Finished Goods'])
                                ->when($orgCode == 'MG6' || $orgCode == 'MPG', function($q) use($orgCode) {
                                    $q->forM06andMPG($orgCode);
                                })
                                ->when($orgCode == 'M05', function($q) use($orgCode) {
                                    $q->forM05($orgCode);
                                })
                                ->where('organization_id', $orgId)
                                ->get();
        $machineTypes     = MachineType::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $wipSteps         = OpmRoutingV::where('owner_organization_id', $orgId)->orderBy('oprn_class_desc', 'asc')->get();
        $oprns            = $wipSteps;
        $oprnClass        = FmOprnCls::all();
        $formulaTypes     = FormulaType::get();
        $wipStepHeaders   = PtpmManufactureStep::where('owner_organization', $organizationCode)->get();
        $periodYears      = YearsV::orderBy('year_thai', 'asc')->get();
        $url = self::url;
        $btnTrans = trans('btn');

        $wipSteps = $wipSteps->groupBy('routing_desc')->mapWithKeys(function ($item, $group) {
            return [$group => $item];
        });
        $routingDesc          = OpmRoutingV::where('routingstep_id', $header->routingstep_id)->first();
        $header->routing_desc = optional($routingDesc)->routing_desc;
        $header->oprn_id      = optional($routingDesc)->oprn_id;
        $header->wip_step_desc = optional($routingDesc)->oprn_desc;
        $itemAlls = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])->where('organization_id', $header->org_id)->get();

        // dd($oprns);
        $uomHeader        = $header ? $header->uomHeader : '';
        $header->uom_desc = optional($uomHeader)->from_unit_of_measure;
        // dd($header, $header->uomHeader, $uomHeader);

        return view('pm.settings.production-formula.show_new', compact('ingredient', 'items', 'machineTypes', 'wipSteps', 'oprns', 'oprnClass', 'header', 'lines', 'formulaTypes', 'wipStepHeaders', 'url', 'periodYears', 'btnTrans', 'oprns', 'itemAlls', 'organizationCode'));
    }

    public function copy($id)
    {
        // dd(request()->all());
        $user = auth()->user();

        // $old = Ingredient::where('ingredient_id', $id)->first();
        $old = RecipesV::where('recipe_id', $id)->first();
        $oldLines = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();

        if (!$old) {
            return redirect()->route('pm.settings.production-formula.index')->with('error', 'ไม่สามารถคัดลอกสูตรได้ เนื่องจากไม่พบสูตรตั้งต้น');
        }

        $type = FormulaType::find(request()->folmula_type);
   
        if ($type->description == 'สูตรมาตรฐาน') {
            $year = YearsV::where('year_thai', request()->period_year)->first();

            $periodYear = request()->period_year;
            $startDate  = $year->start_date ? date('Y-m-d', strtotime($year->start_date)) : '';
            $endDate    = $year->end_date   ? date('Y-m-d', strtotime($year->end_date)) : '';

            $check = RecipesV::where('inventory_item_id', request()->inventory_item_id)
                ->where('folmula_type', request()->folmula_type)
                ->where('period_year', request()->period_year)
                ->where('invoice_flag', 'Y')
                ->orderBy('version', 'desc')
                ->first();

            if ($check) {
                $msg = 'ไม่สามารถคัดลอกสูตรได้ เนื่องจากปีงบประมาณ ' . request()->period_year . ' กองบริหารต้นทุนนำไปใช้แล้ว';
                return redirect()->back()->withInput()->with('error', $msg);
            }

        } else {
            $periodYear = '';
            $startDate  = '';
            $endDate    = '';
        }
        
        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = request()->inventory_item_id;
        $ingredient->org_id            = $old->org_id;
        $ingredient->qty               = $old->qty;
        $ingredient->uom               = $old->uom;         
        $ingredient->version           = request()->version;
        $ingredient->folmula_type      = request()->folmula_type;
        $ingredient->machine           = request()->machine;
        $ingredient->status            = 'New';
        $ingredient->start_date        = $startDate;
        $ingredient->end_date          = $endDate;
        $ingredient->wip               = $old->wip;
        $ingredient->routing_id        = $old->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->attribute10       = $old->invoice_flag;
        $ingredient->period_year       = request()->period_year;
        // $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->save();

        //Copy Ingredient Items
        if ($oldLines) {
            foreach ($oldLines as $oldItem) {

                if ($oldItem->ingredient_qty == 0 || $oldItem->ingredient_folmula_qty == 0) {
                    $loss = 0;
                }else {
                    $loss = (($oldItem->ingredient_qty - $oldItem->ingredient_folmula_qty) / $oldItem->ingredient_folmula_qty) * 100;
                }

                $ingredientItem                         = new IngredientItem;
                $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                $ingredientItem->ingredient_step_line   = $oldItem->ingredient_step_line;
                $ingredientItem->ingredient_item_id     = $oldItem->ingredient_item_id;
                $ingredientItem->ingredient_folmula_qty = $oldItem->ingredient_folmula_qty;
                // $ingredientItem->ingredient_loss        = (($oldItem->ingredient_qty / $oldItem->ingredient_folmula_qty) * 100)-100;
                $ingredientItem->ingredient_loss        = $loss;
                $ingredientItem->ingredient_qty         = $oldItem->ingredient_qty;
                $ingredientItem->ingredient_uom         = $oldItem->ingredient_uom;
                $ingredientItem->status                 = 'Y';
                $ingredientItem->created_by             = $user->user_id;
                $ingredientItem->routingstep_id         = $oldItem->routingstep_id;
                $ingredientItem->save();
            }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'NEW');

        if ($interface['status'] == 'E') {
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);

            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $interface['message'];
            
            return redirect()->back()->withInput()->with('error', $errormsg);
        } else {
            $ingredient->refresh();
            if ($ingredient->recipe_id) {
                return redirect()->route('pm.settings.production-formula.edit', $ingredient->recipe_id)->with('success', 'คัดลอกสูตรเรียบร้อยแล้ว');
            }
            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'คัดลอกสูตรเรียบร้อยแล้ว');
        } 

    }

    public function approve($id)
    {
        $user     = auth()->user();
        $orgCode  = $user->organization ? $user->organization->organization_code : '';
        
        $old = RecipesV::where('recipe_id', $id)->first();
        $oldLines = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();

        if (!$old) {
            return redirect()->route('pm.settings.production-formula.index')->with('error', 'ไม่สามารถส่งอนุมัติสูตรได้ เนื่องจากไม่พบข้อมูลในระบบ');
        }

        // $oldFormulaList = RecipesV::selectRaw("
        //         distinct inventory_item_id, org_id, recipe_id, status
        //     ")
        //     ->approved()
        //     ->where('org_id', $old->org_id)
        //     ->where('inventory_item_id', $old->inventory_item_id)
        //     ->where("recipe_id", '!=', $old->recipe_id)
        //     ->when($old->folmula_type, function($q) use ($old) {
        //         $q->where('folmula_type', $old->folmula_type);
        //     })
        //     ->when($old->machine, function($q) use ($old) {
        //         $q->where('machine', $old->machine);
        //     })
        //     ->get();
        // foreach ($oldFormulaList as $key => $oldFormula) {
        //     $this->inactivePkg($oldFormula->recipe_id);
        // }
        $formulaType = $old->FormulaType ? $old->FormulaType->description : '';
        if ($formulaType == 'สูตรใช้จริง') {
            // $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', request()->start_date)->format('Y-m-d 00:00:00');
            $startDate = date('Y-m-d', strtotime(request()->start_date));
        } else {
            $startDate = $old->start_date ? date('Y-m-d', strtotime($old->start_date)) : '';
        }
        //Ingredient
        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = $old->inventory_item_id;
        $ingredient->org_id            = $old->org_id;
        $ingredient->qty               = $old->qty;
        $ingredient->uom               = $old->uom;         
        $ingredient->version           = $old->version;
        $ingredient->folmula_type      = $old->folmula_type;
        $ingredient->machine           = $old->machine;
        $ingredient->status            = 'Approved';
        $ingredient->start_date        = $startDate;
        $ingredient->end_date          = $old->end_date ? date('Y-m-d', strtotime($old->end_date)) : '';
        $ingredient->wip               = $old->wip;
        $ingredient->routing_id        = $old->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->approved_by       = $user->user_id;
        $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->attribute10       = $old->invoice_flag;
        $ingredient->period_year       = $old->period_year;
        $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->save();
        //Ingredient Items
        if ($oldLines) {
            foreach ($oldLines as $oldItem) {
                $ingredientItem                         = new IngredientItem;
                $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                $ingredientItem->ingredient_step_line   = $oldItem->ingredient_step_line;
                $ingredientItem->ingredient_item_id     = $oldItem->ingredient_item_id;
                $ingredientItem->ingredient_folmula_qty = $oldItem->ingredient_folmula_qty;
                // $ingredientItem->ingredient_loss        = $oldItem->ingredient_qty - $oldItem->ingredient_folmula_qty;
                if ( ($oldItem->ingredient_qty == 0 && $oldItem->ingredient_folmula_qty) || $oldItem->ingredient_folmula_qty == 0 ) {
                    $ingredientItem->ingredient_loss        = 0;
                } else {
                    $ingredientItem->ingredient_loss        = (($oldItem->ingredient_qty / $oldItem->ingredient_folmula_qty) * 100)-100;
                }
                $ingredientItem->ingredient_qty         = $oldItem->ingredient_qty;
                $ingredientItem->ingredient_uom         = $oldItem->ingredient_uom;
                $ingredientItem->status                 = 'Y';
                $ingredientItem->created_by             = $user->user_id;
                $ingredientItem->routingstep_id         = $oldItem->routingstep_id;
                $ingredientItem->save();
            }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'APPROVED');

        return response()->json([
            'data' => [
                'status'  => $interface['status'],
                'message' => $interface['message'],
            ]
        ]);

        if ($interface['status'] == 'E') {
            return redirect()->back()->with('error', $interface['message']);
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);
        } else {
            return redirect()->back()->with('success', 'กดส่งอนุมัติเรียบร้อยแล้ว');
            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'กดส่งอนุมัติเรียบร้อยแล้ว');
        } 
        
    }

    public function inactive($id)
    {
        // dd('xxx', $id);
        $interface = $this->inactivePkg($id);

        return response()->json([
            'data' => [
                'status'  => $interface['status'],
                'message' => $interface['message'],
            ]
        ]);

        if ($interface['status'] == 'E') {
            return redirect()->back()->with('error', $interface['message']);
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);
        } else {
            return redirect()->back()->with('success', 'ยกเลิกเรียบร้อยแล้ว');
            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'ยกเลิกเรียบร้อยแล้ว');
        } 
        
    }


    public function paginate($items, $perPage = 25, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options = ["path" => url()->current(),
                    "pageName" => "page"];
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getParam(Request $request)
    {
        $profile                = getDefaultData(self::url);
        $statusList[]           = ['value' => '', 'label' => 'ท้ังหมด'];
        $inventoryItemIdList[]  = ['value' => '', 'label' => 'ท้ังหมด'];
        $folmulaTypeList[]      = ['value' => '', 'label' => 'ท้ังหมด'];
        $wipList[]              = ['value' => '', 'label' => 'ท้ังหมด'];
        $machineList[]          = ['value' => '', 'label' => 'ท้ังหมด'];
        $versionList[]          = ['value' => '', 'label' => 'ท้ังหมด'];
        $periodYearList[]       = ['value' => '', 'label' => 'ท้ังหมด'];

        $data               = RecipesV::where('org_id', $profile->organization_id);
        $status             = request()->get('status', false);
        $inventoryItemId    = request()->get('inventory_item_id', false);
        $folmulaType        = request()->get('folmula_type', false);
        $wip                = request()->get('wip', false);
        $machine            = request()->get('machine', false);
        $version            = request()->get('version', false);
        $periodYear         = request()->get('period_year', false);

        if ($status || $inventoryItemId || $folmulaType || $wip || $machine || $version || $periodYear) {
            $data = $data->when($status, function($q) use ($status) {
                $q->where('status', $status);
            })->when($inventoryItemId, function($q) use ($inventoryItemId) {
                $q->where('inventory_item_id', $inventoryItemId);
            })->when($folmulaType, function($q) use ($folmulaType) {
                $q->where('folmula_type', $folmulaType);
            })->when($wip, function($q) use ($wip) {
                $q->where('wip', $wip);
            })->when($machine, function($q) use ($machine) {
                $q->where('machine', $machine);
            })->when($version, function($q) use ($version) {
                $q->where('version', $version);
            })->when($periodYear, function($q) use ($periodYear) {
                $q->where('period_year', $periodYear);
            });
        }

        // $data                   = $data->limit(50);
        $data                   = $data;
        $statusData             = clone $data;
        $inventoryItemIdData    = clone $data;
        $folmulaTypeData        = clone $data;
        $wipData                = clone $data;
        $machineData            = clone $data;
        $versionData            = clone $data;
        $periodYearData         = clone $data;
        $data                   = $data->count();
        if ($data) {
            $statusData = $statusData->selectRaw("
                    distinct
                    status value,
                    CASE
                        when status = 'Approved for General Use' then 'อนุมัติ'
                        when status = 'New' then 'สร้างใหม่'
                        when status = 'Obsolete/Archived' then 'ยกเลิก'
                        else ''
                    END
                    as label
            ")
            ->orderBy("label")
            ->whereIn('status', ['Approved for General Use', 'New', 'Obsolete/Archived'])
            ->get();
            $folmulaTypeData    = $folmulaTypeData->selectRaw("distinct folmula_type")->get();
            $wipData            = $wipData->selectRaw("distinct wip")->get();
            $machineData        = $machineData->selectRaw("distinct machine")->get();
            $versionData        = $versionData->selectRaw("
                distinct version value, version as label
            ")
            ->orderBy("label")
            ->get();
            $periodYearData        = $periodYearData->selectRaw("
                distinct period_year value, period_year as label
            ")
            ->whereNotNull('period_year')
            ->orderBy("label")
            ->get();

            $inventoryItemIdData = $inventoryItemIdData->selectRaw("
                    distinct
                    inventory_item_id value,
                    product_segment1 || ' : ' || product_description as label
            ")
            ->orderBy("label")
            ->get();

            if (count($statusData)) {
                $statusList = array_merge($statusList, $statusData->toArray());
            }

            if (count($inventoryItemIdData)) {
                $inventoryItemIdList = array_merge($inventoryItemIdList, $inventoryItemIdData->toArray());
            }

            if (count($folmulaTypeData)) {
                $query = (new RecipesV)->formulaType()->getRelated()->selectRaw("
                    distinct lookup_code value,
                    description as label
                ")
                ->orderBy("label")
                ->whereIn('lookup_code', $folmulaTypeData->pluck('folmula_type', 'folmula_type'))
                ->get();
                $folmulaTypeList = array_merge($folmulaTypeList, $query->toArray());
            }

            if (count($wipData)) {
                $query = (new RecipesV)->opmRouting()->getRelated()->selectRaw("
                    distinct oprn_id value,
                    oprn_desc as label
                ")
                ->orderBy("value")
                ->whereIn('oprn_id', $wipData->pluck('wip', 'wip'))
                ->get();
                $wipList = array_merge($wipList, $query->toArray());
            }

            if (count($machineData)) {
                if ($profile->organization_code == 'M05') {

                    $query = (new RecipesV)->machineGroupF()->getRelated()->selectRaw("
                                distinct lookup_code value,
                                description as label
                            ")
                            ->orderBy("label")
                            ->whereIn('lookup_code', $machineData->pluck('machine', 'machine'))
                            ->get();
                } else {

                    $query = (new RecipesV)->machineType()->getRelated()->selectRaw("
                                distinct lookup_code value,
                                description as label
                            ")
                            ->orderBy("label")
                            ->whereIn('lookup_code', $machineData->pluck('machine', 'machine'))
                            ->get();
                }
                
                
                $machineList = array_merge($machineList, $query->toArray());
            }

            if (count($versionData)) {
                $versionList = array_merge($versionList, $versionData->toArray());
            }

            if (count($periodYearData)) {
                $periodYearList = array_merge($periodYearList, $periodYearData->toArray());
            }
        }

        $data = [
            'status_list'            => $statusList,
            'inventory_item_id_list' => $inventoryItemIdList,
            'folmula_type_list'      => $folmulaTypeList,
            'wip_list'               => $wipList,
            'machine_list'           => $machineList,
            'version_list'           => $versionList,
            'period_year_list'       => $periodYearList,
        ];

        return $data;
    }

    public function inactivePkg($id)
    {
        // dd('inactive', $id);
        $user     = auth()->user();
        $orgCode  = $user->organization ? $user->organization->organization_code : '';
        $old = RecipesV::where('recipe_id', $id)->first();
        $oldLines = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();

        //Ingredient
        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = $old->inventory_item_id;
        $ingredient->org_id            = $old->org_id;
        $ingredient->qty               = $old->qty;
        $ingredient->uom               = $old->uom;         
        $ingredient->version           = $old->version;
        $ingredient->folmula_type      = $old->folmula_type;
        $ingredient->machine           = $old->machine;
        $ingredient->status            = 'Inactive';
        $ingredient->start_date        = $old->start_date ? date('Y-m-d', strtotime($old->start_date)) : '';
        $ingredient->end_date          = $old->end_date   ? date('Y-m-d', strtotime($old->end_date))   : '';
        $ingredient->wip               = $old->wip;
        $ingredient->routing_id        = $old->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->approved_by       = $user->user_id;
        $ingredient->attribute10       = $old->invoice_flag;
        $ingredient->period_year       = $old->period_year;
        $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->save();

        //Ingredient Items
        if ($oldLines) {
            foreach ($oldLines as $oldItem) {
                $ingredientItem                         = new IngredientItem;
                $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                $ingredientItem->ingredient_step_line   = $oldItem->ingredient_step_line;
                $ingredientItem->ingredient_item_id     = $oldItem->ingredient_item_id;
                $ingredientItem->ingredient_folmula_qty = $oldItem->ingredient_folmula_qty;
                // $ingredientItem->ingredient_loss        = $oldItem->ingredient_qty - $oldItem->ingredient_folmula_qty;
                if ( ($oldItem->ingredient_qty == 0 && $oldItem->ingredient_folmula_qty) || $oldItem->ingredient_folmula_qty == 0 ) {
                    $ingredientItem->ingredient_loss        = 0;
                } else {
                    $ingredientItem->ingredient_loss        = (($oldItem->ingredient_qty / $oldItem->ingredient_folmula_qty) * 100)-100;
                }
                $ingredientItem->ingredient_qty         = $oldItem->ingredient_qty;
                $ingredientItem->ingredient_uom         = $oldItem->ingredient_uom;
                $ingredientItem->status                 = 'Y';
                $ingredientItem->created_by             = $user->user_id;
                $ingredientItem->routingstep_id         = $oldItem->routingstep_id;
                $ingredientItem->save();
            }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'INACTIVE');

        return $interface;
    }

    public function active($id)
    {
        $user     = auth()->user();
        $orgCode  = $user->organization ? $user->organization->organization_code : '';
        
        $old = RecipesV::where('recipe_id', $id)->first();
        $oldLines = RecipesV::where('recipe_id', $id)->orderBy('line_no', 'asc')->get();

        if (!$old) {
            return redirect()->route('pm.settings.production-formula.index')->with('error', 'ไม่สามารถส่งอนุมัติสูตรได้ เนื่องจากไม่พบข้อมูลในระบบ');
        }

        //Ingredient
        $ingredient                    = new Ingredient;
        $ingredient->inventory_item_id = $old->inventory_item_id;
        $ingredient->org_id            = $old->org_id;
        $ingredient->qty               = $old->qty;
        $ingredient->uom               = $old->uom;         
        $ingredient->version           = $old->version;
        $ingredient->folmula_type      = $old->folmula_type;
        $ingredient->machine           = $old->machine;
        $ingredient->status            = 'Approved';
        $ingredient->start_date        = $old->start_date ? date('Y-m-d', strtotime($old->start_date)) : '';
        $ingredient->end_date          = $old->end_date   ? date('Y-m-d', strtotime($old->end_date)) : '';
        $ingredient->wip               = $old->wip;
        $ingredient->routing_id        = $old->routing_id;
        $ingredient->created_by        = $user->user_id;
        $ingredient->approved_by       = $user->user_id;
        $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->attribute10       = $old->invoice_flag;
        $ingredient->period_year       = $old->period_year;
        $ingredient->recipe_id         = $old->recipe_id;
        $ingredient->save();
        
        //Ingredient Items
        if ($oldLines) {
            foreach ($oldLines as $oldItem) {
                $ingredientItem                         = new IngredientItem;
                $ingredientItem->ingredient_id          = $ingredient->ingredient_id;
                $ingredientItem->ingredient_step_line   = $oldItem->ingredient_step_line;
                $ingredientItem->ingredient_item_id     = $oldItem->ingredient_item_id;
                $ingredientItem->ingredient_folmula_qty = $oldItem->ingredient_folmula_qty;

                if ( ($oldItem->ingredient_qty == 0 && $oldItem->ingredient_folmula_qty) || $oldItem->ingredient_folmula_qty == 0 ) {
                    $ingredientItem->ingredient_loss        = 0;
                } else {
                    $ingredientItem->ingredient_loss        = (($oldItem->ingredient_qty / $oldItem->ingredient_folmula_qty) * 100)-100;
                }
                $ingredientItem->ingredient_qty         = $oldItem->ingredient_qty;
                $ingredientItem->ingredient_uom         = $oldItem->ingredient_uom;
                $ingredientItem->status                 = 'Y';
                $ingredientItem->created_by             = $user->user_id;
                $ingredientItem->routingstep_id         = $oldItem->routingstep_id;
                $ingredientItem->save();
            }
        }

        $interface = $ingredient->interfaceData($ingredient->ingredient_id, 'APPROVED');

        return response()->json([
            'data' => [
                'status'  => $interface['status'],
                'message' => $interface['message'],
            ]
        ]);

        if ($interface['status'] == 'E') {
            return redirect()->back()->with('error', $interface['message']);
            // return redirect()->route('pm.settings.production-formula.index')->with('error', $interface['message']);
        } else {
            return redirect()->back()->with('success', 'เปิดใช้สูตรเรียบร้อยแล้ว');
            // return redirect()->route('pm.settings.production-formula.index')->with('success', 'กดส่งอนุมัติเรียบร้อยแล้ว');
        } 
        
    }
}
