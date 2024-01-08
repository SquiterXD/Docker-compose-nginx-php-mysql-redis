<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\PeriodV;
use App\Models\OM\PostponeOrders;
use App\Models\OM\PnHolidayModel;
use App\Repositories\OM\OrderRepo;
use Illuminate\Support\Facades\DB;

class AutoController extends Controller
{
    public function postponeDelivery()
    {
        $holiday = PnHolidayModel::where('hol_date','>=',date('Y-m-d'))->get();

        $daysTH = ['ทุกวัน','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์'];

        foreach ($holiday as $key => $v) {

            $dayofweek = date('w', strtotime($v->hol_date));

            $customers = Customer::whereNotNull('customer_number')->whereRaw("lower(sales_classification_code) = 'domestic'")->where('delivery_date',$daysTH[$dayofweek])->whereRaw("lower(status) = 'active'")->get();
            if(!is_null($customers)){

                try {
                    $status = 0;

                    $from_date = $v->hol_date;
                    $date = $v->hol_date;
                    $period = OrderRepo::getPeriodFrom($from_date);

                    if (!is_null($period)) {
                        $from_period_id = $period->period_line_id;
                        $to_period_id = $period->period_line_id;

                        foreach ($customers as $key_cus => $cus) {
                            do {
                                $checkHoliday = PnHolidayModel::where('hol_date',$date)->first();
                                if(!is_null($checkHoliday) || ($dayofweek == 6 || $dayofweek == 0)){
                                    $date = date('Y-m-d',strtotime($date . "+1 days"));
                                    $dayofweek = date('w', strtotime($date));
                                }else{
                                    $status = 1;
                                }
                            } while ($status == 0);

                            $postpone = PostponeOrders::where('customer_id',$cus->customer_id)->where('from_period_id',$from_period_id)->where('to_period_id',$to_period_id)->first();
                            if(is_null($postpone)){
                                $postpone = new PostponeOrders();
                            }

                            $postpone->order_quantity = '0';
                            $postpone->uom = '';
                            $postpone->reason = '';
                            $postpone->org_id = 81;
                            $postpone->org_name = '';
                            $postpone->customer_id = $cus->customer_id;
                            $postpone->from_period_id = $from_period_id;
                            $postpone->to_period_id = $to_period_id;
                            $postpone->from_period_date = $from_date;
                            $postpone->to_period_date = $date;
                            $postpone->approve_status = 'อนุมัติ';
                            $postpone->created_by = 1;
                            $postpone->last_updated_by = 1;
                            $postpone->program_code = 'OMP0009';
                            $postpone->save();

                        }
                    }

                } catch (\Exception $e) {
                    dd($e->getMessage());
                }

            }

        }

    }

}
