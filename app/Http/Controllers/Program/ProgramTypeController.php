<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Program\ProgramTypeStoreRequest;

use App\Models\ProgramType;

class ProgramTypeController extends Controller
{
    // S = Data Setup, M = Master, P = Program or Calculate or Transaction, Q = query data, R = Reports
    public function index(Request $request)
    {
        $search = $request->search;
        $programTypes = ProgramType::search($search)->get();
        $statusLists = ['' => 'ทั้งหมด', 'Y' => 'ใช้งานอยู่', 'N' => 'ไม่ใช้งานแล้ว'];
        return view('program.type.index', compact('search', 'programTypes', 'statusLists'));
    }

    public function create()
    {
        $programType = new ProgramType;
        $typeLists = ['S' => 'Data Setup', 'M' => 'Master', 'P' => 'Program/ Calculate/ Transaction', 'Q' => 'Query Data', 'R' => 'Reports'];

        return view('program.type.create', compact('programType','typeLists'));
    }

    public function store(ProgramTypeStoreRequest $request)
    {
        $result = (new ProgramType)->submitProgramType($request);
        if ($result['status'] == 'E') {
            return redirect()->route('program.type.index')->withErrors('Error: '. $result['message']);
        }

        if ($result['status'] == 'S') {
            return redirect()->route('program.type.index')->with('success', 'ทำการอินเตอร์เฟสข้อมูลเข้าระบบเรียบร้อยแล้ว');
        }
    }

    public function edit($programType)
    {
        $programType = ProgramType::where('program_type_name', $programType)->first();
        $typeLists = ['S' => 'Data Setup', 'M' => 'Master', 'P' => 'Program/ Calculate/ Transaction', 'Q' => 'Query Data', 'R' => 'Reports'];

        return view('program.type.edit', compact('programType','typeLists'));
    }

    public function update(Request $request)
    {
        try {
            \DB::beginTransaction();
            $programType = ProgramType::where('program_type_name', $request->old_program_type)
                                        ->update(['program_type_name'   => $request->name
                                            , 'description'             => $request->description
                                            , 'user_program_type_name'  => $request->user_type
                                            , 'program_type'            => $request->program_type
                                            , 'enable_flag'             => $request->enable? 'Y': 'N'
                                            , 'last_update_date'        => date('Y-m-d H:i:s')
                                        ]);
            \DB::commit();
            return redirect()->route('program.type.index')->with('success', 'ทำการอัพเดตข้อมูลเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->route('program.type.index')->withErrors('Error: '. $result['message']);
        }
    }
}
