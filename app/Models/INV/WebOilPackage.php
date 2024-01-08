<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;
use PDO;

class WebOilPackage extends Model
{
    public function createDistInterface($transactionId)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_fuel_oil_rec   PTINV_WEB_FUEL_OIL%ROWTYPE;
                        
                        BEGIN
                            BEGIN
                                SELECT *
                                INTO v_fuel_oil_rec
                                FROM PTINV_WEB_FUEL_OIL
                                WHERE 1=1
                                AND transaction_id = $transactionId;
                            END;
                        
                            PTINV_WEB_OIL_PKG.CREATE_DIST( P_FUEL_OIL_INFO   =>  v_fuel_oil_rec  ) ;
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->execute();

    }

    public static function interface($transactionId)
    {

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_return_status      varchar2(4000)  :=  NULL;
                            v_message            varchar2(4000)  :=  NULL;
                        BEGIN
                            PTINV_WEB_OIL_PKG.UPLOAD_TO_MMT
                            (   P_TRANSACTION_ID    => $transactionId
                                , P_ACTION_CODE     => 'ISSUE'
                                ,P_RETURN_STATUS    => :v_return_status
                                ,P_RETURN_MESSAGE   => :v_message
                            );

                            dbms_output.put_line ('***Error-'|| :v_return_status);
                            dbms_output.put_line ('***Error-'|| :v_message);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_return_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_message', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

    }

    public static function returnInterface($transactionId)
    {

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_return_status      varchar2(4000)  :=  NULL;
                            v_message            varchar2(4000)  :=  NULL;
                        BEGIN
                            PTINV_WEB_OIL_PKG.UPLOAD_TO_MMT
                            (   P_TRANSACTION_ID    => $transactionId
                                , P_ACTION_CODE     => 'RECEIPT'
                                ,P_RETURN_STATUS    => :v_return_status
                                ,P_RETURN_MESSAGE   => :v_message
                            );

                            dbms_output.put_line ('***Error-'|| :v_return_status);
                            dbms_output.put_line ('***Error-'|| :v_message);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_return_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_message', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;

    }

    public static function updateCarInfoInterface($carInfo)
    {
        $carInfoV = CarInfoV::firstWhere('asset_id', $carInfo->asset_id);
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            V_STATUS            VARCHAR2(1)     := NULL;
                            V_RETURN_STATUS     VARCHAR2(1)     := NULL;
                            V_RETURN_MESSAGE    VARCHAR2(4000)  := NULL;
                        BEGIN
                            V_STATUS := PTINV_UPDATE_CAR_INFO_PKG.CAR_INFO
                            (
                                :p_asset_id
                                ,:car_license_plate
                                ,:car_brand
                                ,:car_vehicle_number
                                ,:car_group
                                ,:default_dept_code
                                ,:car_user
                                ,'Test'
                                ,:account_code
                                ,:car_fuel
                                ,:quota_per_month

                                ,P_RETURN_STATUS      => :V_RETURN_STATUS
                                ,P_RETURN_MESSAGE     => :V_RETURN_MESSAGE
                            );
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $pAssetId        = $carInfo->asset_id;
        $carLicensePlate = $carInfo->car_license_plate;
        $carBrand        = $carInfo->car_brand;
        $carVehicleNumber = $carInfoV->car_vehicle_number;
        $carGroup        = $carInfo->car_group;
        $defaultDeptCode = $carInfoV->default_dept_code;
        $carUser         = $carInfoV->car_user;
        $accountCode     = $carInfo->account_code;
        $carFuel         = $carInfo->car_fuel;
        $quotaPerPonth   = $carInfo->quota_per_month;
 

       $stmt->bindParam(':p_asset_id',         $pAssetId, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_license_plate',  $carLicensePlate, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_brand',          $carBrand, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_vehicle_number', $carVehicleNumber, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_group',          $carGroup, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':default_dept_code',  $defaultDeptCode, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_user',           $carUser, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':account_code',       $accountCode, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':car_fuel',           $carFuel, PDO::PARAM_STR, 1000);
       $stmt->bindParam(':quota_per_month',    $quotaPerPonth, PDO::PARAM_STR, 1000);

        // OUT
        $stmt->bindParam(':V_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public static function updateNonFaInterface($carNonFa)
    {
        $carNonFaV = CarInfoV::firstWhere('car_license_plate', $carNonFa->car_license_plate);
        
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE 
                            v_debug             NUMBER          :=0;
                            V_RETURN_STATUS     VARCHAR2(1)     := NULL;
                            V_RETURN_MSG        VARCHAR2(4000)  := NULL;
                            V_CAR               VARCHAR2(30)    := NULL;

                            V_CAR_NONFA         PTINV_CAR_NONFA_V%rowTYPE;
                            v_upd_data          ptinv_update_car_info_pkg.NONFA_PARAM;
                        BEGIN
                            v_debug                         := 1;
                            V_CAR                           := :car_license_plate;
                            v_upd_data                      := NULL;
                            v_upd_data.DATA_TYPE            := 'UPDATE';
                            v_upd_data.car_license_plate    := V_CAR ;
                                
                            IF v_upd_data.DATA_TYPE  <> 'UPDATE' THEN
                                BEGIN
                                    SELECT  car_license_plate 
                                            , car_description   
                                            , tax_refund_yn     
                                            , car_group         
                                            , car_fuel          
                                            , default_dept_code 
                                            , account_code      
                                            , quota_per_month    
                                            , meaning
                                        INTO  v_upd_data.car_license_plate 
                                                , v_upd_data.car_description   
                                                , v_upd_data.tax_refund_yn     
                                                , v_upd_data.car_group         
                                                , v_upd_data.car_fuel          
                                                , v_upd_data.default_dept_code 
                                                , v_upd_data.account_code      
                                                , v_upd_data.quota_per_month  
                                                , v_upd_data.meaning
                                    FROM PTINV_CAR_NONFA_V
                                    WHERE 1=1
                                    AND car_license_plate    = V_CAR ;
                                END;
                            END IF;
                        
                            v_debug := 2;

                                v_upd_data.car_description        := :car_description;
                                v_upd_data.tax_refund_yn          := :tax_refund_yn;
                                v_upd_data.car_group              := :car_group;
                                v_upd_data.car_fuel               := :car_fuel;
                                v_upd_data.default_dept_code      := :default_dept_code;
                                v_upd_data.account_code           := :account_code;
                                v_upd_data.quota_per_month        := :quota_per_month;           
                                
                            v_debug := 3; 
                                ptinv_update_car_info_pkg.UPD_CAR_NONFA
                                (
                                    P_PARAM             => v_upd_data
                                    ,P_RETURN_STATUS    => :V_RETURN_STATUS
                                    ,P_RETURN_MESSAGE   => :V_RETURN_MSG
                                );
                        END;
        
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $carLicensePlate    = $carNonFa->car_license_plate;
        $carDescription     = $carNonFaV->car_description;
        $taxRefundYn        = $carNonFaV->tax_refund_yn;
        $carGroup           = $carNonFa->car_group;
        $carFuel            = $carNonFa->car_fuel;
        $defaultDeptCode    = $carNonFa->default_dept_code;
        $accountCode        = $carNonFa->account_code;
        $quotaPerPonth      = $carNonFa->quota_per_month;

        $stmt->bindParam(':car_license_plate',    $carLicensePlate, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':car_description',      $carDescription, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':tax_refund_yn',        $taxRefundYn, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':car_group',            $carGroup, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':default_dept_code',    $defaultDeptCode, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':account_code',         $accountCode, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':car_fuel',             $carFuel, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':quota_per_month',      $quotaPerPonth, PDO::PARAM_STR, 1000);

        // OUT
        $stmt->bindParam(':V_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_RETURN_MSG', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public static function addNonFaInterface($carNonFa)
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE 
                            v_debug             NUMBER          :=0;
                            V_RETURN_STATUS     VARCHAR2(1)     := NULL;
                            V_RETURN_MSG        VARCHAR2(4000)  := NULL;
                            V_CAR               VARCHAR2(30)    := NULL;

                            V_CAR_NONFA         PTINV_CAR_NONFA_V%rowTYPE;
                            v_upd_data          ptinv_update_car_info_pkg.NONFA_PARAM;
                        BEGIN
                            v_debug                         := 1;
                            V_CAR                           := :car_license_plate;
                            v_upd_data                      := NULL;
                            v_upd_data.DATA_TYPE            := 'ADD';
                            v_upd_data.car_license_plate    := V_CAR ;
                                
                            IF v_upd_data.DATA_TYPE  <> 'ADD' THEN
                                BEGIN
                                    SELECT  car_license_plate 
                                            , car_description   
                                            , tax_refund_yn     
                                            , car_group         
                                            , car_fuel          
                                            , default_dept_code 
                                            , account_code      
                                            , quota_per_month    
                                            , meaning
                                        INTO  v_upd_data.car_license_plate 
                                                , v_upd_data.car_description   
                                                , v_upd_data.tax_refund_yn     
                                                , v_upd_data.car_group         
                                                , v_upd_data.car_fuel          
                                                , v_upd_data.default_dept_code 
                                                , v_upd_data.account_code      
                                                , v_upd_data.quota_per_month  
                                                , v_upd_data.meaning
                                    FROM PTINV_CAR_NONFA_V
                                    WHERE 1=1
                                    AND car_license_plate    = V_CAR ;
                                END;
                            END IF;
                        
                            v_debug := 2;

                                v_upd_data.car_group              := :car_group;
                                v_upd_data.car_fuel               := :car_fuel;
                                v_upd_data.default_dept_code      := :default_dept_code;
                                v_upd_data.account_code           := :account_code;
                                v_upd_data.quota_per_month        := :quota_per_month;           
                                
                            v_debug := 3; 
                                ptinv_update_car_info_pkg.UPD_CAR_NONFA
                                (
                                    P_PARAM             => v_upd_data
                                    ,P_RETURN_STATUS    => :V_RETURN_STATUS
                                    ,P_RETURN_MESSAGE   => :V_RETURN_MSG
                                );
                        END;
        
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $carLicensePlate    = $carNonFa->car_license_plate;
        $carGroup           = $carNonFa->car_group;
        $carFuel            = $carNonFa->car_fuel;
        $defaultDeptCode    = $carNonFa->default_dept_code;
        $accountCode        = $carNonFa->account_code;
        $quotaPerPonth      = $carNonFa->quota_per_month;

        $stmt->bindParam(':car_license_plate',    $carLicensePlate, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':car_group',            $carGroup, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':default_dept_code',    $defaultDeptCode, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':account_code',         $accountCode, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':car_fuel',             $carFuel, PDO::PARAM_STR, 1000);
        $stmt->bindParam(':quota_per_month',      $quotaPerPonth, PDO::PARAM_STR, 1000);

        // OUT
        $stmt->bindParam(':V_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_RETURN_MSG', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
