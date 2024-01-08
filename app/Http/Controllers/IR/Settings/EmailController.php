<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\Email;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\Settings\PtglCoaDeptCodeView;
use App\Models\HREmployee;
use App\Models\Lookup\ValueSetup;
use App\Models\IR\Settings\DepartmentGroup;

class EmailController extends Controller
{
    public function index()
    {
        // dd('xxx', request()->all());
        $dataSearch = (object)[]; 
        $dataSearch->company_name   = request()->company_name;
        $dataSearch->employee_name  = request()->employee_name;
        $dataSearch->status         = request()->status;

        $dataLists = [];

        $emails = Email::search(request()->company_name, request()->employee_name, request()->status)
                        ->orderBy('email_id', 'asc')
                        ->get();
        // dd($emails);

        $data = Email::get();

        // $companies   = PtirCompanies::where('active_flag', 'Y')
        //                                 ->whereIn('company_number', $data->pluck('company_number'))
        //                                 ->orderBy('company_number', 'asc')
        //                                 ->get();

        $companies = Email::selectRaw("distinct company_name value, company_name label")
                        ->whereNotNull('company_name')
                        // ->orderBy('email_id', 'asc')
                        ->get();
        
        $employees = Email::selectRaw("distinct employee_number value, employee_name label")
                        ->whereNotNull('employee_name')
                        // ->orderBy('email_id', 'asc')
                        ->get();

        $departments = Email::selectRaw("distinct department_name value, department_name label")
                        ->whereNotNull('department_name')
                        // ->orderBy('email_id', 'asc')
                        ->get();

        foreach ($employees as $employee) {
            array_push($dataLists, $employee);
        }

        foreach ($departments as $department) {
            array_push($dataLists, $department);
        }
        // dd($dataLists);

        // dd(request()->all(), $emails);

        return view('ir.settings.email.index', compact('emails', 'companies', 'employees', 'dataSearch', 'dataLists'));
    }

