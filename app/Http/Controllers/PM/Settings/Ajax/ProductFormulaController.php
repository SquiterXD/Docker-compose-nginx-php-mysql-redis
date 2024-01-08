<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\OpmRoutingV;
use App\Models\PM\Settings\Ingredient;
use App\Models\PM\PtpmItemNumberV;

use App\Models\PM\Settings\ItemConvUomV;
use App\Models\PM\Settings\MachineType;
use App\Models\PM\Settings\MachineGroupF;

use App\Models\PM\Settings\RecipesV;

use App\Models\PM\Settings\FormulaType;
use App\Models\PM\PtpmManufactureStep;

use App\Models\PM\Settings;

use App\Models\PM\Settings\SetupMfgDepartmentsV;
use App\Models\PM\Settings\OrganizationCodeV;

class ProductFormulaController extends Controller
{
    public function getItemHeader()
    {
        if (request()->org_code) {
            $org = request()->org_code;
        } else {
            $user = auth()->user();
            $org = $user->organization ? $user->organization->organization_code : '';
            // $org = auth()->user()->organization_id;
        }

        // $text  = request()->get('query');
        $text  = strtoupper(request()->get('query'));

        if ($org == 'MG6' || $org == 'MPG') {
            $data = PtpmItemNumberV::where('user_item_type', 'Finished good')
                                ->where('organization_code', $org)
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('item_number', 'like', "%${text}%")
                                            // ->orWhere('item_desc', 'like', "%${text}%")
                                            ->orWhereRaw("UPPER(item_desc) like ?", "%${text}%")
                                            ->orWhere('inventory_item_id', 'like', "%${text}%");
                                    });
                                })
                                ->forM06andMPG($org)
                                ->where('inventory_item_status_code', 'Active')
                                // ->whereRaw("inventory_item_status_code", "UPPER(active)")
                                // ->limit(50)
                                ->orderBy('item_number', 'asc')
                                ->get();
        } else if ($org == 'M05') {
            $data = PtpmItemNumberV::ForM05($org)
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('item_number', 'like', "%${text}%")
                                            // ->orWhere('item_desc', 'like', "%${text}%")
                                            ->orWhereRaw("UPPER(item_desc) like ?", "%${text}%")
                                            ->orWhere('inventory_item_id', 'like', "%${text}%");
                                    });
                                })
                                ->where('inventory_item_status_code', 'Active')
                                // ->whereRaw("inventory_item_status_code", "UPPER(active)")
                                // ->limit(50)
                                ->orderBy('item_number', 'asc')
                                ->get();
        }  else if ($org == 'M06') {
            $data = PtpmItemNumberV::whereIn('user_item_type', ['Semi Finished Goods', 'Finished good'])
                                ->where('organization_code', $org)
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('item_number', 'like', "%${text}%")
                                            // ->orWhere('item_desc', 'like', "%${text}%")
                                            ->orWhereRaw("UPPER(item_desc) like ?", "%${text}%")
                                            ->orWhere('inventory_item_id', 'like', "%${text}%");
                                    });
                                })
                                ->where('inventory_item_status_code', 'Active')
                                // ->limit(50)
                                ->orderBy('item_number', 'asc')
                                ->get();
        }else {
            $data = PtpmItemNumberV::where('user_item_type', 'Semi Finished Goods')
                                ->where('organization_code', $org)
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('item_number', 'like', "%${text}%")
                                            // ->orWhere('item_desc', 'like', "%${text}%")
                                            ->orWhereRaw("UPPER(item_desc) like ?", "%${text}%")
                                            ->orWhere('inventory_item_id', 'like', "%${text}%");
                                    });
                                })
                                ->where('inventory_item_status_code', 'Active')
                                // ->whereRaw("inventory_item_status_code", "UPPER(active)")
                                // ->when($item, function ($query, $item) {
                                //     return $query->where(function($r) use ($item) {
                                //         $r->where('item_number', 'like', "%${item}%")
                                //             ->orWhere('item_desc', 'like', "${item}%")
                                //     });
                                // })
                                // ->limit(50)
                                ->orderBy('item_number', 'asc')
                                ->get();
        }
        

        // $data = PtpmItemNumberV::whereIn('user_item_type', ['Finished good', 'Semi Finished Goods'])
        //                         ->where('organization_code', $org)
        //                         ->when($text, function ($query, $text) {
        //                             return $query->where(function($r) use ($text) {
        //                                 $r->where('item_number', 'like', "%${text}%")
        //                                     ->orWhere('item_desc', 'like', "${text}%")
        //                                     ->orWhere('inventory_item_id', 'like', "${text}%");
        //                             });
        //                         })
        //                         // ->when($item, function ($query, $item) {
        //                         //     return $query->where(function($r) use ($item) {
        //                         //         $r->where('item_number', 'like', "%${item}%")
        //                         //             ->orWhere('item_desc', 'like', "${item}%")
        //                         //     });
        //                         // })
        //                         ->limit(50)
        //                         ->get();

        return response()->json($data);
    }

    public function getItem()
    {
        // dd('xx', request()->all());
        if (request()->org_id) {
            $org = request()->org_id;
        } else {
            $org = auth()->user()->organization_id;
        }
        $organization = OrganizationCodeV::where('organization_id', $org)->first();
        $org_code     = $organization ? $organization->organization_code : '';

        // $text  = request()->get('query');
        $text  = strtoupper(request()->get('query'));
        // dd($org);

        if ($org_code == 'M06') {
            $wipIssues = SetupMfgDepartmentsV::where('enable_flag', 'Y')
                                ->where('wip_transaction_type_name', 'WIP Issue')
                                ->where('organization_id', $org)
                                ->get()
                                ->pluck('tobacco_group_code');

            $data = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])
                                ->where('organization_id', $org)
                                ->whereIn('tobacco_group_code', $wipIssues)
                                ->where('inventory_item_status_code', 'Active');

            // dd($wipIssues, $data);
        } else {
            $data = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])
                                ->where('organization_id', $org)
                                ->where('inventory_item_status_code', 'Active');
        }
        
        // $data = PtpmItemNumberV::whereIn('user_item_type', ['Raw Material', 'Semi Finished Goods'])
        //                         ->where('organization_id', $org);
        $defaultData = clone $data;

        $defIngredientItemId = (request()->def_ingredient_item_id ?? []);
        $defIngredientItemData = [];
        $itemList = [];
        if (count($defIngredientItemId) > 0) {
            $itemList = [];
            foreach ($defIngredientItemId as $key => $item) {
                $item = json_decode($item);
                $itemList[] = $item->ingredient_item_id;
            }
            if (count($itemList)) {
                $defIngredientItemData = $defaultData->whereIn('inventory_item_id', $itemList)->get();
            }
        }

        $data = $data->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('item_number', 'like', "%${text}%")
                        // ->orWhere('item_desc', 'like', "%${text}%")
                        ->orWhereRaw("UPPER(item_desc) like ?", "%${text}%")
                        ->orWhere('inventory_item_id', 'like', "%${text}%");
                });
            })
            ->when(count($defIngredientItemData) > 0, function ($query) use ($itemList) {
                return $query->whereNotIn('inventory_item_id', $itemList);
            })
            // ->limit(10)
            ->orderBy('item_number', 'asc')
            ->get();

        if (count($defIngredientItemData)) {
            $data = array_merge($data->toArray(), $defIngredientItemData->toArray());
        }
        
        return response()->json($data);
    }

    public function getWipStep()
    {
        if (request()->org_id) {
            $org = request()->org_id;
        } else {
            $org = auth()->user()->organization_id;
        }

        // dd($org);

        $data = OpmRoutingV::where('owner_organization_id', $org)->where('routing_desc', request()->routing_desc)->active()->orderBy('routingstep_no', 'asc')->get();

        // dd($org, $data);
        return response()->json($data);
    }

    public function getVersion()
    {
        // dd(request()->all());
        $organizationCode = request()->organization_code;

        if ($organizationCode == 'MPG' || $organizationCode == 'M12') {
            $wipStep = null;
        } else {
            $wipStep = request()->wip_step;
        }
        if ($organizationCode == 'M06'){
            $wipStep = request()->multi_wip_step;
        } else {
            $wipStep = request()->wip_step;
        }
        if (request()->header_id) {
            // $checkOldVersion = Ingredient::where('ingredient_id', request()->header_id)
            //                             ->where('inventory_item_id', request()->inventory_item_id)
            //                             ->where('folmula_type', request()->folmula_type)
            //                             ->where('machine', request()->machine)
            //                             ->where('wip', request()->wip_step)
            //                             ->first();

            $checkOldVersion = RecipesV::where('recipe_id', request()->header_id)
                                    ->where('inventory_item_id', request()->inventory_item_id)
                                    ->where('folmula_type', request()->folmula_type)
                                    ->where('machine', request()->machine)
                                    ->where('wip', $wipStep)
                                    ->where('period_year', request()->period_year)
                                    ->orderBy('version', 'desc')
                                    ->first();

            if ($checkOldVersion) {
                $data = $checkOldVersion->version;
            } else {
                // $old = Ingredient::where('ingredient_id', '!=', request()->header_id)
                //                 ->where('inventory_item_id', request()->inventory_item_id)
                //                 ->where('folmula_type', request()->folmula_type)
                //                 ->where('machine', request()->machine)
                //                 ->where('wip', request()->wip_step)
                //                 ->orderBy('ingredient_id', 'desc')
                //                 ->first();

                $old = RecipesV::where('recipe_id', '!=', request()->header_id)
                                ->where('inventory_item_id', request()->inventory_item_id)
                                ->where('folmula_type', request()->folmula_type)
                                ->where('machine', request()->machine)
                                ->where('wip', $wipStep)
                                ->where('period_year', request()->period_year)
                                ->orderBy('version', 'desc')
                                ->first();

                if ($old) {
                    $data = $old->version + 1;
                } else {
                    $data = 1;
                }
            }
        } else {
            // $version = Ingredient::where('inventory_item_id', request()->inventory_item_id)
            //             ->where('folmula_type', request()->folmula_type)
            //             ->where('machine', request()->machine)
            //             ->where('wip', request()->wip_step)
            //             ->orderBy('ingredient_id', 'desc')
            //             ->first();

            $version = RecipesV::where('inventory_item_id', request()->inventory_item_id)
                        ->where('folmula_type', request()->folmula_type)
                        ->where('machine', request()->machine)
                        ->where('wip', $wipStep)
                        ->where('period_year', request()->period_year)
                        ->orderBy('version', 'desc')
                        ->first();

            // dd(request()->inventory_item_id, request()->folmula_type, request()->machine, $wipStep, $version);

            if ($version) {
                $data = $version->version + 1;
            } else {
                $data = 1;
            }
            // dd($data, $version);
        }

        return response()->json($data);
    }

    public function getUom()
    {
        if (request()->org_id) {
            $org = request()->org_id;
        } else {
            $org = auth()->user()->organization_id;
        }

        // dd(request()->all(), $org);
        $checkData = '';
        if (request()->uom_code) {
            $checkData =  ItemConvUomV::where('inventory_item_id', request()->inventory_item_id)
                                        ->where('organization_id', $org)
                                        ->where('from_uom_code', request()->uom_code)
                                        ->first();
        }
        // dd($checkData, request()->uom_code);

        $text  = strtoupper(request()->get('query'));

        if ($checkData) {
            $uom = request()->uom_code;
            $uomLists = [];

            $data = ItemConvUomV::where('inventory_item_id', request()->inventory_item_id)
                                ->where('organization_id', $org)
                                // ->when($uom, function ($query, $uom) {
                                //     return $query->where(function($r) use ($uom) {
                                //         $r->where('from_uom_code', 'like', "%${uom}%");
                                //     });
                                // })
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('from_uom_code', 'like', "%${text}%")
                                          ->orWhere('from_unit_of_measure', 'like', "%${text}%");
                                    });
                                })
                                ->when($uom, function ($query) use ($uom) {
                                    return $query->where('from_uom_code', '!=', $uom);
                                })
                                // ->limit(50)
                                ->get();

            // dd($data, $checkData);
            $uomLists = array_merge($data->toArray());
            array_push($uomLists, $checkData);

            // dd($uomLists);
            
        } else {

            $item = PtpmItemNumberV::whereIn('user_item_type', ['Finished good', 'Semi Finished Goods'])
                                        ->where('organization_id', $org)
                                        ->where('inventory_item_id', request()->inventory_item_id)
                                        ->first();

            $uom = $item->primary_uom_code;
            $uomLists = ItemConvUomV::where('inventory_item_id', request()->inventory_item_id)
                                ->where('organization_id', $org)
                                ->when($text, function ($query, $text) {
                                    return $query->where(function($r) use ($text) {
                                        $r->where('from_uom_code', 'like', "%${text}%")
                                          ->orWhere('from_unit_of_measure', 'like', "%${text}%");
                                    });
                                })
                                // ->limit(50)
                                ->get();
        }

        $orcCode = \App\Models\MtlParameter::selectRaw('organization_code')
                    ->where('organization_id', $org)
                    ->first();

        if (request()->get('uom_code', '') == '' && $orcCode) {
            // if ($orcCode->organization_code == 'MG6') {
            //     $uom = 'CG';
            // } else if ($orcCode->organization_code == 'M05') {
            //     $uom = 'PG.';
            // } else {
            //     $uom = $uom;
            // }

            if ($orcCode->organization_code == 'MG6') {
                $uom = 'CG';
            } elseif ($orcCode->organization_code == 'M05') {
                $uom = 'PG.';
            } else {
                $uom = $uom;
            }
        }


        return response()->json([
            'data' => [
                'uomLists' => $uomLists,
                'uom'      => $uom,
            ]
        ]);
    }

    public function getMachineType()
    {
        $org = request()->org_code;

        // dd($org, request()->all());
        
        if ($org == 'M05') {
            $data = MachineGroupF::all();
        } else {
            $data = MachineType::where('attribute1', request()->wip_step)->get();
        }

        return response()->json($data);
    }

    public function getInvoiceFlag()
    {
        $check = RecipesV::where('inventory_item_id', request()->inventory_item_id)
            ->where('folmula_type', request()->folmula_type)
            ->where('period_year', request()->period_year)
            ->where('invoice_flag', 'Y')
            ->orderBy('version', 'desc')
            ->first();

        if ($check) {
            $data = 'Y';
        } else {
            $data = 'N';
        }
        return response()->json($data);
        
    }

}
