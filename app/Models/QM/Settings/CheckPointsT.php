<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\QM\Settings\PtqmCheckPointsV;
use DB;
use PDO;

class CheckPointsT extends Model
{
    use HasFactory;

    protected $table = 'ptqm_check_points_t';
    public $primaryKey = 'check_point_id';
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'organization_id',
        'subinventory_code',
        'warehouse_code',
        'location_code',
        'group_code',
        'disable_flag',
        'image_file_name',
        'attachment_id',
        'record_type',
        'attribute_category',
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'build_name',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'qm_test_type',
        'location_desc',
        'locator_desc'
    ];

    public function checkPointsV(){
        return $this->hasOne(CheckPointsV::class, 'locator_code','locator_code');
    }

    public function checkPoint($param){
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                        v_status        VARCHAR2(20);
                        v_err_msg       VARCHAR2(2000);
                    BEGIN
                        ptqm_main.process_check_point(  p_user_name => 'MERCURY',
                                                        p_response => 'Inventory',
                                                        p_app_short_name =>'INV',
                                                        p_web_batch_no => '{$param->web_batch_no}',
                                                        p_status => :v_status,
                                                        p_err_msg => :v_err_msg);
                        dbms_output.put_line('Status:'||v_status);
                        dbms_output.put_line('Error:'||v_err_msg);
                    END;
        ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
        $stmt->execute();

        \Log::info('status', $result);

        return $result;
    }

}
