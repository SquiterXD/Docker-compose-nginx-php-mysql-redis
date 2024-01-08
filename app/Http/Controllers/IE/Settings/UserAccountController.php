<?php

namespace App\Http\Controllers\IE\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\HREmployee;
use App\Models\IE\UserAccount;
use App\Models\IE\BankInfoV;
use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserAccountController extends Controller
{
    protected $perPage = 50;
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->orgId = getDefaultData()->bu_id;
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $employee_name = $request->employee_name;
        $employee_number = $request->employee_number;

        $employeeLists = HREmployee::with('userAccounts')
        ->when($employee_number, function($q, $employee_number){
            return $q->where('username', 'like', '%'.$employee_number.'%');
        })
        ->when($employee_name, function($q, $employee_name){
            return $q->where('title', 'like', '%'.$employee_name.'%')
                ->orWhere('first_name', 'like', '%'.$employee_name.'%')
                ->orWhere('last_name', 'like', '%'.$employee_name.'%');
        })
        ->orderBy('username')->paginate($this->perPage);
    
        $employeeLists->appends([
            'employee_number'    =>  $employee_number,
            'employee_name'        =>  $employee_name,
        ]); // setpath for search

    	return view('ie.settings.user-accounts.index', compact(
            'employeeLists',
            'request'
        ));
    }

    public function formCreate(Request $request)
    {
        $emp = HREmployee::find($request->employee_number);

        $find = UserAccount::where('employee_number', $emp->username)->get();

        $bankInfos = BankInfoV::select(\DB::raw("bank_or_branch_code AS bank_code"), 'bank', 'bank_name')
            ->orderBy('bank_code')
            ->get();

        $account = new UserAccount;
        $account->user_id = optional($emp->user)->user_id;
        $account->code = $emp->username.'-'.$find->count();
        $account->employee_number = $emp->username;
        $account->employee_name = optional($emp->user)->name ?? $emp->full_name;
        $account->account_name = optional($emp->user)->name ?? $emp->full_name;

        return view('ie.settings.user-accounts._form_create', compact(
            'account',
            'bankInfos',
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'code' => 'required|max:255|unique:ptw_user_accounts,code',
            'employee_number' => 'required|max:255',
            'employee_name' => 'required|max:255',
            'bank_code' => 'required|max:255',
            'bank_name' => 'required|max:255',
            'branch_number' => 'required|max:4',
            'branch_name' => 'required|max:255',
            'account_name' => 'required|max:255',
            'account_number' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();
        try {

            $emp = HREmployee::find($request->employee_number);

            $account = new UserAccount();
            $account->user_id = optional($emp->user)->user_id;
            $account->code = $request->code;
            $account->employee_number = $request->employee_number;
            $account->employee_name = $request->employee_name;
            $account->bank_code = $request->bank_code;
            $account->bank_name = $request->bank_name;
            $account->branch_number = $request->branch_number;
            $account->branch_name = $request->branch_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->bank_account = $account->bank_code.' '.$account->branch_number.' '.$account->account_number;
            $account->last_updated_by = \Auth::user()->user_id;
            $account->created_by = \Auth::user()->user_id;
            $account->save();
            
            \DB::commit();
            return back()->with('success', 'Add Success !');

        } catch (\Exception $e) {
            \DB::rollBack();

            return back()->with('success', $e->getMessage());
        }
    }

    public function formEdit(Request $request, $accountId)
    {
        $account = UserAccount::find($accountId);
        $bankInfos = BankInfoV::select(\DB::raw("bank_or_branch_code AS bank_code"), 'bank', 'bank_name')
            ->orderBy('bank_code')
            ->get();

        return view('ie.settings.user-accounts._form_edit', compact(
            'account',
            'bankInfos'
        ));
    }

    public function update(Request $request, $accountId)
    {
        $validator = Validator::make($request->all(),
        [
            'code' => [
                'required',
                'max:255',
                Rule::unique('ptw_user_accounts')->ignore($accountId, 'user_account_id')
            ],
            'employee_number' => 'required|max:255',
            'employee_name' => 'required|max:255',
            'bank_code' => 'required|max:255',
            'bank_name' => 'required|max:255',
            'branch_number' => 'required|max:255',
            'branch_name' => 'required|max:255',
            'account_name' => 'required|max:255',
            'account_number' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();
        try {

            $account = UserAccount::find($accountId);
            if($account->account_type == 'SYNC'){
                return back()->withErrors('ไม่สามารแก้ไขบัญชีที่ Sync ได้');
            }
            $emp = HREmployee::find($request->employee_number);

            $account->user_id = optional($emp->user)->user_id;
            $account->code = $request->code;
            $account->employee_number = $request->employee_number;
            $account->employee_name = $request->employee_name;
            $account->bank_code = $request->bank_code;
            $account->bank_name = $request->bank_name;
            $account->branch_number = $request->branch_number;
            $account->branch_name = $request->branch_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->bank_account = $account->bank_code.' '.$account->branch_number.' '.$account->account_number;
            $account->last_updated_by = \Auth::user()->user_id;
            $account->save();
            
            \DB::commit();
            return back()->with('success', 'Update Success !');

        } catch (\Exception $e) {
            \DB::rollBack();

            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Request $request, $accountId)
    {
        \DB::beginTransaction();
        try {
            $account = UserAccount::find($accountId);
            if($account->account_type == 'SYNC'){
                return back()->withErrors('ไม่สามารลบบัญชีที่ Sync ได้');
            }
            $account->delete();
            
            \DB::commit();
            $data = [
                'status'   =>  's',
                'msg'      =>  'Delete Success !'
            ];
            return response()->json($data);

        } catch (\Exception $e) {
            \DB::rollBack();

            $data = [
                'status'   =>  'e',
                'msg'      =>  $e->getMessage()
            ];
            return response()->json($data);
        }
    }

    public function sync(Request $request)
    {
        \DB::beginTransaction();
        try {

            // $employeeLists = HREmployee::orderBy('username')->get();

            HREmployee::orderBy('username')
            ->chunk(100, function ($employeeLists) {
                foreach ($employeeLists as $emp) {
                    $master = optional($emp->user)->pnMaster;
    
                    if($master){
                        $account = $emp->userAccounts()
                        ->where('account_type', 'SYNC')
                        ->first();
    
                        if( !$account ) {
    
                            $account = new UserAccount();
                            $account->user_id = optional($emp->user)->user_id;
                            $account->code = $emp->username;
                            $account->employee_number = $emp->username;
                            $account->employee_name = optional($emp->user)->name ?? $emp->full_name;
                            $account->bank_code = optional($master->bank)->bank_or_branch_code ?? $master->prmf_bank_code;
                            $account->bank_name = $master->prmf_bank_code;
                            $account->branch_number = null;
                            $account->branch_name = null;
                            $account->account_name = optional($emp->user)->name ?? $emp->full_name;
                            $account->account_number = $master->prmf_bankacc;
                            $account->bank_account = $account->bank_code.' '.$account->branch_number.' '.$account->account_number;
                            $account->default_flag = true;
                            $account->account_type = 'SYNC';
                            $account->last_updated_by = \Auth::user()->user_id;
                            $account->created_by = \Auth::user()->user_id;
                            $account->save();
    
                        }else {
    
                            $account->user_id = optional($emp->user)->user_id;
                            $account->code = $emp->username;
                            $account->employee_number = $emp->username;
                            $account->employee_name = optional($emp->user)->name ?? $emp->full_name;
                            $account->bank_code = optional($master->bank)->bank_or_branch_code ?? $master->prmf_bank_code;
                            $account->bank_name = $master->prmf_bank_code;
                            $account->branch_number = null;
                            $account->branch_name = null;
                            $account->account_name = optional($emp->user)->name ?? $emp->full_name;
                            $account->account_number = $master->prmf_bankacc;
                            $account->bank_account = $account->bank_code.' '.$account->branch_number.' '.$account->account_number;
                            $account->account_type = 'SYNC';
                            $account->last_updated_by = \Auth::user()->user_id;
                            $account->save();
    
                        }

                        $default = $emp->userAccounts()
                        ->where('default_flag', true)
                        ->first();

                        if(!!$default){
                            Reimbursement::where('requester_id', $emp->username)
                            ->whereIn('status', [
                                'NEW_REQUEST',
                                'RESERVE_ENCUMBRANCE',
                                'APPROVER_DECISION',
                                'BLOCKED'
                            ])
                            ->update([
                                'bank_name' => $default->bank_name,
                                'account_no' => $default->account_number
                            ]);
    
                            CashAdvance::where('requester_id', $emp->username)
                            ->whereIn('status', [
                                'NEW_REQUEST',
                                'APPROVER_DECISION',
                                'BLOCKED'
                            ])
                            ->update([
                                'bank_name' => $default->bank_name,
                                'account_no' => $default->account_number
                            ]);
                        }
                    }
                }
            });

            \DB::commit();

            $data = [
                'status'   =>  'S',
                'msg'      =>  'Sync success !'
            ];

            return response()->json($data);

        } catch (\Exception $e) {
            // ERROR CREATE SYNC
            logger($e->getMessage());
            \DB::rollBack();
            $data = [
                'status'   =>  'e',
                'msg'      =>  $e->getMessage()
            ];

            return response()->json($data);
        }
    }

    public function setDefault(Request $request, $accountId)
    {
        try {
            $account = UserAccount::find($accountId);
            $user = $account->user;

            foreach ($user->userAccounts as $acc) {
                $acc->default_flag = false;
                $acc->last_updated_by = getDefaultData()->user_id;
                $acc->save();
            }

            $account->default_flag = true;
            $account->last_updated_by = getDefaultData()->user_id;
            $account->save();

            $data = [
                'status'   =>  'S',
                'msg'      =>  'Change default success !'
            ];
            return response()->json($data);

        } catch (\Exception $e) {
            $data = [
                'status'   =>  'e',
                'msg'      =>  $e->getMessage()
            ];
            return response()->json($data);
        }
    }
}
