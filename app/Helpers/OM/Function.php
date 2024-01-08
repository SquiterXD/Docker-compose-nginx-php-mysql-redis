<?php

use App\Models\OM\Api\AdditionQuotaHeader;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\ConsignmentLines;
use App\Models\OM\DomesticMatching\PaymentMatchInvoice;
use App\Models\OM\PaymentHeader;
use App\Models\OM\PaymentMatchInvoice as OMPaymentMatchInvoice;
use App\Models\OM\PTOM_AUTHORITY_LISTS;
use App\Models\OM\SaleConfirmation\OrderLines;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonInterval;
use Carbon\Carbon;
use App\Models\OM\TranspotReportModel;
use App\Models\User;
use App\Models\OM\InvoiceRunningNumber;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\PaymentLines;
use App\Models\OM\ProductType;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\PtomInvoiceLine;
use App\Models\OM\PtomOrderHeader;
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\Ptom\PtomOrderHeader as PtomPtomOrderHeader;
use App\Models\Lookup\QuotaGroup;
use App\Models\OM\ProformaInvoiceLines;
use App\Models\OM\Settings\QuotaCreditGroup;
use App\Models\OM\UomConversionsV;

const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
const BAHT_TEXT_TWENTY = 'ยี่';
const BAHT_TEXT_INTEGER = 'ถ้วน';
const BAHT_TEXT_BAHT = 'บาท';
const BAHT_TEXT_SATANG = 'สตางค์';
const BAHT_TEXT_POINT = 'จุด';

