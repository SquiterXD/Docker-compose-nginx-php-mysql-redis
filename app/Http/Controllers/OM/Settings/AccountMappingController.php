<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\AccountMapping;

use App\Models\OM\Settings\Company;
use App\Models\OM\Settings\Evm;
use App\Models\OM\Settings\Department;           
use App\Models\OM\Settings\CostCenter;
use App\Models\OM\Settings\BudgetYear;
use App\Models\OM\Settings\BudgetType;
use App\Models\OM\Settings\BudgetDetail;
use App\Models\OM\Settings\BudgetReason;
use App\Models\OM\Settings\MainAccount;
use App\Models\OM\Settings\SubAccount;
use App\Models\OM\Settings\Reserved1;
use App\Models\OM\Settings\Reserved2;

class AccountMappingController extends Controller
{
    public function index()
    {
        $accounts       = AccountMapping::orderBy('account_code', 'asc')->get();
        $accountAliases = AccountMapping::search(request()->account, request()->status)->orderBy('account_code', 'asc')->paginate(25);

        return view('om.settings.account-mapping.index', compact('accounts', 'accountAliases'));

    }

    public function create()
    {
        $companies     = Company::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE')->get();
        $evms          = Evm::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-EVM')->get();
        $departments   = Department::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE')->get();
        $budgetYears   = BudgetYear::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR')->get();
        $budgetTypes   = BudgetType::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE')->get();
        $budgetReasons = BudgetReason::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON')->get();
        $mainAccounts  = MainAccount::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT')->get();
        $reserveds1    = Reserved1::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1')->get();
        $reserveds2    = Reserved2::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2')->get();

        return view('om.settings.account-mapping.create', compact('companies', 'evms', 'departments', 'budgetYears', 'budgetTypes', 'budgetReasons', 'mainAccounts', 'reserveds1', 'reserveds2'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $this->validate(request(), [
            'account_code' => 'required',
            // 'description'  => 'required',
            // 'segment1'     => 'required',
            // 'segment2'     => 'required',
            // 'segment3'     => 'required',
            // 'segment4'     => 'required',
            // 'segment5'     => 'required',
            // 'segment6'     => 'required',
            // 'segment7'     => 'required',
            // 'segment8'     => 'required',
            // 'segment9'     => 'required',
            // 'segment10'    => 'required',
            // 'segment11'    => 'required',
            // 'segment12'    => 'required',
        ], [
            'account_code.required'  => 'ระบุ Code',
        ]);

        $checkaccount = AccountMapping::where('account_code', request()->account_code)->first();

        if ($checkaccount) {
            return redirect()->back();
        }

        $codeCombine = request()->segment1.'.'.request()->segment2.'.'.request()->segment3.'.'.request()->segment4.'.'.request()->segment5.'.'.request()->segment6.'.'.request()->segment7.'.'.request()->segment8.'.'.request()->segment9.'.'.request()->segment10.'.'.request()->segment11.'.'.request()->segment12;
        
        $combineDesc = $this->accountCombineDesc(request());

        // dd($codeCombine, $combineDesc);

        // $glCode = GlCodeCombination::where('concatenated_segments', $codeCombine)->first();


        $accountMapping                          = new AccountMapping;
        $accountMapping->account_code            = request()->account_code;
        $accountMapping->account_combine         = $codeCombine;
        $accountMapping->description             = request()->description;
        $accountMapping->active_flag             = request()->active_flag ? 'Y' : 'N';
        $accountMapping->segment1                = request()->segment1;
        $accountMapping->segment2                = request()->segment2;
        $accountMapping->segment3                = request()->segment3;
        $accountMapping->segment4                = request()->segment4;
        $accountMapping->segment5                = request()->segment5;
        $accountMapping->segment6                = request()->segment6;
        $accountMapping->segment7                = request()->segment7;
        $accountMapping->segment8                = request()->segment8;
        $accountMapping->segment9                = request()->segment9;
        $accountMapping->segment10               = request()->segment10;
        $accountMapping->segment11               = request()->segment11;
        $accountMapping->segment12               = request()->segment12;
        $accountMapping->account_combine_desc    = $combineDesc;
        // $accountMapping->code_combination_id     = $glCode ? $glCode->code_combination_id : '';
        $accountMapping->program_code            = 'OMS0017';
        $accountMapping->created_by              = $user->user_id;
        $accountMapping->last_updated_by         = $user->user_id;
        $accountMapping->start_date              = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $accountMapping->end_date                = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $accountMapping->save();

        return redirect()->route('om.settings.account-mapping.index');

    }

    public function edit($id)
    {
        $accountMapping  = AccountMapping::find($id);
        $companies       = Company::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE')->get();
        $evms            = Evm::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-EVM')->get();
        $departments     = Department::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE')->get();
        $budgetYears     = BudgetYear::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR')->get();
        $budgetTypes     = BudgetType::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE')->get();
        $budgetReasons   = BudgetReason::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON')->get();
        $mainAccounts    = MainAccount::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT')->get();
        $reserveds1      = Reserved1::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1')->get();
        $reserveds2      = Reserved2::where('flex_value_set_name', getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2')->get();
        

        return view('om.settings.account-mapping.edit', compact('accountMapping', 'companies', 'evms', 'departments', 'budgetYears', 'budgetTypes', 'budgetReasons', 'mainAccounts', 'reserveds1', 'reserveds2'));

    }

    public function update(Request $request, $id)
    {
        // dd(request()->all());

        $user = auth()->user();

        $codeCombine = request()->segment1.'.'.request()->segment2.'.'.request()->segment3.'.'.request()->segment4.'.'.request()->segment5.'.'.request()->segment6.'.'.request()->segment7.'.'.request()->segment8.'.'.request()->segment9.'.'.request()->segment10.'.'.request()->segment11.'.'.request()->segment12;
        
        $combineDesc = $this->accountCombineDesc(request());

        // dd(request()->all(), $codeCombine, $combineDesc);

        $accountMapping  = AccountMapping::find($id);
        $accountMapping->account_combine         = $codeCombine;
        $accountMapping->description             = request()->description;
        $accountMapping->active_flag             = request()->active_flag ? 'Y' : 'N';
        $accountMapping->segment1                = request()->segment1;
        $accountMapping->segment2                = request()->segment2;
        $accountMapping->segment3                = request()->segment3;
        $accountMapping->segment4                = request()->segment4;
        $accountMapping->segment5                = request()->segment5;
        $accountMapping->segment6                = request()->segment6;
        $accountMapping->segment7                = request()->segment7;
        $accountMapping->segment8                = request()->segment8;
        $accountMapping->segment9                = request()->segment9;
        $accountMapping->segment10               = request()->segment10;
        $accountMapping->segment11               = request()->segment11;
        $accountMapping->segment12               = request()->segment12;
        $accountMapping->account_combine_desc    = $combineDesc;
        $accountMapping->start_date              = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $accountMapping->end_date                = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $accountMapping->last_updated_by         = $user->user_id;
        $accountMapping->save();

        return redirect()->route('om.settings.account-mapping.index');
    }

    public function accountCombineDesc($request)
    {
        $segment1  = (new Company)->getDesciption(request()->segment1);
        $segment2  = (new Evm)->getDesciption(request()->segment2);
        $segment3  = (new Department)->getDesciption(request()->segment3);
        $segment4  = (new CostCenter)->getDesciption(request()->segment4, request()->segment3);
        $segment5  = (new BudgetYear)->getDesciption(request()->segment5);
        $segment6  = (new BudgetType)->getDesciption(request()->segment6);
        $segment7  = (new BudgetDetail)->getDesciption(request()->segment7, request()->segment6);
        $segment8  = (new BudgetReason)->getDesciption(request()->segment8);
        $segment9  = (new MainAccount)->getDesciption(request()->segment9);
        $segment10 = (new SubAccount)->getDesciption(request()->segment10, request()->segment9);
        $segment11 = (new Reserved1)->getDesciption(request()->segment11);
        $segment12 = (new Reserved2)->getDesciption(request()->segment12);

        $combineDesc = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;


        return $combineDesc;
    }
}
