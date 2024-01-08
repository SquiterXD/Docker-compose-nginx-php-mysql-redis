<?php

namespace App\Models\IR\Settings;

use App\Models\IR\Views\PtirRenewCarInsurancesView;
use App\Models\IR\Views\PtirToatFaCategorySeg5View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use stdClass;

class PtirVehicles extends Model
{
    use HasFactory;

    protected $table = "ptir_vehicles";
    public $primaryKey = 'vehicle_id';
    public $timestamps = false;
    private $limit = 50;
    protected $fillable = [
        'vehicle_id',
        'asset_id',
        'asset_number',
        'vehicle_type_code',
        'vehicle_brand_code',
        'license_plate',
        'vehicle_cc',
        'engine_number',
        'tank_number',
        'return_vat_flag',
        // 'vat_percent',
        'revenue_stamp_percent',
        'account_id',
        'account_number',
        'account_description',
        'insurance_expire_date',
        'license_plate_expire_date',
        'acts_expire_date',
        'car_inspection_expire_date',
        'active_flag',
        'policy_set_header_id',
        'category_segment4',
        'group_code',
        'insurance_type_code',
        'sold_flag',
        'sold_date',
        'reason',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'location_code',
        'location_description',
        'renew_car_act',
        'renew_car_license_plate',
        'renew_car_inspection'
    ];

    public function categorySeg5() {
        return $this->belongsTo(PtirToatFaCategorySeg5View::class, 'vehicle_type_code', 'value');
    }

    public function renewCar() {
        return $this->belongsTo(PtirRenewCarInsurancesView::class, 'insurance_type_code', 'lookup_code');
    }

    public function updateVehicle($data)
    {
        $db = PtirVehicles::find($data['vehicle_id']);
        $db->group_code                 = $data['group_code'];
        $db->return_vat_flag            = $data['return_vat_flag'];
        // $db->vat_percent                = $data['vat_percent'];
        $db->revenue_stamp_percent      = $data['revenue_stamp_percent'];
        $db->insurance_type_code        = $data['insurance_type_code'];
        $db->active_flag                = $data['active_flag'];
        $db->policy_set_header_id       = $data['policy_set_header_id'];
        $db->group_code                 = $data['group_code'];
        $db->account_id                 = $data['account_id'];
        $db->account_number             = $data['account_number'];
        $db->account_description        = $data['account_description'];

        $db->license_plate              = $data['license_plate'];
        $db->category_segment4          = $data['category_segment4'];
        $db->sold_flag                  = $data['sold_flag'];
        $db->sold_date                  = $data['sold_date'];
        $db->vehicle_cc                 = $data['vehicle_cc'];
        $db->engine_number              = $data['engine_number'];
        $db->tank_number                = $data['tank_number'];
        $db->reason                     = $data['reason'];
        $db->last_updated_by            = $data['last_updated_by'];
        $db->updated_at                 = $data['updated_at'];
        $db->last_update_date           = $data['last_update_date'];
        // Date
        $db->insurance_expire_date      = $data['insurance_expire_date'];
        $db->license_plate_expire_date  = $data['license_plate_expire_date'];
        $db->acts_expire_date           = $data['acts_expire_date'];
        $db->car_inspection_expire_date = $data['car_inspection_expire_date'];
        // New Requirement 09012022
        $db->location_code              = $data['location_code'];
        $db->location_description       = $data['location_description'];
        $db->renew_car_act              = $data['renew_car_act'];
        $db->renew_car_license_plate    = $data['renew_car_license_plate'];
        $db->renew_car_inspection       = $data['renew_car_inspection'];

        $db->save();
    }

    public function updateActiveFlag($data)
    {
        $db = PtirVehicles::find($data['vehicle_id']);
        if ($db !== null) {
            $db->active_flag           = $data['active_flag'];
            $db->last_updated_by       = $data['last_updated_by'];
            $db->updated_at            = $data['updated_at'];
            $db->last_update_date      = $data['last_update_date'];
            $db->save();
        } else {
            $this->storeSomeData($data);
        }
    }

    public function updateReturnVatFlag($data)
    {
        $db = PtirVehicles::find($data['vehicle_id']);
        if ($db !== null) {
            $db->return_vat_flag       = $data['return_vat_flag'];
            $db->last_updated_by       = $data['last_updated_by'];
            $db->updated_at            = $data['updated_at'];
            $db->last_update_date      = $data['last_update_date'];
            $db->save();
        } else {
            $this->storeSomeData($data);
        }
    }