function dayTHcompare($value, $orderday)
{
    $daysTH = ['ทุกวัน', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'];

    $search = array_search($value, $daysTH);

    if (!$search) {
        $daysTH = ['ทุกวัน', 'วันจันทร์', 'วันอังคาร', 'วันพุธ', 'วันพฤหัสบดี', 'วันศุกร์', 'วันเสาร์', 'วันอาทิตย์'];
        $search = array_search($value, $daysTH);
    }
    if ($search == 0) {
        return Carbon::parse($orderday)->timezone('Asia/Bangkok')->addDay()->format('Y-m-d');
    } else {
        $days = ['All', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $v = $days[$search];
        $info = Carbon::parse($orderday)->timezone('Asia/Bangkok')->next($v)->format('Y-m-d');
        return $info;
    }
}

function dayEngtoThaiName($name)
{
    $day = [
        'All'         => 'ทุกวัน',
        'Monday'      => 'จันทร์',
        'Tuesday'     => 'อังคาร',
        'Wednesday'   => 'พุธ',
        'Thursday'    => 'พฤหัสบดี',
        'Friday'      => 'ศุกร์',
        'Saturday'    => 'เสาร์',
        'Sunday'      => 'อาทิตย์',
    ];

    return $day[$name];
}

function pr($data)
{
    echo '<pre>';
    echo print_r($data);
    echo '</pre>';
}

function runOrderNumber($number)
{
    $last_number = explode('POC', $number);
    $number = substr($last_number[1], 2);

    if (is_numeric($number)) {
        $newnumber = sprintf('%06d', $number + 1);
    } else {
        $newnumber = sprintf('%06d', 1);
    }
    return 'POC' . (date('y') + 43) . $newnumber;
}

function draftGroupIDTaxAdjust()
{
    // $id = DB::table('ptom_tax_adjustments')->select('group_id')->whereNotNull('group_id')->orderByDesc('interface_id')->first();
    // if (empty($id)) {
    //     $newnumber = sprintf('%06d', 1);
    // } else {
    //     $newnumber = sprintf('%06d', $id->group_id + 1);
    // }

    return Carbon::now()->format('YmdHis');
}

function monthToNumber($month)
{
    $data = '0';
    if ($month == 'มกราคม') {
        $data = '01';
    } elseif ($month == 'กุมภาพันธ์') {
        $data = '02';
    } elseif ($month == 'มีนาคม') {
        $data = '03';
    } elseif ($month == 'เมษายน') {
        $data = '04';
    } elseif ($month == 'พฤษภาคม') {
        $data = '05';
    } elseif ($month == 'มิถุนายน') {
        $data = '06';
    } elseif ($month == 'กรกฎาคม') {
        $data = '07';
    } elseif ($month == 'สิงหาคม') {
        $data = '08';
    } elseif ($month == 'กันยายน') {
        $data = '09';
    } elseif ($month == 'ตุลาคม') {
        $data = '10';
    } elseif ($month == 'พฤศจิกายน') {
        $data = '11';
    } elseif ($month == 'ธันวาคม') {
        $data = '12';
    }

    return  $data;
}

function monthname($month_on)
{
    if ($month_on == '01') {
        $month = 'มกราคม';
    } elseif ($month_on == '02') {
        $month = 'กุมภาพันธ์';
    } elseif ($month_on == '03') {
        $month = 'มีนาคม';
    } elseif ($month_on == '04') {
        $month = 'เมษายน';
    } elseif ($month_on == '05') {
        $month = 'พฤษภาคม';
    } elseif ($month_on == '06') {
        $month = 'มิถุนายน';
    } elseif ($month_on == '07') {
        $month = 'กรกฎาคม';
    } elseif ($month_on == '08') {
        $month = 'สิงหาคม';
    } elseif ($month_on == '09') {
        $month = 'กันยายน';
    } elseif ($month_on == '10') {
        $month = 'ตุลาคม';
    } elseif ($month_on == '11') {
        $month = 'พฤศจิกายน';
    } elseif ($month_on == '12') {
        $month = 'ธันวาคม';
    }

    return $month;
}

function dateNoTime($date)
{
    $date_ex    = explode(' ', $date);
    $date_only  = explode('-', $date_ex[0]);

    if ($date_only[1] == '01') {
        $month = 'มกราคม';
    } elseif ($date_only[1] == '02') {
        $month = 'กุมภาพันธ์';
    } elseif ($date_only[1] == '03') {
        $month = 'มีนาคม';
    } elseif ($date_only[1] == '04') {
        $month = 'เมษายน';
    } elseif ($date_only[1] == '05') {
        $month = 'พฤษภาคม';
    } elseif ($date_only[1] == '06') {
        $month = 'มิถุนายน';
    } elseif ($date_only[1] == '07') {
        $month = 'กรกฎาคม';
    } elseif ($date_only[1] == '08') {
        $month = 'สิงหาคม';
    } elseif ($date_only[1] == '09') {
        $month = 'กันยายน';
    } elseif ($date_only[1] == '10') {
        $month = 'ตุลาคม';
    } elseif ($date_only[1] == '11') {
        $month = 'พฤศจิกายน';
    } elseif ($date_only[1] == '12') {
        $month = 'ธันวาคม';
    }

    $year = $date_only[0] + 543;
    return $date_only[2] . '/' . $month . '/' . $year;
}

function dateNoTimeNoSlad($date)
{
    $date_ex    = explode(' ', $date);
    $date_only  = explode('-', $date_ex[0]);

    if ($date_only[1] == '01') {
        $month = 'มกราคม';
    } elseif ($date_only[1] == '02') {
        $month = 'กุมภาพันธ์';
    } elseif ($date_only[1] == '03') {
        $month = 'มีนาคม';
    } elseif ($date_only[1] == '04') {
        $month = 'เมษายน';
    } elseif ($date_only[1] == '05') {
        $month = 'พฤษภาคม';
    } elseif ($date_only[1] == '06') {
        $month = 'มิถุนายน';
    } elseif ($date_only[1] == '07') {
        $month = 'กรกฎาคม';
    } elseif ($date_only[1] == '08') {
        $month = 'สิงหาคม';
    } elseif ($date_only[1] == '09') {
        $month = 'กันยายน';
    } elseif ($date_only[1] == '10') {
        $month = 'ตุลาคม';
    } elseif ($date_only[1] == '11') {
        $month = 'พฤศจิกายน';
    } elseif ($date_only[1] == '12') {
        $month = 'ธันวาคม';
    }

    $year = $date_only[0] + 543;
    return $date_only[2] . ' ' . $month . ' ' . $year;
}

function dateThaiNumberSlad($date)
{
    $date_ex    = explode(' ', $date);
    $date_only  = explode('-', $date_ex[0]);

    $year = $date_only[0] + 543;
    return $date_only[2] . '/' . $date_only[1] . '/' . $year;
}

function DateThaiToGlobal($strDate)
{
    $exp = explode('/', $strDate);
    $year = date("Y", strtotime($strDate)) - 543;
    return  $year . '-' . $exp[1] . '-' . $exp[0];
}

function GlobalToDateThai($strDate)
{
    $date_ex    = explode(' ', $strDate);
    $exp        = explode('-', $date_ex[0]);
    $year       = date("Y", strtotime($date_ex[0])) + 543;
    return  $exp[2] . '/' . $exp[1] . '/' . $year;
}

function ConvertSum($datas)
{
    $total = 0;
    foreach ($datas as $data) {
        if ($data['uom_code'] == null) {
            $total += $data['order_quantity'];
        } else {
            if ($data['uom_code'] == 'CGK') {
                $total += $data['order_quantity'];
            } else {
                $checkUOMClass = UomConversionsV::where('uom_code',$data['uom_code'])->value('uom_class');

                if($checkUOMClass == 'ทั่วไป'){
                    $total += $data['order_quantity'];
                }else{
                    $total += $data['order_quantity'] / 10;
                }
            }
        }
    }
    return number_format($total, 2);
}

function Promotionlists($datas)
{
    $status = false;
    foreach ($datas as $data) {
        if ($data['promotion_id'] != null) {
            $status = true;
            break;
        }
        continue;
    }
    return $status;
}

function Draftpayoutedit($datas)
{
    $status = false;
    foreach ($datas as $data) {
        if ($data['original_quantity'] != $data['diff_quantity']) {
            $status = true;
            break;
        }
        continue;
    }
    return $status;
}

function Ordertype($data)
{
    $status = false;
    if (strpos($data, 'ยาเส้น') !== false) {
        $status = true;
    }
    return $status;
}

function listProduct($data, $number)
{
    //$data = order_quantity
    //$number 1 = หีบ,2 = ห่อ
    $total = 0;
    if ($number == 1) {
        $total = $data / 10;
    } else {
        $total = $data / 0.2;
    }

    return $total == 0 ? '' : $total;
}

function SOInterfaceNo12($docCode)
{
    $result = [];
    $db     =  DB::connection('oracle')->getPdo();
    $sql = "
    DECLARE
    LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
    LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
  BEGIN


      PTOM_WEB_UTILITIES_PKG.CREATE_SALE_ORDER_RMA
                      (P_BATCH_NO        =>  '${docCode}'
                      ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                      ,O_RETURN_MSG     =>  :LV_RETURN_MSG
                      );


  END;
    ";

    $sql = preg_replace("/[\r\n]*/", "", $sql);
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
    $stmt->execute();
    return $result;
}

function ARInterfaceNo8($docCode)
{
    $result = [];
    $db     =  DB::connection('oracle')->getPdo();
    $sql = "
    DECLARE
        LV_RETURN_STATUS        VARCHAR2(10)    :=  NULL;
        LV_RETURN_MSG           VARCHAR2(4000)  :=  NULL;
        V_ORGANIZATION_ID       NUMBER          :=  NULL;

    BEGIN
        
        BEGIN 
            SELECT  ORGANIZATION_ID
            INTO    V_ORGANIZATION_ID
            FROM    HR_OPERATING_UNITS
            WHERE   SHORT_CODE = 'TOAT';
        END;
        
        mo_global.set_policy_context('S', V_ORGANIZATION_ID);

        FND_GLOBAL.APPS_INITIALIZE(
            USER_ID        => 0,
            RESP_ID      => 20678,
            RESP_APPL_ID => 222
        );

        PTOM_WEB_UTILITIES_PKG.CREATE_AR_INVOICE(
            P_BATCH_NO        =>  '${docCode}'
            ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
            ,O_RETURN_MSG     =>  :LV_RETURN_MSG
        );


    END;
    ";

    $sql = preg_replace("/[\r\n]*/", "", $sql);
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
    $stmt->execute();
    return $result;
}

function SOInterfaceNo13($docCode)
{
    $result = [];
    $db     =  DB::connection('oracle')->getPdo();
    $sql = "
    DECLARE
        LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
        LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
    BEGIN


        PTOM_WEB_UTILITIES_PKG.CREATE_SALE_ORDER_PROFORMA(
            P_BATCH_NO        =>  '${docCode}'
            ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
            ,O_RETURN_MSG     =>  :LV_RETURN_MSG
        );


    END;
    ";

    $sql = preg_replace("/[\r\n]*/", "", $sql);
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
    $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
    $stmt->execute();
    return $result;
}

function autoNumberDraftOMP0040($docCode, $field)
{
    $result = [];

    $db     =   DB::connection('oracle')->getPdo();
    do {
        $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE                     =>  '${docCode}'
                        , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                    );
                END;
            ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':lv_doc_sequence_number', $result['sequence_number'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        if (is_null($result['sequence_number'])) {
            break;
        }
    } while (!empty($result['sequence_number']) && !empty(OrderHeader::where($field, '=', $result['sequence_number'])->whereNotNull($field)->orderBy($field, 'desc')->first()));

    return $result['sequence_number'];
}

function autoNumberPayment($docCode, $field)
{
    $result = [];

    $db     =   DB::connection('oracle')->getPdo();
    do {
        $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE                     =>  '${docCode}'
                        , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                    );
                END;
            ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':lv_doc_sequence_number', $result['sequence_number'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        if (is_null($result['sequence_number'])) {
            break;
        }
    } while (!empty($result['sequence_number']) && !empty(PaymentHeader::where($field, '=', $result['sequence_number'])->whereNotNull($field)->orderBy($field, 'desc')->first()));

    return $result['sequence_number'];
}

function payfine($number, $srtdate, $strdate2, $prepare_order_number, $credit_group_code, $invoice_number, $type)
{
    //$srtdate = duedate
    //$strdate2 = creation_date
    if ($invoice_number == null || $invoice_number == '') {
        $payfines = '0.00';
        return $payfines;
    } else {
        if ($invoice_number != null) {
            if ($type == 'D') {
                if (strpos($invoice_number, 'F') !== false) {
                    $customer_type = Customer::join('ptom_consignment_headers', 'ptom_customers.customer_id', 'ptom_consignment_headers.customer_id', 'left')->where('ptom_consignment_headers.consignment_no', $invoice_number)->first(['customer_type_id']);
                    $ct = $customer_type->customer_type_id;
                } else {
                    $customer_type = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_TYPE_ID FROM PTOM_CUSTOMERS INNER JOIN PTOM_ORDER_HEADERS ON PTOM_CUSTOMERS.CUSTOMER_ID = PTOM_ORDER_HEADERS.CUSTOMER_ID
                WHERE PTOM_ORDER_HEADERS.PICK_RELEASE_NO = '$invoice_number'");
                    $ct = $customer_type[0]->customer_type_id;
                }
            } else {
                if (strpos($invoice_number, 'DN') !== false) {
                    $customer_type = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_TYPE_ID FROM PTOM_CUSTOMERS INNER JOIN PTOM_INVOICE_HEADERS ON PTOM_CUSTOMERS.CUSTOMER_ID = PTOM_INVOICE_HEADERS.CUSTOMER_ID WHERE PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER = '$invoice_number'");
                    $ct = $customer_type[0]->customer_type_id;
                } else {
                    $customer_type = DB::select("SELECT PTOM_CUSTOMERS.CUSTOMER_TYPE_ID FROM PTOM_CUSTOMERS INNER JOIN PTOM_PROFORMA_INVOICE_HEADERS ON PTOM_CUSTOMERS.CUSTOMER_ID = PTOM_PROFORMA_INVOICE_HEADERS.CUSTOMER_ID WHERE PTOM_PROFORMA_INVOICE_HEADERS.PICK_RELEASE_NO = '$invoice_number'");
                    $ct = $customer_type[0]->customer_type_id;
                }
            }
            if (!empty($ct) && $ct = 30) {
                $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $invoice_number . "' AND CREDIT_GROUP_CODE = '" . $credit_group_code . "'");
            } else {
                $pon = OrderHeader::where('prepare_order_number', $prepare_order_number)->first();
                if (!empty($pon) && $pon->pick_release_no != null) {
                    $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $pon->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $credit_group_code . "'");
                } else {
                    $imporoe = null;
                }
            }
        } else {
            $pon = OrderHeader::where('prepare_order_number', $prepare_order_number)->first();
            if (!empty($pon) && $pon->pick_release_no != null) {
                $imporoe = DB::select("SELECT CANCEL_FLAG FROM PTOM_IMPROVE_FINES WHERE INVOICE_NUMBER = '" . $pon->pick_release_no . "' AND CREDIT_GROUP_CODE = '" . $credit_group_code . "'");
            } else {
                $imporoe = null;
            }
        }

        if (!empty($imporoe) && $imporoe[0]->cancel_flag == 'Y') {
            $payfines = '0.00';
        } else {
            if (!is_null($srtdate)) {

                $today = Carbon::now('Asia/Bangkok')->format('Y-m-d');
                $d1 = explode('-', $today);
                $d2 = explode('-', Carbon::parse($srtdate)->format('Y-m-d'));
                $date1 = Carbon::createMidnightDate($d1[0], $d1[1], $d1[2], 'Asia/Bangkok');
                $date2 = Carbon::createMidnightDate($d2[0], $d2[1], $d2[2], 'Asia/Bangkok');

                if ($date1->greaterThan($date2)) {
                    $arrDueDate = explode('-', $srtdate);
                    $dueYear = $arrDueDate[0];

                    if ($dueYear % 4 == 0) {
                        $dayOfYear = 366;
                    } else {
                        $dayOfYear = 365;
                    }

                    $newDueDate = date('Y-m-d', strtotime($srtdate));
                    $dateNow = $strdate2 == null ? date("Y-m-d") : date('Y-m-d', strtotime($strdate2));

                    // วันเริ่มต้น
                    $arrStart = explode('-', $newDueDate);
                    $startYear = $arrStart[0];
                    $startMonth = $arrStart[1];
                    $startDay = $arrStart[2];

                    // วันปัจจุบัน
                    $arrNow = explode('-', $dateNow);
                    $nowYear = $arrNow[0];
                    $nowMonth = $arrNow[1];
                    $nowDay = $arrNow[2];

                    $makeNow = mktime(0, 0, 0, $nowMonth, $nowDay, $nowYear);
                    $makeStart = mktime(0, 0, 0, $startMonth, $startDay, $startYear);

                    $dayOverDue = ceil(($makeNow - $makeStart) / 86400);

                    $totlepayfile = $number * 0.15 * $dayOverDue / $dayOfYear;

                    $payfines = number_format(abs($totlepayfile), 2);
                } else {
                    $payfines = '0.00';
                }
            } else {
                $payfines = '0.00';
            }
        }
        return $payfines;
    }
}


