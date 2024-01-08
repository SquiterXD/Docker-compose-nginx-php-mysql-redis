<?php

namespace App\Http\Controllers\PD\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lookup\ProgramColumn;
use App\Models\Lookup\Program;

class ProgramColumnController extends Controller
{
    public function index()
    { 
        $programNames       = Program::whereNotNull('source_name')->get();   

        $programColumns     = ProgramColumn::orderBy('column_seq_num','ASC')
                                    ->get();

        return view('pd.settings.set-up.index', compact('programNames','programColumns'));        
    }    

    public function show($programCode)
    { 
        $programColumns = ProgramColumn::where('program_code',$programCode)
                        ->orderBy('column_seq_num','ASC')
                        ->get();

        $names          = Program::where('program_code',$programCode)
                        ->get();

        return view('pd.settings.set-up._table_program_column', compact('programColumns', 'programCode', 'names'));        
    }   

    // public function edit($programCode, $columnName)
    // {
    //     dd($programCode, $columnName);

    //     $valueSet = ProgramColumn::where('program_code', $programCode)
    //                                 ->where('column_name', $columnName)
    //                                 ->first();

    //                                 dd($valueSets);

    //     return view('pd.setting.set-up._form'); 
    // }

    public function update(Request $request, $programCode, $columnName)
    {
        // dd($request->all(), $programCode, $columnName);
        
        // $valueSet = ProgramColumn::where('program_code', $programCode)
                                // ->where('column_name', $columnName)
                                // ->first();

        $valueSet = ProgramColumn::where('program_code', $programCode)
                                ->where('column_name', $columnName)
                                ->update([  'column_prompt'     => $request->column_prompt,
                                            'column_seq_num'    => $request->column_seq_num,
                                            'input_type'        => $request->input_type,
                                            'enable_flag'       => $request->enable_flag ?'Y':'N',
                                            'required_flag'     => $request->required_flag ?'Y':'N']);


        // $valueSet->column_prompt            = $request->column_prompt;
        // $valueSet->column_seq_num           = $request->column_seq_num;
        // $valueSet->enable_flag              = $request->enable_flag ?'Y':'N';
        // $valueSet->save();

        return redirect()->route('set-up.show' ,$programCode)->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }
}
