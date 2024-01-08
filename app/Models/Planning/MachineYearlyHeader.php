<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineYearlyHeader extends Model
{
    use HasFactory;
    protected $table = "ptpp_machine_yearly_headers";
    public $primaryKey = 'res_plan_h_id';
    protected $appends = [
        'created_at_format',
        'updated_at_format'
    ];

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by_id');
    }

    public function getCreatedAtFormatAttribute()
    {
        return parseToDateTh($this->created_at);
    }

    public function getUpdatedAtFormatAttribute()
    {
        return parseToDateTh($this->updated_at);
    }

    public function scopeSearch($q, $param)
    {
        if ($param) {
            if ($param['budget_year']) {
                $q->where('budget_year', $param['budget_year']);
            }else{
                $q;
            }

            if (array_key_exists('product_type', $param)) {
                if ( $param['product_type'] != null || $param['product_type'] != '') {
                    $q->where('product_type', $param['product_type']);
                }
                $q;
            }else{
                $q;
            }
        }

        return $q;
    }

    // วันหยุดเสาร์ อาทิตย์
    public static function getHoliday($date)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_flag   varchar2(1000) := null;
                begin
                    :v_flag  := ptpp_utilities_pkg.get_holiday_flag('{$date}');
                end;
            ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $stmt->bindParam(':v_flag', $result['v_flag'], \PDO::PARAM_STR, 1000);
        $stmt->execute();

        return $result;
    }

    // Display plan date
    public static function convertFormatDate($date)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    v_display_plan_date  varchar2(1000) := null;
                begin
                    :v_display_plan_date := pt_utilities_pkg.convert_sht_mon_to_thai_char('{$date}');
                end;
            ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);

        $stmt->bindParam(':v_display_plan_date', $result['v_display_plan_date'], \PDO::PARAM_STR, 1000);
        $stmt->execute();

        return $result;
    }
}
