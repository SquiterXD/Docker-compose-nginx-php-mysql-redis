<?php

namespace App\Http\Controllers\Planning\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lookup\ProgramColumn;
use App\Models\Lookup\Program;

use App\Models\Lookup\ValueSetup;
use App\Repositories\LookUpRepository;

use App\Models\Menu;

class YearlyProdLineController extends Controller
{
    public function index()
    {
        // dd('xxxxxxx');
        $program =  Program::where('source_name', 'PTPP_EST_YEARLY_PROD_LINE')->first();

        $programColumns = $program->programColumns;

        $lookup = ValueSetup::where('lookup_type', $program->source_name)->first() ?? new ValueSetup;

        $menu = Menu::where('program_code', $program->program_code)->first();

        return view('planning.settings.yearly-prod-line.index', compact('lookup', 'programColumns', 'program', 'menu'));
    }

    public function store(Request $request)
    {
        $program =  Program::where('source_name', 'PTPP_EST_YEARLY_PROD_LINE')->first();
        $programColumns = $program->programColumns;

        $lookup = ValueSetup::where('lookup_type', $program->source_name)->where('lookup_code', request()->id)->first();

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
            return redirect()->route('planning.settings.yearly-prod-line.index')->with('error', 'ทำการเพิ่มข้อมูลไม่สำเร็จ เนื่องจากข้อมูลซ้ำกับในระบบ');
        }       


        // dd($request->all(), $program, $lookup);

        if ($lookup) {
            $insetData = (new LookUpRepository)->dataUpdate($request, 'UPDATE', $program, $lookup);

            $errormsg = 'ทำการแก้ไขข้อมูลไม่สำเร็จ ' . $insetData['message'];
    
            if ($insetData['status'] == 'C') {
                return redirect()->route('planning.settings.yearly-prod-line.index')->with('success', 'ทำการแก้ไขเรียบร้อยแล้ว');
            } else {
                return redirect()->route('planning.settings.yearly-prod-line.index')->with('error', $errormsg);
            }
        } else {
            $insetData = (new LookUpRepository)->insertData($request, 'ADD', $program);
            $errormsg = 'ทำการเพิ่มข้อมูลไม่สำเร็จ ' . $insetData['message'];

            if ($insetData['status'] == 'C') {
                return redirect()->route('planning.settings.yearly-prod-line.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
            } else {
                return redirect()->route('planning.settings.yearly-prod-line.index')->with('error', $errormsg);
            }
        }
        
    }
}
