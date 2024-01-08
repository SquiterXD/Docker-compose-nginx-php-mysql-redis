<?php

namespace App\Repositories\OM\Settings;



class PaymentTermRepository
{
    public function insertData($request, $type, $dataType, $term)
    {
        // dd($request->all());
        if ($type == 'DOMESTIC') {
            $startDate = request()->start_date_active ? parseFromDateTh(request()->start_date_active) : '';
            $endDate   = request()->end_date_active   ? parseFromDateTh(request()->end_date_active)   : '';
        } else {
            $startDate = request()->start_date_active   ? date('Y-M-d', strtotime(request()->start_date_active)) : '';
            $endDate   = request()->end_date_active     ? date('Y-M-d', strtotime(request()->end_date_active))   : '';
        }
       
        $description       = request()->description        ? request()->description        : '';
        $dueDays           = request()->due_days           ? request()->due_days           : '';
        $shipmentCondition = request()->shipment_condition ? request()->shipment_condition : '';


        // dd($request, $type, $dataType, $term);
        // dd($startDate, $endDate, 'ttt', request()->start_date_active, request()->end_date_active);

        if ($term) {
            $termName = $term->term_name;
        } else {
            $termName = $request->name;
        }

        $description = $request->description;
        
        
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug             NUMBER := 2;
                            v_return_flag   varchar2(1) := NULL;
                            
                            v_data_rec  PTRA_TERMS_V%ROWTYPE;
                        BEGIN
                            dbms_output.put_line('------ S T A R T ------------');
                            
                                v_data_rec  := NULL;
                                v_debug := 5;    
                                v_data_rec.term_name             := :term_name;  
                                v_data_rec.description           := :input_description;
                                v_data_rec.start_date_active     := :start_date;
                                v_data_rec.end_date_active       := :end_date;
                                
                                v_data_rec.sales_type            := :sales_type;
                                v_data_rec.due_days              := :due_days;   
                                v_data_rec.shipment_condition    := :shipment_condition;  
                                
                                
                                
                            v_debug := 7;     
                            :v_return_flag    :=  PTOM_WEB_UTILITIES_PKG.create_payment_term (P_DATA_TYPE         => :data_type 
                                                                        ,P_TERMS_REC        => v_data_rec );
                                                
                            dbms_output.put_line(v_debug||' : v_return_flag=' ||v_return_flag);                     
                                                    
                            dbms_output.put_line('------ E N D. ------------');                  
                        exception WHEN no_data_found THEN 
                            dbms_output.put_line(v_debug||'***Error-'||sqlerrm);    
                        END;
                ";


                
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':term_name', $termName, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':input_description', $description, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':start_date', $startDate, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':end_date', $endDate, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':sales_type', $type, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':due_days', $dueDays, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':shipment_condition', $shipmentCondition, \PDO::PARAM_STR, 250);
        $stmt->bindParam(':data_type', $dataType, \PDO::PARAM_STR, 250);


        $stmt->bindParam(':v_return_flag', $result['v_return_flag'], \PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        return $result;
    }
}
