<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

class GLCombinationKFV extends Model
{
    use HasFactory;
    protected $table = 'gl_code_combinations_kfv';
    protected $connection   = 'oracle';

    public function getFund($param, $ccid, $periodAdjName, $transId)
    {
        $period = $param['period'];
        if ($param['adj_flag'] === "true") {
           $period = $periodAdjName;
        }
        $user = auth()->user();
        $db  = \DB::reconnect('oracle')->getPdo();
        $sql = "declare 
                    v_trans_id  number := 0 ;
                    begin 
                        PTGL_BUDGET_PKG.GET_FUNDS(
                                            p_ledger_id                 => {$param['ledger']}
                                            , p_budget_id               => {$param['budget']}
                                            , p_period_name             => '{$period}'
                                            , p_amount_type             => '{$param['amount_type']}'
                                            , p_encumbrance_type        => '{$param['encum_type']}'
                                            , p_account_level           => '{$param['account_level']}'
                                            , p_account_id              => {$ccid}

                                            , p_trans_id                => {$transId}
                                            , p_create_by_id            => {$user->user_id}
                                            , p_create_by               => {$user->fnd_user_id}

                                            , x_trans_id                => :v_trans_id
                                        );

                        dbms_output.put_line('v_trans_id = '|| :v_trans_id);
                    end; ";

        logger($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_trans_id', $result['trans_id'], \PDO::PARAM_INT);
        $stmt->execute();

        return $result;
    }

    public function getEncumbranceBc($ccid, $periodNum)
    {
        return $bc = collect(\DB::select("
                select line_code_combination_id
                    , actual_flag
                    , period_name
                    , period_num
                    , sum(nvl(line_entered_dr, 0) - nvl(line_entered_cr, 0)) encumbrance_amount
                from psa_je_bcp_lines_v
                where 1=1
                and line_code_combination_id = {$ccid}
                and period_num <= {$periodNum}
                and actual_flag = 'E'
                and batch_status <> 'P'
                group by line_code_combination_id
                    , actual_flag
                    , period_name
                    , period_num
            "));
    }

    public function getTransactionBc($ccid, $period)
    {
        return $bc = collect(\DB::select("
                select je_category category
                    , je_source source
                    , header_description description
                    , batch_name transaction_number
                    , line_entered_dr entered_dr
                    , line_entered_cr entered_cr
                    , decode(actual_flag,  'B', 1,  'E', 2,  'A', 3) actual_flag_num
                    , currency_code
                    , '' encumbrance_type
                    , je_header_id
                from psa_je_bcp_lines_v
                where 1=1
                and line_code_combination_id = {$ccid}
                and period_name = '{$period}'
                and actual_flag = 'E'
                and batch_status <> 'P'
            "));
    }

    public function getDescriptionAccount($segment_override)
    {
        $checkSummary = self::selectRaw('summary_flag')->where('concatenated_segments', $segment_override)->first();
        $isSummary = optional($checkSummary)->summary_flag ?? null;
        $explodeSegment = explode('.', $segment_override);
        $company = (new GLCompanyV)->companyDesc(getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE', $explodeSegment[0], $explodeSegment[0]);
        $evm = (new GLEVMV)->emvDesc(getPrefixValueSetName().'_GL_ACCT_CODE-EVM', $explodeSegment[1], $explodeSegment[1]);
        $department = (new GLDepartmentV)->departmentDesc(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $explodeSegment[2], $explodeSegment[2]);
        $costCenter = (new GLCostCenterV)->costCenterDesc(getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER', $explodeSegment[3], $explodeSegment[3], $explodeSegment[2]);
        $budgetYear = (new GLBudgetYearV)->budgetYearDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR', $explodeSegment[4], $explodeSegment[4]);
        $budgetType = (new GLBudgetTypeV)->budgetTypeDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE', $explodeSegment[5], $explodeSegment[5]);
        $budgetDetail = (new GLBudgetDetailV)->budgetDetailDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL', $explodeSegment[6], $explodeSegment[6], $explodeSegment[5]);
        $budgetReason = (new GLBudgetReasonV)->budgetReasonDesc(getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON', $explodeSegment[7], $explodeSegment[7]);
        $mainAccount = (new GLMainAccountV)->mainAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT', $explodeSegment[8], $explodeSegment[8]);
        $subAccount = (new GLSubAccountV)->subAccountDesc(getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT', $explodeSegment[9], $explodeSegment[9], $explodeSegment[8]);
        $reserved1 = (new GLReserved1V)->reserved1Desc(getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1', $explodeSegment[10], $explodeSegment[10]);
        $reserved2 = (new GLReserved2V)->reserved2Desc(getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2', $explodeSegment[11], $explodeSegment[11]);
        //Result
        $company = optional($company)->description ?? null;
        $evm = optional($evm)->description ?? null;
        $department = optional($department)->description ?? null;
        $costCenter = optional($costCenter)->description ?? null;
        $budgetYear = optional($budgetYear)->description ?? null;
        $budgetType = optional($budgetType)->description ?? null;
        $budgetDetail = optional($budgetDetail)->description ?? null;
        $budgetReason = optional($budgetReason)->description ?? null;
        $mainAccount = optional($mainAccount)->description ?? null;
        $subAccount = optional($subAccount)->description ?? null;
        $reserved1 = optional($reserved1)->description ?? null;
        $reserved2 = optional($reserved2)->description ?? null;

        $concatDesc = $company.'.'.$evm.'.'.$department.'.'.$costCenter.'.'.$budgetYear.'.'.$budgetType.'.'.$budgetDetail.'.'.$budgetReason.'.'.$mainAccount.'.'.$subAccount.'.'.$reserved1.'.'.$reserved2;

        return ['concatDesc' => $concatDesc, 'isSummary' => $isSummary];
    }

    public function scopeSegment1($q, $account_from, $account_to)
    {
        $segment1 = GLCompanyV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment1) || in_array($account_to, $segment1) || $account_from == 'T') {
        //     $q->whereBetween('segment1', ['00', 'ZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment1', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment1', [$account_from, 'ZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment1', ['00', $account_to]);
        }else{
            $q->whereBetween('segment1', ['00', 'ZZ']);
        }

        return $q;
    }

    public function scopeSegment2($q, $account_from, $account_to)
    {
        $segment2 = GLEVMV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment2) || in_array($account_to, $segment2)) {
        //     $q->whereBetween('segment2', ['0', 'Z']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment2', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment2', [$account_from, 'Z']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment2', ['0', $account_to]);
        }else{
            $q->whereBetween('segment2', ['0', 'Z']);
        }

        return $q;
    }

    public function scopeSegment3($q, $account_from, $account_to)
    {
        $segment3 = GLDepartmentV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment3) || in_array($account_to, $segment3)) {
        //     $q->whereBetween('segment3', ['00000000', 'ZZZZZZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment3', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment3', [$account_from, 'ZZZZZZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment3', ['00000000', $account_to]);
        }else{
            $q->whereBetween('segment3', ['00000000', 'ZZZZZZZZ']);
        }

        return $q;
    }

    public function scopeSegment4($q, $account_from, $account_to)
    {
        $segment4 = GLCostCenterV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment4) || in_array($account_to, $segment4)) {
        //     $q->whereBetween('segment4', ['00', 'ZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment4', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment4', [$account_from, 'ZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment4', ['00', $account_to]);
        }else{
            $q->whereBetween('segment4', ['00', 'ZZ']);
        }

        return $q;
    }

    public function scopeSegment5($q, $account_from, $account_to)
    {
        $segment5 = GLBudgetYearV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment5) || in_array($account_to, $segment5)) {
        //     $q->whereBetween('segment5', ['00', 'ZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment5', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment5', [$account_from, 'ZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment5', ['00', $account_to]);
        }else{
            $q->whereBetween('segment5', ['00', 'ZZ']);
        }

        return $q;
    }

    public function scopeSegment6($q, $account_from, $account_to)
    {
        $segment6 = GLBudgetTypeV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment6) || in_array($account_to, $segment6)) {
        //     $q->whereBetween('segment6', ['000', 'ZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment6', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment6', [$account_from, 'ZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment6', ['000', $account_to]);
        }else{
            $q->whereBetween('segment6', ['000', 'ZZZ']);
        }

