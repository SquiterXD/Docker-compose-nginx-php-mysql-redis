<?php

namespace App\Jobs;

use App\Imports\OM\Saleorder\Domestic\TransferMonthlyImport;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\Customers\Export\ForeignCustomerModel;
use App\Models\OM\Saleorder\Domestic\CustomerQuotaHeaderModel;
use App\Models\OM\Saleorder\Domestic\CustomerQuotaLineModel;
use App\Models\OM\Saleorder\Domestic\ProductItemModel;
use App\Models\OM\Saleorder\Domestic\TransferMonthlyModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class UploadFileQuata implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $result;
    protected $filename;
    protected $month;
    protected $year;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($result, $filename, $month, $year, $data)
    {
        $this->result = $result;
        $this->data = $data;
        $this->filename = $filename;
        $this->month = $month;
        $this->year = $year;
    }
    public function failed() {
        Cache::add('uploadFileQuata', 'Execl Upload Error', now()->addDay(2));
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        Log::info('Processing Excel');
        try {

            $filename = $this->file->getClientOriginalName();
            $excel = new TransferMonthlyImport;
            
            Cache::add('uploadFileQuata', 'Processing Execl Upload ........', now()->addDay(2));
            $result = $this->result->data;

            //get file name
            $filename = $this->filename;

            if (!$result) {
                throw new \Exception('Header');
            }

            //get data customer
            $customer = ForeignCustomerModel::whereIn('customer_number', $result['shop'])->get();
            if ($customer->count() == 0) {
                throw new \Exception('shop');
            }

            //set array prepare to non sql 
            foreach ($customer as $key => $customer_item) {
                $date = nextDaysOfWeekNotPlus(compareDaysTH($customer_item->delivery_date));
                $customer_list[$customer_item->customer_number] = [
                    'customer_id'   => $customer_item->customer_id,
                    'customer_name' => $customer_item->customer_name,
                    'delivery_date' => $customer_item->delivery_date,
                    'date'          => date('N', strtotime($date)),
                    'status'        => $customer_item->status
                ];
            }

            $noData = [];
            $listNoData = '';
            foreach ($result['shop'] as $item) {
                if (!empty($customer_list[$item])) {
                    if ($customer_list[$item]['status'] == 'Inactive') {
                        $noData[] = 'false';
                        $listNoData .= ',' . $item . ' Error Message : รหัสร้านค้ามีสถานะเป็น Inactive แล้ว ข้อมูลจะไม่ถูกอัพโหลดเข้าไป';
                    } else {
                        $noData[] = 'true';
                    }
                } else {
                    $noData[] = 'false';
                    $listNoData .= ',' . $item . ' Error Message : รหัสร้านค้าไม่ถูกต้องหรือไม่มีในระบบ โปรดตรวจสอบรหัสร้านค้า';
                }
            }

            if (in_array('false', $noData)) {
                throw new \Exception('NoCustomer_' . $listNoData);
            }


            //get product item
            $product = ProductItemModel::whereIn('item_code', $result['code_item'])->get();
            if ($product->count() == 0) {
                throw new \Exception('product');
            }

            //set array prepare to non sql 
            foreach ($product  as $product_item) {
                $product_list[$product_item->item_code] = [
                    'id' => $product_item->inventory_item_id,
                    'description' => $product_item->item_description
                ];
            }

            $noData_prod = [];
            $listNoData_prod = '';
            foreach ($result['code_item'] as $item) {
                if (!empty($product_list[$item])) {
                    $noData_prod[] = 'true';
                } else {
                    $noData_prod[] = 'false';
                    $listNoData_prod .= ',' . $item . ' Error Message : รหัสสินค้าไม่ถูกต้องหรือไม่มีในระบบ โปรดตรวจสอบรหัสสินค้า';
                }
            }

            if (in_array('false', $noData_prod)) {
                throw new \Exception('NoProduct_' . $listNoData_prod);
            }

            //get month number
            $month_number = monthToNumber($this->month);

            //get year thai to global
            $year = $this->year;
            $year -= 543;

            //set first date / end date of month 
            $date_start = $year . '-' . $month_number . '-01';
            $date_end   = $year . '-' . $month_number . '-' . date('t', strtotime($date_start));

            //-- set period for use insert update
            $period = PeriodModel::where('budget_year', $year)
                ->where('start_buget_year', '<=', $year . '-01-01')
                ->where(function ($query) use ($month_number) {
                    $query->whereMonth('start_period', '=', $month_number);
                    $query->orwhereMonth('end_period', '=', $month_number);
                })
                ->where(function ($query) use ($month_number) {
                    $query->whereMonth('end_period', '>=', $month_number);
                    $query->orwhereMonth('end_period', '>=', $month_number);
                })
                ->orderBy('period_line_id')
                ->get();

            if ($period->count() == 0) {
                throw new \Exception('period');
            }

            //set array prepare to non sql and find startdate end date of mounth
            $period_list = [];

            foreach ($period as $period_item) {
                $datestart  = new \DateTime($period_item->start_period);
                $dateend    = new \DateTime($period_item->end_period);
                $period_list[] = [
                    'period_no'         => $period_item->period_no,
                    'period_line_id'    => $period_item->period_line_id,
                    'start_date'        => $period_item->start_period,
                    'end_date'          => $period_item->end_period,
                    'start_date_m'      => $datestart->format('m'),
                    'end_date_m'        => $dateend->format('m'),
                    'mount'             => $month_number,
                    'realdate_start'    => $datestart->format('m') < $month_number ? date('Y') . '-' . $month_number . '-01' : '0',
                    'realdate_end'      => $dateend->format('m') > $month_number ? date('Y-m-t', strtotime($period_item->start_period)) : '0',
                    'start_deli'        => $datestart->format('m') < $month_number ? date('N', strtotime(date('Y') . '-' . $month_number . '-01')) : '0',
                    'end_deli'          => $dateend->format('m') > $month_number ? date('N', strtotime(date('Y-m-t', strtotime($period_item->start_period)))) : '0',
                ];
            }

            $data = $this->data;

            //-- get last version upload excel
            $last_version = TransferMonthlyModel::where('budget_year', $year)->where('month_name', $this->month)->max('version');
            $new_version = !empty($last_version) ? $last_version + 1 : 1;
            //--
            $quota_header = [];
            foreach (collect($result['shop_data'])->take(1) as $key_data => $item_data) {
                //--- sector to customer_quota_header
                foreach ($period_list as $key_period_header => $period_quota_header_item) {

                    //get data for check update or insert
                    $datecheck = [
                        'start_at'  => empty($period_quota_header_item['realdate_start']) ? $period_quota_header_item['start_date'] : $period_quota_header_item['realdate_start'],
                        'end_at'    => empty($period_quota_header_item['realdate_end']) ? $period_quota_header_item['end_date'] : $period_quota_header_item['realdate_end']
                    ];

                    $quota = CustomerQuotaHeaderModel::where('customer_id', $customer_list[$key_data]['customer_id'])
                        ->where('start_date', '>=', $datecheck['start_at'])
                        ->where('start_date', '<=', $datecheck['end_at'])
                        ->whereNull('deleted_at')
                        ->first();

                    //update data
                    if ($quota) {
                        $product_line = DB::table('ptom_order_lines')
                            ->join('ptom_customer_quota_lines', 'ptom_order_lines.quota_line_id', '=', 'ptom_customer_quota_lines.quota_line_id')
                            ->where('quota_header_id', $quota->quota_header_id)
                            ->get();

                        if ($product_line->count() > 0) {
                            throw new \Exception('quota_' . $customer_list[$key_data]['customer_id'] . '_' . $quota->start_date);
                        }

                        $quota_header[$key_period_header]        = $quota->quota_header_id;

                        $quota->start_date          = empty($period_quota_header_item['realdate_start']) ? $period_quota_header_item['start_date'] : $period_quota_header_item['realdate_start'];
                        $quota->end_date            = empty($period_quota_header_item['realdate_end']) ? $period_quota_header_item['end_date'] : $period_quota_header_item['realdate_end'];
                        // $quota->start_date          = $period_quota_header_item['start_date'];
                        // $quota->end_date            =  $period_quota_header_item['end_date'];
                        $quota->status              = 'Active';
                        $quota->last_updated_by     = optional(auth()->user())->user_id;
                        $quota->last_update_date    = date('Y-m-d H:i:s');
                        $quota->save();

                        //insert data
                    } else {
                        //get max number
                        $max_number = CustomerQuotaHeaderModel::where('customer_id', $customer_list[$key_data]['customer_id'])->whereNull('deleted_at')->max('quota_number');
                        $max_number = !empty($max_number) ? $max_number + 1 : 1;

                        $quota                      = new CustomerQuotaHeaderModel();
                        $quota->customer_id         = $customer_list[$key_data]['customer_id'];
                        $quota->quota_number        = $max_number;
                        $quota->start_date          = empty($period_quota_header_item['realdate_start']) ? $period_quota_header_item['start_date'] : $period_quota_header_item['realdate_start'];
                        $quota->end_date            = empty($period_quota_header_item['realdate_end']) ? $period_quota_header_item['end_date'] : $period_quota_header_item['realdate_end'];
                        // $quota->start_date          = $period_quota_header_item['start_date'];
                        // $quota->end_date            =  $period_quota_header_item['end_date'];
                        $quota->status              = 'Active';
                        $quota->program_code        = 'OMP0061';
                        $quota->created_by          = optional(auth()->user())->user_id;
                        $quota->creation_date       = date('Y-m-d H:i:s');
                        $quota->last_updated_by     = optional(auth()->user())->user_id;
                        $quota->last_update_date    = date('Y-m-d H:i:s');
                        $quota->save();

                        //get id header to array preprea for loop insert line
                        $quota_header[$key_period_header]        = $quota->quota_header_id;
                    }
                    // }
                }
                //--
                $org = DB::table('ptom_operating_units_v')->where('short_code', 'TOAT')->first();
                if ($org) {
                    $org_id = $org->organization_id;
                } else {
                    $org_id = 121;
                }

                if (empty($customer_list[$key_data])) {
                    throw new \Exception('shopData ' . $key_data);
                }

                foreach ($result['shop_data'][$key_data] as $item_update) {
                    if (empty($product_list[$item_update['product_code']])) {
                        throw new \Exception('productData ' . $item_update['product_code']);
                    }

                    //insert data to PTOM_TRANSFER_QUOTA
                    foreach ($period_list as $key_period => $period_item_list) {

                        if (!empty($quota_header[$key_period])) {
                            $insert = [
                                'org_id'            => $org_id,
                                'budget_year'       => $year,
                                'version'           => $new_version,
                                'file_name'         => $filename,
                                'path_name'         => $data->log_directory,
                                'month_name'        => $this->month,
                                'customer_name'     => $customer_list[$key_data]['customer_name'],
                                'customer_id'       => $customer_list[$key_data]['customer_id'],
                                'customer_no'       => $key_data,
                                'item_code'         => $item_update['product_code'],
                                'item_id'           => $product_list[$item_update['product_code']]['id'],
                                'item_description'  => $product_list[$item_update['product_code']]['description'],
                                'period_line_id'    => $period_item_list['period_line_id'],
                                'period_no'         => $period_item_list['period_no'],
                                'quantity'          => $item_update['total'],
                                'approve_flag'      => '-',
                                'program_code'      => 'OMP0061',
                                'created_by'        => optional(auth()->user())->user_id,
                                'creation_date'     => date('Y-m-d H:i:s'),
                                'last_updated_by'   => optional(auth()->user())->user_id,
                                'last_update_date'  => date('Y-m-d H:i:s'),
                            ];

                            TransferMonthlyModel::insert($insert);


                            //check data to update or insert to line
                            $quota_line = CustomerQuotaLineModel::where('quota_header_id', $quota_header[$key_period])
                                ->where('item_code', $item_update['product_code'])
                                ->first();

                            if (!empty($quota_line)) {
                                $quota_line->received_quota     = $item_update['total'];
                                $quota_line->minimum_quota      = 1;
                                $quota_line->remaining_quota    = $item_update['total'];
                                $quota_line->last_updated_by    = optional(auth()->user())->user_id;
                                $quota_line->last_update_date   = date('Y-m-d H:i:s');
                                $quota_line->save();
                            } else {
                                $quota_line                     = new CustomerQuotaLineModel();
                                $quota_line->quota_header_id    = $quota_header[$key_period];
                                $quota_line->item_id            = $product_list[$item_update['product_code']]['id'];
                                $quota_line->item_code          = $item_update['product_code'];
                                $quota_line->item_description   = $product_list[$item_update['product_code']]['description'];
                                $quota_line->received_quota     = $item_update['total'];
                                $quota_line->minimum_quota      = 1;
                                $quota_line->remaining_quota    = $item_update['total'];
                                $quota_line->program_code       = 'OMP0061';
                                $quota_line->created_by         = optional(auth()->user())->user_id;
                                $quota_line->creation_date      = date('Y-m-d H:i:s');
                                $quota_line->last_updated_by    = optional(auth()->user())->user_id;
                                $quota_line->last_update_date   = date('Y-m-d H:i:s');
                                $quota_line->save();
                            }
                        }
                    }
                }
            }


            DB::commit();
            $rest = [
                'status'    => true,
                'message'   => 'success'
            ];
            Cache::add('uploadFileQuata', 'Processing Execl Failed', now()->addDay(2));

            // return response()->json(['data' => $rest]);
        } catch (\Exception $em) {
            DB::rollBack();
            $message = $em->getMessage();
            Cache::add('uploadFileQuata', 'Execl Upload Error', now()->addDay(2));

            $file = $this->filename;
            $file_expol = \explode('.', $file);

            $file_name = date('YmdHis') . '-' . $file_expol[0] . '.txt';

            if (strpos($message, 'Undefined offset:') !== false) {
                $log_content = 'โปรดตรวจสอบไฟล์ Excel ตามรูปแบบให้ถูกต้อง Line:' . $em->getLine();
            } elseif (strpos($message, 'productData') !== false) {
                $data_epl = \explode(' ', $message);
                $log_content = 'ไม่พบรหัสสินค้านี้ในระบบ :' . $data_epl[1] . ' กรุณาตรวจสอบรหัสสินค้าอีกครั้ง';
            } elseif (strpos($message, 'Header') !== false) {
                $log_content = 'โปรดตรวจสอบไฟล์ Excel ชื่อสินค้า, รหัสสินค้า ตามรูปแบบให้ถูกต้อง';
            } elseif ($message == 'shop') {
                $log_content = 'ไม่พบร้านค้าในระบบ';
            } elseif (strpos($message, 'shopData') !== false) {
                $data_epl = \explode(' ', $message);
                $log_content = 'ไม่พบร้านค้านี้ในระบบ :' . $data_epl[1] . ' กรุณาตรวจสอบรหัสร้านค้าอีกครั้ง';
            } elseif ($message == 'product') {
                $log_content = 'ไม่พบสินค้าในระบบ';
            } elseif ($message == 'period') {
                $log_content = 'ไม่พบงวดในระบบ';
            } elseif (strpos($message, 'quota') !== false) {
                $data_epl = \explode(' ', $message);
                $month = date("m", strtotime($data_epl[2]));
                $log_content = 'เพดานการจำหน่าย เดือน' . monthFormatThaiString($month) . ' ร้านค้า ' . $data_epl[1] . ' ถูกใช้งานแล้ว ไม่สามารถเพิ่มข้อมูลได้';
            } elseif (strpos($message, 'NoCustomer') !== false) {
                $data_epl = \explode('_', $message);
                $list = explode(',', $data_epl[1]);
                $log_content = '';
                foreach ($list as $key => $item) {
                    if ($key > 0) {
                        $log_content .= 'รายการ ' . $item;
                        $log_content .= ' ';
                    }
                }
            } elseif (strpos($message, 'NoProduct') !== false) {
                $data_epl = \explode('_', $message);
                $list = explode(',', $data_epl[1]);
                $log_content = '';
                foreach ($list as $key => $item) {
                    if ($key > 0) {
                        $log_content .= 'รายการ ' . $item;
                        $log_content .= ' ';
                    }
                }
            } else {
                $log_content = $em->getMessage() . ' Line:' . $em->getLine();
            }
            abort(500);
        }
    }
}
