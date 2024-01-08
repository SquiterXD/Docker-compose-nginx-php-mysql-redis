<?php

namespace App\Repositories\OM;

use DB;
use PDO;

class CustomersRepo
{
    public static function callWMSPackageCreateCustomers($customerId)
    {
        $result = [];

        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      VARCHAR2(100)   :=  NULL;
                lv_return_msg         VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.CREATE_CUSTOMER
                (
                I_CUSTOMER_ID   =>    :customer_id
                , O_RETURN_STATUS =>  :lv_return_status
                , O_RETURN_MSG    =>  :lv_return_msg
                );
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        logger($sql);
        logger($customerId);
        $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_INT);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;

    }

    public static function callWMSPackageUpdateCustomers($customerId)
    {
        $result = [];

        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      VARCHAR2(100)   :=  NULL;
                lv_return_msg         VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER
                (
                I_CUSTOMER_ID   =>    :customer_id
                , O_RETURN_STATUS =>  :lv_return_status
                , O_RETURN_MSG    =>  :lv_return_msg
                );
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;

    }

    public static function callWMSPackageCreateCustomersShipTo($shipToSiteId)
    {
        $result = [];

        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      VARCHAR2(100)   :=  NULL;
                lv_return_msg         VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.CREATE_CUSTOMER_SITE
                (
                    I_SITE_ID         =>  :ship_to_site_id
                , o_return_status   =>  :lv_return_status
                , o_return_msg      =>  :lv_return_msg
                );
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ship_to_site_id', $shipToSiteId, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;

    }

    public static function callWMSPackageUpdateCustomersShipTo($shipToSiteId)
    {
        $result = [];

        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
            DECLARE
                lv_return_status      VARCHAR2(100)   :=  NULL;
                lv_return_msg         VARCHAR2(4000)  :=  NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.UPDATE_CUSTOMER_SITE
                (
                    I_SITE_ID         =>  :ship_to_site_id
                , o_return_status   =>  :lv_return_status
                , o_return_msg      =>  :lv_return_msg
                );
            END;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ship_to_site_id', $shipToSiteId, \PDO::PARAM_STR);
        $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_return_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;

    }
}