        return $q;
    }

    public function scopeSegment7($q, $account_from, $account_to)
    {
        $segment7 = GLBudgetDetailV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment7) || in_array($account_to, $segment7)) {
        //     $q->whereBetween('segment7', ['000000', 'ZZZZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment7', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment7', [$account_from, 'ZZZZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment7', ['000000', $account_to]);
        }else{
            $q->whereBetween('segment7', ['000000', 'ZZZZZZ']);
        }

        return $q;
    }

    public function scopeSegment8($q, $account_from, $account_to)
    {
        $segment8 = GLBudgetReasonV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment8) || in_array($account_to, $segment8)) {
        //     $q->whereBetween('segment8', ['0', 'Z']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment8', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment8', [$account_from, 'Z']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment8', ['0', $account_to]);
        }else{
            $q->whereBetween('segment8', ['0', 'Z']);
        }

        return $q;
    }

    public function scopeSegment9($q, $account_from, $account_to)
    {
        $segment9 = GLMainAccountV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment9) || in_array($account_to, $segment9)) {
        //     $q->whereBetween('segment9', ['000000', 'ZZZZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment9', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment9', [$account_from, 'ZZZZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment9', ['000000', $account_to]);
        }else{
            $q->whereBetween('segment9', ['000000', 'ZZZZZZ']);
        }

        return $q;
    }

    public function scopeSegment10($q, $account_from, $account_to)
    {
        $segment10 = GLSubAccountV::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment10) || in_array($account_to, $segment10)) {
        //     $q->whereBetween('segment10', ['000', 'ZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment10', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment10', [$account_from, 'ZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment10', ['000', $account_to]);
        }else{
            $q->whereBetween('segment10', ['000', 'ZZZ']);
        }

        return $q;
    }

    public function scopeSegment11($q, $account_from, $account_to)
    {
        $segment11 = GLReserved1V::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment11) || in_array($account_to, $segment11)) {
        //     $q->where('segment11', '0')
        //         ->orWhereBetween('segment11', ['000', 'ZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment11', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment11', [$account_from, 'ZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->where('segment11', '0')
                ->orWhereBetween('segment11', ['000', $account_to]);
        }else{
            $q->where('segment11', '0')
                ->orWhereBetween('segment11', ['000', 'ZZZ']);
        }

        return $q;
    }

    public function scopeSegment12($q, $account_from, $account_to)
    {
        $segment12 = GLReserved2V::summary()->get()->pluck('meaning')->toArray();
        // if (in_array($account_from, $segment12) || in_array($account_to, $segment12)) {
        //     $q->where('segment12', '0')
        //         ->orWhereBetween('segment12', ['000', 'ZZZ']);
        // }else
        if (($account_from != null || $account_from != '') && ($account_to != null || $account_to != '')) {
            $q->whereBetween('segment12', [$account_from, $account_to]);
        }elseif (($account_from != null || $account_from != '') && ($account_to == null || $account_to == '')) {
            $q->whereBetween('segment12', [$account_from, 'ZZZ']);
        }elseif (($account_from == null || $account_from == '') && ($account_to != null || $account_to != '')) {
            $q->where('segment12', '0')
                ->orWhereBetween('segment12', ['000', $account_to]);
        }else{
            $q->where('segment12', '0')
                ->orWhereBetween('segment12', ['000', 'ZZZ']);
        }

        return $q;
    }
}