<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_ingredient';
    protected $primaryKey = 'ingredient_id';

    public function ingredientSteps()
    {
        return $this->hasMany(IngredientStep::class, 'ingredient_id', 'ingredient_id');
    }

    public function ingredientItems()
    {
        return $this->hasMany(IngredientItem::class, 'ingredient_id', 'ingredient_id');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\PM\PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id')
                ->where('organization_id', $this->org_id);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\FndUser::class, 'created_by', 'user_id');
    }

    public function machineType()
    {
        return $this->belongsTo(MachineType::class, 'machine', 'lookup_code');
    }

    public function machineGroupF()
    {
        return $this->belongsTo(MachineGroupF::class, 'machine', 'lookup_code');
    }

    public function opmRouting()
    {
        return $this->belongsTo(OpmRoutingV::class, 'wip', 'oprn_class_desc');
    }

    public function routing()
    {
        return $this->belongsTo(OpmRoutingV::class, 'routing_id', 'routing_id');
    }


    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'org_id', 'organization_id');
    }

    public function folmulaTypes()
    {
        return [
            'สูตรใช้จริง',
            'สูตรมาตรฐาน',
            'สูตรทดลอง'
        ];
    }

    public function checkRouting($wipStep)
    {
        $data = $this->ingredientSteps->where('wip_step_id', $wipStep)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function interfaceData($ingredientID, $status)
    {
        // dd('xxxxx', $this->ingredient_id);
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        declare
                            v_status         varchar2(5);
                            v_err_msg        varchar2(2000);
                        begin
                            
                            PTPM_TRANSACTION_PKG.CREATE_RECIPE( P_Ingredient_ID   => :ingredient_ID
                                                                ,P_FLAG     =>  :status_flag
                                                                ,V_MESSAGE  =>  :v_err_msg
                                                                ,V_STATUS   =>  :v_status);
                                                
                                dbms_output.put_line('Status : ' || v_status);
                                dbms_output.put_line('Error : ' || v_err_msg);
                        end;
                    ";
        \Log::info($ingredientID);
        \Log::info($status);
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':ingredient_ID', $ingredientID, \PDO::PARAM_STR);
        $stmt->bindParam(':status_flag', $status, \PDO::PARAM_STR);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }
}
