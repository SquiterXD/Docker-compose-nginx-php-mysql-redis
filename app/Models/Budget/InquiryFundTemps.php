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

class InquiryFundTemps extends Model
{
    use HasFactory;
    protected $table        = 'pt_inquiry_fund_temps';
    protected $connection   = 'oracle';
    protected $primaryKey    = 'trans_id';
    protected $fillable     = ['code_combination_id', 'concatenated_segments', 'budget_amount', 'encumbrance_amount', 'actual_amount', 'funds_available_amount', 'req_encumbrance_amount', 'po_encumbrance_amount', 'segment1', 'segment2', 'segment3', 'segment4', 'segment5', 'segment6', 'segment7', 'segment8', 'segment9', 'segment10', 'segment11', 'segment12', 'created_by_id', 'created_by', 'creation_date', 'description_segments', 'other_encumbrance_amount', 'created_at', 'updated_at', 'updated_by_id', 'last_update_date', 'last_updated_by', 'last_update_login', 'summary_flag', 'parent_trans_id'];
    public $timestamps = false;

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

    public function parent()
    {
        return $this->hasMany(InquiryFundTemps::class, 'parent_trans_id', 'trans_id');
    }
}
