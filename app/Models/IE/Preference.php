<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'ptw_preferences';
    public $primaryKey = 'preference_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    protected $fillable = ['org_id','category_id','sub_category_id','type'];

    public static function getBaseCurrency()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $currency = Currency::whereCurrencyCode('THB')->first();

        if($currency){
            return $currency->currency_code;
        }else{
            return 'THB'; // default THB
        }
    }

    // public static function getBaseMileageUnit()
    // {
    //     if(!$orgId)
        // $orgId = getDefaultData()->bu_id;

    //     $mileageUnit = MileageUnit::whereCode('KM')->first();

    //     return $mileageUnit->mileage_unit_id;
    //     return null;
    // }

    public static function getPendingDayBlocking()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $pendingDayBlocking = self::whereCode('pending_day_blocking')->first();
        // default if not found
        if(!$pendingDayBlocking){
            $pendingDayBlocking = new Preference();
            $pendingDayBlocking->code = 'pending_day_blocking';
            // $pendingDayBlocking->org_id = $orgId;
            $pendingDayBlocking->data_type = 'varchar';
            $pendingDayBlocking->data_value = null;
            $pendingDayBlocking->last_updated_by = -1;
            $pendingDayBlocking->created_by = -1;
            $pendingDayBlocking->save();
        }
        return decodeDataValue($pendingDayBlocking->data_type,
                                        $pendingDayBlocking->data_value);
    }

    public static function getPendingNumberBlocking()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $pendingNumberBlocking = self::whereCode('pending_number_blocking')->first();
        // default if not found
        if(!$pendingNumberBlocking){
            $pendingNumberBlocking = new Preference();
            $pendingNumberBlocking->code = 'pending_number_blocking';
            // $pendingNumberBlocking->org_id = $orgId;
            $pendingNumberBlocking->data_type = 'varchar';
            $pendingNumberBlocking->data_value = '["0"]';
            $pendingNumberBlocking->last_updated_by = -1;
            $pendingNumberBlocking->created_by = -1;
            $pendingNumberBlocking->save();
        }
        return decodeDataValue($pendingNumberBlocking->data_type,
                                        $pendingNumberBlocking->data_value);
    }

    public static function getUnblockers()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $unblockUsers = self::whereCode('unblock_users')->first();
        // default if not found
        if(!$unblockUsers){
            $unblockUsers = new Preference();
            $unblockUsers->code = 'unblock_users';
            // $unblockUsers->org_id = $orgId;
            $unblockUsers->data_type = 'json';
            $unblockUsers->data_value = null;
            $unblockUsers->last_updated_by = -1;
            $unblockUsers->created_by = -1;
            $unblockUsers->save();
        }

        return decodeDataValue($unblockUsers->data_type,
                                        $unblockUsers->data_value);

    }

    public static function getChangeApprovers()
    {
        $changeApproveUsers = self::whereCode('change_approvers')->first();
        // default if not found
        if(!$changeApproveUsers){
            $changeApproveUsers = new Preference();
            $changeApproveUsers->code = 'change_approvers';
            // $changeApproveUsers->org_id = $orgId;
            $changeApproveUsers->data_type = 'json';
            $changeApproveUsers->data_value = null;
            $changeApproveUsers->last_updated_by = -1;
            $changeApproveUsers->created_by = -1;
            $changeApproveUsers->save();
        }

        return decodeDataValue($changeApproveUsers->data_type,
                                        $changeApproveUsers->data_value);
    }

    public static function getShowAllUsers()
    {
        $showAllUsers = self::whereCode('show_all_users')->first();
        // default if not found
        if(!$showAllUsers){
            $showAllUsers = new Preference();
            $showAllUsers->code = 'show_all_users';
            // $showAllUsers->org_id = $orgId;
            $showAllUsers->data_type = 'json';
            $showAllUsers->data_value = null;
            $showAllUsers->last_updated_by = -1;
            $showAllUsers->created_by = -1;
            $showAllUsers->save();
        }

        return decodeDataValue($showAllUsers->data_type,
                                        $showAllUsers->data_value);
    }

    public static function getAccountantUsers()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $accountantUsers = self::whereCode('accountant_users')->first();
        // default if not found
        if(!$accountantUsers){
            $accountantUsers = new Preference();
            $accountantUsers->code = 'accountant_users';
            // $accountantUsers->org_id = $orgId;
            $accountantUsers->data_type = 'json';
            $accountantUsers->data_value = null;
            $accountantUsers->last_updated_by = -1;
            $accountantUsers->created_by = -1;
            $accountantUsers->save();
        }

        return decodeDataValue($accountantUsers->data_type,
                                        $accountantUsers->data_value);

    }

    public static function getMappingOU()
    {
        $mapping_ou = self::whereCode('mapping_ou')->first();
        // default if not found
        if(!$mapping_ou){
            $mapping_ou = new Preference();
            $mapping_ou->code = 'mapping_ou';
            // $unblockUsers->org_id = $orgId;
            $mapping_ou->data_type = 'json';
            $mapping_ou->data_value = null;
            $mapping_ou->last_updated_by = -1;
            $mapping_ou->created_by = -1;
            $mapping_ou->save();
        }

        $mapping_ou->data_value = $mapping_ou->data_value ? json_decode($mapping_ou->data_value) : [];
        $dataSet = [];
        foreach($mapping_ou->data_value as $key => $value)
        {
            $dataSet[$key] = $value;
        }

        return $dataSet;
    }

    public static function getPurpose($object = null)
    {
        $purpose = self::whereCode('purpose')->first();
        // default if not found
        if(!$purpose){
            $purpose = new Preference();
            $purpose->code = 'purpose';
            // $unblockUsers->org_id = $orgId;
            $purpose->data_type = 'json';
            $purpose->data_value = null;
            $purpose->last_updated_by = -1;
            $purpose->created_by = -1;
            $purpose->save();
        }

        $purpose->data_value = $purpose->data_value ? json_decode($purpose->data_value) : [];
        $dataSet = [];
        foreach($purpose->data_value as $key => $value)
        {
            if($object){
                $dataSet[$value] = $value;
            }else {
                $dataSet[$key] = $value;
            }
        }

        return $dataSet;
    }

    public static function getOverBudgetApproverJob()
    {
        // if(!$orgId)
        $orgId = getDefaultData()->bu_id;

        $overBudgetApproverJob = self::whereCode('over_budget_approver_job')
                            ->first();
        // default if not found
        if(!$overBudgetApproverJob){
            // DEFAULT APPROVAL AUTHORITY = 60 (EO)
            $jobEO = Job::where('approval_authority',60)->first();
            $overBudgetApproverJob = new Preference();
            $overBudgetApproverJob->code = 'over_budget_approver_job';
            // $overBudgetApproverJob->org_id = $orgId;
            $overBudgetApproverJob->data_type = 'varchar';
            $overBudgetApproverJob->data_value = '["'.$jobEO->job_id.'"]';
            $overBudgetApproverJob->last_updated_by = -1;
            $overBudgetApproverJob->created_by = -1;
            $overBudgetApproverJob->save();
        }
        return decodeDataValue($overBudgetApproverJob->data_type,
                                        $overBudgetApproverJob->data_value);
    }
}
