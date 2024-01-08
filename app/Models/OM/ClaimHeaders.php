<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OM\Customers;
use App\Models\OM\ClaimLines;
use App\Models\OM\UomV;
use App\Models\OM\Attachments;
use DB;

class ClaimHeaders extends Model
{
    use HasFactory;

    protected $table        = 'PTOM_CLAIM_HEADERS';
    protected $primaryKey   = 'claim_header_id';

    public function customers()
    {
        return $this->hasOne(Customers::class, 'customer_id', 'customer_id');
    }

    public function claimLines()
    {
        return $this->hasMany(ClaimLines::class, 'claim_header_id', 'claim_header_id');
    }

    public function scopeSearch($q)
    {
        if (request()->all()){
            if(request()->flag == '1'){
                if (request()->customerId) {
                    $q->where('customer_id', request()->customerId);
                }
            }
            if(request()->flag == '0'){
                if (request()->customerNumber) {
                    $q->where('customer_id', request()->customerNumber);
                }
            }
            if(!array_key_exists("flag", request()->all())){
                if (request()->customerNumber) {
                    $q->where('customer_id', request()->customerNumber);
                }
            }
            if (request()->claimNumber) {
                $q->where('claim_number', request()->claimNumber);
            }
            if (request()->claimDate) {
                $claimDate = date('d-m-Y', strtotime(parseFromDateTh(request()->claimDate)));
                $q->whereRaw("trunc(claim_date) >= TO_DATE('{$claimDate}','dd-mm-YYYY')");
            }
            if (request()->statusClaim) {
                $q->where('status_claim_code', request()->statusClaim);
            }
        }
        $header = $q->whereNotNull('claim_number')
                    ->where('sales_type','DOMESTIC')
                    ->with('customers','claimLines')
                    ->orderBy('claim_header_id', 'DESC')
                    ->get();
        
        $header->map(function ($q) {
            $q->invoice_date_converThDate = parseToDateTh($q->invoice_date); 
            $q->claim_date_converThDate = parseToDateTh($q->claim_date);
            $q->invoice_number_collect = collect(\DB::select("
                                                                select                        
                                                                        decode(consignment.consignment_status
                                                                            ,'Confirm',consignment.consignment_no
                                                                            ,NULL,orderHeader.pick_release_no
                                                                            ,NULL)                                              invoice_number
                                                                from    PTOM_ORDER_HEADERS                                      orderHeader,
                                                                        PTOM_CONSIGNMENT_HEADERS                                consignment
                                                                where          1 = 1
                                                                and            orderHeader.order_header_id                     = consignment.order_header_id(+)
                                                                and            upper(orderHeader.pick_release_status)          = upper('Confirm')
                                                                and            orderHeader.order_header_id = '{$q->invoice_id}'                                     "))->first();
            $q->attachment = Attachments::where('attachment_program_code', 'OMP0049')
                                        ->where('header_id', $q->claim_header_id)
                                        ->orderBy('line_id')
                                        ->orderBy('attribute1')
                                        ->get();
            if(!empty($q->claimLines)){
                foreach ($q->claimLines as $key => $value) {
                    if(isset($value['enter_claim_uom'])){
                        $q->uomEnterClaim = UomV::where('domestic', 'Y')
                                                ->where('uom_code', $value['enter_claim_uom'])
                                                ->get();
                    }
                }
            }
        });

        return $header;
    }
}