    public function updateSoldFlag($data)
    {
        $db = PtirVehicles::find($data['vehicle_id']);
        if ($db !== null) {
            $db->sold_flag             = $data['sold_flag'];
            $db->sold_date             = $data['sold_date'];
            $db->reason                = $data['reason'];
            $db->active_flag           = $data['active_flag'];
            $db->last_updated_by       = $data['last_updated_by'];
            $db->updated_at            = $data['updated_at'];
            $db->last_update_date      = $data['last_update_date'];
            $db->save();
        } else {
            $this->storeSomeData($data);
        }
    }

    public function storeSomeData($data)
    {
        PtirVehicles::insert([
            'asset_id'              => $data['asset_id'],
            'asset_number'          => $data['asset_number'],
            'license_plate'         => $data['license_plate'],
            'vehicle_type_code'     => $data['vehicle_type_code'],
            'vehicle_brand_code'    => $data['vehicle_brand_code'],
            'return_vat_flag'       => $data['return_vat_flag'],
            // 'vat_percent'           => $data['vat_percent'],
            'revenue_stamp_percent' => $data['revenue_stamp_percent'],
            'account_id'            => $data['account_id'],
            'account_number'        => $data['account_number'],
            'active_flag'           => $data['active_flag'],
            'program_code'          => $data['program_code'],
            'created_by'            => $data['created_by'],
            'created_by_id'         => $data['created_by_id'],
            'last_updated_by'       => $data['last_updated_by'],
            'created_at'            => $data['created_at'],
            'updated_at'            => $data['updated_at'],
            'creation_date'         => $data['creation_date'],
            'last_update_date'      => $data['last_update_date'],
        ]);
    }

    public function getVehicleForCars($assetNumber)
    {
        $collection = DB::table('ptir_vehicles as a')->select(
            'a.asset_number',
            'a.policy_set_header_id',
            'b.policy_set_description',
            'b.account_id',
            'b.gl_expense_account_id',
            'c.account_combine',
            'c.account_combine_desc'
        )
        ->leftJoin('ptir_policy_set_headers as b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
        ->leftJoin('ptir_accounts_mapping_v as c', 'b.gl_expense_account_id', '=', 'c.account_id')
        ->where('a.asset_number', $assetNumber)
        ->first();

        return $collection;
    }

    public function callGetFALocationPackage()
    {
        $user = \Auth::user()->fnd_user_id;
        $db = \DB::connection('oracle')->getPdo();
        $sql = " declare 
                v_return_status varchar2(1);
                v_return_msg    varchar2(4000);
                begin 
                       ptir_web_utilities_pkg.get_vehicles(i_org_id             => 121
                                                            , i_user_id         => {$user}
                                                            , o_return_status   => :v_return_status
                                                            , o_return_msg      => :v_return_msg
                                                         );

                      dbms_output.put_line('v_return_status = '||v_return_status);
                      dbms_output.put_line('v_return_msg = '||v_return_msg);
                end ;";
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function callValidateAccount($account)
    {
        $account = explode('.', $account);
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare 
                    v_account_id     number := 0;
                    v_account_code   varchar2(250);
                    v_return_status  varchar2(1);
                    v_return_msg     varchar2(4000);
                begin 
                    ptir_utilities_pkg.get_new_account_fa( i_segment_1          => '{$account[0]}'
                                                            , i_segment_2           => '{$account[1]}'
                                                            , i_segment_3           => '{$account[2]}'
                                                            , i_segment_4           => '{$account[3]}'
                                                            , i_segment_5           => '{$account[4]}'
                                                            , i_segment_6           => '{$account[5]}'
                                                            , i_segment_7           => '{$account[6]}'
                                                            , i_segment_8           => '{$account[7]}'
                                                            , i_segment_9           => '{$account[8]}'
                                                            , i_segment_10          => '{$account[9]}'
                                                            , i_segment_11          => '{$account[10]}'
                                                            , i_segment_12          => '{$account[11]}'
                                                            , o_combination_id      => :v_account_id
                                                            , o_combination_code    => :v_account_code
                                                            , o_return_status       => :v_return_status
                                                            , o_return_msg          => :v_return_msg
                                                        );
                end; ";

        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':v_account_id', $result['ccid'], \PDO::PARAM_INT);
        $stmt->bindParam(':v_account_code', $result['account_code'], \PDO::PARAM_STR, 250);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
