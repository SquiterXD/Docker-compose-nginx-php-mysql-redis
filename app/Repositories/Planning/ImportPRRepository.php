<?php
namespace App\Repositories\Planning;

use App\Models\Planning\StampFollow\PRStampInterfaceTemp;
use App\Models\Planning\PtppPeriodsV;
use Carbon\Carbon;

class ImportPRRepository {

    public function importPRTemp($stamps, $batchNo, $needByDate, $stampFollowMain, $approver1, $approver2)
    {
        $userInterface = auth()->user()->fnd_user_id;
        $periodYear = self::getPeriodYear($stampFollowMain);
        try {
            foreach ($stamps as $index => $stamp) {
                PRStampInterfaceTemp::insert([
                    'org_code'                  => 'การยาสูบแห่งประเทศไทย'
                    , 'pr_number'               => ''
                    , 'pr_creation_date'        => date('d-M-Y')
                    , 'type_lookup_code'        => 'Purchase Requisition' // PURCHASE
                    , 'preparer_no'             => 'กองวางแผนและบริหารผลิตภัณฑ์ ฝ่ายวางแผนการผลิต,'
                    , 'description_header'      => 'ซื้อแสตมป์ยาสูบ'
                    , 'authorization_status'    => 'APPROVED' 
                    , 'head_context'            => 'วิธีเฉพาะเจาะจง'
                    , 'head_attribute1'         => Carbon::now()
                    , 'head_attribute2'         => 'ใช้ผลิตบุหรี่'
                    , 'head_attribute3'         => 'FC6ROJ02'
                    , 'head_attribute6'         => Carbon::now()
                    , 'head_attribute7'         => auth()->user()->username
                    , 'head_attribute8'         => $approver1
                    , 'head_attribute9'         => $approver2
                    , 'head_attribute10'        => ''
                    , 'head_attribute11'        => ''
                    , 'head_attribute14'        => ''
                    , 'head_attribute15'        => ''
                    , 'line_num'                => $index+1
                    , 'line_type'               => 'จัดจ้าง/สินค้า'
                    , 'category'                => '02-03.01'
                    , 'item_code'               => $stamp->stamp_code
                    , 'item_description'        => $stamp->stamp_description
                    , 'unit_meas_lookup_code'   => 'ดวง'
                    , 'quantity'                => $stamp->weekly_receive_qty
                    , 'quantity_delivered'      => 0
                    , 'remaining_quantity'      => $stamp->weekly_receive_qty
                    , 'unit_price'              => $stamp->item->unit_price
                    , 'need_by_date'            => $needByDate
                    , 'source_type_code'        => 'VENDOR'
                    , 'suggested_vendor_code'   => 'กรมสรรพสามิต กระทรวงการคลัง สำนักงานสรรพสามิตพื้นที่กรุงเทพมหานคร 3'
                    , 'suggested_vendor_location' => 'กรุงเทพมหานคร'
                    , 'destination_type_code'   => 'INVENTORY'
                    , 'requestor_no'            => 'กองวางแผนและบริหารผลิตภัณฑ์ ฝ่ายวางแผนการผลิต,'
                    , 'dest_organization'       => 'แสตมป์'
                    , 'location_ship_to'        => 'FC6ROJ02' //Location
                    , 'line_context'            => 'ไม่มีราคากลาง'
                    , 'line_amount'             => $stamp->weekly_receive_qty
                    , 'line_attribute1'         => ''
                    , 'line_attribute2'         => ''
                    , 'line_attribute3'         => ''
                    , 'line_attribute4'         => ''
                    , 'line_attribute5'         => ''
                    , 'line_attribute6'         => ''
                    , 'line_attribute9'         => ''
                    , 'line_attribute10'        => ''
                    , 'line_attribute14'        => ''
                    , 'line_attribute6'         => ''
                    , 'distribution_num'        => 1
                    , 'distribution_quantity'   => $stamp->weekly_receive_qty
                    , 'charge_account_code'     => '01.0.00000000.00.00.000.000000.0.117000.001.0.0'
                    , 'gl_date'                 => $needByDate
                    , 'budget_account_code'     => '01.0.00000000.00.'.$periodYear.'.411.000000.0.117000.999.0.0'
                    , 'accrual_account_code'    => '01.0.00000000.00.00.000.000000.0.212900.417.0.0'
                    , 'variance_account_code'   => '01.0.00000000.00.00.000.000000.0.115190.001.0.0'
                    , 'batch_no'                => $batchNo
                    , 'creation_date'           => Carbon::now()
                    , 'created_by'              => $userInterface
                    , 'last_update_date'        => Carbon::now()
                    , 'last_updated_by'         => $userInterface
                    , 'follow_stamp_main_id'    => $stamp->follow_stamp_main_id
                ]);
            }
            \DB::commit();
        } catch (Exception $e) {
            \Log::error($e);
        }
        return 'Success';
    }

    private function getPeriodYear($stampFollowMain)
    {
        $period = PtppPeriodsV::selectRaw('period_name, period_year+543 period_year')
                            ->where('period_name', $stampFollowMain->period_name)
                            ->first();
        $convertToDate = '01-01-'.$period->period_year;
        $date = date('d-m-Y', strtotime($convertToDate));
        $periodYear = date('y', strtotime($date));

        return $periodYear;
    }


}