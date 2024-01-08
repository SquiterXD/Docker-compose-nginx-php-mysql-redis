<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\LookUpRepository;
use App\Models\Lookup\EmployeeType;

use App\Models\Lookup\ProgramColumn;
use App\Models\Lookup\Program;

use App\Models\Lookup\ValueSetup;

use App\Models\Menu;
use App\Models\OM\CustomerContractGroup;

use App\Models\Budget\GLDepartmentV;
use App\Models\EAM\AssetV;
use App\Models\Lookup\MachineType;
use App\Models\INV\ItemLocation;

class LookupController extends Controller
{

    public function index(Request $request)
    {
        // dd(request()->all(), request()->programCode);
        // $lookups = checkProgram(request()->programCode);
        $profile = getDefaultData();
        $program =  Program::where('program_code', request()->programCode)->first();
        $programColumns = $program->programColumns;

        // if (!canEnter('/lookup?programCode='.$program->program_code) || !canView('/lookup?programCode='.$program->program_code)) {
        //     return redirect()->back()->withError(trans('403'));
        // }

        $lookups = ValueSetup::where('lookup_type', $program->source_name)
                ->orderBy('enabled_flag', 'desc')
                ->orderBy('lookup_code','asc')
                ->when($program->program_code == 'PMS0040', function($q) use($profile) {
                    $q->where('tag', $profile->organization_code);
                })
                ->when($program->program_code == 'PMS0027', function($q) use($profile) {
                    $q->where('attribute1', $profile->organization_code);
                })
                ->when($program->program_code == 'PMS0001', function($q) use($profile) {
                    $q->where('attribute1', $profile->organization_code);
                })
                ->when($program->program_code == 'QMS0024', function($q) use($program) {
                    $dataOPN = ValueSetup::where('attribute1', $program->program_code)
                                        ->where('enabled_flag', 'Y')
                                        ->where('lookup_type', 'PTQM_OPN')
                                        ->get();
                    $arrayValueOPN = [];
                    foreach ($dataOPN as $key => $value) {
                        array_push($arrayValueOPN,$value['description']);
                    }
                    $q->whereIn('attribute5', $arrayValueOPN)
                      ->where('enabled_flag', 'Y');
                })
                ->when($program->program_code == 'QMS0025', function($q) use($program) {
                    $dataOPN = ValueSetup::where('attribute1', $program->program_code)
                                        ->where('lookup_type', 'PTQM_OPN')
                                        ->where('enabled_flag', 'Y')
                                        ->get();
                    $arrayValueOPN = [];
                    foreach ($dataOPN as $key => $value) {
                        array_push($arrayValueOPN,$value['description']);
                    }
                    $q->whereIn('attribute5', $arrayValueOPN)
                      ->where('enabled_flag', 'Y');
                })
                ->when($program->program_code == 'QMS0026', function($q) use($program) {
                    $dataOPN = ValueSetup::where('attribute1', $program->program_code)
                                        ->where('lookup_type', 'PTQM_OPN')
                                        ->where('enabled_flag', 'Y')
                                        ->get();
                    $arrayValueOPN = [];
                    foreach ($dataOPN as $key => $value) {
                        array_push($arrayValueOPN,$value['description']);
                    }
                    $q->whereIn('attribute5', $arrayValueOPN)
                      ->where('enabled_flag', 'Y');
                })
                ->get();

        $lookups->map(function ($item, $key) use($program) {
            if ($program->program_code == 'QMS0024' || $program->program_code == 'QMS0025' || 
                $program->program_code == 'QMS0026' || $program->program_code == 'QMS0021'      ) 
            {
                $getQualityProcedureDes = ValueSetup::where('lookup_type', 'PTQM_OPERATION_CLASS')
                                                    ->where('lookup_code', $item['attribute5'])
                                                    ->value('description');
                $item->displayQualityProcedure = $item['attribute5']. ': ' .$getQualityProcedureDes;

                $arrayWord = explode("-",$item->meaning);
                $getDeptDes = GLDepartmentV::where('meaning', $arrayWord[0])->value('description');
                $item->displayDept = $arrayWord[0]. ': ' .$getDeptDes;

                $machineTypeAsset = AssetV::where('asset_id', $item->attribute13)->value('machine_type');
                $item->displayAssetNumber = AssetV::where('asset_id', $item->attribute13)->value('asset_number');
                $item->displayMachineTypeDes = MachineType::where('lookup_code', $machineTypeAsset)->value('description');
                
                if($program->program_code == 'QMS0021'){
                    $segment1 = ItemLocation::where('inventory_location_id', $item->attribute8)->value('segment1');
                    $segment2 = ItemLocation::where('inventory_location_id', $item->attribute8)->value('segment2');
                    $item->displayItemLocation = $segment1. "." .$segment2;
                }
            }
        });

        $menu = Menu::where('program_code', $program->program_code)->first();

        return view('lookup.index', compact('lookups', 'programColumns', 'program', 'menu'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        // $lookup = getNewProgram(request()->programCode);
        
        $lookup = new ValueSetup;

        $program =  Program::where('program_code', request()->programCode)->first();
        $programColumns = $program->programColumns;
        $menu = Menu::where('program_code', $program->program_code)->first();

        return view('lookup.create', compact('lookup', 'programColumns', 'program', 'user', 'menu'));
    }

    public function store(Request $request)
    {  
        $result = (new LookUpRepository)->validateData($request);
        // $result = $this->validateData($request);
        if (count($result)) {
            $msg = '';
            foreach ($result as $key => $value) {
                $msg = $msg . $value['err_msg'];
            }

            return redirect()->back()->withInput()->with('error', $msg);
            return redirect()->route('lookup.index', ['programCode' => $request->programCode])->with('error', $msg);
        }
        
        $program        =  Program::where('program_code', request()->programCode)->first();
        $programColumns = $program->programColumns->pluck('column_name')->toArray();
        if (request()->START_DATE_ACTIVE && request()->END_DATE_ACTIVE) {
            if (date('Y-m-d', strtotime(request()->END_DATE_ACTIVE)) < date('Y-m-d', strtotime(request()->START_DATE_ACTIVE))) {
                $request->validate([
                    'check_date' => 'required',
                    
                ],[
                    'check_date.required' => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้'
                ]);
            }
        }

        $columnRequireds = $program->programColumns->where('required_flag', 'Y')->pluck('column_name')->toArray(); 
        
        foreach ($columnRequireds as $columnRequired) {
            $request->validate([
                $columnRequired => 'required',
                
            ],[
                "$columnRequired.required" => 'ข้อมูลไม่ครบถ้วน'
            ]);
        }
        
        $checkDuplicate = getDuplicate($program, $request, null);
        if ($checkDuplicate) {
            return redirect()->back()->withInput()->with('error', 'ทำการเพิ่มข้อมูลไม่สำเร็จ เนื่องจากข้อมูลซ้ำกับในระบบ');
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('error', 'ทำการเพิ่มข้อมูลไม่สำเร็จ เนื่องจากข้อมูลซ้ำกับในระบบ');
        }    
        
        $insetData = (new LookUpRepository)->insertData($request, 'ADD', $program);

        if ($insetData['status'] == 'C') {
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
        } else {

            $lookupType = 'LOOKUP-TYPE='. $program->source_name . ',';

            $msg = str_replace($lookupType, " ", $insetData['p_message']);
            
            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $msg;

            // dd($errormsg);

            return redirect()->back()->withInput()->with('error', $errormsg);
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('error', $errormsg);
        }
        
    }

    public function edit($lookupCode)
    {
        $user = auth()->user();
        // $lookup = getProgramTest(request()->programCode, $lookupCode);
        $program =  Program::where('program_code', request()->programCode)->first();
        $programColumns = $program->programColumns;

        $lookup = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', $lookupCode)
                            ->first();

        if ($program->program_code == 'QMS0024' || $program->program_code == 'QMS0025' || 
            $program->program_code == 'QMS0026' || $program->program_code == 'QMS0021'      ) 
        {
            $getQualityProcedureDes = ValueSetup::where('lookup_type', 'PTQM_OPERATION_CLASS')
                                                ->where('lookup_code', $lookup['attribute5'])
                                                ->value('description');
            $lookup->displayQualityProcedure = $lookup['attribute5']. ': ' .$getQualityProcedureDes;

            $arrayWord = explode("-",$lookup->meaning);
            $getDeptDes = GLDepartmentV::where('meaning', $arrayWord[0])->value('description');
            $lookup->displayDept = $arrayWord[0]. ': ' .$getDeptDes;

            $machineTypeAsset = AssetV::where('asset_id', $lookup->attribute13)->value('machine_type');
            $lookup->displayAssetNumber = AssetV::where('asset_id', $lookup->attribute13)->value('asset_number');
            $lookup->displayMachineTypeDes = MachineType::where('lookup_code', $machineTypeAsset)->value('description');
            
            if($program->program_code == 'QMS0021'){
                $segment1 = ItemLocation::where('inventory_location_id', $lookup->attribute8)->value('segment1');
                $segment2 = ItemLocation::where('inventory_location_id', $lookup->attribute8)->value('segment2');
                $lookup->displayItemLocation = $segment1. "." .$segment2;
            }
        }

        // dd($lookup);

        $menu = Menu::where('program_code', $program->program_code)->first();

        return view('lookup.edit', compact('lookup', 'programColumns', 'program', 'user', 'menu'));
    }

    public function update(Request $request, $lookupCode)
    {
        $program =  Program::where('program_code', request()->programCode)->first();
        $lookup = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', $lookupCode)
                            ->first();

        $result = (new LookUpRepository)->validateData($request, $lookup);                    
        // $result = $this->validateData($request, $lookup);

        if (count($result)) {
            $msg = '';
            foreach ($result as $key => $value) {
                $msg = $msg . $value['err_msg'];
            }
            return redirect()->back()->withInput()->with('error', $msg);
            return redirect()->route('lookup.index', ['programCode' => $request->programCode])->with('error', $msg);
        }

        if (request()->START_DATE_ACTIVE && request()->END_DATE_ACTIVE) {
            if (date('Y-m-d', strtotime(request()->END_DATE_ACTIVE)) < date('Y-m-d', strtotime(request()->START_DATE_ACTIVE))) {
                $request->validate([
                    'check_date' => 'required',
                    
                ],[
                    'check_date.required' => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้'
                ]);
            }
        }
        

        // $lookup = getProgramTest(request()->programCode, $lookupCode);
        $program =  Program::where('program_code', request()->programCode)->first();

        // $columnRequireds = $program->programColumns->where('required_flag', 'Y')->pluck('column_name')->toArray(); 
        $columnRequireds = $program->programColumns->where('required_flag', 'Y')->where('column_name', '!=', 'LOOKUP_CODE')->pluck('column_name')->toArray(); 

        foreach ($columnRequireds as $columnRequired) {
            $request->validate([
                $columnRequired => 'required',
                
            ],[
                "$columnRequired.required" => 'ข้อมูลไม่ครบถ้วน'
            ]);
        }

        $lookup = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', $lookupCode)
                            ->first();

        $checkDuplicate = getDuplicate($program, $request, $lookup);

        if ($checkDuplicate) {
            return redirect()->back()->withInput()->with('error', 'ทำการแก้ไขข้อมูลไม่สำเร็จ เนื่องจากข้อมูลซ้ำกับในระบบ');
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('error', 'ทำการแก้ไขข้อมูลไม่สำเร็จ เนื่องจากข้อมูลซ้ำกับในระบบ');
        }

        $insetData = (new LookUpRepository)->dataUpdate($request, 'UPDATE', $program, $lookup);

        // $errormsg = 'ทำการแก้ไขข้อมูลไม่สำเร็จ ' . $insetData['p_message'];

        if ($insetData['status'] == 'C') {
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('success', 'ทำการแก้ไขเรียบร้อยแล้ว');
        } else {
            $lookupType = 'LOOKUP-TYPE='. $program->source_name . ',';

            $msg = str_replace($lookupType, " ", $insetData['p_message']);
            
            $errormsg = 'ทำการแก้ไขข้อมูลไม่สำเร็จ ' . $msg;
            return redirect()->back()->withInput()->with('error', $errormsg);
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('error', $errormsg);
        }
        
        
    }

    public function destroy($lookupCode)
    {
        $program =  Program::where('program_code', request()->programCode)->first();

        $lookup = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', $lookupCode)
                            ->first();

        if (request()->programCode == 'OMS0043') {
            $check = CustomerContractGroup::where('credit_group_code', $lookup->lookup_code)->first();

            if ($check) {
                return redirect()->back()->with('error', 'มีการใช้กลุ่มวงเงินเชื่อนี้ในข้อมูลร้านค้าแล้ว ไม่สามารถลบได้');
            }
        }
                    
        $insetData = (new LookUpRepository)->dataDel($lookup, 'DELETE', $program->source_name);

        if ($insetData['status'] == 'C') {
            return redirect()->back()->with('success','ทำการลบเรียบร้อยแล้ว');
        } else {
            $lookupType = 'LOOKUP-TYPE='. $program->source_name . ',';

            $msg = str_replace($lookupType, " ", $insetData['p_message']);
            
            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $msg;

            return redirect()->back()->with('error', $errormsg);
        }
    }

    public function search()
    {
        $search = request()->search;
        $id     = request()->id;
        $programCode = request()->program_code;

        $programColumn = ProgramColumn::where('program_code', request()->program_code)
                                    ->where('column_name', request()->program_column)
                                    ->first();

        // $limit = $programColumn->remote_limit ? $programColumn->remote_limit : 50;  
        $limit = $programColumn->remote_limit;

        if ($limit) {
            if ($search) {
                $keyWords = explode(',' , $programColumn->remote_search);
                $dataSearch = '';
    
                foreach ($keyWords as $key => $value) {
                    if ($key == 0) {
                        if (str_contains($programColumn->sql_text, 'WHERE')) {
                            $dataSearch .= " and $value like '%$search%'";
                        }else {
                            $dataSearch .= " WHERE $value like '%$search%'";
                        }
                    }else {
                        $dataSearch .= " or $value like '%$search%'";
                    }
                    
                }            
                if((request()->program_code =='PMS0014' || request()->program_code =='EMS0003') && request()->program_column === 'ATTRIBUTE1') {
                    $sqlQueryString = sprintf($programColumn->sql_text, $id);
                    $data = collect(\DB::select("
                        SELECT	t2.*
                            FROM	(SELECT	 ROWNUM AS rn, t1.*
                                            FROM	 ( {$sqlQueryString}
                                        {$dataSearch}
    
                                    ) t1
                                        WHERE	 ROWNUM <= {$limit}) t2
                            WHERE	t2.rn >= 1
                    "));
                } else {
                    $data = collect(\DB::select("
                    SELECT	t2.*
                        FROM	(SELECT	 ROWNUM AS rn, t1.*
                                        FROM	 ( {$programColumn->sql_text}
                                     {$dataSearch}
    
                                ) t1
                                    WHERE	 ROWNUM <= {$limit}) t2
                        WHERE	t2.rn >= 1
                    "));
                }
                  
    
                if ($id) {
                    $dataDefault = collect(\DB::select("$programColumn->sql_text"))->where('value', $id);
                    $data = array_merge($data->toArray(), $dataDefault->toArray());
                }
            } else {
                if((request()->program_code =='PMS0014' || request()->program_code =='EMS0003') && request()->program_column === 'ATTRIBUTE1') {
                        $sqlQueryString = sprintf($programColumn->sql_text, $id);
    
                        $data = collect(\DB::select("
                        SELECT	t2.*
                            FROM	(SELECT	 ROWNUM AS rn, t1.*
                                            FROM	 ( {$sqlQueryString}
    
                                    ) t1
                                        WHERE	 ROWNUM <= {$limit}) t2
                            WHERE	t2.rn >= 1
                        "));
                      
                } else {
                    $data = collect(\DB::select("
                        SELECT	t2.*
                            FROM	(SELECT	 ROWNUM AS rn, t1.*
                                            FROM	 ( {$programColumn->sql_text}
    
                                    ) t1
                                        WHERE	 ROWNUM <= {$limit}) t2
                            WHERE	t2.rn >= 1
                        "));
                }
                if ($id) {
                    $dataDefault = collect(\DB::select("$programColumn->sql_text"))->where('value', $id);
    
                    $data = array_merge($data->toArray(), $dataDefault->toArray());
                }
            }
        } else {
            if ($programCode == 'PMS0012' || $programCode == 'PMS0013' ||$programCode == 'PMS0027' || ($programCode == 'PMS0014' || $programCode == 'EMS0003')) {
                // $lookup->sqlByOrg($programColumn->sql_text, $org)
                $user = auth()->user();
                $org  = $user->organization ? $user->organization->organization_code : '';
                $sql = str_replace('$org', $org, $programColumn->sql_text);
                // if ($id) {
                    $data = collect(\DB::select($sql));
                // } else {
                //     $data = collect(\DB::select($programColumn->sql_text));
                // }
            } else {
                if ($id) {
                    $data = collect(\DB::select("$programColumn->sql_text"));
                } else {
                    $data = collect(\DB::select("$programColumn->sql_text"));
                }
            }

        }
        
        // if ($search) {
        //     $keyWords = explode(',' , $programColumn->remote_search);
        //     $dataSearch = '';

        //     foreach ($keyWords as $key => $value) {
        //         if ($key == 0) {
        //             if (str_contains($programColumn->sql_text, 'WHERE')) {
        //                 $dataSearch .= " and $value like '%$search%'";
        //             }else {
        //                 $dataSearch .= " WHERE $value like '%$search%'";
        //             }
        //         }else {
        //             $dataSearch .= " or $value like '%$search%'";
        //         }
                
        //     }            
        //     if((request()->program_code =='PMS0014' || request()->program_code =='EMS0003') && request()->program_column === 'ATTRIBUTE1') {
        //         $sqlQueryString = sprintf($programColumn->sql_text, $id);
        //         $data = collect(\DB::select("
        //             SELECT	t2.*
        //                 FROM	(SELECT	 ROWNUM AS rn, t1.*
        //                                 FROM	 ( {$sqlQueryString}
        //                             {$dataSearch}

        //                         ) t1
        //                             WHERE	 ROWNUM <= {$limit}) t2
        //                 WHERE	t2.rn >= 1
        //         "));
        //     } else {
        //         $data = collect(\DB::select("
        //         SELECT	t2.*
        //             FROM	(SELECT	 ROWNUM AS rn, t1.*
        //                             FROM	 ( {$programColumn->sql_text}
        //                          {$dataSearch}

        //                     ) t1
        //                         WHERE	 ROWNUM <= {$limit}) t2
        //             WHERE	t2.rn >= 1
        //         "));
        //     }
              

        //     if ($id) {
        //         $dataDefault = collect(\DB::select("$programColumn->sql_text"))->where('value', $id);
        //         $data = array_merge($data->toArray(), $dataDefault->toArray());
        //     }
        // } else {
        //     if((request()->program_code =='PMS0014' || request()->program_code =='EMS0003') && request()->program_column === 'ATTRIBUTE1') {
        //             $sqlQueryString = sprintf($programColumn->sql_text, $id);

        //             $data = collect(\DB::select("
        //             SELECT	t2.*
        //                 FROM	(SELECT	 ROWNUM AS rn, t1.*
        //                                 FROM	 ( {$sqlQueryString}

        //                         ) t1
        //                             WHERE	 ROWNUM <= {$limit}) t2
        //                 WHERE	t2.rn >= 1
        //             "));
                  
        //     } else {
        //         $data = collect(\DB::select("
        //             SELECT	t2.*
        //                 FROM	(SELECT	 ROWNUM AS rn, t1.*
        //                                 FROM	 ( {$programColumn->sql_text}

        //                         ) t1
        //                             WHERE	 ROWNUM <= {$limit}) t2
        //                 WHERE	t2.rn >= 1
        //             "));
        //     }
        //     if ($id) {
        //         $dataDefault = collect(\DB::select("$programColumn->sql_text"))->where('value', $id);

        //         $data = array_merge($data->toArray(), $dataDefault->toArray());
        //     }
        // }

        return response()->json($data);  
    }

    public function updateHeaderName(Request $request, $programCode)
    {
        $program           = Program::where('program_code', $programCode)->first();
        $lookups           = ValueSetup::where('lookup_type', $program->source_name)->get();
        $headerDescription = $request->header_description;

        try {
            \DB::beginTransaction();

            foreach ($lookups as $lookup) {
                // dd('updateHeaderName', $lookup);
                $insetData = (new LookUpRepository)->dataUpdateHeader($headerDescription, 'UPDATE', $program, $lookup);
    
                if ($insetData['status'] == 'E') {
                    \DB::rollback();
                    $lookupType = 'LOOKUP-TYPE='. $program->source_name . ',';
                    $msg = str_replace($lookupType, " ", $insetData['p_message']);
                    
                    $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $msg;
                    return redirect()->back()->withInput()->with('error', $errormsg);
                }
            }
    
            \DB::commit();
            return redirect()->route('lookup.index', ['programCode' => $program->program_code])->with('success', 'ทำการแก้ไขเรียบร้อยแล้ว');

        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
        
    }
}
