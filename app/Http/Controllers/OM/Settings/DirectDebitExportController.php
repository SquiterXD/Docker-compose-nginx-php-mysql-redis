<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\DirectDebitExport;
use App\Models\OM\Settings\Customer;
use App\Models\OM\Settings\BankAccountsV;
use App\Models\OM\Settings\BankAccountTypesV;
use App\Models\OM\Settings\CEBanksV;
use App\Models\OM\Settings\CEBankBranchesV;

class DirectDebitExportController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/direct-debit-export') || !canView('/om/settings/direct-debit-export')) {
            return redirect()->back()->withError(trans('403'));
        }

        $directDebitExports = DirectDebitExport::where('sale_channel', 'EXPORT')->orderBy('direct_debit_id', 'asc')->get();

        $customers = Customer::where('sales_classification_code', 'Export')
                            ->where('status', 'Active')
                            ->whereHas('directDebitExports')
                            ->orderBy('customer_number', 'asc')
                            ->paginate(25);  

        return view('om.settings.direct-debit-export.index', compact('directDebitExports', 'customers'));
    }

    public function create()
    {
        $customers        = Customer::where('sales_classification_code', 'Export')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();
        $bankAccounts     = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get();
        $bankUniques      = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get()->unique('bank_name');
        $bankAccountTypes = BankAccountTypesV::active()->get();
        $banks            = CEBanksV::where('bank_name', '!=', 'บัญชีพัก')->orderBy('bank_number', 'asc')->get();
        $branchs          = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                                branch_party_id, bank_branch_name, branch_number')->get();
        
        return view('om.settings.direct-debit-export.create', compact('customers', 'bankAccounts', 'bankUniques', 'bankAccountTypes', 'banks', 'branchs'));
    }
    
    public function store(Request $request)
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

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';

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

        // $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;
        
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

        $directDebitExport = new DirectDebitExport;
        $directDebitExport->customer_id       = $request->customer_id;
        $directDebitExport->bank_id           = $request->bank_id;
        $directDebitExport->account_type_id   = $request->account_type_id;
        $directDebitExport->account_number    = $request->account_num;
        $directDebitExport->program_code      = 'OMS0020';
        $directDebitExport->sale_channel      = 'EXPORT';
        $directDebitExport->created_by        = $user->user_id;
        $directDebitExport->last_updated_by   = $user->user_id;
        $directDebitExport->start_date        = $startDate;
        $directDebitExport->end_date          = $endDate;
        $directDebitExport->bank_account_name = $bankAccountName;
        $directDebitExport->bank_number       = $bank->bank_number;
        $directDebitExport->short_bank_name   = $bank->short_bank_name;
        $directDebitExport->bank_name         = $bank->bank_name;
        $directDebitExport->branch_id         = $branch->branch_party_id;
        $directDebitExport->branch_name       = $branch->bank_branch_name;
        $directDebitExport->branch_number     = $branch->branch_number;
        $directDebitExport->save();

        return redirect()->route('om.settings.direct-debit-export.index')->with('success', 'ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $directDebitExport = DirectDebitExport::find($id);
        $customer          = $directDebitExport->customer;
        $customers         = Customer::where('sales_classification_code', 'Export')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();
        $bankAccount       = $directDebitExport->bankAccount;

        $bankAccounts      = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get();
        $bankUniques       = BankAccountsV::where('bank_name', '!=', 'บัญชีพัก')->get()->unique('bank_name');
        $bankAccountTypes  = BankAccountTypesV::active()->get();
        $banks             = CEBanksV::where('bank_name', '!=', 'บัญชีพัก')->orderBy('bank_number', 'asc')->get();
        $branchs           = CEBankBranchesV::selectRaw('bank_home_country, bank_party_id, bank_name, bank_number,
                                branch_party_id, bank_branch_name, branch_number')->get();
        
        // $bankAccounts = BankAccountsV::all();
        return view('om.settings.direct-debit-export.edit', compact('directDebitExport', 'customer', 'customers', 'bankAccount', 'bankAccounts', 'bankUniques', 'bankAccountTypes', 'banks', 'branchs'));
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

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';

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

        // $bankAccountName = $bank->short_bank_name . ' - ' . $bankAccountType->description . ' - ' . $branch->bank_branch_name . ' เลขที่บัญชี ' . $request->account_num;

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

        $directDebitExport = DirectDebitExport::find($id);
        $directDebitExport->customer_id       = $request->customer_id;
        $directDebitExport->bank_id           = $request->bank_id;
        $directDebitExport->account_type_id   = $request->account_type_id;
        $directDebitExport->account_number    = $request->account_num;
        $directDebitExport->last_updated_by   = $user->user_id;
        $directDebitExport->start_date        = $startDate;
        $directDebitExport->end_date          = $endDate;
        $directDebitExport->bank_account_name = $bankAccountName;
        $directDebitExport->bank_number       = $bank->bank_number;
        $directDebitExport->short_bank_name   = $bank->short_bank_name;
        $directDebitExport->bank_name         = $bank->bank_name;
        $directDebitExport->branch_id         = $branch->branch_party_id;
        $directDebitExport->branch_name       = $branch->bank_branch_name;
        $directDebitExport->branch_number     = $branch->branch_number;
        $directDebitExport->save();

        return redirect()->route('om.settings.direct-debit-export.index')->with('success', 'ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