function baht_text($number, $include_unit = true, $display_zero = true)
{
    if (!is_numeric($number)) {
        return null;
    }

    $log = floor(log($number, 10));
    if ($log > 5) {
        $millions = floor($log / 6);
        $million_value = pow(1000000, $millions);
        $normalised_million = floor($number / $million_value);
        $rest = $number - ($normalised_million * $million_value);
        $millions_text = '';
        for ($i = 0; $i < $millions; $i++) {
            $millions_text .= BAHT_TEXT_UNITS[6];
        }
        return baht_text($normalised_million, false) . $millions_text . baht_text($rest, true, false);
    }

    $number_str = (string)floor($number);
    $text = '';
    $unit = 0;

    if ($display_zero && $number_str == '0') {
        $text = BAHT_TEXT_NUMBERS[0];
    } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
        $current_number = (int)$number_str[$i];

        $unit_text = '';
        if ($unit == 0 && $i > 0) {
            $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
            if ($current_number == 1 && $previous_number > 0) {
                $unit_text .= BAHT_TEXT_ONE_IN_TENTH;
            } else if ($current_number > 0) {
                $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
            }
        } else if ($unit == 1 && $current_number == 2) {
            $unit_text .= BAHT_TEXT_TWENTY;
        } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
            $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
        }

        if ($current_number > 0) {
            $unit_text .= BAHT_TEXT_UNITS[$unit];
        }

        $text = $unit_text . $text;
        $unit++;
    }

    if ($include_unit) {
        $text .= BAHT_TEXT_BAHT;

        $satang = explode('.', number_format($number, 2, '.', ''))[1];
        $text .= $satang == 0
            ? BAHT_TEXT_INTEGER
            : baht_text($satang, false) . BAHT_TEXT_SATANG;
    } else {
        $exploded = explode('.', $number);
        if (isset($exploded[1])) {
            $text .= BAHT_TEXT_POINT;
            $decimal = (string)$exploded[1];
            for ($i = 0; $i < strlen($decimal); $i++) {
                $text .= BAHT_TEXT_NUMBERS[$decimal[$i]];
            }
        }
    }

    return $text;
}