    public function create()
    {
        $companies   = PtirCompanies::where('active_flag', 'Y')
                                        ->with('vendorBranch')
                                        ->orderBy('company_number', 'asc')
                                        ->get();

        $departments = PtglCoaDeptCodeView::where('enabled_flag', 'Y')
                                            // ->where('summary_flag', 'Y')
                                            ->orderBy('department_code', 'asc')
                                            ->limit(20)
                                            ->get();

        $employees = HREmployee::limit(20)->get();

        $btnTrans = trans('btn');

        return view('ir.settings.email.create', compact('companies', 'departments', 'employees', 'btnTrans'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        // $company   = PtirCompanies::where('active_flag', 'Y')
        //                                 ->where('company_number', request()->company_number)
        //                                 ->first();

        // $department = PtglCoaDeptCodeView::where('department_code', request()->department_group_code)
        //                                     ->where('summary_flag', 'Y')
        //                                     ->where('enabled_flag', 'Y')
        //                                     ->first();

        $employee = HREmployee::where('username', request()->employee_number)->first();
        // dd('store', request()->all(), $employee);
        
        $user = auth()->user();

        \DB::beginTransaction();

        try {
            $data = new Email;
            $data->company_flag          = request()->type == 'บริษัทประกันภัย' ? 'Y' : 'N';
            $data->employee_flag         = request()->type == 'พนักงาน' ? 'Y' : 'N';
            $data->department_flag       = request()->type == 'หน่วยงาน' ? 'Y' : 'N';
            // $data->company_number        = request()->type == 'บริษัทประกันภัย' ? request()->company_number : '';
            $data->company_name          = request()->type == 'บริษัทประกันภัย' ? request()->company_name : '';
            $data->employee_number       = request()->type == 'พนักงาน' ? $employee->username : '';
            $data->employee_name         = request()->type == 'พนักงาน' ? $employee->title . $employee->first_name . ' ' . $employee->last_name : '';
            $data->email                 = str_replace(' ', '', request()->email);
            // $data->department_group_code = request()->department_group_code;
            // $data->department_group_desc = $department ? $department->description : '';
            $data->department_name       = request()->type == 'หน่วยงาน' ? request()->department_name : '';
            $data->to_flag               = request()->to_flag     ? 'Y' : 'N';
            $data->cc_flag               = request()->cc_flag     ? 'Y' : 'N';
            $data->sender_flag           = request()->sender_flag ? 'Y' : 'N';
            $data->active_flag           = request()->active_flag ? 'Y' : 'N';
            $data->program_code          = 'IRM0010';
            $data->created_by            = $user->user_id;
            $data->last_updated_by       = $user->user_id;
            $data->save();

            $departmentGroups = explode(',' , request()->department_group_code);

            foreach ($departmentGroups as $departmentGroup) {

                if ($departmentGroup) {
                    $dept = PtglCoaDeptCodeView::where('department_code', $departmentGroup)
                                                    ->where('enabled_flag', 'Y')
                                                    ->first();

                    $department                        = new DepartmentGroup;
                    $department->email_id              = $data->email_id;
                    $department->department_group_code = $departmentGroup;
                    $department->department_group_desc = $dept->description;
                    $department->program_code          = 'IRM0010';
                    $department->created_by            = $user->user_id;
                    $department->last_updated_by       = $user->user_id;
                    $department->save();
                }
            }

        // dd('store', $departmentGroups);
            \DB::commit();
            return redirect()->route('ir.settings.email.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function edit($id)
    {        
        $data = Email::find($id);
        
        $companies   = PtirCompanies::where('active_flag', 'Y')
                                        ->with('vendorBranch')
                                        ->orderBy('company_number', 'asc')
                                        ->get();

        $departments = PtglCoaDeptCodeView::where('enabled_flag', 'Y')
                                            // ->where('summary_flag', 'Y')
                                            ->orderBy('department_code', 'asc')
                                            ->get();

        if ($data->employee_flag == 'Y') {   
            $employees = HREmployee::where('username', $data->employee_number)->get();
        } else {
            $employees = HREmployee::limit(20)->get();
        }
        // dd($data->departmentGroups->pluck('department_group_code'));

        if ($data->departmentGroups) {   
            $departments = PtglCoaDeptCodeView::whereIn('department_code', $data->departmentGroups->pluck('department_group_code'))->get();
        } else {
            $departments = PtglCoaDeptCodeView::where('enabled_flag', 'Y')
                                                ->orderBy('department_code', 'asc')
                                                ->limit(20)
                                                ->get();
        }

        $departmentGroups   = $data->departmentGroups->pluck('department_group_code');

        return view('ir.settings.email.edit', compact('companies', 'departments', 'data', 'employees', 'departmentGroups'));
    }

    public function update(Request $request, $id)
    {
        // dd('update <-->', request()->all(), $id);
        $user = auth()->user();

        // $company   = PtirCompanies::where('active_flag', 'Y')
        //                                 ->where('company_number', request()->company_number)
        //                                 ->first();

        $department = PtglCoaDeptCodeView::where('department_code', request()->department_group_code)
                                            ->where('summary_flag', 'Y')
                                            ->where('enabled_flag', 'Y')
                                            ->first();

        $employee = HREmployee::where('username', request()->employee_number)->first();

        \DB::beginTransaction();

        try {
            $data = Email::find($id);
            $data->company_flag          = request()->type == 'บริษัทประกันภัย' ? 'Y' : 'N';
            $data->employee_flag         = request()->type == 'พนักงาน' ? 'Y' : 'N';
            $data->department_flag       = request()->type == 'หน่วยงาน' ? 'Y' : 'N';
            // $data->company_number        = request()->type == 'บริษัทประกันภัย' ? request()->company_number : '';
            $data->company_name          = request()->type == 'บริษัทประกันภัย' ? request()->company_name : '';
            $data->employee_number       = request()->type == 'พนักงาน' ? $employee->username : '';
            $data->employee_name         = request()->type == 'พนักงาน' ? $employee->title . $employee->first_name . ' ' . $employee->last_name : '';
            $data->email                 = str_replace(' ', '', request()->email);
            $data->department_group_code = request()->department_group_code;
            $data->department_group_desc = $department ? $department->description : '';
            $data->department_name       = request()->type == 'หน่วยงาน' ? request()->department_name : '';
            $data->to_flag               = request()->to_flag     ? 'Y' : 'N';
            $data->cc_flag               = request()->cc_flag     ? 'Y' : 'N';
            $data->sender_flag           = request()->sender_flag ? 'Y' : 'N';
            $data->active_flag           = request()->active_flag ? 'Y' : 'N';
            $data->program_code          = 'IRM0010';
            $data->last_updated_by       = $user->user_id;
            $data->save();


            $departmentGroups    = explode(',' , request()->department_group_code);
            $oldDepartmentGroups = $data->departmentGroups()->WhereNotIn('department_group_code', $departmentGroups)->get();

            // dd($oldDepartmentGroups);
    
            //ลบข้อมูลที่ไม่ใช้ออก
            foreach ($oldDepartmentGroups as $old) {
                $old->delete();
            }

            // เพิ่มข้อมูลที่เลือกมาใหม่
            foreach ($departmentGroups as $departmentGroup) {

                if ($departmentGroup) {
                    $dept = PtglCoaDeptCodeView::where('department_code', $departmentGroup)
                                                    ->where('enabled_flag', 'Y')
                                                    ->first();

                    $department = DepartmentGroup::firstOrCreate(
                        [
                            'email_id'   => $data->email_id, 
                            'department_group_code' => $departmentGroup
                        ],
                        [
                            'department_group_desc' => $dept->description,
                            'program_code'          => 'IRM0010',
                            'created_by'            => $user->user_id,
                            'last_updated_by'       => $user->user_id
                        ]
                    );
                }
            }

            \DB::commit();
            return redirect()->route('ir.settings.email.index')->with('success','ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');

        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }
}
