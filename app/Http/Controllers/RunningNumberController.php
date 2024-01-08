<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RunningNumberHeader;
use App\Models\Menu;
use App\Models\SystemModule;
use App\Models\GroupFormat;
use App\Models\ResetAt;
use App\Models\DateFormat;
use App\Models\YearType;
use App\Models\SeqAssignment;
use App\Models\ProgramInfo;
use App\Models\RunningNumDocument;

class RunningNumberController extends Controller
{
    public function index()
    {
        // dd(request()->all(), '4555');
        $headers = RunningNumberHeader::search(request()->running_code, request()->system_module)->orderBy('doc_seq_header_id', 'asc')->paginate(25);
        $runningNumber = RunningNumberHeader::orderBy('doc_seq_header_id', 'asc')->get();
        // $headers = RunningNumberHeader::search(request()->running_code, request()->system_module)->orderBy('doc_seq_header_id', 'asc')->get();
        // dd($headers->links());
        $modules = SystemModule::all();

        return view('running-number.index', compact('headers', 'modules', 'runningNumber'));
    }

    public function create()
    {
        $programs     = ProgramInfo::orderby('program_code')->get();
        $modules      = SystemModule::all();
        $groupFormats = GroupFormat::all();
        $resetAts     = ResetAt::all();
        $dateFormats  = DateFormat::all();
        $yearTypes    = YearType::all();

        $numDocuments = RunningNumDocument::all();

        $headers      = RunningNumberHeader::all();

        return view('running-number.create', compact('programs', 'modules', 'groupFormats', 'resetAts', 'dateFormats', 'yearTypes', 'numDocuments', 'headers'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $programList = explode(',' , request()->programs_code);
        $formats = request()->group_format;

        $this->validate(request(), [
            'running_code'  => 'required',
            'start_date'    => 'required',
            'reset_at'      => 'required',
            'number_digit'  => 'required',
            'start_digit'   => 'required',
            
        ], [
            'running_code.required'  => 'โปรดระบุ Document Code',
            // 'systemModule.required'  => 'โปรดเลือก ระบบงาน',
            'start_date.required'    => 'โปรดเลือก วันที่เริ่มต้นการใช้งาน',
            'reset_at.required'      => 'โปรดเลือก Running',
            'number_digit.required'  => 'โปรดระบุ Running Number',
            'start_digit.required'   => 'โปรดระบุ Running Number',
            
        ]);

        $oldRunningCode = RunningNumberHeader::where('doc_seq_code', request()->running_code)->orderBy('doc_seq_header_id', 'desc')->first();

        if ($oldRunningCode) {
            if ($oldRunningCode->end_date) {
                // dd(request()->all(), $oldRunningCode);
                if (date('Y-m-d', strtotime(request()->start_date)) <= date('Y-m-d', strtotime($oldRunningCode->end_date))) {
                    $this->validate(request(), [
                        'running_duplicate'  => 'required',
                        
                    ], [
                        'running_duplicate.required'  => 'Document Code เดียวกันไม่สามารถสร้างวันที่ซ้ำซ้อนกันได้',
                        
                    ]);
                }
        
            } else {
                $this->validate(request(), [
                    'running_duplicate'  => 'required',
                    
                ], [
                    'running_duplicate.required'  => 'Document Code เดียวกันไม่สามารถสร้างวันที่ซ้ำซ้อนกันได้',
                    
                ]);
            }
        }


        // $assigment = SeqAssignment::whereIn('assign_program_code', $programList)->first();

        // if ($assigment) {
        //     if ($assigment->runningNumber->active_flag == 'Y') {

        //         $assigmentStrat = date('Y-M-d', strtotime($assigment->runningNumber->start_date));
        //         $assigmentEnd   = date('Y-M-d', strtotime($assigment->runningNumber->end_date));
        //         $stratDate      = date('Y-M-d', strtotime(request()->start_date));

        //         if ($stratDate >= $assigmentStrat && $stratDate <= $assigmentEnd) {
        //             return redirect()->back()->with('error','เมนูซ้ำกับในระบบ');
        //         } 
        //     }            
        // }

        // dd('xxxx');
        $old = RunningNumberHeader::where('doc_seq_description', request()->description)->first();

        // if ($ol) {
        //     return redirect()->back()->w
        // }
        $numDocument = RunningNumDocument::where('lookup_code', request()->running_code)->first();

        if (request()->dataGroup) {
            foreach (request()->dataGroup as $key => $value) {
                // dd(request()->all(), $key, $value, $value['group_format']);
                
                if ($key == 0) {
                    $data['format1'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 1) {
                    $data['format2'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 2) {
                    $data['format3'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 3) {
                    $data['format4'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 4) {
                    $data['format5'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 5) {
                    $data['format6'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 6) {
                    $data['format7'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 7) {
                    $data['format8'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 8) {
                    $data['format9'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                } elseif ($key == 9) {
                    $data['format10'] = $value['group_format'] == '$PREFIX' ? $value['detail'] : $value['group_format'];
                }
            }
        }

        // foreach (request()->group_format as $key => $value) {
        //     if ($key == 0) {
        //         $data['format1'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 1) {
        //         $data['format2'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 2) {
        //         $data['format3'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 3) {
        //         $data['format4'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 4) {
        //         $data['format5'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 5) {
        //         $data['format6'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 6) {
        //         $data['format7'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 7) {
        //         $data['format8'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 8) {
        //         $data['format9'] = $value == '$PREFIX' ? request()->detail : $value;
        //     } elseif ($key == 9) {
        //         $data['format10'] = $value == '$PREFIX' ? request()->detail : $value;
        //     }
        // }

        $data['doc_seq_code']          = request()->running_code;
        $data['doc_seq_description']   = request()->description;
        $data['module_code']           = $numDocument->tag ?? null;
        $data['start_date']            = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $data['end_date']              = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $data['year_type']             = request()->year_type;
        $data['format_date']           = request()->date_format;
        $data['reset_every']           = request()->reset_at;
        $data['prefix_number_digit']   = request()->number_digit;
        $data['active_flag']           = request()->active_flag ? 'Y' : 'N';
        $data['program_code']          = 'TOATRUNNING';
        $data['created_by']            = $user->user_id;
        $data['created_by_id']         = $user->user_id;
        $data['last_updated_by']       = $user->user_id;
        $data['start_with']            = request()->start_digit;

        $running = RunningNumberHeader::create($data);
 


        // $running = new RunningNumberHeader;
        // $running->doc_seq_code          = request()->running_code;
        // $running->doc_seq_description   = request()->description;
        // $running->module_code           = $numDocument->tag ?? null;
        // $running->start_date            = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $running->end_date              = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        // // $running->start_date            = request()->start_date ? date('Y-M-d', strtotime(parseFromDateth(request()->start_date))) : '';
        // // $running->end_date              = request()->end_date   ? date('Y-M-d', strtotime(parseFromDateth(request()->end_date))) : '';
        // $running->year_type             = request()->year_type;
        // $running->format_date           = request()->date_format;
        // $running->reset_every           = request()->reset_at;
        // $running->prefix_number_digit   = request()->number_digit;
        // $running->active_flag           = request()->active_flag ? 'Y' : 'N';
        // $running->format1               = request()->group_format ? request()->group_format[0] ? request()->group_format[0] == '$PREFIX' ? request()->detail : request()->group_format[0] : '' : '';
        // $running->format2               = request()->group_format ? request()->group_format[1] ? request()->group_format[1] == '$PREFIX' ? request()->detail : request()->group_format[1] : '' : '';
        // // $running->format3               = request()->group_format[2] ? request()->group_format[2] == '$PREFIX' ? request()->detail : request()->group_format[2] : null;
        // // $running->format4               = request()->group_format[3] ? request()->group_format[3] == '$PREFIX' ? request()->detail : request()->group_format[3] : null;
        // // $running->format5               = request()->group_format[4] ? request()->group_format[4] == '$PREFIX' ? request()->detail : request()->group_format[4] : null;
        // $running->program_code          = 'TOATRUNNING';
        // $running->created_by            = $user->user_id;
        // $running->created_by_id         = $user->user_id;
        // $running->last_updated_by       = $user->user_id;
        // $running->start_with            = request()->start_digit;
        // $running->save();

        foreach ($programList as $program) {
            $assignment = new SeqAssignment;
            $assignment->doc_seq_header_id     = $running->doc_seq_header_id;
            $assignment->assign_program_code   = $program;
            $assignment->start_date            = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
            $assignment->end_date              = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
            $assignment->active_flag           = request()->active_flag ? 'Y' : 'N';
            $assignment->program_code          = 'TOATRUNNING';
            $assignment->created_by_id         = $user->user_id;
            $assignment->created_by            = $user->user_id;
            $assignment->last_updated_by       = $user->user_id;
            $assignment->save();
        }

        return redirect()->route('running-number.index');
    }

    public function edit($id)
    {
        $header = RunningNumberHeader::find($id);

        $programs         = ProgramInfo::orderby('program_code')->get();
        $modules          = SystemModule::all();
        // $groupFormats     = GroupFormat::where('lookup_code', '!=', '$RUNNING_NO')->get();
        $groupFormats     = GroupFormat::all();
        $resetAts         = ResetAt::all();
        $dateFormats      = DateFormat::all();
        $yearTypes        = YearType::all();

        $numDocuments = RunningNumDocument::all();

        $headers      = RunningNumberHeader::where('doc_seq_header_id', '!=', $id)->get();

        
        // $runningNumber = GroupFormat::where('lookup_code', '$RUNNING_NO')->first();

        $getAssignments   = $header->assignments->pluck('assign_program_code');


        return view('running-number.edit', compact('header', 'programs', 'modules', 'groupFormats', 'resetAts', 'dateFormats', 'yearTypes', 'getAssignments', 'numDocuments', 'headers'));
    }

    public function update(Request $request, $id)   
    {
        $user = auth()->user();

        // $this->validate(request(), [
        //     'running_code'  => 'required',
        //     'systemModule'  => 'required',
        //     // 'programs_code' => 'required',
        //     'start_date'    => 'required',
        //     'reset_at'      => 'required',
        //     'number_digit'  => 'required',
        //     'start_digit'   => 'required',
            
        // ], [
        //     'running_code.required'  => 'โปรดระบุ Document Code',
        //     'systemModule.required'  => 'โปรดเลือก ระบบงาน',
        //     // 'programs_code.required' => 'โปรดเลือก เมนู',
        //     'start_date.required'    => 'โปรดเลือก วันที่เริ่มต้นการใช้งาน',
        //     'reset_at.required'      => 'โปรดเลือก Running',
        //     'number_digit.required'  => 'โปรดระบุ Running Number',
        //     'start_digit.required'   => 'โปรดระบุ Running Number',
            
        // ]);

        $programList = explode(',', request()->programs_code);

        // $assigment = SeqAssignment::whereIn('assign_program_code', $programList)->first();

        // if ($assigment) {
        //     if ($assigment->runningNumber->active_flag == 'Y') {

        //         $assigmentStrat = date('Y-M-d', strtotime($assigment->runningNumber->start_date));
        //         $assigmentEnd   = date('Y-M-d', strtotime($assigment->runningNumber->end_date));
        //         $stratDate      = date('Y-M-d', strtotime(request()->start_date));

        //         if ($stratDate >= $assigmentStrat && $stratDate <= $assigmentEnd) {
        //             return redirect()->back()->with('error','เมนูซ้ำกับในระบบ');
        //         } 
        //     }            
        // }
        
        // $oldRunningCode = RunningNumberHeader::where('doc_seq_header_id', '!=', id)
        //                                     ->where('doc_seq_code', request()->running_code)
        //                                     ->where('start_date', '<=', date('Y-m-d', strtotime(request()->request()->end_date)))
        //                                     ->where('end_date', '>=',  date('Y-m-d', strtotime(request()->request()->end_date)))
        //                                     ->orderBy('doc_seq_header_id', 'desc')
        //                                     ->first();

        // $oldRunningCode2 = RunningNumberHeader::where('doc_seq_header_id', '!=', id)
        //                                     ->where('doc_seq_code', request()->running_code)
        //                                     ->where('start_date', '>=', date('Y-m-d', strtotime(request()->request()->start_date)))
        //                                     ->where('end_date', '<=',  date('Y-m-d', strtotime(request()->request()->start_date)))
        //                                     ->orderBy('doc_seq_header_id', 'desc')
        //                                     ->first();

        // dd(request()->all(), $oldRunningCod, $oldRunningCode2);

        // if ($oldRunningCode) {
        //     $this->validate(request(), [
        //         'running_duplicate'  => 'required',
                
        //     ], [
        //         'running_duplicate.required'  => 'Document Code เดียวกันไม่สามารถสร้างวันที่ซ้ำซ้อนกันได้',
                
        //     ]);
        // }

        $running = RunningNumberHeader::find($id);
        // $running->doc_seq_description   = request()->description;
        // $running->year_type             = request()->year_type;
        // $running->format_date           = request()->date_format;
        // $running->prefix_number_digit   = request()->number_digit;
        $running->end_date              = request()->end_date ? date('Y-M-d', strtotime(request()->end_date)) : '';
        $running->active_flag           = request()->active_flag ? 'Y' : 'N';
        // $running->format1               = '$RUNNING_NO';
        // $running->format1               = request()->group_format[0] ? request()->group_format[0] == '$PREFIX' ? request()->detail : request()->group_format[0] : null;
        // $running->format2               = request()->group_format[1] ? request()->group_format[1] == '$PREFIX' ? request()->detail : request()->group_format[1] : null;
        // $running->format3               = request()->group_format[2] ? request()->group_format[2] == '$PREFIX' ? request()->detail : request()->group_format[2] : null;
        // $running->format4               = request()->group_format[3] ? request()->group_format[3] == '$PREFIX' ? request()->detail : request()->group_format[3] : null;
        // $running->format5               = request()->group_format[4] ? request()->group_format[4] == '$PREFIX' ? request()->detail : request()->group_format[4] : null;
        $running->last_updated_by       = $user->user_id;
        // $running->start_with            = request()->start_digit;
        $running->save();
        

        $oldAssignments = $running->assignments()->WhereNotIn('assign_program_code', $programList)->get();
 
        //ลบ menu ที่ไม่ใช้ออก
        foreach ($oldAssignments as $oldAssignment) {
            $oldAssignment->delete();
        }

        // เพิ่มเมนูที่เลือกมาใหม่
        foreach ($programList as $program) {
            $assignment = SeqAssignment::firstOrCreate(
                [
                    'doc_seq_header_id'   => $running->doc_seq_header_id, 
                    'assign_program_code' => $program
                ],
                [
                    'end_date'        => request()->end_date ? date('Y-M-d', strtotime(request()->end_date))   : '',
                    'active_flag'     => request()->active_flag ? 'Y' : 'N',
                    'program_code'    => 'TOATRUNNING',
                    'created_by_id'   => $user->user_id,
                    'created_by'      => $user->user_id,
                    'last_updated_by' => $user->user_id
                ]
            );
        }

        return redirect()->route('running-number.index');

    }
}
