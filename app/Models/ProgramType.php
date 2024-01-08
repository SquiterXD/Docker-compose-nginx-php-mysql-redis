<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class ProgramType extends Model
{
    use HasFactory;
    protected $table = "pt_program_types";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function scopeSearch($q, $search)
    {
        if ($search) {
            if ($search['program_type'] != null) {
                $q->where('program_type_name', 'like', '%'.$search['program_type'].'%');
            }

            if ($search['status'] != null) {
                $q->where('enable_flag', $search['status']);
            }

            // Createion Date
            if ($search['start_date'] != null &&  $search['end_date'] != null) {
                $q->whereRaw("trunc(created_at) BETWEEN TO_DATE('{$search['start_date']}','dd-mm-YYYY') AND TO_DATE('{$search['end_date']}','dd-mm-YYYY')");
            }

            if ($search['start_date'] != null) {
                $q->whereRaw("trunc(created_at) >= TO_DATE('{$search['start_date']}','dd-mm-YYYY')");
            }
        }

        return $q;
    }

    public function submitProgramType($request)
    {
        //v_rec_type.updated_by_id                := {$user->user_id};
        $user   = auth()->user();
        $enable = $request->enable? 'Y': 'N';
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_rec_type      pt_program_types%rowtype;
                        v_status        varchar2(20);
                        v_err_msg       varchar2(2000);
                        begin
                            v_rec_type.program_type_name            := '{$request->name}';
                            v_rec_type.user_program_type_name       := '{$request->user_type}';
                            v_rec_type.description                  := '{$request->description}';
                            v_rec_type.enable_flag                  := '{$enable}';
                            v_rec_type.created_at                   := sysdate;
                            v_rec_type.updated_at                   := sysdate;
                            v_rec_type.created_by_id                := {$user->user_id};
                            v_rec_type.creation_date                := sysdate;
                            v_rec_type.last_update_date             := sysdate;
                            v_rec_type.CREATED_BY                   := -1;
                            v_rec_type.LAST_UPDATED_BY              := -1;
                            v_rec_type.program_type                 := '{$request->program_type}';
                            ptweb_utilities.generate_program_type(p_rec_type   => v_rec_type,
                                                                    p_status    => :v_status,
                                                                    p_error_msg => :v_err_msg);
                            dbms_output.put_line('Status : ' || :v_status);
                            dbms_output.put_line('Error : ' || :v_err_msg);
                        exception
                            when others then
                                v_status:= 'E';
                                v_err_msg:= 'Error : ' || sqlerrm;
                                dbms_output.put_line('Status : ' || :v_status);
                                dbms_output.put_line('Error : ' || :v_err_msg);
                        end;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = false;

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
