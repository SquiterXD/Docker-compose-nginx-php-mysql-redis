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


use App\Models\PM\Settings\RecipesV;
use App\Models\PM\Settings\FormulaType;
use App\Models\PM\Settings\YearsV;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PM\FormulaExport;

class CopyProductionFormulaController extends Controller
{
    const url = '/pm/settings/copy-production-formula';


    public function index(Request $request)
    {
        // dd(request()->all());
        
        $profile           = getDefaultData(self::url);
        $url               = self::url;
        $user              = auth()->user();
        $organizationCode  = $user->organization ? $user->organization->organization_code : '';
        $organizationId    = $user->organization ? $user->organization->organization_id : '';

        // $toPeriodYears       = YearsV::orderBy('year_thai', 'asc')->get();
        $toPeriodYears      = YearsV::selectRaw("
                distinct year_thai value, year_thai as label
            ")
            ->whereNotNull('year_thai')
            ->orderBy("label")
            ->get()
            ->toArray();
            // dd($toPeriodYears);
        $formulaType       = FormulaType::where('description', 'สูตรมาตรฐาน')->first();
        $formulaTypeID     = $formulaType ? $formulaType->lookup_code : '';

        $data              = RecipesV::where('org_id', $profile->organization_id)->where('folmula_type', $formulaTypeID)->where('status', 'Approved for General Use');

        $periodYear        = request()->get('period_year', false);
        $toPeriodYear      = request()->get('to_period_year', false);
        $searchData = [
            'period_year'         => $periodYear,
            'to_period_year'      => $toPeriodYear,
            'search_url'          => route('pm.settings.copy-production-formula.index')
        ];
        $dataLists = [];
        if ($periodYear) {
            // $dataLists = $data->when($periodYear, function($q) use ($periodYear) {
            //     $q->where('period_year', $periodYear);
            // });
            $dataLists = RecipesV::selectRaw('distinct recipe_id, inventory_item_id, org_id, organization_code, qty,	
                                        version, folmula_type, machine,	status,	invoice_flag, period_year, start_date,	
                                        end_date, wip, routing_id,	creation_date')
                            ->where('organization_code', $organizationCode)
                            ->where('folmula_type', $formulaTypeID)
                            ->where('status', 'Approved for General Use')
                            ->when($periodYear, function($q) use ($periodYear) {
                                $q->where('period_year', $periodYear);
                            })
                            ->orderBy('recipe_id', 'desc');
        }
        $periodYearList     = [];
        $periodYearData     = clone $data;
        $data               = $data->count();
        if ($data) {
            $periodYearData        = $periodYearData->selectRaw("
                distinct period_year value, period_year as label
            ")
            ->whereNotNull('period_year')
            ->orderBy("label")
            ->get();

            if (count($periodYearData)) {
                $periodYearList = array_merge($periodYearList, $periodYearData->toArray());
            }
        }

        if ($request->ajax()) {
            if ($dataLists) {
            
                $filterTotal = clone $dataLists;
                $filterTotal = $filterTotal->get()->count();
                $results = $dataLists
                    ->skip($request->start)->get()
                    ;
                foreach($results as $item) {
                    $item->_item_number = $item->item->item_number;
                    $item->_item_desc = $item->item->item_desc;
                    $item->_f_description = $item->FormulaType->description;
                    $item->_routing_desc = $item->routing->routing_desc;
                    $item->_oprn_desc = $item->opmRouting->oprn_desc ?? '';
                    $item->_start_date =parseToDateTh($item->start_date);
                    $item->_end_date =parseToDateTh($item->end_date);
                    $item->_action = '';
            
                    $item->_checkbox = "<div class='text-center'><input type='checkbox' class='list-checkbox' value='". $item->recipe_id ."' /></div>";
                    $item->_checkbox_approve = "<div class='text-center'><input type='checkbox' class='approve-checkbox' value='". $item->recipe_id ."' /></div>";
                    
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
                // dd(count($results), $request->draw, $filterTotal, $filterTotal);
                return ["draw"=> $request->draw,
                "recordsTotal"=> $filterTotal,
                "recordsFiltered"=> $filterTotal,
                "data"=> $results];
            }
        }

        $countData = '';

        if ($dataLists) {
            $countData = clone $dataLists;
            $countData = $countData->get()->count();
        }

        return view('pm.settings.copy-production-formula.index', compact('organizationId', 'organizationCode', 'searchData', 'url', 'periodYearList', 'toPeriodYears', 'dataLists', 'countData'));

    }

    public function copyFormula()
    {
        $user = auth()->user();
        $errors = [];
        // dd(request()->all());

        foreach (request()->value as $value) {
            // $checkValueApprove = in_array($value, request()->approve_value);
            $old = RecipesV::where('recipe_id', $value)->first();
            $oldLines = RecipesV::where('recipe_id', $value)->orderBy('line_no', 'asc')->get();

            // dd(request()->all(), $old);

            $type = FormulaType::find(request()->folmula_type);
   
            $year = YearsV::where('year_thai', request()->year)->first();

            $startDate  = $year->start_date;
            $endDate    = $year->end_date;

            $checkVersion = RecipesV::where('inventory_item_id', $old->inventory_item_id)
                    ->where('folmula_type', $old->folmula_type)
                    ->where('machine', $old->machine)
                    ->where('wip', $old->wip)
                    ->where('period_year', request()->year)
                    ->orderBy('version', 'desc')
                    ->first();

            if ($checkVersion) {
                $version = $checkVersion->version + 1;
            } else {
                $version = 1;
            }

            // dd($old, $checkVersion, $version);

            $ingredient                    = new Ingredient;
            $ingredient->inventory_item_id = $old->inventory_item_id;
            $ingredient->org_id            = $old->org_id;
            $ingredient->qty               = $old->qty;
            $ingredient->uom               = $old->uom;         
            $ingredient->version           = $version;
            $ingredient->folmula_type      = $old->folmula_type;
            $ingredient->machine           = $old->machine;
            $ingredient->status            = 'New';
            $ingredient->start_date        = $startDate;
            $ingredient->end_date          = $endDate;
            $ingredient->wip               = $old->wip;
            $ingredient->routing_id        = $old->routing_id;
            $ingredient->created_by        = $user->user_id;
            $ingredient->attribute10       = $old->invoice_flag;
            $ingredient->period_year       = request()->year;
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

                $item = PtpmItemNumberV::where('organization_id', $ingredient->org_id)->where('inventory_item_id', $ingredient->inventory_item_id)->first();

                if ($interface['message']) {
                    $msg = $interface['message'];
                } else {
                    $msg = $ingredient->interfaced_msg;
                }

                $errormsg = 'ทำการเพิ่มข้อมูล'. $item->item_number . 'version ' . $ingredient->version . 'ไม่สำเร็จ เนื่องจาก' . $msg;
                
                array_push($errors, $errormsg);
            }else {
                $ingredient->refresh();
                // \Log::info(" --- Copy Formula Begin ---- ");
                // \Log::info($ingredient->recipe_id);
                // \Log::info(" --- Copy Formula End ---- ");
                
                // --- Approve Start ---
                if (request()->approve_value) {
                    $checkValueApprove = in_array($value, request()->approve_value);

                    if ($checkValueApprove) {
                        $recipe = RecipesV::where('recipe_id', $ingredient->recipe_id)->first();
                        $recipeLines = RecipesV::where('recipe_id', $ingredient->recipe_id)->orderBy('line_no', 'asc')->get();

                        //Ingredient
                        $ingredientApprove                    = new Ingredient;
                        $ingredientApprove->inventory_item_id = $recipe->inventory_item_id;
                        $ingredientApprove->org_id            = $recipe->org_id;
                        $ingredientApprove->qty               = $recipe->qty;
                        $ingredientApprove->uom               = $recipe->uom;         
                        $ingredientApprove->version           = $recipe->version;
                        $ingredientApprove->folmula_type      = $recipe->folmula_type;
                        $ingredientApprove->machine           = $recipe->machine;
                        $ingredientApprove->status            = 'Approved';
                        $ingredientApprove->start_date        = $recipe->start_date;
                        $ingredientApprove->end_date          = $recipe->end_date;
                        $ingredientApprove->wip               = $recipe->wip;
                        $ingredientApprove->routing_id        = $recipe->routing_id;
                        $ingredientApprove->created_by        = $user->user_id;
                        $ingredientApprove->approved_by       = $user->user_id;
                        $ingredientApprove->recipe_id         = $recipe->recipe_id;
                        $ingredientApprove->attribute10       = $recipe->invoice_flag;
                        $ingredientApprove->period_year       = $recipe->period_year;
                        $ingredientApprove->formula_id        = $recipe->formula_id;
                        $ingredientApprove->recipe_id         = $recipe->recipe_id;
                        $ingredientApprove->save();

                        //Ingredient Items
                        if ($recipeLines) {
                            foreach ($recipeLines as $recipeLine) {
                                $ingredientItemApprove                         = new IngredientItem;
                                $ingredientItemApprove->ingredient_id          = $ingredient->ingredient_id;
                                $ingredientItemApprove->ingredient_step_line   = $recipeLine->ingredient_step_line;
                                $ingredientItemApprove->ingredient_item_id     = $recipeLine->ingredient_item_id;
                                $ingredientItemApprove->ingredient_folmula_qty = $recipeLine->ingredient_folmula_qty;
                                if ( ($recipeLine->ingredient_qty == 0 && $recipeLine->ingredient_folmula_qty) || $recipeLine->ingredient_folmula_qty == 0 ) {
                                    $ingredientItemApprove->ingredient_loss        = 0;
                                } else {
                                    $ingredientItemApprove->ingredient_loss        = (($recipeLine->ingredient_qty / $recipeLine->ingredient_folmula_qty) * 100)-100;
                                }
                                $ingredientItemApprove->ingredient_qty         = $recipeLine->ingredient_qty;
                                $ingredientItemApprove->ingredient_uom         = $recipeLine->ingredient_uom;
                                $ingredientItemApprove->status                 = 'Y';
                                $ingredientItemApprove->created_by             = $user->user_id;
                                $ingredientItemApprove->routingstep_id         = $recipeLine->routingstep_id;
                                $ingredientItemApprove->save();
                            }
                        }
                        
                        $interfaceApprove = $ingredientApprove->interfaceData($ingredientApprove->ingredient_id, 'APPROVED');
                        
                        // \Log::info(" --- Copy Formula Approve Begin ---- ");
                        // \Log::info($interfaceApprove['status']);
                        // \Log::info(" --- Copy Formula Approve End ---- ");

                        if ($interfaceApprove['status'] == 'E') {

                            $item = PtpmItemNumberV::where('organization_id', $ingredientApprove->org_id)->where('inventory_item_id', $ingredientApprove->inventory_item_id)->first();
            
                            if ($interfaceApprove['message']) {
                                $msg = $interfaceApprove['message'];
                            } else {
                                $msg = $ingredientApprove->interfaced_msg;
                            }
            
                            $errormsg = 'ทำการอนุมัติข้อมูล'. $item->item_number . 'version ' . $ingredientApprove->version . 'ไม่สำเร็จ เนื่องจาก' . $msg;
                            
                            array_push($errors, $errormsg);
                        }
                    }
                }
                // --- Approve End ---
            }
        }
        $msgError = '';
        if ($errors) {
            foreach ($errors as $error) {
                if ($loop->first) {
                    $msgError = $error;
                } else {
                    $msgError = $msgError . $error;
                }
                
                
            }
        }

        if ($msgError) {
            return redirect()->back()->with('error', $msgError);
        } else {
            return redirect()->back()->with('success', 'บันทึกข้อมูลในระบบเรียบร้อย');
        }
    }

    public function Export()
    {
        return Excel::download(new FormulaExport(), 'PMS0033'.'.xlsx');
    }
}
