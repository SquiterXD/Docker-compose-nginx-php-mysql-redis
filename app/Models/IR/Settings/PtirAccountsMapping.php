<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

use App\Models\IR\Settings\PtglCoaCompanyView       as Company;
use App\Models\IR\Settings\PtglCoaEvmView           as Evm;
use App\Models\IR\Settings\PtglCoaDeptCodeView      as Department;           
use App\Models\IR\Settings\PtglCoaCostCenterView    as CostCenter;
use App\Models\IR\Settings\PtglCoaBudgetYearView    as BudgetYear;
use App\Models\IR\Settings\PtglCoaBudgetTypeView    as BudgetType;
use App\Models\IR\Settings\PtglCoaBudgetDetailView  as BudgetDetail;
use App\Models\IR\Settings\PtglCoaBudgetReasonView  as BudgetReason;
use App\Models\IR\Settings\PtglCoaMainAccountView   as MainAccount;
use App\Models\IR\Settings\PtglCoaSubAccountView    as SubAccount;
use App\Models\IR\Settings\PtglCoaReserved1View     as Reserved1;
use App\Models\IR\Settings\PtglCoaReserved2View     as Reserved2;

class PtirAccountsMapping extends Model
{
    use HasFactory;

    protected $table = "ptir_accounts_mapping";
    public $primaryKey = 'account_id';
    // public $timestamps = false;

