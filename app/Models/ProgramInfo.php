<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class ProgramInfo extends Model
{
    use HasFactory;
    protected $table = "pt_programs_info";
    // public $primaryKey = 'program_code';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function userType(){
        return $this->hasOne(ProgramType::class, 'program_type_name', 'program_type_name');
    }

    public function scopeSearch($q, $search)
    {
        if ($search) {
            if ($search['program'] != null) {
                $q->where('program_code', 'like', '%'.$search['program'].'%');
            }

            if ($search['program_type'] != null) {
                $q->where('program_type_name', 'like', '%'.$search['program_type'].'%');
            }

            if ($search['module'] != null) {
                $q->where('module_name', $search['module']);
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

    public function submitProgramInfo($request)
    {
        $user   = auth()->user();
        $enable = $request->enable? 'Y': 'N';
        $insert = $request->insert? 'Y': 'N';
        $update = $request->update? 'Y': 'N';
        $delete = $request->delete? 'Y': 'N';
        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "declare
                        v_rec_type      pt_programs_info%rowtype;
                        v_status        varchar2(20);
                        v_err_msg       varchar2(2000);
                        v_program_code  varchar2(30);
                        begin
                            v_rec_type.program_code             := '{$request->name}';
                            v_rec_type.description              := '{$request->description}';
                            v_rec_type.enable_flag              := '{$enable}';

                            v_rec_type.created_at               := sysdate;
                            v_rec_type.updated_at               := sysdate;
                            v_rec_type.created_by_id            := {$user->user_id};
                            v_rec_type.updated_by_id            := {$user->user_id};
                            v_rec_type.creation_date            := sysdate;
                            v_rec_type.last_update_date         := sysdate;
                            v_rec_type.CREATED_BY               := -1;
                            v_rec_type.LAST_UPDATED_BY          := -1;

                            v_rec_type.program_type_name        := '{$request->program_type}';
                            v_rec_type.schemas_name             := '{$request->schema}';
                            v_rec_type.module_name              := '{$request->module}';

                            v_rec_type.package_name             := null;
                            v_rec_type.image_path               := null;
                            v_rec_type.import_table_name        := null;
                            v_rec_type.input_directory          := null;
                            v_rec_type.archive_directory        := '{$request->archive_directory}';
                            v_rec_type.output_directory         := '{$request->output_directory}';
                            v_rec_type.error_directory          := '{$request->error_directory}';
                            v_rec_type.log_directory            := '{$request->log_directory}';
                            v_rec_type.report_name              := null;

                            v_rec_type.source                   := '{$request->source_type}';
                            v_rec_type.source_name              := '{$request->source_name}';
                            v_rec_type.insert_flag              := '{$insert}';
                            v_rec_type.update_flag              := '{$update}';
                            v_rec_type.delete_flag              := '{$delete}';
                            ptweb_utilities.generate_program(p_rec_type         => v_rec_type,
                                                                p_program_code  => :v_program_code,
                                                                p_status        => :v_status,
                                                                p_error_msg     => :v_err_msg);
                            dbms_output.put_line('Program Code : ' || :v_program_code);
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
        logger($sql);
        $result = false;

        $stmt->bindParam(':v_program_code', $result['program_code'], \PDO::PARAM_STR, 30);
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
    public function scopeOfType($q, $type)
    {
        return $q->where('program_type_name', $type);
    }

    public function scopeOfModule($q, $module)
    {
        return $q->where('module_name', $module);
    }

    public function scopeTypeReport($q)
    {
        return $q->ofType('R1');

    }
    
    public function insertProgramColumn($programCode)
    {
        $lists = [];

            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'LOOKUP_CODE',
                'COLUMN_PROMPT'        => 'LOOKUP_CODE',
                'ENABLE_FLAG'          => 'Y',
                'COLUMN_SEQ_NUM'       => 1,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);

            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'MEANING',
                'COLUMN_PROMPT'        => 'MEANING',
                'ENABLE_FLAG'          => 'Y',
                'COLUMN_SEQ_NUM'       => 2,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);

            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'DESCRIPTION',
                'COLUMN_PROMPT'        => 'DESCRIPTION',
                'ENABLE_FLAG'          => 'Y',
                'COLUMN_SEQ_NUM'       => 3,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);

            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'START_DATE_ACTIVE',
                'COLUMN_PROMPT'        => 'START_DATE_ACTIVE',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 4,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'END_DATE_ACTIVE',
                'COLUMN_PROMPT'        => 'END_DATE_ACTIVE',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 5,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'TAG',
                'COLUMN_PROMPT'        => 'TAG',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 6,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ENABLED_FLAG',
                'COLUMN_PROMPT'        => 'ENABLED_FLAG',
                'ENABLE_FLAG'          => 'Y',
                'COLUMN_SEQ_NUM'       => 7,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE1',
                'COLUMN_PROMPT'        => 'ATTRIBUTE1',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 8,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE2',
                'COLUMN_PROMPT'        => 'ATTRIBUTE2',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 9,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE3',
                'COLUMN_PROMPT'        => 'ATTRIBUTE3',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 10,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE4',
                'COLUMN_PROMPT'        => 'ATTRIBUTE4',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 11,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE5',
                'COLUMN_PROMPT'        => 'ATTRIBUTE5',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 12,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE6',
                'COLUMN_PROMPT'        => 'ATTRIBUTE6',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 13,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE7',
                'COLUMN_PROMPT'        => 'ATTRIBUTE7',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 14,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE8',
                'COLUMN_PROMPT'        => 'ATTRIBUTE8',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 15,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE9',
                'COLUMN_PROMPT'        => 'ATTRIBUTE9',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 16,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE10',
                'COLUMN_PROMPT'        => 'ATTRIBUTE10',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 17,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE11',
                'COLUMN_PROMPT'        => 'ATTRIBUTE11',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 18,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE12',
                'COLUMN_PROMPT'        => 'ATTRIBUTE12',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 19,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE13',
                'COLUMN_PROMPT'        => 'ATTRIBUTE13',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 20,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE14',
                'COLUMN_PROMPT'        => 'ATTRIBUTE14',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 21,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]);
            
            array_push($lists, [
                'PROGRAM_CODE'         => $programCode,
                'COLUMN_NAME'          => 'ATTRIBUTE15',
                'COLUMN_PROMPT'        => 'ATTRIBUTE15',
                'ENABLE_FLAG'          => 'N',
                'COLUMN_SEQ_NUM'       => 22,
                'VIEW_NAME'            => NULL,
                'FLEX_NAME'            => NULL,
                'SQL_TEXT'             => NULL,
                'DESCRIPTION'          => NULL,
                'ATTRIBUTE_CATEGORY'   => NULL,
                'ATTRIBUTE1'           => NULL,
                'ATTRIBUTE2'           => NULL,
                'ATTRIBUTE3'           => NULL,
                'ATTRIBUTE4'           => NULL,
                'ATTRIBUTE5'           => NULL,
                'ATTRIBUTE6'           => NULL,
                'ATTRIBUTE7'           => NULL,
                'ATTRIBUTE8'           => NULL,
                'ATTRIBUTE9'           => NULL,
                'ATTRIBUTE10'          => NULL,
                'ATTRIBUTE11'          => NULL,
                'ATTRIBUTE12'          => NULL,
                'ATTRIBUTE13'          => NULL,
                'ATTRIBUTE14'          => NULL,
                'ATTRIBUTE15'          => NULL,
                'CREATED_BY'           => NULL,
                'CREATION_DATE'        => NULL,
                'LAST_UPDATED_BY'      => NULL,
                'LAST_UPDATE_DATE'     => NULL,
                'REQUIRED_FLAG'        => NULL,
                'SQL_TEXT_DISPLAY'     => NULL,
                'INPUT_TYPE'           => NULL, 
            ]); 
        
        DB::connection('oracle_toat')->table('pt_program_columns_info')->insert($lists);

        return $lists;
    }

    public function scopeSelectFieldTypeReport($q)
    {
        return $q->selectRaw('program_code,
                    description,
                    module_name,
                    program_type_name'
                );
    }
}
