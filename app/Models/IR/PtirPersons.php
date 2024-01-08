<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirPersons extends Model
{
    use HasFactory;
    protected $table = "ptir_persons";
    public $primaryKey = 'person_id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number',
        'status',
        'year',
        'invoice_type',
        'invoice_number',
        'voucher_number',
        'policy_number',
        'start_date',
        'end_date',
        'total_days',
        'person_name',
        'policy_type_code',
        'policy_type_name',
        'insurance_amount',
        'discount_amount',
        'duty_amount',
        'vat_amount',
        'net_amount',
        'company_id',
        'company_name',
        'expense_account_id',
        'expense_account',
        'expense_account_desc',
        'expense_flag',
        'policy_set_header_id',
        'premium_rate',
        'revenue_stamp',
        'prepaid_insurance',
        'tax',
        'payment_status',
        'payment_date',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ]; 

    public function getAllPerson($year, $typeCode, $invoiceNumber, $status)
    {
        $invoiceNumber = ($invoiceNumber == '') ? '-' : $invoiceNumber;
        $collection = DB::table('ptir_persons as a')->select(DB::raw("a.person_id, 
                                                   nvl(INITCAP(a.status), 'NEW') status, 
                                                   a.document_number, 
                                                   to_number(a.year)+543 as year, 
                                                   a.invoice_type, 
                                                   a.invoice_number, 
                                                   a.voucher_number, 
                                                   a.policy_number,
                                                   to_char(add_months(a.start_date, 6516), 'dd/mm/yyyy') start_date,
                                                   to_char(add_months(a.end_date, 6516), 'dd/mm/yyyy') end_date,
                                                   a.total_days, 
                                                   a.person_name, 
                                                   a.policy_type_code, 
                                                   a.policy_type_name, 
                                                   nvl(a.insurance_amount, 0) insurance_amount,
                                                   nvl(a.discount_amount, 0) as discount, 
                                                   nvl(a.duty_amount, 0) duty_amount, 
                                                   0.04 as revenue_stamp_percent, 
                                                   nvl(a.vat_amount, 0) vat_amount,
                                                   7 as vat_percent, 
                                                   a.net_amount, 
                                                   a.company_id, 
                                                   b.company_number, 
                                                   a.company_name, 
                                                   a.expense_account_id, 
                                                   a.expense_account, 
                                                   a.expense_account_desc,
                                                   (case when a.payment_status = 'Y' then
                                                            'Yes'
                                                        else 
                                                            'No'
                                                    end) payment_status, 
                                                   a.policy_set_header_id, 
                                                   a.reference_document_number, 
                                                   nvl(a.expense_flag, 'N') expense_flag, 
                                                   b.tag, 
                                                   d.revenue_stamp, 
                                                   to_char(a.payment_date, 'dd-Mon-yy') payment_date,
                                                   e.group_desc group_name"))
                                    ->leftjoin('ptir_companies as b', 'a.company_id', '=', 'b.company_id')
                                    ->leftJoin('ptir_governer_policy_types as b', 'a.policy_type_code' , '=', 'b.lookup_code')
                                    ->leftJoin('ptir_policy_group_sets as c', 'a.policy_set_header_id' , '=', 'c.policy_set_header_id')
                                    ->leftJoin('ptir_policy_group_lines as d', 'c.group_header_id' , '=', 'd.group_header_id')
                                    ->leftJoin('oair.ptir_policy_set_headers_v as e', 'e.policy_set_header_id', '=', 'a.policy_set_header_id')
                                    ->whereRaw("a.year = nvl(to_number(?)-543, a.year)
                                               and a.policy_type_code = nvl(?, a.policy_type_code) 
                                               and ? = (case when ? = '-' then
                                                             ?
                                                        else 
                                                            a.invoice_number
                                                        end)
                                               and d.year = a.year
                                               and a.status = nvl(?, a.status)", [$year, $typeCode, $invoiceNumber, $invoiceNumber, $invoiceNumber, $status])
                                    ->orderByRaw("a.document_number desc nulls last")
                                    ->get();

        return $collection;                           
    }

    public function updatePersons($data)
    {
        $db = PtirPersons::find($data['person_id']);
        $db->document_number       = $data['document_number'];
        $db->status                = $data['status'];
        $db->year                  = $data['year'];
        $db->invoice_type          = $data['invoice_type'];
        $db->invoice_number        = $data['invoice_number'];
        $db->voucher_number        = $data['voucher_number'];
        $db->policy_number         = $data['policy_number'];
        $db->start_date            = $data['start_date'];
        $db->end_date              = $data['end_date'];
        $db->total_days            = $data['total_days'];
        $db->person_name           = $data['person_name'];
        $db->policy_type_code      = $data['policy_type_code'];
        $db->policy_type_name      = $data['policy_type_name'];
        $db->insurance_amount      = $data['insurance_amount'];
        $db->discount_amount       = $data['discount_amount'];
        $db->duty_amount           = $data['duty_amount'];
        $db->vat_amount            = $data['vat_amount'];
        $db->net_amount            = $data['net_amount'];
        $db->company_id            = $data['company_id'];
        $db->company_name          = $data['company_name'];
        $db->policy_number         = $data['policy_number'];
        $db->expense_account_id    = $data['expense_account_id'];
        $db->expense_account       = $data['expense_account'];
        $db->expense_account_desc  = $data['expense_account_desc'];
        $db->expense_flag          = $data['expense_flag'];
        $db->policy_set_header_id  = $data['policy_set_header_id'];
        $db->payment_status        = $data['payment_status'];
        $db->payment_date          = $data['payment_date'];
        $db->updated_at            = $data['updated_at'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->last_update_date      = $data['last_update_date'];
        $db->save();
    }

    public function getAllInvoiceNumberLov()
    {
        $collection = PtirPersons::select('invoice_number')
                                    ->orderBy('invoice_number', 'asc')
                                    ->get();

        return $collection;
    }
}