function ConverttoThai($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".", "");
    $pt = strpos($amount_number, ".");
    $number = $fraction = "";
    if ($pt === false)
        $number = $amount_number;
    else {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }

    $ret = "";
    $baht = ReadNumber($number);
    if ($baht != "")
        $ret .= $baht . "บาท";

    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else
        $ret .= "ถ้วน";
    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number >= 1000000) {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos = 0;
    while ($number > 0) {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

function convertToCount($number, $data)
{
    //$data = order_quantity
    //$number 1 = หีบ,2 = ห่อ
    $total = 0;
    if ($number == 1) {
        $total = $data / 10;
    } else {
        $total = $data / 0.2;
    }

    return $total == 0 ? '' : $total;
}


function invoiceNumberForTest($date)
{
    $m = Carbon::parse($date)->format('m');
    $y = Carbon::parse($date)->format('Y') + 543;
    $yy = substr($y, 2);
    if ($m == 10 || $m == 11 || $m == 12) {
        $yyy = $yy + 1;
    } else {
        $yyy = $yy;
    }
    $prefix = $yyy . $m;
    $running = InvoiceRunningNumber::where('prefix', $prefix)->first() ?? new InvoiceRunningNumber;

    $new_running = !$running->current_number ? 1 : (int)$running->current_number + 1;

    $running->prefix = $prefix;
    $running->current_number = $new_running;
    $running->save();

    return $prefix . sprintf('%05d', $new_running);
}

function runPrepareNumber($number, $budgetYear)
{
    $prefix = $budgetYear . 'O';
    $last_number = explode($prefix, $number);
    $number = substr($last_number[1], 2);

    if (is_numeric($number)) {
        $newnumber = sprintf('%06d', $number + 1);
    } else {
        $newnumber = sprintf('%06d', 1);
    }

    return $prefix . $newnumber;
}

function groupIDDraftforTest()
{
    // $invoice = TranspotReportModel::orderByDesc('ap_interface_id')->first(['group_id']);
    // if (empty($invoice)) {
    //     $newnumber = sprintf('%07d', 1);
    // } else {
    //     $last_number = substr($invoice->invoice_number, 2);
    //     if (is_numeric($last_number)) {
    //         $newnumber = sprintf('%07d', $last_number + 1);
    //     } else {
    //         $newnumber = sprintf('%07d', 1);
    //     }
    // }

    // $year = date('Y') + 543;

    // return substr($year, 2) . $newnumber;
    return Carbon::now()->format('YmdHis');
}

function covertNFToFloat($number)
{
    return filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function returnUserID($id)
{
    if (intval($id)) {
        $user_number = PTOM_AUTHORITY_LISTS::where('authority_id', $id)->first(['employee_number']);
        if (empty($user_number)) {
            return null;
        }
        $getID = User::where('username', $user_number->employee_number)->first(['user_id']);
        if (empty($getID)) {
            return null;
        }
        return $getID->user_id;
    }
    return null;
}

function returnUserName($id)
{
    if (intval($id)) {
        $user_number = PTOM_AUTHORITY_LISTS::where('authority_id', $id)->first(['employee_number']);
        if (empty($user_number)) {
            return null;
        }
        $getID = User::where('username', $user_number->employee_number)->first(['name']);
        if (empty($getID)) {
            return null;
        }
        return $getID->name;
    }
    return null;
}

function countamountts($consignment_no)
{
    $sum = ConsignmentHeader::where('consignment_no', $consignment_no)->first();
    return $sum->total_include_vat;
}

function countamount($order_header_id, $credit_code)
{
    $sum = 0;
    $sums = DB::select("SELECT SUM(AMOUNT) AMOUNT FROM PTOM_ORDER_CREDIT_GROUPS WHERE ORDER_HEADER_ID = '" . $order_header_id . "' AND CREDIT_GROUP_CODE = '" . $credit_code . "' AND ORDER_LINE_ID != 0");
    if (empty($sums)) {
        return $sum;
    }
    return $sums[0]->amount;
}

// MCR Piaywut 07092021
function getPeriodName($period)
{
    $result = '';
    if ($period) {
        $budgetYear = $period->budget_year + 543;
        $no = $period->period_no;
        $result = $budgetYear . '/' . $no;
    }

    return $result;
}

function countamontdn($ref)
{
    $sim = DB::select("SELECT INVOICE_AMOUNT FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $ref . "'");
    if (empty($sim)) {
        return 0;
    }
    return $sim[0]->invoice_amount;
}


function datedn($ref)
{
    $sim = DB::select("SELECT INVOICE_DATE FROM PTOM_INVOICE_HEADERS WHERE INVOICE_HEADERS_NUMBER = '" . $ref . "'");
    if (empty($sim)) {
        return date('Y-m-d');
    }
    return $sim[0]->invoice_date;
}

function amountwithdayonprint($payment_id, $days)
{
    $sum = OMPaymentMatchInvoice::where('payment_header_id', $payment_id)->where('due_day', $days)->sum('payment_amount');

    return empty($sum) ? '0.00' : number_format($sum, 2);
}

function amountwithdayonprintwithOrderHearder($payment_id, $days,$productType)
{
    $sum = OMPaymentMatchInvoice::leftJoin('ptom_order_headers','ptom_order_headers.prepare_order_number','=','ptom_payment_match_invoices.prepare_order_number')
                                ->where('ptom_payment_match_invoices.payment_header_id', $payment_id)
                                ->where('ptom_order_headers.product_type_code', $productType)
                                ->where('ptom_payment_match_invoices.due_day', $days)
                                ->sum('ptom_payment_match_invoices.payment_amount');

    return empty($sum) ? '0.00' : number_format($sum, 2);
}


function omp0015($lookup_code)
{
    $actings = DB::select("SELECT MEANING FROM PTOM_ACTING_POSITION_V WHERE LOOKUP_CODE = '$lookup_code'");
    if (!empty($actings)) {
        return $actings[0]->meaning;
    }
    return '';
}
function getGroupID()
{
    return date('YmdHis');
}

function getInvoiceNumber($prefix)
{
    $running = InvoiceRunningNumber::where('prefix', $prefix)->first() ?? new InvoiceRunningNumber;

    $new_running = !$running->current_number ? 1 : (int)$running->current_number + 1;

    $running->prefix = $prefix;
    $running->current_number = $new_running;
    $running->save();

    return $prefix . sprintf('%05d', $new_running);
}

function autoWebBatchNumber()
{
    $web_batch_no = DB::table('ptom_order_direct_debit')->select('web_batch_no')->whereNotNull('web_batch_no')->orderByDesc('web_batch_no')->first();
    if (empty($web_batch_no)) {
        $newnumber = sprintf('%06d', 1);
    } else {
        if (!is_null($web_batch_no->web_batch_no)) {
            $newnumber = sprintf('%06d', (int)$web_batch_no->web_batch_no + 1);
        } else {
            $newnumber = sprintf('%06d', 1);
        }
    }

    return $newnumber;
}

function convert_number($number)
{
    list($integer, $fraction) = explode(".", (string) number_format(str_replace(',', '', $number), 2));

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11][0] == '0'
                            ? " "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " and";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            if (strlen($fraction) == 1) {
                $output .= " " . convertTwoDigit($fraction[$i], '0');
            } else {
                $output .= " " . convertDigit($fraction[$i]);
            }
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}

function getitemtoreportomp0040($item_code, $order_header, $promo = false)
{
    if ($promo) {
        $orderlines = OrderLines::where('item_code', $item_code)->where('order_header_id', $order_header)->where('promo_flag', 'Y')->first(['approve_quantity', 'promo_flag']);
        if (empty($orderlines)) {
            return 0;
        } else {
            if ($orderlines->promo_flag == 'Y') {
                return number_format($orderlines->approve_quantity, 2);
            } else {
                return 0;
            }
        }
    } else {
        $orderline = OrderLines::where('item_code', $item_code)->where('order_header_id', $order_header)->first(['approve_quantity', 'promo_flag']);
        if (empty($orderline)) {
            return 0;
        } else {
            if ($orderline->promo_flag == 'Y') {
                return 0;
            } else {
                return number_format($orderline->approve_quantity, 2);
            }
        }
    }
}

function getitemtoreportomp0040sum($item_code, $order_header, $promo = false)
{
    if ($promo) {
        $orderlines = OrderLines::where('item_code', $item_code)->where('order_header_id', $order_header)->where('promo_flag', 'Y')->first(['approve_quantity', 'promo_flag']);
        if (empty($orderlines)) {
            return 0;
        } else {
            if ($orderlines->promo_flag == 'Y') {
                return $orderlines->approve_quantity;
            } else {
                return 0;
            }
        }
    } else {
        $orderline = OrderLines::where('item_code', $item_code)->where('order_header_id', $order_header)->first(['approve_quantity', 'promo_flag']);
        if (empty($orderline)) {
            return 0;
        } else {
            if ($orderline->promo_flag == 'Y') {
                return 0;
            } else {
                return $orderline->approve_quantity;
            }
        }
    }
}

function getapprovecardboardbox($item_code, $order_header, $promo = false)
{
    //หีบ
    if ($promo) {
        $orderlines = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->where('promo_flag', 'Y')->first(['approve_cardboardbox', 'promo_flag']);
        if (empty($orderlines)) {
            return 0;
        } else {
            if ($orderlines->promo_flag == 'Y') {
                return number_format($orderlines->approve_cardboardbox, 1);
            } else {
                return 0;
            }
        }
    } else {
        $orderline = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->first(['approve_cardboardbox', 'promo_flag']);
        if (empty($orderline)) {
            return 0;
        } else {
            if ($orderline->promo_flag == 'Y') {
                return 0;
            } else {
                return number_format($orderline->approve_cardboardbox, 1);
            }
        }
    }
}

function getapproveQty($item_code, $order_header, $promo = false, $uom)
{
    //หีบ
    if ($promo) {
        $orderlines = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->where('uom_code', $uom)->where('promo_flag', 'Y')->first(['approve_quantity', 'promo_flag']);
        if (empty($orderlines)) {
            return 0;
        } else {
            if ($orderlines->promo_flag == 'Y') {
                return number_format($orderlines->approve_quantity, 1);
            } else {
                return 0;
            }
        }
    } else {
        $orderline = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->where('uom_code', $uom)->first(['approve_quantity', 'promo_flag']);
        if (empty($orderline)) {
            return 0;
        } else {
            if ($orderline->promo_flag == 'Y') {
                return 0;
            } else {
                return number_format($orderline->approve_quantity, 1);
            }
        }
    }
}

function getapprovecarton($item_code, $order_header, $promo = false)
{
    //ห่อ
    if ($promo) {
        $orderlines = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->where('promo_flag', 'Y')->first(['approve_carton', 'promo_flag']);
        if (empty($orderlines)) {
            return 0;
        } else {
            if ($orderlines->promo_flag == 'Y') {
                return number_format($orderlines->approve_carton, 1);
            } else {
                return 0;
            }
        }
    } else {
        $orderline = OrderLines::where('item_code', $item_code)->whereIn('order_header_id', $order_header)->first(['approve_carton', 'promo_flag']);
        if (empty($orderline)) {
            return 0;
        } else {
            if ($orderline->promo_flag == 'Y') {
                return 0;
            } else {
                return number_format($orderline->approve_carton, 1);
            }
        }
    }
}

function convertUom($item_id, $qty = 1, $from_unit, $to_unit)
{
    $org_id = getOrganizationId();
    if (!$org_id) {
        return $qty;
    }

    $query = DB::select(
        DB::raw("
            select (
                apps.inv_convert.inv_um_convert (
                    item_id           => :item_id,
                    organization_id   => :org_id,
                    PRECISION         => NULL,
                    from_quantity     => :qty,
                    from_unit         => :from_unit,
                    to_unit           => :to_unit,
                    from_name         => NULL,
                    to_name           => NULL
                )
            ) qty_cgc
            from    dual
        "),
        array(
            'item_id' => $item_id,
            'org_id' => $org_id,
            'qty' => $qty,
            'from_unit' => $from_unit,
            'to_unit' => $to_unit
        )
    );

    if (array_key_exists(0, $query)) {
        return $query[0]->qty_cgc;
    }
    return $qty;
}

function getOrganizationId()
{
    $query = DB::select(
        DB::raw("
            select * from mtl_parameters where organization_code = 'A01'
        ")
    );
    if (array_key_exists(0, $query)) {
        return $query[0]->organization_id;
    }
    return null;
}

function printWithSpace($length, $text)
{
    $ansi = iconv(mb_detect_encoding($text), "WINDOWS-874//TRANSLIT//IGNORE", $text);
    $format = '%-' . (string)($length) . 's';
    return sprintf($format, $ansi);

    // $decode = utf8_decode($text);
    // $count_decode = strlen($decode);
    // $count_text = strlen($text);
    // $format = '%-'.(string)((int)$length - (int)$count_decode + (int)$count_text).'s';
    // return sprintf($format, $text);
}

function getPaymentHeaderID($payment_match_id)
{
    $payment_header_id = PaymentMatchInvoice::find($payment_match_id);
    if (empty($payment_header_id)) {
        return '';
    }
    return $payment_header_id->payment_header_id;
}

function meaningproducttype($consignmentno, $prepare = null)
{
    if ($consignmentno == '' || $consignmentno == null) {
        $header_id = OrderHeader::where('prepare_order_number', $prepare)->first();
        $lines = OrderLines::where('order_header_id', $header_id->order_header_id)->orderBy('order_line_id', 'DESC')->first();
    } else {
        $header_id = ConsignmentHeader::where('consignment_no', $consignmentno)->first();
        if (!empty($header_id)) {
            $lines = ConsignmentLines::where('consignment_header_id', $header_id->consignment_header_id)->orderBy('consignment_line_id', 'DESC')->first();
        } else {
            $header_id = OrderHeader::where('prepare_order_number', $prepare)->first();
            $lines = OrderLines::where('order_header_id', $header_id->order_header_id)->orderBy('order_line_id', 'DESC')->first();
        }
        
    }
    $order_header_id = $lines->order_header_id;
    $order = OrderHeader::find($order_header_id);
    $type =  ProductType::where('lookup_code', $order->product_type_code)->first();

    return $type->meaning ?? '';
}


function meaningproducttypeexport($invoice, $prepare = null)
{
    if ($invoice == '' || $invoice == null) {
        $header_id = OrderHeader::where('prepare_order_number', $prepare)->first();
        if ($header_id == null) {
            return '';
        }
        $lines = OrderLines::where('order_header_id', $header_id->order_header_id)->orderBy('order_line_id', 'DESC')->first();
        if ($lines == null) {
            return '';
        }
        $order_header_id = $lines->order_header_id;
    } else {
        $header_id = ProformaInvoiceHeaders::where('pick_release_no', $invoice)->where('sa_number', $prepare)->first();
        if ($header_id == null) {
            return '';
        }
        $lines = ProformaInvoiceLines::where('pi_header_id', $header_id->pi_header_id)->orderBy('pi_line_id', 'DESC')->first();
        if ($lines == null) {
            return '';
        }
        $order_header_id = $lines->ref_order_header_id;
    }
    $order = OrderHeader::find($order_header_id);
    $type =  ProductType::where('lookup_code', $order->product_type_code)->first();

    return $type->meaning ?? '';
}

function convertRatetoomp0068($number_cn)
{
    $PtomInvoiceHeader = PtomInvoiceHeader::where('invoice_headers_number', $number_cn)->first();
    if (empty($PtomInvoiceHeader)) {
        return 1;
    }
    return $PtomInvoiceHeader->exchange_rate == null ? 1 : $PtomInvoiceHeader->exchange_rate;
}


function getCurrency($number_cn)
{
    $PtomInvoiceHeader = PtomInvoiceHeader::where('invoice_headers_number', $number_cn)->first();
    if (empty($PtomInvoiceHeader)) {
        return '';
    }
    return $PtomInvoiceHeader->currency;
}

function meaningtypepayment($code)
{
    $meaning = DB::select("SELECT MEANING FROM PTOM_PAYMENT_TYPE WHERE LOOKUP_CODE = $code");
    if (empty($meaning)) {
        return '';
    }
    return $meaning[0]->meaning;
}

function printDetailsOMP0067($payment)
{
    if ($payment->invoice_number == null) {
        $data = PtomOrderHeader::join('ptom_product_type_export', 'ptom_order_headers.product_type_code', 'ptom_product_type_export.lookup_code', 'left')->where('ptom_order_headers.prepare_order_number', $payment->prepare_order_number)->first();
        return 'รับชำระค่า' . $data->description . ' ตาม ' . $data->prepare_order_number;
    } else {
        $data = PtomProformaInvoiceHeadres::join('ptom_product_type_export', 'ptom_proforma_invoice_headers.product_type_code', 'ptom_product_type_export.lookup_code', 'left')->where('ptom_proforma_invoice_headers.pick_release_no', $payment->invoice_number)->first();
        return 'รับชำระค่า' . $data->description . ' ตาม ' . $data->pi_number;
    }
}

function printVatOMP0067($payment)
{
    if ($payment->invoice_number == null) {
        $vat = PtomOrderHeader::join('ptom_tax_code_v', 'ptom_order_headers.vat_code', 'ptom_tax_code_v.tax_rate_code', 'left')->where('ptom_order_headers.prepare_order_number', $payment->prepare_order_number)->first();
        return $vat->percentage_rate;
    } else {
        $vat = PtomProformaInvoiceHeadres::join('ptom_tax_code_v', 'ptom_proforma_invoice_headers.vat_code', 'ptom_tax_code_v.tax_rate_code', 'left')->where('ptom_proforma_invoice_headers.pick_release_no', $payment->invoice_number)->first();
        return $vat->percentage_rate;
    }
}

function printAmountVatOMP0067($payment)
{
    if ($payment->invoice_number == null) {
        $amount = PtomOrderHeader::where('ptom_order_headers.prepare_order_number', $payment->prepare_order_number)->first();
        return number_format($amount->tax, 2);
    } else {
        $amount = PtomProformaInvoiceHeadres::where('ptom_proforma_invoice_headers.pick_release_no', $payment->invoice_number)->first();
        return number_format($amount->tax, 2);
    }
}

function getAmountSellThisWeek($id, $mean) {
    $customer = AdditionQuotaHeader::find($id);
    $period_id = PtomOrderHeader::where('order_status', 'Confirm')
                                ->where('customer_id', $customer[0]->customer_id)
                                ->where('order_header_id', $customer[0]->order_header_id)
                                ->first();
    if(empty($period_id)) {
        return "-";
    } else {
        $group = QuotaGroup::where('meaning', $mean)->first();
        if(empty($group)) {
            return "-";
        } else {
            $quota = QuotaCreditGroup::where('quota_group_code', $group->lookup_code)->pluck('item_id')->toArray();
            if(empty($quota)) {
                return "-";
            } else {
                $data = PtomOrderHeader::join(  'ptom_order_lines', 
                                                'ptom_order_headers.order_header_id', 
                                                'ptom_order_lines.order_header_id')
                                        ->where('ptom_order_headers.order_status', 'Confirm')
                                        ->where('ptom_order_headers.pick_release_status', 'Confirm')
                                        ->where('ptom_order_headers.period_id', $period_id->period_id)
                                        ->where('ptom_order_headers.customer_id', $customer[0]->customer_id)
                                        ->whereIn('ptom_order_lines.item_id', $quota)
                                        ->sum('ptom_order_lines.approve_quantity');
          
                return ceil($data/10);
            }
        }
    }
}

function convertToCS1($uom_code, $count)
{
    if($uom_code == 'CS1') {
        return $count;
    } elseif ($uom_code == 'PTN') {
        return ceil($count  * (1/120));
    } elseif ($uom_code == 'E00') {
        return ceil($count * (1/120));
    } elseif ($uom_code == 'CL1') {
        return ceil($count * (12/120));
    } elseif ($uom_code == 'CGK') {
        return ceil($count * (1/120));
    } else {
        return 1;
    }
}

function convertWithTypeToCS1($mean, $uom_code, $count, $approve)
{
    if($mean == 'บุหรี่ในประเทศ') {
        return $count;
    } else {
        if($uom_code == 'CS1') {
            return $approve;
        } elseif ($uom_code == 'PTN') {
            return ceil($approve  * (1/120));
        } elseif ($uom_code == 'E00') {
            return ceil($approve * (1/120));
        } elseif ($uom_code == 'CL1') {
            return ceil($approve * (12/120));
        } elseif ($uom_code == 'CGK') {
            return ceil($approve * (1/120));
        } else {
            return 1;
        }
    }
}

function convertToCS1RemoveCell($uom_code, $count)
{
    if($uom_code == 'CS1') {
        return $count;
    } elseif ($uom_code == 'PTN') {
        return ($count  * (1/120));
    } elseif ($uom_code == 'E00') {
        return ($count * (1/120));
    } elseif ($uom_code == 'CL1') {
        return ($count * (12/120));
    } elseif ($uom_code == 'CGK') {
        return ($count * (1/120));
    } else {
        return 1;
    }
}

// DEV JOEY
function translateToWords($number)
{
/*****
     * A recursive function to turn digits into words
     * Numbers must be integers from -999,999,999,999 to 999,999,999,999 inclussive.
     *
     *  (C) 2010 Peter Ajtai
     *    This program is free software: you can redistribute it and/or modify
     *    it under the terms of the GNU General Public License as published by
     *    the Free Software Foundation, either version 3 of the License, or
     *    (at your option) any later version.
     *
     *    This program is distributed in the hope that it will be useful,
     *    but WITHOUT ANY WARRANTY; without even the implied warranty of
     *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *    GNU General Public License for more details.
     *
     *    See the GNU General Public License: <http://www.gnu.org/licenses/>.
     *
     */
    // zero is a special case, it cause problems even with typecasting if we don't deal with it here
    $string = '';
    $suffix = '';
    $max_size = pow(10,18);
    if (!$number) return "zero";
    if (is_int($number) && $number < abs($max_size))
    {
        switch ($number)
        {
            // set up some rules for converting digits to words
            case $number < 0:
                $prefix = "negative";
                $suffix = translateToWords(-1*$number);
                $string = $prefix . " " . $suffix;
                break;
            case 1:
                $string = "one";
                break;
            case 2:
                $string = "two";
                break;
            case 3:
                $string = "three";
                break;
            case 4:
                $string = "four";
                break;
            case 5:
                $string = "five";
                break;
            case 6:
                $string = "six";
                break;
            case 7:
                $string = "seven";
                break;
            case 8:
                $string = "eight";
                break;
            case 9:
                $string = "nine";
                break;
            case 10:
                $string = "ten";
                break;
            case 11:
                $string = "eleven";
                break;
            case 12:
                $string = "twelve";
                break;
            case 13:
                $string = "thirteen";
                break;
            // fourteen handled later
            case 15:
                $string = "fifteen";
                break;
            case $number < 20:
                $string = translateToWords($number%10);
                // eighteen only has one "t"
                if ($number == 18)
                {
                $suffix = "een";
                } else
                {
                $suffix = "teen";
                }
                $string .= $suffix;
                break;
            case 20:
                $string = "twenty";
                break;
            case 30:
                $string = "thirty";
                break;
            case 40:
                $string = "forty";
                break;
            case 50:
                $string = "fifty";
                break;
            case 60:
                $string = "sixty";
                break;
            case 70:
                $string = "seventy";
                break;
            case 80:
                $string = "eighty";
                break;
            case 90:
                $string = "ninety";
                break;
            case $number < 100:
                $prefix = translateToWords($number-$number%10);
                $suffix = translateToWords($number%10);
                $string = $prefix . " " . $suffix;
                break;
            // handles all number 100 to 999
            case $number < pow(10,3):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,2)))) . " hundred";
                if ($number%pow(10,2)) $suffix = " and " . translateToWords($number%pow(10,2));
                $string = $prefix . $suffix;
                break;
            case $number < pow(10,6):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,3)))) . " thousand";
                if ($number%pow(10,3)) $suffix = translateToWords($number%pow(10,3));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10,9):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,6)))) . " million";
                if ($number%pow(10,6)) $suffix = translateToWords($number%pow(10,6));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10,12):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,9)))) . " billion";
                if ($number%pow(10,9)) $suffix = translateToWords($number%pow(10,9));
                $string = $prefix . " " . $suffix;
                break;
            case $number < pow(10,15):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,12)))) . " trillion";
                if ($number%pow(10,12)) $suffix = translateToWords($number%pow(10,12));
                $string = $prefix . " " . $suffix;
                break;
            // Be careful not to pass default formatted numbers in the quadrillions+ into this function
            // Default formatting is float and causes errors
            case $number < pow(10,18):
                // floor return a float not an integer
                $prefix = translateToWords(intval(floor($number/pow(10,15)))) . " quadrillion";
                if ($number%pow(10,15)) $suffix = translateToWords($number%pow(10,15));
                $string = $prefix . " " . $suffix;
                break;
        }
    } else
    {
        // echo "ERROR with - $number<br/> Number must be an integer between -" . number_format($max_size, 0, ".", ",") . " and " . number_format($max_size, 0, ".", ",") . " exclussive.";
    }
    return $string;
}

function getNumberFormatFor0082($value, $product_type_code = 0)
{
    $decimal = null;
    if($product_type_code == '10'){
        $decimal = 2;
    }elseif($product_type_code == '20'){
        $decimal = 0;
    }else {
        if(is_float($value)){
            $decimal = strlen(substr(strrchr($value, "."), 1));
        }else {
            $decimal = 0;
        } 
    }

    return '#,##'.number_format(0, $decimal);
}