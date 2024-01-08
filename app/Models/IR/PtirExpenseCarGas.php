<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IR\PtirExtendGasStations;

class PtirExpenseCarGas extends Model
{
    use HasFactory;
    protected $table = "ptir_expense_car_gas";
    public $primaryKey = 'expense_id';
    public $timestamps = false;

    public function station()
    {
        return $this->belongsTo(PtirExtendGasStations::class, 'document_header_id', 'ex_gas_station_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        // 'document_number',
        'document_header_id',
        'document_line_id',
        'expense_type_code',
        'policy_set_header_id',
        'policy_set_description',
        'department_code',
        'department_name',
        'renew_type_code',
        'renew_type',
        'license_plate',
        'gas_station_type_code',
        'gas_station_type_name',
        'net_amount',
        'start_date',
        'end_date',
        'total_days',
        'expense_account_id',
        'expense_account',
        'expense_account_desc',
        'prepaid_account_id',
        'prepaid_account',
        'prepaid_account_desc',
        'expense_flag',
        'sold_flag',
        'reference_header_id',
        'reference_line_id',
        'reference_document_number',
        'period_name',
        'group_code',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ];

    public static function duplicateCheck($id, $type)
    {
        $collection = PtirExpenseCarGas::where('document_header_id', $id)
            ->where('expense_type_code', $type)
            ->first();

        if ($collection == null) {
            return true;
        }

        return false;
    }

    public function scopeSearch($q, $param, $period_name)
    {
        if ($param) {
            if ($param->period_name) {
                $q->where('period_name', $period_name);
            }

            if ($param->insurance_type) {
                $q->where('expense_type_code', $param->insurance_type);
            }

            if ($param->expense_type) {
                // $q->where('prepaid_account_id', $param->expense_type);
                $q->where('group_code', $param->expense_type);
            }
        }
        return $q;
    }

    public function typeCarGas()
    {
        return $this->hasOne('App\Models\IR\Views\PtirExpTypeCarGasView', 'lookup_code', 'expense_type_code');
    }

    public function group()
    {
        return $this->hasOne('App\Models\IR\Views\PtirGroupsView', 'lookup_code', 'group_code');
    }

    public function getExpenseTypeDescAttribute()
    {
        return optional($this->typeCarGas)->description;
    }

    public function getGroupNameAttribute()
    {
        return optional($this->group)->meaning;
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Models\IR\Views\PtirVehiclesView', 'license_plate', 'license_plate');
    }
}
