<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Program\ProgramInfoStoreRequest;

use App\Models\ProgramType;
use App\Models\ProgramInfo;

class ProgramInfoController extends Controller
{
    public function __construct()
    {
        $this->module = ['IE', 'IR', 'PM', 'QM', 'OM', 'PD', 'EM', 'IN', 'PP', 'CT'];
        $this->schema = ['IE'=>'OAIE', 'IR'=>'OAIR', 'PM'=>'OAPM', 'QM'=>'OAQM', 'OM'=>'OAOM', 'PD'=>'OAPD', 'EM'=>'OAEAM', 'PP'=>'OAPP', 'CT'=>'OACT'];
        // $this->schema = ['OAIE', 'OAIR', 'OAPM', 'OAQM', 'OAOM', 'OAPD', 'OAEAM'];
    }
   
    public function index(Request $request)
    {
        $search = $request->search;
        $programInfos = ProgramInfo::search($search)->get();
        $programTypes = ProgramType::where('enable_flag', 'Y')->get();
        $statusLists = ['' => 'ทั้งหมด', 'Y' => 'ใช้งานอยู่', 'N' => 'ไม่ใช้งานแล้ว'];
        $moduleLists = $this->module;
        return view('program.info.index', compact('search', 'programInfos', 'programTypes', 'statusLists', 'moduleLists'));
    }

    public function create()
    {
        $programInfo = new ProgramInfo;
        $programTypes = ProgramType::where('enable_flag', 'Y')->get();
        $moduleLists = $this->module;
        $schemaLists = $this->schema;
        $sourceTypeLists = ['', 'TABLE', 'VIEW', 'PACKAGE'];

        return view('program.info.create', compact('programInfo', 'programTypes', 'moduleLists', 'schemaLists', 'sourceTypeLists'));
    }

    public function store(ProgramInfoStoreRequest $request)
    {
        $result = (new ProgramInfo)->submitProgramInfo($request);
        if ($result['status'] == 'E') {
            return redirect()->route('program.info.index')->withErrors('Error: '. $result['message']);
        }

        if ($result['status'] == 'S') {

            if ($result['program_code'] != '') {
                if ($request->program_type == 'SL1' || $request->program_type == 'SL2') {
                    if ($request->source_name) {
                        $programColumns = (new ProgramInfo)->insertProgramColumn($result['program_code']);
                    }
                }
            }
            
            return redirect()->route('program.info.index')->with('success', 'ทำการอินเตอร์เฟสข้อมูลเข้าระบบเรียบร้อยแล้ว');
        }
    }

    public function edit($programCode)
    {
        $programInfo = ProgramInfo::where('program_code', $programCode)->first();
        $programTypes = ProgramType::where('enable_flag', 'Y')->get();
        $moduleLists = $this->module;
        $schemaLists = $this->schema;
        $sourceTypeLists = ['', 'TABLE', 'VIEW', 'PACKAGE'];
        return view('program.info.edit', compact('programInfo', 'programTypes', 'moduleLists', 'schemaLists', 'sourceTypeLists'));
    }

    public function update(Request $request)
    {
        try {
            \DB::beginTransaction();
            $user = auth()->user();
            $programType = ProgramInfo::where('program_code', $request->old_program_code)
                                        ->update(['description'    => $request->description
                                            , 'program_type_name'  => $request->program_type
                                            , 'schemas_name'       => $request->schema
                                            , 'module_name'        => $request->module
                                            , 'enable_flag'        => $request->enable? 'Y': 'N'
                                            , 'updated_at'         => date('Y-m-d H:i:s')
                                            , 'updated_by_id'      => $user->user_id
                                            , 'last_update_date'   => date('Y-m-d H:i:s')
                                            , 'insert_flag'        => $request->insert? 'Y': 'N'
                                            , 'update_flag'        => $request->update? 'Y': 'N'
                                            , 'delete_flag'        => $request->delete? 'Y': 'N'
                                            , 'source'             => $request->source_type
                                            , 'source_name'        => $request->source_name
                                            //PATH
                                            , 'archive_directory'  => $request->archive_directory
                                            , 'output_directory'   => $request->output_directory
                                            , 'error_directory'    => $request->error_directory
                                            , 'log_directory'      => $request->log_directory
                                        ]);
            \DB::commit();
            return redirect()->route('program.info.index')->with('success', 'ทำการอัพเดตข้อมูลเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->route('program.info.index')->withErrors('Error: '. $e->message());
        }
    }
}
