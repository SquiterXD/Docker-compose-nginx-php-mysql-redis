<?php
namespace App\Models\Example;

use DB;
use PDO;

class UserInterface
{
    public static function success()
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE

                            i_concurr_record      FND_CONCURRENT_REQUESTS%ROWTYPE;
                            o_concurr_record      FND_CONCURRENT_REQUESTS%ROWTYPE;

                            lv_data               varchar2(4000)  :=  NULL;
                            lv_status             varchar2(10)    :=  NULL;
                            lv_msg                varchar2(4000)  :=  NULL;

                        BEGIN
                            i_concurr_record.request_id :=  1059471;

                            PT_CUSTOM.VALIDATE_SUCCESS
                            (
                                I_CON_REC     =>  i_concurr_record
                                ,O_CON_REC    =>  o_concurr_record
                                ,O_DATA       =>  :lv_data
                                ,O_STATUS     =>  :lv_status
                                ,O_MSG        =>  :lv_msg
                            );

                            dbms_output.put_line('o_concurr_record.argument_text = '||o_concurr_record.argument_text);
                            dbms_output.put_line('lv_data = '||lv_data);
                            dbms_output.put_line('lv_status = '||lv_status);
                            dbms_output.put_line('lv_msg = '||lv_msg);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':lv_data', $result['data'], PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':lv_msg', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public static function error()
    {
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE

                            i_concurr_record      FND_CONCURRENT_REQUESTS%ROWTYPE;
                            o_concurr_record      FND_CONCURRENT_REQUESTS%ROWTYPE;

                            lv_data               varchar2(4000)  :=  NULL;
                            lv_status             varchar2(10)    :=  NULL;
                            lv_msg                varchar2(4000)  :=  NULL;

                        BEGIN
                            i_concurr_record.request_id :=  1059471;

                            PT_CUSTOM.VALIDATE_ERROR
                            (
                                I_CON_REC     =>  i_concurr_record
                                ,O_CON_REC    =>  o_concurr_record
                                ,O_DATA       =>  :lv_data
                                ,O_STATUS     =>  :lv_status
                                ,O_MSG        =>  :lv_msg
                            );

                            dbms_output.put_line('o_concurr_record.argument_text = '||o_concurr_record.argument_text);
                            dbms_output.put_line('lv_data = '||lv_data);
                            dbms_output.put_line('lv_status = '||lv_status);
                            dbms_output.put_line('lv_msg = '||lv_msg);
                        END;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':lv_data', $result['data'], PDO::PARAM_STR, 4000);
        $stmt->bindParam(':lv_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':lv_msg', $result['message'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }

    public function testView() {
        // $db     =   DB::connection('oracle')->getPdo();
        // $sql = "
        //         DECLARE

        //         lv_data          varchar2(4000)  :=  NULL;
        //             v_vender_name   varchar(240);

        //         begin

        //             select VENDOR_NAME into v_vender_name
        //             from PTIR_VENDOR_V
        //             where rownum = 1;

        //             dbms_output.put_line('lv_data = '||v_vender_name);
        //             END;
        //            ";
        // $stmt = $db->prepare($sql);
        // $stmt->execute();
        $db = DB::connection('oracle')->select("select VENDOR_NAME from PTIR_VENDOR_V where rownum = 1");

        return $db;
    }
}
