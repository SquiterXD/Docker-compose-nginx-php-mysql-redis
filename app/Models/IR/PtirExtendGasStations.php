<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\IR\PtirExpenseCarGas;

class PtirExtendGasStations extends Model
{
    use HasFactory;
    protected $table = "ptir_extend_gas_stations";
    public $primaryKey = 'ex_gas_station_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gas_station_id',
        'document_number',
        'reference_document_number',
        'status',
        'year',
        'start_date',
        'end_date',
        'total_days',
        'department_code',
        'department_name',
        'group_code',
        'group_name',
        'type_code',
        'type_name',
        'insurance_amount',
        'discount',
        'duty_amount',
        'vat_amount',
        'net_amount',
        'vat_refund',
        'policy_number',
        'company_id',
        'company_name',
        'expense_account_id',
        'expense_account',
        'expense_account_desc',
        'prepaid_account_id',
        'prepaid_account',
        'prepaid_account_desc',
        'expense_flag',
        'policy_set_header_id',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'end_month_28_365',
        'end_month_29_366',
        'end_month_30_365',
        'end_month_30_366',
        'end_month_31_365',
        'end_month_31_366',
        'coverage_amount',
    ];

    public function getAllExtendGasStation($year, $typeCode, $groupCode, $status, $func)
    {
        $collection = DB::table('ptir_extend_gas_stations as a')->select(DB::raw("
            a.ex_gas_station_id,
            a.gas_station_id,
            a.document_number,
            a.reference_document_number,
            INITCAP(a.status) status,
            to_number(a.year)+543 as year,
            to_char(add_months(a.start_date, 6516), 'dd/mm/yyyy') start_date,
            to_char(add_months(a.end_date, 6516), 'dd/mm/yyyy') end_date,
            a.total_days,
            a.department_code,
            a.department_name,
            a.vat_amount,
            a.group_code,
            a.group_name,
            a.type_code,
            a.type_name,
            nvl(a.insurance_amount, 0) insurance_amount,
            nvl(a.discount, 0) discount,
            nvl(a.duty_amount, 0) duty_amount,
            nvl(b.revenue_stamp_percent, 0) revenue_stamp_percent,
            nvl(b.vat_percent, 0) vat_percent,
            nvl(a.net_amount, 0) net_amount,
            nvl(b.return_vat_flag, 'N') return_vat_flag,
            a.policy_number,
            a.company_id,
            a.company_name,
            e.company_number,
            a.expense_account_id,
            a.expense_account,
            a.expense_account_desc,
            nvl(a.expense_flag, 'N') expense_flag,
            a.policy_set_header_id,
            a.coverage_amount,
            a.insurance_date,
            nvl(a.ap_re_create_flag, 'N') re_create_flag
        "))
        ->leftjoin('ptir_gas_stations as b', 'a.gas_station_id', '=', 'b.gas_station_id')
        ->leftjoin('ptir_accounts_mapping_v as c', 'b.account_id', '=', 'c.account_id')
        ->leftjoin('ptir_policy_set_headers_v as d', 'b.policy_set_header_id', '=', 'd.policy_set_header_id')
        ->leftjoin('ptir_companies as e', 'a.company_id', '=', 'e.company_id')
        ->whereRaw(
            " a.year = nvl(to_number(?)-543, a.year)
            and b.type_code = nvl(?, b.type_code)
            and b.group_code = nvl(?, b.group_code)
            and a.status = nvl(?, a.status)",
            [
                $year, $typeCode, $groupCode,
                $status
            ]
        )
        ->when($func == 'fetch', function($q){
            $q->whereNull('a.document_number');
        })
        ->orderByRaw("a.document_number desc nulls last, a.reference_document_number asc nulls last")
        ->get();

        return $collection;
    }

    public function updateExtendGasStaion($data)
    {
        $db = PtirExtendGasStations::find($data['ex_gas_station_id']);
        $db->document_number       = $data['document_number'];
        $db->reference_document_number       = $data['reference_document_number'];
        $db->status                = $data['status'];
        $db->year                  = $data['year'];
        $db->gas_station_id        = $data['gas_station_id'];
        $db->type_code             = $data['type_code'];
        $db->type_name             = $data['type_name'];
        $db->document_number       = $data['document_number'];
        $db->start_date            = $data['start_date'];
        $db->end_date              = $data['end_date'];
        $db->total_days            = $data['total_days'];
        $db->department_code       = $data['department_code'];
        $db->department_name       = $data['department_name'];
        $db->insurance_amount      = $data['insurance_amount'];
        $db->discount              = $data['discount'];
        $db->duty_amount           = $data['duty_amount'];
        $db->vat_amount            = $data['vat_amount'];
        $db->net_amount            = $data['net_amount'];
        $db->policy_number         = $data['policy_number'];
        $db->company_id            = $data['company_id'];
        $db->company_name          = $data['company_name'];
        $db->expense_account_id    = $data['expense_account_id'];
        $db->expense_account       = $data['expense_account'];
        $db->expense_account_desc  = $data['expense_account_desc'];
        $db->expense_flag          = $data['expense_flag'];
        $db->policy_set_header_id  = $data['policy_set_header_id'];
        $db->updated_at            = $data['updated_at'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->last_update_date      = $data['last_update_date'];
        $db->end_month_28_365      = $data['end_month_28_365'];
        $db->end_month_29_366      = $data['end_month_29_366'];
        $db->end_month_30_365      = $data['end_month_30_365'];
        $db->end_month_30_366      = $data['end_month_30_366'];
        $db->end_month_31_365      = $data['end_month_31_365'];
        $db->end_month_31_366      = $data['end_month_31_366'];
        $db->save();
    }


    // on b.DOCUMENT_HEADER_ID = a.EX_GAS_STATION_ID
    public function cars()
    {
        return $this->hasMany(PtirExpenseCarGas::class, 'document_header_id', 'ex_gas_station_id');
    }

    public function scopeSearchReport($q, $param)
    {
        if ($param) {
            if ($param->year) {
                $q->where('year', $param->year);
            }

            if ($param->type_code) {
                $q->where('type_code', $param->type_code);
            }
        }
        return $q;
    }
}