    private $limit = 50;
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_code',
        'description',
        'account_combine',
        'segment_1',
        'segment_2',
        'segment_3',
        'segment_4',
        'segment_5',
        'segment_6',
        'segment_7',
        'segment_8',
        'segment_9',
        'segment_10',
        'segment_11',
        'segment_12',
        'active_flag',
        'account_combine_desc',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ];

    public function scopeSearch($q, $accountCode, $status)
    {
        return $q->when($accountCode, function($q) use($accountCode) {
            $q->where('account_code', 'like', '%' . $accountCode . '%');
        })->when($status, function($q) use($status) {
            $q->where('active_flag', $status);
        });
    }

    /**
     * Get all account mapping
     */
    public function allAccountsMapping() 
    {
        $data = PtirAccountsMapping::select('ACCOUNT_ID', 'ACCOUNT_CODE', 'DESCRIPTION')->get();

        return $data;
    }

    public function getSpecifiedAccountMapping($id, $active_flag)
    {
        $data = PtirAccountsMapping::select('ACCOUNT_ID', 'ACCOUNT_CODE', 'DESCRIPTION', 'SEGMENT_1 as COMPANY_CODE',
                                            'SEGMENT_2 as DEPARTMENT_CODE', 'SEGMENT_3 as EVM_CODE', 'SEGMENT_4 as COST_CENTER_CODE',
                                            'SEGMENT_5 as BUDGET_YEAR', 'SEGMENT_6 as BUDGET_TYPE', 'SEGMENT_7 as BUDGET_DETAIL',
                                            'SEGMENT_8 as BUDGET_REASON', 'SEGMENT_9 as MAIN_ACCOUNT', 'SEGMENT_10 as SUB_ACCOUNT',
                                            'SEGMENT_11 as RESERVED1', 'SEGMENT_12 as RESERVED2', 'ACTIVE_FLAG', 'ACCOUNT_COMBINE',
                                            'ACCOUNT_COMBINE_DESC', 'CODE_COMBINATION_ID')
                                    ->where('ACCOUNT_ID', $id)
                                    ->where('ACTIVE_FLAG', $active_flag)
                                    ->first();
        
        return $this->objectAccountMapping($data);
    }

    public function updateAccountMapping($data) 
    {
        $db = PtirAccountsMapping::find($data['account_id']);
        $db->account_code         = $data['account_code'];
        $db->description          = $data['description'];
        $db->account_code_combine = $data['account_code_combine'];
        $db->segment_1            = $data['segment_1'];
        $db->segment_2            = $data['segment_2'];
        $db->segment_3            = $data['segment_3'];
        $db->segment_4            = $data['segment_4'];
        $db->segment_5            = $data['segment_5'];
        $db->segment_6            = $data['segment_6'];
        $db->segment_7            = $data['segment_7'];
        $db->segment_8            = $data['segment_8'];
        $db->segment_9            = $data['segment_9'];
        $db->segment_10           = $data['segment_10'];
        $db->segment_11           = $data['segment_11'];
        $db->segment_12           = $data['segment_12'];
        $db->active_flag          = $data['active_flag'];
        $db->account_combine_desc = $data['account_combine_desc'];
        $db->active_flag          = $data['active_flag'];
        $db->last_updated_by      = $data['last_updated_by'];
        $db->updated_at           = $data['updated_at'];
        $db->last_update_date     = $data['last_update_date'];
        $db->save();
    }

    private function objectAccountMapping($data) 
    {
        $obj = new stdClass();
        $obj->account_id            = (isset($data->account_id)) ? $data->account_id : '';
        $obj->account_code          = (isset($data->account_code)) ? $data->account_code : ''; 
        $obj->description           = (isset($data->description)) ? $data->description : '';
        $obj->company_code          = (isset($data->company_code)) ? $data->company_code : '';
        $obj->department_code       = (isset($data->department_code)) ? $data->department_code : '';
        $obj->evm_code              = (isset($data->evm_code)) ? $data->evm_code : '';
        $obj->cost_center_code      = (isset($data->cost_center_code)) ? $data->cost_center_code : '';
        $obj->budget_year           = (isset($data->budget_year)) ? $data->budget_year : '';
        $obj->budget_type           = (isset($data->budget_type)) ? $data->budget_type : '';
        $obj->budget_detail         = (isset($data->budget_detail)) ? $data->budget_detail : '';
        $obj->budget_reason         = (isset($data->budget_reason)) ? $data->budget_reason : ''; 
        $obj->main_account          = (isset($data->main_account)) ? $data->main_account : '';
        $obj->sub_account           = (isset($data->sub_account)) ? $data->sub_account : '';
        $obj->reserved1             = (isset($data->reserved1)) ? $data->reserved1 : '';
        $obj->reserved2             = (isset($data->reserved2)) ? $data->reserved2 : '';
        $obj->active_flag           = (isset($data->active_flag)) ? $data->active_flag : '';
        $obj->account_combine_desc  = (isset($data->account_combine_desc)) ? $data->account_combine_desc : '';
        $obj->account_combine       = (isset($data->account_combine)) ? $data->account_combine : '';
        $obj->code_combination_id   = (isset($data->code_combination_id)) ? $data->code_combination_id : '';

       return $obj;
    }

    public function getAccountCodeCombine($id, $desciption) 
    {
        $id         = (isset($id)) ? $id.'%' : '%';
        $desciption = (isset($desciption)) ? $desciption.'%' : '%';
        $collection = PtirAccountsMapping::select('account_id', 'account_code', 'description', 'account_code_combine')
                                          ->where('account_code', 'like', $id)
                                          ->where('description', 'like', $desciption)
                                          ->take($this->limit)
                                          ->get();
    }

    public function getAccount($id)
    {
        $collection = PtirAccountsMapping::where('account_id', $id)->first();
        return $collection;
    }

    public function getFullGlCodeAttribute()
    {
        return sprintf('%s.%s.%s.%s.%s.%s.%s.%s.%s.%s.%s.%s',
            $this->segment_1,
            $this->segment_2,
            $this->segment_3,
            $this->segment_4,
            $this->segment_5,
            $this->segment_6,
            $this->segment_7,
            $this->segment_8,
            $this->segment_9,
            $this->segment_10,
            $this->segment_11,
            $this->segment_12
        );
    }
    public function getFullGlDescAttribute()
    {
        // dd($this->segment1);
        $segment1  = (new Company)->getDesciption($this->segment_1);
        $segment2  = (new Evm)->getDesciption($this->segment_2);
        $segment3  = (new Department)->getDesciption($this->segment_3);
        $segment4  = (new CostCenter)->getDesciption($this->segment_4);
        $segment5  = (new BudgetYear)->getDesciption($this->segment_5);
        $segment6  = (new BudgetType)->getDesciption($this->segment_6);
        $segment7  = (new BudgetDetail)->getDesciption($this->segment_7);
        $segment8  = (new BudgetReason)->getDesciption($this->segment_8);
        $segment9  = (new MainAccount)->getDesciption($this->segment_9);
        $segment10 = (new SubAccount)->getDesciption($this->segment_10);
        $segment11 = (new Reserved1)->getDesciption($this->segment_11);
        $segment12 = (new Reserved2)->getDesciption($this->segment_12);

        $combineDesc = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;

        return $combineDesc;
        
    }

    public function updateActiveFlag($id, $flag, $userId) 
    {
        // dd($id, $flag, $userId);
        $data = PtirAccountsMapping::find($id);
        $data->active_flag      = $flag;
        $data->last_updated_by  = $userId;
        $data->save();
    }

    // public function accountCombineDesc($type, $code)
    // {
    //     if (request()->segment1) {
    //         $data = (new Company)->getDesciption(request()->segment1);
    //     } elseif (request()->segment2) {
    //         $data = (new Evm)->getDesciption(request()->segment2);
    //     } elseif (request()->segment3) {
    //         $data = (new Department)->getDesciption(request()->segment3);
    //     } elseif (request()->segment4) {
    //         $data = (new CostCenter)->getDesciption(request()->segment4);
    //     } elseif (request()->segment5) {
    //         $data = (new BudgetYear)->getDesciption(request()->segment5);
    //     } elseif (request()->segment6) {
    //         $data = (new BudgetType)->getDesciption(request()->segment6);
    //     } elseif (request()->segment7) {
    //         $data = (new BudgetDetail)->getDesciption(request()->segment7);
    //     } elseif (request()->segment8) {
    //         $data = (new BudgetReason)->getDesciption(request()->segment8);
    //     } elseif (request()->segment9) {
    //         $data = (new MainAccount)->getDesciption(request()->segment9);
    //     } elseif (request()->segment10) {
    //         $data = (new SubAccount)->getDesciption(request()->segment10);
    //     } elseif (request()->segment11) {
    //         $data = (new Reserved1)->getDesciption(request()->segment11);
    //     } elseif (request()->segment12) {
    //         $data = (new Reserved2)->getDesciption(request()->segment12);
    //     }

    //     return $data;
        
    //     // $segment1  = (new Company)->getDesciption(request()->segment1);
    //     // $segment2  = (new Evm)->getDesciption(request()->segment2);
    //     // $segment3  = (new Department)->getDesciption(request()->segment3);
    //     // $segment4  = (new CostCenter)->getDesciption(request()->segment4);
    //     // $segment5  = (new BudgetYear)->getDesciption(request()->segment5);
    //     // $segment6  = (new BudgetType)->getDesciption(request()->segment6);
    //     // $segment7  = (new BudgetDetail)->getDesciption(request()->segment7);
    //     // $segment8  = (new BudgetReason)->getDesciption(request()->segment8);
    //     // $segment9  = (new MainAccount)->getDesciption(request()->segment9);
    //     // $segment10 = (new SubAccount)->getDesciption(request()->segment10);
    //     // $segment11 = (new Reserved1)->getDesciption(request()->segment11);
    //     // $segment12 = (new Reserved2)->getDesciption(request()->segment12);

    //     // $combineDesc = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;

    //     // return $combineDesc;
        
    // }

}
