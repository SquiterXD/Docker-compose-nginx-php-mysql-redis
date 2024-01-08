<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\DirectDebitDomestic;
use App\Models\OM\Settings\Customer;
use App\Models\OM\Settings\BankAccountsV;
use App\Models\OM\Settings\BankAccountTypesV;
use App\Models\OM\Settings\CEBanksV;
use App\Models\OM\Settings\CEBankBranchesV;

class DirectDebitDomesticController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/direct-debit-domestic') || !canView('/om/settings/direct-debit-domestic')) {
            return redirect()->back()->withError(trans('403'));
        }

        $defaultCustomer      = request()->customer_id;
        $directDebitDomestics = DirectDebitDomestic::search($defaultCustomer)
                                ->where('sale_channel', 'DOMESTIC')
                                ->orderBy('direct_debit_id', 'asc')
                                ->paginate(25);
                                // dd($directDebitDomestics);

        $customers = Customer::search($defaultCustomer)
                            ->where('sales_classification_code', 'Domestic')
                            ->where('status', 'Active')
                            ->whereHas('directDebitDomestics')
                            ->orderBy('customer_number', 'asc')
                            ->paginate(25);  

        // $customer = Customer::where('customer_id', 187)->first();

        // dd($customer->directDebitDomestic);

        $directDebitAll  = DirectDebitDomestic::where('sale_channel', 'DOMESTIC')->orderBy('customer_id')->get();
        $directDebitList = $directDebitAll->pluck('customer_id')->unique();
        $customerAll     = Customer::whereIn('customer_id', $directDebitList)->orderBy('customer_number')->get();


        // dd($directDebitAll->pluck('customer_id')->unique(), $customerAll);
        

        return view('om.settings.direct-debit-domestic.index', compact('directDebitDomestics', 'customers', 'customerAll', 'defaultCustomer'));
    }

    public function create()
    {
        $customers        = Customer::where('sales_classification_code', 'Domestic')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();
        // $bankAccounts     = BankAccountsV::all();
        $bankAccounts     = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get();
        $bankUniques      = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get()->unique('bank_name');

        // dd($bankUniques);
        // $bankAccounts2    = BankAccountsV::selectRaw('DISTINCT bank_name', 'bank_number', 'bank_account_id')->where('bank_name', '!=', 'บัญชีพัก')->get();
        $bankAccountTypes = BankAccountTypesV::active()->get();
        $banks            = CEBanksV::where('bank_name', '!=', 'บัญชีพัก')
                                ->where(function($q){
                                    return $q->whereDate('start_date', '<=', \Carbon\Carbon::now())
                                        ->where(function($p) {
                                            return $p->whereDate('end_date', '>=', \Carbon\Carbon::now())
                                                ->orwhereNull('end_date');
                                        });
                                })
                                ->orderBy('bank_number', 'asc')
                                ->get();
                                
        $branchs          = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                                branch_party_id, bank_branch_name, branch_number')->get();

        // dd($banks);

        // dd($bankAccounts, $bankUniques);
        
        return view('om.settings.direct-debit-domestic.create', compact('customers', 'bankAccounts', 'bankAccountTypes', 'bankUniques', 'banks', 'branchs'));
    }
    
    public function store(Request $request)
    {
        // dd(request()->all());
        $user = auth()->user();

        $request->validate([
            'customer_id' => 'required',
            'bank_id'     => 'required',
            'account_num' => 'required|min:10|max:10',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
        ], [
            'customer_id.required' => 'โปรดเลือก รหัสลูกค้า',
            'bank_id.required'     => 'โปรดเลือก รหัสธนาคาร',
            'account_num.required' => 'โปรดระบุหมายเลขบัญชีให้ถูกต้อง',
        ]);


        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $startDate = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate   = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if ($startDate && $endDate) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $bankAccountType = BankAccountTypesV::active()->where('lookup_code', $request->account_type_id)->first();
        $bank            = CEBanksV::where('bank_party_id', $request->bank_id)->first();
        $branch          = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                branch_party_id, bank_branch_name, branch_number')->where('branch_party_id', $request->branch_id)->first();

        // $branch          = CEBankBranchesV::find($request->bank_branch);
        // ใช้ Format SHORT_BANK_NAME + "-" + ACCOUNT_TYPE_CODE + "-" + BRANCH_NAME + "เลขที่บัญชี" + ACCOUNT_NUMBER
        if ($branch) {
            if ($bankAccountType) {
                $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
            } else {
                $bankAccountName = $bank->short_bank_name . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
            }
        }else {
            if ($bankAccountType) {
                $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . ' เลขที่บัญชี ' . $request->account_num;
            } else {
                $bankAccountName = $bank->short_bank_name . ' - ' . ' เลขที่บัญชี ' . $request->account_num;
            }
        }

        $directDebitDomestic = new DirectDebitDomestic;
        $directDebitDomestic->customer_id       = $request->customer_id;
        $directDebitDomestic->bank_id           = $request->bank_id;
        $directDebitDomestic->account_type_id   = $request->account_type_id;
        $directDebitDomestic->account_number    = $request->account_num;
        $directDebitDomestic->program_code      = 'OMS0019';
        $directDebitDomestic->sale_channel      = 'DOMESTIC';
        $directDebitDomestic->created_by        = $user->user_id;
        $directDebitDomestic->last_updated_by   = $user->user_id;
        $directDebitDomestic->start_date        = $startDate;
        $directDebitDomestic->end_date          = $endDate;
        
        $directDebitDomestic->bank_account_name = $bankAccountName;
        $directDebitDomestic->bank_number       = $bank->bank_number;
        $directDebitDomestic->short_bank_name   = $bank->short_bank_name;
        $directDebitDomestic->bank_name         = $bank->bank_name;
        $directDebitDomestic->branch_id         = $branch->branch_party_id ?? null;
        $directDebitDomestic->branch_name       = $branch->bank_branch_name ?? null;
        $directDebitDomestic->branch_number     = $branch->branch_number ?? null;
        $directDebitDomestic->save();

        return redirect()->route('om.settings.direct-debit-domestic.index')->with('success', 'ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $directDebitDomestic = DirectDebitDomestic::find($id);
        $customer            = $directDebitDomestic->customer;
        $customers           = Customer::where('sales_classification_code', 'Domestic')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();
        $bankAccount         = $directDebitDomestic->bankAccount;
        // $bankAccounts        = BankAccountsV::all();
        $bankAccounts        = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get();
        // ->orderBy('bank_number', 'asc')
        $bankUniques         = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get()->unique('bank_name');
        // $bankAccounts        = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get()->unique('bank_name');
        $bankAccountTypes    = BankAccountTypesV::active()->get();
        $banks               = CEBanksV::where('bank_name', '!=', 'บัญชีพัก')
                                    ->where(function($q){
                                        return $q->whereDate('start_date', '<=', \Carbon\Carbon::now())
                                            ->where(function($p) {
                                                return $p->whereDate('end_date', '>=', \Carbon\Carbon::now())
                                                    ->orwhereNull('end_date');
                                            });
                                    })
                                    ->orderBy('bank_number', 'asc')
                                    ->get();

        $branchs             = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                                branch_party_id, bank_branch_name, branch_number')->get();
        
        return view('om.settings.direct-debit-domestic.edit', compact('directDebitDomestic', 'customer', 'customers', 'bankAccount', 'bankAccounts', 'bankAccountTypes', 'bankUniques', 'banks', 'branchs'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $request->validate([
            'customer_id' => 'required',
            'bank_id'     => 'required',
            'account_num' => 'required|min:10|max:10',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
        ], [
            'customer_id.required' => 'โปรดเลือก รหัสลูกค้า',
            'bank_id.required'     => 'โปรดเลือก รหัสธนาคาร',
            'account_num.required' => 'โปรดระบุหมายเลขบัญชีให้ถูกต้อง',
        ]);

        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $startDate = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate   = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if ($startDate && $endDate) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }
        $bankAccountType = BankAccountTypesV::active()->where('lookup_code', $request->account_type_id)->first();
        $bank            = CEBanksV::where('bank_party_id', $request->bank_id)->first();
        $branch          = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                            branch_party_id, bank_branch_name, branch_number')->where('branch_party_id', $request->branch_id)->first();

        // dd($branch, $request->all());

        // if ($branch) {
        //     $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
        // }else {
        //     $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . ' เลขที่บัญชี ' . $request->account_num;
        // }

        if ($branch) {
            if ($bankAccountType) {
                $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
            } else {
                $bankAccountName = $bank->short_bank_name . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
            }
        }else {
            if ($bankAccountType) {
                $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . ' เลขที่บัญชี ' . $request->account_num;
            } else {
                $bankAccountName = $bank->short_bank_name . ' - ' . ' เลขที่บัญชี ' . $request->account_num;
            }
        }

        $directDebitDomestic = DirectDebitDomestic::find($id);
        $directDebitDomestic->customer_id       = $request->customer_id;
        $directDebitDomestic->bank_id           = $request->bank_id;
        $directDebitDomestic->account_type_id   = $request->account_type_id;
        $directDebitDomestic->account_number    = $request->account_num;
        $directDebitDomestic->last_updated_by   = $user->user_id;
        $directDebitDomestic->start_date        = $startDate;
        $directDebitDomestic->end_date          = $endDate;
        $directDebitDomestic->bank_account_name = $bankAccountName;
        $directDebitDomestic->bank_number       = $bank->bank_number;
        $directDebitDomestic->short_bank_name   = $bank->short_bank_name;
        $directDebitDomestic->bank_name         = $bank->bank_name;
        $directDebitDomestic->branch_id         = $branch->branch_party_id ?? null;
        $directDebitDomestic->branch_name       = $branch->bank_branch_name ?? null;
        $directDebitDomestic->branch_number     = $branch->branch_number ?? null;
        $directDebitDomestic->save();

        return redirect()->route('om.settings.direct-debit-domestic.index')->with('success', 'ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
