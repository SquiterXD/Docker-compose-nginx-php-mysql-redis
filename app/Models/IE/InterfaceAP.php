<?php

namespace App\Models\IE;

use Carbon\Carbon;
use DB;
use PDO;

class InterfaceAP
{
	public static function getInvoiceApprovalStatus($orgId,$invoiceNum)
    {
		$result = DB::select(
            DB::raw("select apps.ap_invoices_pkg.get_approval_status@web_to_erp(
            					ai.invoice_id,
								ai.invoice_amount,
								ai.payment_status_flag,
								ai.invoice_type_lookup_code ) as status
					from 	apps.ap_invoices_all@web_to_erp ai 
					where 	org_id = :orgId 
					and 	invoice_num = :invoiceNum"),
        [
        	'orgId' => $orgId,
            'invoiceNum' => $invoiceNum
        ]);

		return $result;
    }

    public static function getBudgetByAccount($orgId, $concatenatedSegments, $amount = 0, $date = null)
    {
        $amount_type = 'YTDE';
        $period = $date ? Carbon::parse($date)->format('M-y') : date('M-y');

    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            v_msg_data              VARCHAR2 (4000) := NULL;
                            v_msg_status            VARCHAR2 (4000) := NULL;
                        
                            v_bedget_amt            NUMBER  :=0;
                            v_encumbrance_amt       NUMBER  :=0;
                            v_actual_amt            NUMBER  :=0;
                            v_fund_available        NUMBER  :=0;
                            v_template_id           NUMBER  :=0;
                        BEGIN
                        
                        PTIE_WEB_INF_APINVOICE_PKG.IS_FUND_AVAILABLE(
                            I_ORG_ID            =>  :org_id
                            , I_GL_ACCOUNT      =>  :concatenated_segments
                            , I_AMOUNT          =>  :amount
                            , I_PERIOD_NAME     =>  :period
                            , I_AMOUNT_TYPE     =>  :amount_type
                            , o_bedget_amt      =>  :v_bedget_amt
                            , o_encumbrance_amt =>  :v_encumbrance_amt
                            , o_actual_amt      =>  :v_actual_amt
                            , o_fund_available  =>  :v_fund_available
                            , o_result          =>  :v_msg_status
                            , o_msg             =>  :v_msg_data
                            , o_template_id     =>  :v_template_id
                            );
                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $result = [];
            $stmt->bindParam(':org_id', $orgId, PDO::PARAM_STR);
            $stmt->bindParam(':concatenated_segments', $concatenatedSegments, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':period', $period, PDO::PARAM_STR);
            $stmt->bindParam(':amount_type', $amount_type, PDO::PARAM_STR);

            $stmt->bindParam(':v_bedget_amt',$result['budget_amount'], PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_encumbrance_amt', $result['encumbrance_amount'], \PDO::PARAM_STR, 50);
            $stmt->bindParam(':v_actual_amt', $result['actual_amount'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_fund_available',$result['fund_available'], PDO::PARAM_STR, 4000);
            $stmt->bindParam(':v_template_id',$result['template_id'], PDO::PARAM_STR, 50);
            $stmt->bindParam(':v_msg_status', $result['status'], \PDO::PARAM_STR, 50);
            $stmt->bindParam(':v_msg_data', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }
}
