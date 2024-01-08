<?php

namespace App\Http\Controllers\Budget\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Budget\GLCompanyV;
use App\Models\Budget\GLEVMV;
use App\Models\Budget\GLDepartmentV;
use App\Models\Budget\GLCostCenterV;
use App\Models\Budget\GLBudgetYearV;
use App\Models\Budget\GLBudgetTypeV;
use App\Models\Budget\GLBudgetDetailV;
use App\Models\Budget\GLBudgetReasonV;
use App\Models\Budget\GLMainAccountV;
use App\Models\Budget\GLSubAccountV;
use App\Models\Budget\GLReserved1V;
use App\Models\Budget\GLReserved2V;
use App\Models\Budget\GLAliasV;
use App\Models\Budget\GLCombinationKFV;
use App\Models\Budget\PeriodBalanceV;
use App\Models\Budget\BGFundsGLLV;
use App\Models\Budget\BGFundsXLAV;
use App\Models\Budget\InquiryFundTemps;
use App\Models\Budget\GLBalance;
use App\Models\Budget\SummaryAccountV;
use App\Models\Budget\BiweeklyPeriod;
use App\Models\Budget\GLPeriodV;
use Illuminate\Support\Collection;

class InquiryFundsController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'flex_value_set_name' => 'required',
        ]);
        $setName = $request->flex_value_set_name;
        $setValue = $request->flex_value_set_data;
        $setParent = $request->flex_value_parent;
        $text  = $request->get('query');
        $flexValue = [];

        //Alias
        if ($setName == getPrefixValueSetName().'_GL_ALIAS') {
            $flexValue = (new GLAliasV)->aliasResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
            $flexValue = (new GLCompanyV)->companyResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-EVM') {
            $flexValue = (new GLEVMV)->emvResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE') {
            $flexValue = (new GLDepartmentV)->departmentResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {
            $flexValue = (new GLCostCenterV)->costCenterResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR') {
            $flexValue = (new GLBudgetYearV)->budgetYearResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE') {
            $flexValue = (new GLBudgetTypeV)->budgetTypeResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL') {
            $flexValue = (new GLBudgetDetailV)->budgetDetailResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON') {
            $flexValue = (new GLBudgetReasonV)->budgetReasonResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT') {
            $flexValue = (new GLMainAccountV)->mainAccountResult($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT') {
            $flexValue = (new GLSubAccountV)->subAccountResult($setName, $setValue, $text, $setParent);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1') {
            $flexValue = (new GLReserved1V)->reserved1Result($setName, $setValue, $text);
        }
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2') {
            $flexValue = (new GLReserved2V)->reserved2Result($setName, $setValue, $text);
        }

        return $flexValue;
    }

    public function getInquriyFunds(Request $request)
    {
        $param = $request->search;
        $periodAdjName = '';
        $coaArr = self::findAccount($param['segment_override'], $param['last_segment_override']);
        if (array_key_exists('adj_period', $param)) {
            $periodAdjName = (new GLBalance)->getPeriodAdjust($param['adj_period']);
        }
        if ($coaArr) {
            foreach ($coaArr as $key => $coa) {
                $resultFund = (new GLCombinationKFV)->getFund($param, $coa->code_combination_id, $periodAdjName, 0);

                // $glCombination = (new GLCombinationKFV)->getDescriptionAccount($coa->concatenated_segments);
                // $expAccount = explode('.', $coa->concatenated_segments);
                // //insert date to temp for display For Summary Account
                // $temp = $this->insertToTemp($coa, $glCombination, $resultFund, $expAccount);

                $transId = $resultFund['trans_id'] ;
                // ----------------------------------
                if ($coa->summary_flag == 'Y') {
                    $summaryAccs = SummaryAccountV::selectRaw('detail_code_combination_id code_combination_id
                                                , summary_combine_account
                                                , detail_combine_account concatenated_segments'
                                            )
                                            ->where('summary_combine_account', $coa->concatenated_segments)
                                            ->get();
                    foreach ($summaryAccs as $acc) {
                        $resultFund = (new GLCombinationKFV)->getFund($param, $acc->code_combination_id, $periodAdjName, $transId);
                        // $glCombination = (new GLCombinationKFV)->getDescriptionAccount($acc->concatenated_segments);
                        // $expAccount = explode('.', $acc->concatenated_segments);
                        // $temps = $this->insertToTemp($acc, $glCombination, $resultFund, $expAccount, $temp['trans_id']);
                    }
                }
            }
            $data = [
                'status' => 'S',
                'redirect_show_page' => route('funds.index',['account_from' => $param['segment_override']
                            , 'account_to'   => $param['last_segment_override']
                            , 'period'      => $periodAdjName != ''? $periodAdjName: $param['period']
                            , 'ledger'      => $param['ledger']
                            , 'budget'      => $param['budget']
                            , 'amount_type' => $param['amount_type']
                            , 'encum_type'  => $param['encum_type']
                            , 'account_level' => $param['account_level']
                            , 'adj_flag'    => $param['adj_flag']
                            , 'adj_period'  => array_key_exists('adj_period', $param)? $param['adj_period']: ''
                        ])
            ];
            return response()->json($data);
        }

        $data = [
            'status' => 'E',
            'msg' => 'ไม่มี Account: '.$param['segment_override'].' ในระบบ กรุณาตรวจสอบอีกครั้ง'
        ];

        return response()->json($data);
    }

    public function findAccount($account_from, $account_to)
    {
        $account_from = explode('.', $account_from);
        $account_to = explode('.', $account_to);
        $coa = GLCombinationKFV::selectRaw('code_combination_id, concatenated_segments, summary_flag')
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
                        ->get();

        return $coa;
    }

    public function getTransaction(Request $request)
    {
        $ccid = GLCombinationKFV::selectRaw('code_combination_id')
                        ->where('concatenated_segments', $request->coa)
                        ->first()->code_combination_id;
        $gll = BGFundsGLLV::selectRaw('gl_category category, gl_source source, gll_description description, accounted_dr entered_dr, accounted_cr entered_cr, transaction_number, gl_document_number, actual_flag_num, currency_code, encumbrance_type, je_header_id')
                        ->where('code_combination_id', $ccid)
                        ->where('period_name', $request->period)
                        ->orderBy('actual_flag_num')
                        ->get();
        $xla = BGFundsXLAV::selectRaw('gl_category category, gl_source source, xal_description description, transaction_number, gl_document_number, accounted_dr entered_dr, accounted_cr entered_cr, actual_flag_num, currency_code, encumbrance_type, je_header_id')
                        ->where('code_combination_id', $ccid)
                        ->where('period_name', $request->period)
                        ->orderByRaw('actual_flag_num')
                        ->get();
        $bc = (new GLCombinationKFV)->getTransactionBc($ccid, $request->period);
        $transactions = collect($bc)->merge($gll)->merge($xla);
        // $transactions = $transactions->groupBy('actual_flag_num');

        $data = [];
        $data['html'] = view("budget.inquiry-funds._form_transaction", compact('request', 'transactions'))->render();
        return response()->json(['data' => $data]);
    }

    public function getPeriodBalance(Request $request)
    {
        $fund = InquiryFundTemps::where('code_combination_id', $request->ccid)->first();
        $period = (new PeriodBalanceV)->getPeriodYear($request->period_name);

        if ($request->adj_flag === true) {
            $period['year'] = $request->adj_period;
            $period['month'] = 13;
        }
        if ($fund) {
            $periodBalance = PeriodBalanceV::where('account_code', $fund->concatenated_segments)
                                            ->where('period_year', $period['year'])
                                            ->where('period_num', '<=', $period['month'])
                                            ->orderBy('period_num', 'asc')
                                            ->get();

            $bc = (new GLCombinationKFV)->getEncumbranceBc($request->ccid, $period['month']);
            $data = [
                'status' => 'S',
                'fund' => $fund,
                'period_balance' => $periodBalance,
                'encumbrances' => $bc,
            ];

            return response()->json($data);
        }

        $data = [
            'status' => 'E',
            'msg' => 'ไม่มี Account: '.$request->account_from.' - '.$request->account_to.'ในระบบ กรุณาตรวจสอบอีกครั้ง'
        ];

        return response()->json($data);
    }

    private function insertToTemp($coa, $glCombination, $resultFund, $expAccount, $summaryId = null)
    {
        $temp = InquiryFundTemps::updateOrCreate(
                    [
                        'code_combination_id'       => $coa->code_combination_id
                        , 'concatenated_segments'   => $coa->concatenated_segments
                    ],[
                        'code_combination_id'       => $coa->code_combination_id
                        , 'concatenated_segments'   => $coa->concatenated_segments
                        , 'description_segments'    => $glCombination['concatDesc']
                        , 'budget_amount'           => $resultFund['budget_amount'] ?? 0
                        , 'encumbrance_amount'      => $resultFund['encumbrance_amount'] ?? 0
                        , 'actual_amount'           => $resultFund['actual_amount'] ?? 0
                        , 'funds_available_amount'  => $resultFund['funds_available_amount'] ?? 0
                        , 'req_encumbrance_amount'  => $resultFund['req_encumbrance_amount'] ?? 0
                        , 'po_encumbrance_amount'   => $resultFund['po_encumbrance_amount'] ?? 0
                        , 'other_encumbrance_amount' => $resultFund['other_encumbrance_amount'] ?? 0
                        , 'segment1'                => $expAccount[0]
                        , 'segment2'                => $expAccount[1]
                        , 'segment3'                => $expAccount[2]
                        , 'segment4'                => $expAccount[3]
                        , 'segment5'                => $expAccount[4]
                        , 'segment6'                => $expAccount[5]
                        , 'segment7'                => $expAccount[6]
                        , 'segment8'                => $expAccount[7]
                        , 'segment9'                => $expAccount[8]
                        , 'segment10'               => $expAccount[9]
                        , 'segment11'               => $expAccount[10]
                        , 'segment12'               => $expAccount[11]
                        , 'created_by_id'           => auth()->user()->user_id //web
                        , 'created_by'              => auth()->user()->fnd_user_id
                        , 'creation_date'           => now()
                        , 'summary_flag'            => $glCombination['isSummary']
                        , 'parent_trans_id'         => $summaryId
                    ]
                );
        return $temp;
    }

    public function getPeriodYear(Request $request)
    {
        $periodYear = GLPeriodV::selectRaw('distinct period_year+543 period_year, start_date')
                                ->where('period_name', $request->period)
                                ->first();
        // dd($periodYear, $request->period);
        $convertToDate = '01-01-'.$periodYear->period_year;
        $date = $periodYear? date('d-m-Y', strtotime($convertToDate)): date('d-m-Y');
        $periodYear = date('y', strtotime($date));

        $data = [ 'periodYear' => $periodYear ];
        return response()->json($data);
    }
}
