<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Budget\GLLedger;
use App\Models\Budget\GLBudgetV;
use App\Models\Budget\GLEncumbranceV;
use App\Models\Budget\InquiryFundTemps;
use App\Models\Budget\GLCombinationKFV;
use App\Models\Budget\BiweeklyPeriod;

class InquiryFundsController extends Controller
{
    public function index(Request $request)
    {
        $ledgers = GLLedger::selectRaw('short_name, ledger_id, name')->orderBy('ledger_id')->get();
        $budgetLists = GLBudgetV::selectRaw('budget_name, budget_version_id, start_date, end_date, first_valid_period_name')
                                ->orderBy('budget_name')
                                ->get();
        $encumbranceLists = GLEncumbranceV::selectRaw('encumbrance_type, encumbrance_type_id')->orderBy('encumbrance_type')->get();
        $amountLists = ['PTD' => 'Period To Date'
                        , 'QTDE' => 'Quarter To Date Extented'
                        , 'YTDE' => 'Year To Date Extented'
                        , 'PJTD' => 'Project To Date'];
        $accountLevelLists = ['A' => 'All'
                            , 'D' => 'Detail'
                            , 'S' => 'Summary'];

        //Data Inquiry funds
        $inquiryFunds = [];
        if($request->account_from) {
            $account_from = explode('.', $request->account_from);
            $account_to = explode('.', $request->account_to);
            $inquiryFunds = InquiryFundTemps::with(['parent' => function ($query) {
                                $query->orderBy('concatenated_segments');
                            }])
                            ->segment1($account_from[0], $account_to[0])
                            ->segment2($account_from[1], $account_to[1])
                            ->segment3($account_from[2], $account_to[2])
                            ->segment4($account_from[3], $account_to[3])
                            ->segment5($account_from[4], $account_to[4])
                            ->segment6($account_from[5], $account_to[5])
                            ->segment7($account_from[6], $account_to[6])
                            ->segment8($account_from[7], $account_to[7])
                            ->segment9($account_from[8], $account_to[8])
                            ->segment10($account_from[9], $account_to[9])
                            ->segment11($account_from[10], $account_to[10])
                            ->segment12($account_from[11], $account_to[11])
                            ->orderBy('concatenated_segments')
                            ->get();
        }

        $search = (object)[];
        $search->account_from = $request? $request->account_from: '';
        $search->account_to = $request? $request->account_to: '';
        $search->period = $request? $request->period: '';
        $search->ledger = $request? $request->ledger: '';
        $search->budget = $request? $request->budget: '';
        $search->amount_type = $request? $request->amount_type: '';
        $search->encum_type = $request? $request->encum_type: '';
        $search->account_level = $request? $request->account_level: '';
        $search->adj_flag = $request? $request->adj_flag: '';
        $search->adj_period = $request? $request->adj_period: '';

        $defaultInput = (object)[];
        $defaultInput->ledger =  optional($ledgers)->first()->ledger_id ?? '';
        $defaultInput->summary_flag = $inquiryFunds? in_array('Y', $inquiryFunds->pluck('summary_flag')->toArray()): false;
        $defaultValueSetName = (object)[];
        $defaultValueSetName->alias =  getPrefixValueSetName().'_GL_ALIAS';
        $defaultValueSetName->segment1 =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2 =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3 =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4 =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9 =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        return view('budget.inquiry-funds.index', compact('ledgers', 'budgetLists', 'encumbranceLists', 'amountLists', 'accountLevelLists', 'inquiryFunds', 'search', 'defaultInput', 'defaultValueSetName'));
    }
}
