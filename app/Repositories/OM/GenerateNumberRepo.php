<?php

namespace App\Repositories\OM;

use App\Models\MtlParameter;
use App\Models\OM\PrepareSaleOrder\PrepareSaleOrderModel;

use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use DB;
use PDO;

class GenerateNumberRepo
{

    public static function docSequenceNumber($docCode,$field)
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

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':lv_doc_sequence_number', $result['sequence_number'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            
            \Log::info('gen prepare_order_number ', [$result['sequence_number'], $result['status'], $result['message'] ]);

            if(is_null($result['sequence_number'])){
                break;
            }


        } while (!empty($result['sequence_number']) && !empty(OrderHeaders::where($field, '=', $result['sequence_number'])->whereNotNull($field)->orderBy($field,'desc')->first()));

        return $result['sequence_number'];
    }

    public static function getByTypeCustomer($customerID = 0)
    {
        // return DB::table('ptom_customers')
        // ->whereRaw("lower(status) = 'active' ")
        // ->whereRaw("lower(sales_classification_code) = '".$type."' ")
        // ->where('deleted_at',NULL)
        // ->get();


        $result = [];
        $customerId = 145;
        // do {

            $db     =   DB::connection('oracle')->getPdo();
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER                      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS                            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG                               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE                         =>  'OMP0019_SO_NUM_L_DOM'
                        , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':lv_doc_sequence_number', $result['sequence_number'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();


        // } while ($a <= 10);


        // $customerId = 144;
        // $db     =   \DB::connection('oracle')->getPdo();
        // $sql = "
        //     DECLARE
        //         lv_return_status      VARCHAR2(100)   :=  NULL;
        //         lv_return_msg         VARCHAR2(4000)  :=  NULL;
        //     BEGIN
        //         PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER
        //         (
        //         I_CUSTOMER_ID   =>    :customer_id
        //         , O_RETURN_STATUS =>  :lv_return_status
        //         , O_RETURN_MSG    =>  :lv_return_msg
        //         );
        //     END;
        // ";

        // $sql = preg_replace("/[\r\n]*/","",$sql);
        // $stmt = $db->prepare($sql);

        // $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_STR);
        // $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        // $stmt->execute();
        return $result;

        // return $result;
    }

    public static function generateCustomerNumberDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMM0007_CUST_NUM_DOM'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['customer_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['customer_number']) && !empty(Customer::where('customer_number', '=', $result['customer_number'])->whereNotNull('customer_number')->orderBy('customer_number','desc')->first()));

        return $result['customer_number'];
    }

    public static function generateApprovePrepare($documentCode)
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  '{$documentCode}'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            // logger($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['pick_release_no'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['pick_release_no']) && !empty(OrderHeaders::where('pick_release_no', '=', $result['pick_release_no'])->whereNotNull('pick_release_no')->orderBy('pick_release_no','desc')->first()));

        return $result['pick_release_no'];
    }

    public static function generateSaleConfirmation($documentCode)
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  '{$documentCode}'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['prepare_order_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['prepare_order_number']) && !empty(OrderHeaders::where('prepare_order_number', '=', $result['prepare_order_number'])->whereNotNull('prepare_order_number')->orderBy('prepare_order_number','desc')->first()));

        return $result['prepare_order_number'];
    }

    public static function generateConsignmentNo($documentCode)
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  '{$documentCode}'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['consignment_no'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['consignment_no']) && !empty(ConsignmentHeader::where('consignment_no', '=', $result['consignment_no'])->whereNotNull('consignment_no')->orderBy('consignment_no','desc')->first()));

        return $result['consignment_no'];
    }

    public static function callWMSPackageConsignment($consignmentHeaderID, $consignmentNo)
    {
        $result = [];

        // $consignmentHeaderID = 180;
        // $consignmentNo = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_7(i_consignment_header_id   => {$consignmentHeaderID}
                    ,i_consignment_no     => '{$consignmentNo}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function callWMSPackageApprovePrepare($orderHeaderID, $prepareOrderNumber)
    {
        $result = [];

        // $orderHeaderID = 180;
        // $prepareOrderNumber = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_4(i_order_header_id   => {$orderHeaderID}
                    ,i_prepare_order_number     => '{$prepareOrderNumber}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function getOrderNumberPrepareSaleOrder($lastnumber = '')
    {
        $result = [];
        $i = 1;
        do {
            $db     =   DB::connection('oracle')->getPdo();
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER                  VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS                        VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG                           VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE                     =>  'OMP0019_SO_NUM_CG_DOM'
                        , O_DOC_SEQUENCE_NUMBER             =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS                   =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG                      =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            // $stmt->bindParam(':customer_id', $customerID, \PDO::PARAM_STR);
            $stmt->bindParam(':lv_doc_sequence_number', $result['sequence_number'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            if(!empty($result['sequence_number'])){
                $order = PrepareSaleOrderModel::where('prepare_order_number',$result['sequence_number'])->count();
            }else{
                break;
            }
            $i++;
            if($i > 10){
                break;
            }

        } while ($order > 0);

        $result['total']    = $i;

        return $result;
    }

    public static function generateCustomerNumberExport()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMM0006_CUST_NUM_EXP'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['customer_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['customer_number']) && !empty(Customer::where('customer_number', '=', $result['customer_number'])->whereNotNull('customer_number')->orderBy('customer_number','desc')->first()));

        return $result['customer_number'];
    }

    public static function callPackageUpdateActiveCustomerExport($customer_id)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                LV_RETURN_STATUS      VARCHAR2(100)    :=  NULL;
                LV_RETURN_MSG         VARCHAR2(4000)   :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.CREATE_CUSTOMER
                (
                     I_CUSTOMER_ID          => {$customer_id}
                    ,O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                    ,O_RETURN_MSG          =>  :LV_RETURN_MSG
                );
            END;
        ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }

    public static function callPackageUpdateCustomerExport($customer_id)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                LV_RETURN_STATUS      VARCHAR2(100)    :=  NULL;
                LV_RETURN_MSG         VARCHAR2(4000)   :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER
                (
                     I_CUSTOMER_ID          => {$customer_id}
                    ,O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                    ,O_RETURN_MSG          =>  :LV_RETURN_MSG
                );
            END;
        ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }

    public static function callPackageCreateCustomerShiptoSiteExport($ship_to_site_id)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                LV_RETURN_STATUS      VARCHAR2(100)    :=  NULL;
                LV_RETURN_MSG         VARCHAR2(4000)   :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.CREATE_CUSTOMER_SITE
                (
                    I_SITE_ID              => {$ship_to_site_id}
                    ,O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                    ,O_RETURN_MSG          =>  :LV_RETURN_MSG
                );
            END;
        ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }

    public static function callPackageUpdateCustomerShiptoSiteExport($ship_to_site_id)
    {
        $result = [];
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                LV_RETURN_STATUS      VARCHAR2(100)    :=  NULL;
                LV_RETURN_MSG         VARCHAR2(4000)   :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER_SITE
                (
                    I_SITE_ID              => {$ship_to_site_id}
                    ,O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                    ,O_RETURN_MSG          =>  :LV_RETURN_MSG
                );
            END;
        ";
        
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        
        return $result;
    }

    public static function callWMSPackagePrepare($order_id, $prepare_number)
    {
        $result = [];

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
            PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_1
            (i_order_header_id          => {$order_id}
            ,i_prepare_order_number     => '{$prepare_number}'
            ,o_result                   => :o_result);
            dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function callWMSPackageCancelPrepare($order_id, $prepare_number)
    {
        $result = [];

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
            PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_11
            (i_order_header_id          => {$order_id}
            ,i_prepare_order_number     => '{$prepare_number}'
            ,o_result                   => :o_result);
            dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

    }

    public static function callWMSPackagePrepareSaleOrder($order_id, $prepare_number)
    {
        $result = [];

        // $consignmentHeaderID = 180;
        // $consignmentNo = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
            PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_2
            (i_order_header_id          => {$order_id}
            ,i_prepare_order_number     => '{$prepare_number}'
            ,o_result                   => :o_result);
            dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function generateDebitNoteNumberDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMP0032_DN_NUM_DOM'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['invoice_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['invoice_number']) && !empty(DB::table('ptom_invoice_headers')->where('invoice_type','DN')->where('program_code','OMP0032')->where('invoice_headers_number', '=', $result['invoice_number'])->whereNotNull('invoice_headers_number')->orderBy('invoice_headers_number','desc')->first()));

        return $result['invoice_number'];
    }

    public static function generateCreditNoteExportDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMP0076_DN_NUM_EXP'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['invoice_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['invoice_number']) && !empty(DB::table('ptom_invoice_headers')->where('invoice_type','DN')->where('program_code','OMP0076')->where('invoice_headers_number', '=', $result['invoice_number'])->whereNotNull('invoice_headers_number')->orderBy('invoice_headers_number','desc')->first()));

        return $result['invoice_number'];
    }

    public static function generateCreditNoteOtherExportDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMP0077_CN_NUM_EXP'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['invoice_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['invoice_number']) && !empty(DB::table('ptom_invoice_headers')->where('invoice_type','CN_OTHER')->where('invoice_headers_number', '=', $result['invoice_number'])->where('program_code','OMP0077')->whereNotNull('invoice_headers_number')->orderBy('invoice_headers_number','desc')->first()));

        return $result['invoice_number'];
    }


    public static function generateCreditNoteOtherNumberDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMP0033_CN_NUM_DOM'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['invoice_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['invoice_number']) && !empty(DB::table('ptom_invoice_headers')->where('invoice_type','CN_OTHER')->where('program_code','OMP0033')->where('invoice_headers_number', '=', $result['invoice_number'])->whereNotNull('invoice_headers_number')->orderBy('invoice_headers_number','desc')->first()));

        return $result['invoice_number'];
    }

    public static function generateCreditNoteRanchTransferNumberDomestics()
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  'OMP0034_CN_TC_NUM_DOM'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['invoice_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['invoice_number']) && !empty(DB::table('ptom_invoice_headers')->where('invoice_type','CN_TRANFER')->where('program_code','OMP0034')->where('invoice_headers_number', '=', $result['invoice_number'])->whereNotNull('invoice_headers_number')->orderBy('invoice_headers_number','desc')->first()));

        return $result['invoice_number'];
    }

    public static function callWMSPackageProformaInvoice($piHeaderID, $piNumber)
    {
        $result = [];

        // $piHeaderID = 180;
        // $piNumber = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_3(i_pi_header_id   => {$piHeaderID}
                    ,i_pi_number     => '{$piNumber}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function callWMSPackageTaxInvoice($piHeaderID, $piNumber)
    {
        $result = [];

        // $piHeaderID = 180;
        // $piNumber = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_5(i_pi_header_id   => {$piHeaderID}
                    ,i_pi_number     => '{$piNumber}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function callWMSPackageTaxInvoiceChangeDeliveryDate($piHeaderID, $piNumber)
    {
        $result = [];

        // $piHeaderID = 180;
        // $piNumber = '64O05001';

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_6(i_pi_header_id   => {$piHeaderID}
                    ,i_pi_number     => '{$piNumber}'
                    ,o_result                   => :o_result);
                dbms_output.put_line(o_result);
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['o_result'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

        // dd('result', $result);
    }

    public static function generateCopyToPI($documentCode)
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  '{$documentCode}'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['pi_number'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['pi_number']) && !empty(ProformaInvoiceHeaders::where('pi_number', '=', $result['pi_number'])->whereNotNull('pi_number')->orderBy('pi_number','desc')->first()));

        return $result['pi_number'];
    }

    public static function generateCopyToIN($documentCode)
    {
        $result     = [];

        $db     =   DB::connection('oracle')->getPdo();

        do {
            $sql = "
                DECLARE
                    LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                    LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                    LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                BEGIN
                    PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                    (
                        I_DOCUMENT_CODE         =>  '{$documentCode}'
                        , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                        , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                        , O_RETURN_MSG          =>  :LV_RETURN_MSG
                    );
                END;
            ";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['attribute1'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

        } while (!empty($result['attribute1']) && !empty(ProformaInvoiceHeaders::where('attribute1', '=', $result['attribute1'])->whereNotNull('attribute1')->orderBy('attribute1','desc')->first()));

        return $result['attribute1'];
    }

    public static function callWMSPackageReqNumberExport()
    {
        $result = [];

        $db     =   DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                (
                    I_DOCUMENT_CODE         =>  'OMM0001_REQ_NUM_EXP'
                    , O_DOC_SEQUENCE_NUMBER =>  :LV_DOC_SEQUENCE_NUMBER
                    , O_RETURN_STATUS       =>  :LV_RETURN_STATUS
                    , O_RETURN_MSG          =>  :LV_RETURN_MSG
                );
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['data'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

    }

    public static function convertUnitItem($itemID, $orderQuantity, $uomCode, $toUnit)
    {
        $orgA01Id = MtlParameter::where('organization_code', 'A01')->value('organization_id');
        // dd($orgA01Id);
        // exit();
        $from_quantity = str_replace(',', '', $orderQuantity);

        $convertOrder = collect(DB::select("
                            select (apps.inv_convert.inv_um_convert (
                                    item_id         => '{$itemID}',
                                    organization_id => {$orgA01Id},
                                    PRECISION       => NULL,
                                    from_quantity   => '{$from_quantity}',
                                    from_unit       => '{$uomCode}',
                                    to_unit         => '{$toUnit}',
                                    from_name       => NULL,
                                    to_name         => NULL)
                                ) result
                            from dual
        "))->first();

        return !empty($convertOrder->result) ? $convertOrder->result : 0;
    }

    public static function convertTaxToRound($value)
    {
        // $value = 565.60;
        $amount = 0;

        $db     =   DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                        LV_AMOUNT       number   :=  NULL;

                BEGIN
                    :LV_AMOUNT :=  ptom_web_utilities_pkg.roundup_to_ten(
                            i_amount        =>   '{$value}'
                        );

                END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':LV_AMOUNT', $amount, \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $amount;
    }
}
