<?php

namespace App\Models\OM\ReprintInvoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class OrderHeaderModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_ORDER_HEADERS";

    public function scopeJoincreditnoteunlock($query,$request)
    {
        if(!empty($request['pick_release'])){
            return $query->select(  'ptom_order_headers.*',
                                    'ptom_customers.customer_name')
                            ->where(function($query) use ($request){
                                if(!empty($request['pick_release']) ){
                                    $query->where('ptom_order_headers.pick_release_no',$request['pick_release']);
                                }
                            });

        }elseif(!empty($request['invoice_number'])){
            return $query->select(  'ptom_order_headers.*',
                                'ptom_customers.customer_name',
                                'ptom_invoice_headers.invoice_headers_number','ptom_invoice_headers.invoice_status','ptom_invoice_headers.invoice_headers_id'
                                ,'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                    ->leftJoin('ptom_invoice_lines','ptom_invoice_lines.document_id','ptom_order_headers.order_header_id')
                    ->leftJoin('ptom_invoice_headers','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_id')
                    ->where(function($query) use ($request){
                        if(!empty($request['invoice_number'])){
                            $query->where('ptom_invoice_headers.invoice_headers_number',$request['invoice_number']);
                        }
                    });
        }
    }

    public function scopeJoincreditnote($query,$request)
    {
        if(!empty($request['pick_release'])){
            return $query->select(  'ptom_order_headers.*',
                                    'ptom_customers.customer_name')
                            ->where(function($query) use ($request){
                                if(!empty($request['pick_release']) ){
                                    $query->where('ptom_order_headers.pick_release_no',$request['pick_release']);
                                    if(!empty($request['print_status'])){
                                        if($request['print_status'] == 'Y'){
                                            $query->where('ptom_order_headers.unlock_print_flag','N');
                                        }elseif($request['print_status'] == 'N'){
                                            $query->where('ptom_order_headers.unlock_print_flag','Y');
                                        }
                                    }
                                }
                            });

        }elseif(!empty($request['invoice_number'])){
            return $query->select(  'ptom_order_headers.*',
                                'ptom_customers.customer_name',
                                'ptom_invoice_headers.invoice_headers_number','ptom_invoice_headers.invoice_status','ptom_invoice_headers.invoice_headers_id'
                                ,'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                    ->leftJoin('ptom_invoice_lines','ptom_invoice_lines.document_id','ptom_order_headers.order_header_id')
                    ->leftJoin('ptom_invoice_headers','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_id')
                    ->where(function($query) use ($request){
                        if(!empty($request['invoice_number'])){
                            $query->where('ptom_invoice_headers.invoice_headers_number',$request['invoice_number']);
                        }

                        if(!empty($request['print_status'])){
                            if($request['print_status'] == 'Y'){
                                $query->where('ptom_invoice_headers.attribute2','Y');

                            }elseif($request['print_status'] == 'N'){
                                $query->where('ptom_invoice_headers.attribute2','Y');

                            }
                        }
                    });
        }else{
            return $query->select(  'ptom_order_headers.*',
                                'ptom_customers.customer_name',
                                'ptom_invoice_headers.invoice_headers_number','ptom_invoice_headers.invoice_status','ptom_invoice_headers.invoice_headers_id'
                                ,'ptom_invoice_headers.attribute1','ptom_invoice_headers.attribute2','ptom_invoice_headers.invoice_amount')
                    ->leftJoin('ptom_invoice_lines','ptom_invoice_lines.document_id','ptom_order_headers.order_header_id')
                    ->leftJoin('ptom_invoice_headers','ptom_invoice_lines.invoice_headers_id','ptom_invoice_headers.invoice_headers_id')
                    ->where(function($query) use ($request){
                        if(!empty($request['print_status'])){
                            if($request['print_status'] == 'Y'){
                                $query->where('ptom_invoice_headers.attribute2','N');
                                $query->where('ptom_order_headers.unlock_print_flag','Y');

                            }elseif($request['print_status'] == 'N'){
                                $query->where('ptom_invoice_headers.attribute2','Y');
                                $query->where('ptom_order_headers.unlock_print_flag','N');

                            }
                        }
                    });
        }
    }

}
