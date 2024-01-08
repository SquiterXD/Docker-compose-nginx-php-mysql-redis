<?php

namespace App\Repositories;

use App\Models\Lookup\ValueSetup;
use App\Models\OM\Settings\ThailandTerritory;
use App\Models\Lookup\Program;
use App\Models\EAM\AssetV;
use App\Models\Lookup\PtpmMachineRelationLookup;
use App\Models\QM\BomDepartments;

class LookUpRepository
{
    public function getSeqNo(Type $var = null)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql = "
                    DECLARE
                    v_seq_no        NUMBER :=0;
                    BEGIN
                        SELECT PTWEB_LOOKUP_VALUE_SETUP_S.nextval 
                            INTO :v_seq_no
                        FROM dual;
                    
                    END;
                ";

        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_seq_no', $result['v_seq_no'], \PDO::PARAM_STR, 1000);
        $stmt->execute();
        \Log::info($result);
        return $result['v_seq_no'];
    }
    public function insertData($request, $dataType, $program)
    {
        $user              = auth()->user();
        $orgCode           = $user->organization ? $user->organization->organization_code : '';

        $seq               = $this->getSeqNo();
        $enabledFlag       = $request->ENABLED_FLAG       ? 'Y' : 'N';
        // $lookupCode        = $request->LOOKUP_CODE        ? $request->LOOKUP_CODE : $seq;
        $meaning           = $request->MEANING            ? $request->MEANING     : $seq;

        // 
        if ($program->program_code == 'PPS0001') {
            $lookupCode        = $meaning;
        } else {
            $lookupCode        = $request->LOOKUP_CODE        ? $request->LOOKUP_CODE : $seq;
        }

        $checkEnabled = $program->programColumns->where('column_name', 'ENABLED_FLAG');
        
        if ($checkEnabled->isEmpty()) {
            $enabledFlag = 'Y';
        }

        if (request()->date_type) {
            $startDate = $request->START_DATE_ACTIVE  ? parseFromDateTh($request->START_DATE_ACTIVE) : '';
            $endDate   = $request->END_DATE_ACTIVE    ? parseFromDateTh($request->END_DATE_ACTIVE) : '';
        } else {
            $startDate = $request->START_DATE_ACTIVE  ? date('Y-M-d', strtotime($request->START_DATE_ACTIVE)) : '';
            $endDate   = $request->END_DATE_ACTIVE    ? date('Y-M-d', strtotime($request->END_DATE_ACTIVE)) : '';
        }


        // if ($program->program_code == 'OMS0001' || $program->program_code == 'OMS0004' || $program->program_code == 'OMS0006' || 
        //     $program->program_code == 'OMS0008' || $program->program_code == 'OMS0009' || $program->program_code == 'OMS0034' || 
        //     $program->program_code == 'OMS0035') {

        //     $startDate = $request->START_DATE_ACTIVE  ? parseFromDateTh($request->START_DATE_ACTIVE) : '';
        //     $endDate   = $request->END_DATE_ACTIVE    ? parseFromDateTh($request->END_DATE_ACTIVE) : '';

        // } else {

        //     $startDate = $request->START_DATE_ACTIVE  ? date('Y-M-d', strtotime($request->START_DATE_ACTIVE)) : '';
        //     $endDate   = $request->END_DATE_ACTIVE    ? date('Y-M-d', strtotime($request->END_DATE_ACTIVE)) : '';

        // }
        
        if (!$request->START_DATE_ACTIVE && $program->module_name == 'PM') {
            $startDate = date('Y-M-d');
        }
        
        $attributeCategory = $program->attribute_category ?? '';

        if ($program->program_code == 'OMS0008' || $program->program_code =='OMS0022' || $program->program_code =='OMS0038' || $program->program_code == 'IRS0004') {
            $tag  = $request->TAG ? 'Y' : 'N';
        } elseif ($program->program_code =='OMS0036') {
            $territory = ThailandTerritory::where('province_thai', $request->DESCRIPTION)->distinct()->first();
            $tag       = $territory->province_id;
        } else {
            $tag  = $request->TAG;
        }
        
        if ($program->program_code == 'PPS0002') {
            $attribute2  = $request->ATTRIBUTE2 ? 'Y' : 'N';
        } else {
            $attribute2  = $request->ATTRIBUTE2;
        }

        if ($program->program_code == 'PMS0045') {
            $description = $request->MEANING;
        } else {
            $description = $request->DESCRIPTION;
        }

        if ($program->program_code =='PMS0040') {
            $lookup = ValueSetup::where('lookup_type', $program->source_name)
                                ->whereNotnull('attribute1')
                                ->where('tag', $tag)
                                ->orderBy('attribute1', 'desc')
                                ->first();
            $attribute1 = $lookup ? $lookup->attribute1 + 1 : 1;

        } elseif ($program->program_code =='PPS0002') {
            $attribute1 = $lookupCode;

        } else {
            $attribute1  = $request->ATTRIBUTE1;
        }

        if ($program->program_code == 'PMS0012' || $program->program_code == 'PMS0013') {
            $attribute3 = $user->department_code;
            $attribute4 = $orgCode;
            
        } else {
            $attribute3 = $request->ATTRIBUTE3;
            $attribute4 = $request->ATTRIBUTE4;
        }

        if($program->program_code == 'QMS0021'){
            $enabledFlag = $request->ENABLED_FLAG == "true" ? 'Y' : 'N';
            $assetNumber = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('asset_number');
            $description = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('asset_description');
            $attributeCategory = $program->source_name;
            $departmentCode = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('owning_department');
            $meaning = $assetNumber.':'.$seq;
            $attribute1 = BomDepartments::where('department_code', $departmentCode)->value('department_id');
            $attribute2 = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('resource_code');
            $attribute3 = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('machine_type');
            $attribute4 = $request->ATTRIBUTE4;
            $request->ATTRIBUTE13 = AssetV::where('asset_number', $assetNumber)->value('asset_id');
        }

        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_message               varchar2(2000);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;
                            v_tran_id          varchar2(2000);
                            p_message               varchar2(2000);

                            cursor data(p_tran_id number) is
                            select interface_msg 
                            from PTFND_LOOKUP_VALUE_T
                            where tran_id = p_tran_id;

                        BEGIN
                            dbms_output.put_line('------  S T A R T ------');

                            v_lookup_rec  := NULL;
                            v_lookup_rec.INTERFACE_NAME         := 'WEB_CREATE_LOOKUP';
                            v_lookup_rec.DATA_TYPE              := '".$dataType."';
                            v_lookup_rec.LOOKUP_TYPE            := '".$program->source_name."';  
                            v_lookup_rec.LOOKUP_CODE            := '".$lookupCode."';  
                            v_lookup_rec.MEANING                := '".$meaning."'; 
                            v_lookup_rec.DESCRIPTION            := '".$description."'; 
                            v_lookup_rec.ENABLED_FLAG           := '".$enabledFlag."'; 
                            v_lookup_rec.TAG                    := '".$tag."';
                            v_lookup_rec.START_DATE_ACTIVE      := '".$startDate."';       
                            v_lookup_rec.END_DATE_ACTIVE        := '".$endDate."'; 
                            v_lookup_rec.ATTRIBUTE1             := '".$attribute1."';
                            v_lookup_rec.ATTRIBUTE2             := '".$attribute2."';
                            v_lookup_rec.ATTRIBUTE3             := '".$attribute3."';
                            v_lookup_rec.ATTRIBUTE4             := '".$attribute4."';
                            v_lookup_rec.ATTRIBUTE5             := '".$request->ATTRIBUTE5."';
                            v_lookup_rec.ATTRIBUTE6             := '".$request->ATTRIBUTE6."';
                            v_lookup_rec.ATTRIBUTE7             := '".$request->ATTRIBUTE7."';
                            v_lookup_rec.ATTRIBUTE8             := '".$request->ATTRIBUTE8."';
                            v_lookup_rec.ATTRIBUTE9             := '".$request->ATTRIBUTE9."';
                            v_lookup_rec.ATTRIBUTE10            := '".$request->ATTRIBUTE10."';
                            v_lookup_rec.ATTRIBUTE11            := '".$request->ATTRIBUTE11."';
                            v_lookup_rec.ATTRIBUTE12            := '".$request->ATTRIBUTE12."';
                            v_lookup_rec.ATTRIBUTE13            := '".$request->ATTRIBUTE13."';
                            v_lookup_rec.ATTRIBUTE14            := '".$request->ATTRIBUTE14."';
                            v_lookup_rec.ATTRIBUTE15            := '".$request->ATTRIBUTE15."';
                            v_lookup_rec.ATTRIBUTE_CATEGORY     := '".$attributeCategory."';
                            v_lookup_rec.RETURN_STATUS          := NULL;
                            v_lookup_rec.RETURN_MESSAGE         := NULL;
                            v_lookup_rec.TRAN_ID                := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;
                            :v_message := v_lookup_rec.return_message;
                            :v_tran_id   := v_lookup_rec.tran_id;


                            dbms_output.put_line('Output : interface_name  = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output : return_status   = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output : return_message  = '|| v_lookup_rec.return_message );
                            dbms_output.put_line('Output : return_message  = '|| v_lookup_rec.return_message );

                            dbms_output.put_line('Output : tran_id  = '|| v_lookup_rec.tran_id );

                            if v_lookup_rec.return_status not in ('S','C') then

                                for rec in data(v_lookup_rec.TRAN_ID) loop          
                                        dbms_output.put_line('Output :  return_message = '||rec.interface_msg ); 

                                        :p_message := rec.interface_msg;

                                end loop;
                                
                            end if;

                            dbms_output.put_line('------  E N D ------');
                    
                    END;
                ";
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':p_message', $result['p_message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_tran_id', $result['tran_id'], \PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        return $result;
    }

    public function dataDel($request, $dataType, $lookupType)
    {

        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;

                        BEGIN
                            dbms_output.put_line('------  S T A R T ------');

                            v_lookup_rec  := NULL;
                            v_lookup_rec.INTERFACE_NAME        := 'WEB_CREATE_LOOKUP';
                            v_lookup_rec.DATA_TYPE             := '".$dataType."';
                            v_lookup_rec.LOOKUP_TYPE           := '".$lookupType."';  
                            v_lookup_rec.LOOKUP_CODE           := '".$request->lookup_code."';  
                            v_lookup_rec.MEANING               := NULL; 
                            v_lookup_rec.DESCRIPTION           := NULL; 
                            v_lookup_rec.ENABLED_FLAG          := NULL; 
                            v_lookup_rec.START_DATE_ACTIVE     := NULL;       
                            v_lookup_rec.END_DATE_ACTIVE       := NULL; 
                            v_lookup_rec.ATTRIBUTE1            := NULL;
                            v_lookup_rec.ATTRIBUTE2            := NULL;
                            v_lookup_rec.RETURN_STATUS         := NULL;
                            v_lookup_rec.RETURN_MESSAGE        := NULL;
                            v_lookup_rec.TRAN_ID                := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;


                            dbms_output.put_line('Output : interface_name = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output :  return_status = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output :  message       = '|| v_lookup_rec.RETURN_MESSAGE );

                            dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        // $result = false;
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }

    public function dataUpdate($request, $dataType, $program, $lookup)
    {
        // dd($request, $dataType, $program, $lookup);
        $user              = auth()->user();
        $orgCode           = $user->organization ? $user->organization->organization_code : '';

        $enabledFlag = $request->ENABLED_FLAG ? 'Y' : 'N';

        if ($request->MEANING) {
            $meaning  = $request->MEANING;
        } else {
            if ($lookup->meaning) {
                $meaning  = $lookup->meaning;
            } else {
                $meaning  = $seq;
            }
            
        }

        // if (request()->date_type) {

        //     $startDate = $request->START_DATE_ACTIVE  ? parseFromDateTh($request->START_DATE_ACTIVE) : '';
        //     $endDate   = $request->END_DATE_ACTIVE    ? parseFromDateTh($request->END_DATE_ACTIVE) : '';

        // } else {

        //     $startDate = $request->START_DATE_ACTIVE  ? date('Y-M-d', strtotime($request->START_DATE_ACTIVE)) : '';
        //     $endDate   = $request->END_DATE_ACTIVE    ? date('Y-M-d', strtotime($request->END_DATE_ACTIVE)) : '';

        // }

        if (checkColumnEnable($program->program_code, $lookup, 'START_DATE_ACTIVE')) {
            $startDate = $lookup->start_date_active;
        } else {
            if (request()->date_type) {
                $startDate = $request->START_DATE_ACTIVE  ? parseFromDateTh($request->START_DATE_ACTIVE) : '';
            }else {
                $startDate = $request->START_DATE_ACTIVE  ? date('Y-M-d', strtotime($request->START_DATE_ACTIVE)) : '';
            }
        }
        
        if (checkColumnEnable($program->program_code, $lookup, 'END_DATE_ACTIVE')) {
            $endDate = $lookup->end_date_active;
        } else {
            if (request()->date_type) {
                $endDate = $request->END_DATE_ACTIVE  ? parseFromDateTh($request->END_DATE_ACTIVE) : '';
            }else {
                $endDate = $request->END_DATE_ACTIVE  ? date('Y-M-d', strtotime($request->END_DATE_ACTIVE)) : '';
            }
        }

        if (!$request->START_DATE_ACTIVE && $program->module_name == 'PM') {
            $startDate = $lookup->start_date_active;
        }

        $checkEnabled = $program->programColumns->where('column_name', 'ENABLED_FLAG');

        if ($checkEnabled->isEmpty()) {
            $enabledFlag = $lookup->enabled_flag;
        }

        $attributeCategory = $program->attribute_category ?? '';

        if ($program->program_code == 'OMS0008' || $program->program_code =='OMS0022' || $program->program_code =='OMS0038' || $program->program_code == 'IRS0004') {
            $tag  = $request->TAG ? 'Y' : 'N';
        } elseif ($program->program_code =='OMS0036') {
            $territory = ThailandTerritory::where('province_thai', $request->DESCRIPTION)->distinct()->first();
            $tag       = $territory->province_id;
        } else {
            if (checkColumnEnable($program->program_code, $lookup, 'TAG')) {
                $tag  = $lookup->tag;
            } else {
                $tag  = $request->TAG;
            }            
        }

        if ($program->program_code == 'PPS0002') {
            $attribute2  = $request->ATTRIBUTE2 ? 'Y' : 'N';         
        }elseif ($program->program_code == 'PMS0040') {
            // if ($orgCode == 'M06') {
                if (checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE2')) {
                    $attribute2  = $lookup->attribute2;
                } else {
                    $attribute2  = $request->ATTRIBUTE2;
                } 
            // } else {
            //     $attribute2  = $lookup->attribute2;
            // }
        } else {
            if (checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE2')) {
                $attribute2  = $lookup->attribute2;
            } else {
                $attribute2  = $request->ATTRIBUTE2;
            } 
        }
        
        if ($program->program_code == 'PMS0045') {
            $description = $request->MEANING;
        } else {
            
            if (checkColumnEnable($program->program_code, $lookup, 'DESCRIPTION')) {
                $description  = $lookup->description;
            } else {
                $description = $request->DESCRIPTION;
            } 
        }

        if ($program->module_name == 'IR') {
            if ($enabledFlag == 'N' && !$endDate) {
                $endDate = date('Y-M-d');
            }
        }

        if($program->program_code == 'QMS0021'){
            $enabledFlag = $request->ENABLED_FLAG == "true" ? 'Y' : 'N';
            $assetNumber = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('asset_number');
            $description = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('asset_description');
            $attributeCategory = $program->source_name;
            $departmentCode = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('owning_department');
            $attribute1 = BomDepartments::where('department_code', $departmentCode)->value('department_id');
            $attribute2 = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('resource_code');
            $attribute3 = AssetV::where('asset_id', $request->ATTRIBUTE2)->value('machine_type');
            $attribute4 = $request->ATTRIBUTE4;
            $request->ATTRIBUTE13 = AssetV::where('asset_number', $assetNumber)->value('asset_id');
            $attribute2 = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE1')  ? $lookup->attribute2  : $request->ATTRIBUTE2;
        }

        $attribute1   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE1')  ? $lookup->attribute1  : $request->ATTRIBUTE1;
        $attribute3   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE3')  ? $lookup->attribute3  : $request->ATTRIBUTE3;
        $attribute4   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE4')  ? $lookup->attribute4  : $request->ATTRIBUTE4;
        $attribute5   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE5')  ? $lookup->attribute5  : $request->ATTRIBUTE5;
        $attribute6   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE6')  ? $lookup->attribute6  : $request->ATTRIBUTE6;
        $attribute7   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE7')  ? $lookup->attribute7  : $request->ATTRIBUTE7;
        $attribute8   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE8')  ? $lookup->attribute8  : $request->ATTRIBUTE8;
        $attribute9   = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE9')  ? $lookup->attribute9  : $request->ATTRIBUTE9;
        $attribute10  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE10') ? $lookup->attribute10 : $request->ATTRIBUTE10;
        $attribute11  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE11') ? $lookup->attribute11 : $request->ATTRIBUTE11;
        $attribute12  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE12') ? $lookup->attribute12 : $request->ATTRIBUTE12;
        $attribute13  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE13') ? $lookup->attribute13 : $request->ATTRIBUTE13;
        $attribute14  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE14') ? $lookup->attribute14 : $request->ATTRIBUTE14;
        $attribute15  = checkColumnEnable($program->program_code, $lookup, 'ATTRIBUTE15') ? $lookup->attribute15 : $request->ATTRIBUTE15;
        
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_message               varchar2(2000);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;

                            v_tran_id               varchar2(2000);
                            p_message               varchar2(2000);

                            cursor data(p_tran_id number) is
                            select interface_msg 
                            from PTFND_LOOKUP_VALUE_T
                            where tran_id = p_tran_id;

                        BEGIN
                            dbms_output.put_line('------  S T A R T ------');

                            v_lookup_rec  := NULL;
                            v_lookup_rec.INTERFACE_NAME         := 'WEB_CREATE_LOOKUP';
                            v_lookup_rec.DATA_TYPE              := '".$dataType."';
                            v_lookup_rec.LOOKUP_TYPE            := '".$program->source_name."';  
                            v_lookup_rec.LOOKUP_CODE            := '".$lookup->lookup_code."';  
                            v_lookup_rec.MEANING                := '".$meaning."'; 
                            v_lookup_rec.DESCRIPTION            := '".$description."'; 
                            v_lookup_rec.ENABLED_FLAG           := '".$enabledFlag."'; 
                            v_lookup_rec.TAG                    := '".$tag."';
                            v_lookup_rec.START_DATE_ACTIVE      := '".$startDate."';       
                            v_lookup_rec.END_DATE_ACTIVE        := '".$endDate."'; 
                            v_lookup_rec.ATTRIBUTE1             := '".$attribute1."';
                            v_lookup_rec.ATTRIBUTE2             := '".$attribute2."';
                            v_lookup_rec.ATTRIBUTE3             := '".$attribute3."';
                            v_lookup_rec.ATTRIBUTE4             := '".$attribute4."';
                            v_lookup_rec.ATTRIBUTE5             := '".$attribute5."';
                            v_lookup_rec.ATTRIBUTE6             := '".$attribute6."';
                            v_lookup_rec.ATTRIBUTE7             := '".$attribute7."';
                            v_lookup_rec.ATTRIBUTE8             := '".$attribute8."';
                            v_lookup_rec.ATTRIBUTE9             := '".$attribute9."';
                            v_lookup_rec.ATTRIBUTE10            := '".$attribute10."';
                            v_lookup_rec.ATTRIBUTE11            := '".$attribute11."';
                            v_lookup_rec.ATTRIBUTE12            := '".$attribute12."';
                            v_lookup_rec.ATTRIBUTE13            := '".$attribute13."';
                            v_lookup_rec.ATTRIBUTE14            := '".$attribute14."';
                            v_lookup_rec.ATTRIBUTE15            := '".$attribute15."';
                            v_lookup_rec.ATTRIBUTE_CATEGORY     := '".$attributeCategory."';
                            v_lookup_rec.RETURN_STATUS          := NULL;
                            v_lookup_rec.RETURN_MESSAGE         := NULL;
                            v_lookup_rec.TRAN_ID                := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;
                            :v_message := v_lookup_rec.return_message;
                            :v_tran_id := v_lookup_rec.tran_id;


                            dbms_output.put_line('Output : interface_name  = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output : return_status   = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output : return_message  = '|| v_lookup_rec.return_message );

                            dbms_output.put_line('Output : tran_id  = '|| v_lookup_rec.tran_id );

                            if v_lookup_rec.return_status not in ('S','C') then

                                for rec in data(v_lookup_rec.TRAN_ID) loop          
                                        dbms_output.put_line('Output :  return_message = '||rec.interface_msg ); 

                                        :p_message := rec.interface_msg;

                                end loop;
                                
                            end if;

                            dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_tran_id', $result['tran_id'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':p_message', $result['p_message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }

    public function validateData($request, $lookup = false)
    {
        $user        = auth()->user();
        $userOrgCode = $user->organization ? $user->organization->organization_code : '';

        $result = [];
        $program =  Program::where('program_code', $request->programCode)->first();
        $programColumns = $program->programColumns;

        if ($request->programCode === 'PPS0009') {
            $text = $programColumns->where('column_name', 'ATTRIBUTE1')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }

            $attr2Text = $programColumns->where('column_name', 'ATTRIBUTE2')->first()->column_prompt;
            $attr3Text = $programColumns->where('column_name', 'ATTRIBUTE3')->first()->column_prompt;
            // คงคลังสูงกว่า (วัน) > คงคลังต่ำกว่า (วัน)
            if ($request->ATTRIBUTE2 > $request->ATTRIBUTE3) {
                $msg = "$attr3Text ต้องมีค่ามากกว่า $attr2Text";
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
            }
        }

        if ($request->programCode === 'PMS0013') {

            if ($request->TAG) {
                $tagText = $programColumns->where('column_name', 'TAG')->first()->column_prompt;

                $msg = "ทำการเพิ่มข้อมูล{$tagText} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
                if ($lookup) {
                    $checkDuplicateTag = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('lookup_code', '!=', $lookup->lookup_code)
                                    ->where('tag', $request->TAG)
                                    ->where('attribute4', $lookup->attribute4)
                                    ->first();
                } else {
                    // dd('11');
                    $checkDuplicateTag = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('tag', $request->TAG)
                                    ->where('attribute4', $userOrgCode)
                                    ->first();
                }

                if ($checkDuplicateTag) {
                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            if ($request->ATTRIBUTE1) {
                $attr1Text = $programColumns->where('column_name', 'ATTRIBUTE2')->first()->column_prompt;
                $msg = "ทำการเพิ่มข้อมูล{$attr1Text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
                if ($lookup) {
                    $checkDuplicateAttribute = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('lookup_code', '!=', $lookup->lookup_code)
                                    ->where('attribute1', $request->ATTRIBUTE1)
                                    ->where('attribute4', $lookup->attribute4)
                                    ->first();
                    // $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                } else {
                    // dd('11');
                    $checkDuplicateAttribute = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('attribute1', $request->ATTRIBUTE1)
                                    ->where('attribute4', $userOrgCode)
                                    ->first();
                    // $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                }

                if ($checkDuplicateAttribute) {
                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
        }

        if ($request->programCode === 'PPS0001') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('meaning', $request->MEANING)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('meaning', $request->MEANING)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'PPS0002') {

            // dd('zz', !$request->MEANING, request()->all());
            $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('lookup_code', $request->LOOKUP_CODE)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', $request->LOOKUP_CODE)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }

            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            if (!$request->MEANING) {
                $msg = "ทำการเพิ่ม/แก้ไขข้อมูลไม่สำเร็จ เนื่องจากไม่ได้ระบุข้อมูล {$text}";
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'PPS0008') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('meaning', $request->MEANING)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('meaning', $request->MEANING)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }

            $text = $programColumns->where('column_name', 'ATTRIBUTE1')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('attribute1', $request->ATTRIBUTE1)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'PMS0018') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('meaning', $request->MEANING)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('meaning', $request->MEANING)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'PMS0041') {
            $text = $programColumns->where('column_name', 'DESCRIPTION')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('description', $request->DESCRIPTION)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('description', $request->DESCRIPTION)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'QMS0001') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('meaning', $request->MEANING)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('meaning', $request->MEANING)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'QMS0001' || $request->programCode === 'QMS0003' || $request->programCode === 'QMS0004' || $request->programCode === 'QMS0002' || $request->programCode === 'QMS0019') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('lookup_code', '!=', $lookup->lookup_code)
                                ->where('meaning', $request->MEANING)
                                ->first();
            } else {
                $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('meaning', $request->MEANING)
                                ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }

        if ($request->programCode === 'PMS0047') {

            if ($request->LOOKUP_CODE) {
                $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
                if (!$lookup) {
                    $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('lookup_code', $request->LOOKUP_CODE)
                                    ->first();
                } 

                if ($isDuplicate) {
                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }

            if ($request->MEANING) {
                $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
                if ($lookup) {
                    $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('lookup_code', '!=', $lookup->lookup_code)
                                    ->where('meaning', $request->MEANING)
                                    ->first();
                } else {
                    $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                    ->where('meaning', $request->MEANING)
                                    ->first();
                }

                if ($isDuplicate) {
                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        if ($request->programCode === 'PDS0004') {
            $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
            $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            if ($lookup) {
                $data = strtoupper($request->MEANING);

                $isDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("UPPER(meaning) like '{$data}'")
                                ->first();

                // $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                //                 ->where('lookup_code', '!=', $lookup->lookup_code)
                //                 ->where('meaning', $request->MEANING)
                //                 ->first();
            } else {
                $data = strtoupper($request->MEANING);

                $isDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("UPPER(meaning) like '{$data}'")
                                ->first();

                // $isDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                //                 ->where('meaning', $request->MEANING)
                //                 ->first();
            }

            if ($isDuplicate) {
                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;
            }
        }
        
        if ($request->programCode === 'PDS0005') {

            // if ($request->LOOKUP_CODE) {
            //     $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
            //     $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
            //     if (!$lookup) {
            //         $data = strtoupper($request->LOOKUP_CODE);

            //         $isDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
            //                         ->whereRaw("UPPER(lookup_code) like '{$data}'")
            //                         ->first();
            //     } 

            //     if ($isDuplicate) {
            //         $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
            //         return $result;
            //     }
            // }

            $isCodeDuplicate = '';
            $isMeaningDuplicate = '';

            if ($request->LOOKUP_CODE) {
                if (!$lookup) {
                    // $isCodeDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                    //                 ->where('lookup_code', $request->LOOKUP_CODE)
                    //                 ->first();

                    $data = strtoupper($request->LOOKUP_CODE);

                    $isCodeDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code = '{$data}'")
                                ->first();
                } 
            }

            if ($request->MEANING) {
                if ($lookup) {

                    $data = strtoupper($request->MEANING);

                    // $isMeaningDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                    //                 ->where('lookup_code', '!=', $lookup->lookup_code)
                    //                 ->where('meaning', $request->MEANING)
                    //                 ->first();

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {
                    // $isMeaningDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                    //                 ->where('meaning', $request->MEANING)
                    //                 ->first();

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(meaning) like '{$data}'")
                                    ->first();
                }
            }

            if ($isCodeDuplicate && $isMeaningDuplicate) {
                $code = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;

                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$code} และ {$meaning} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;

            } else {
                if ($isCodeDuplicate) {
                    $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }

                if ($isMeaningDuplicate) {
                    $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        if ($request->programCode === 'IRS0001' || $request->programCode === 'IRS0002' || $request->programCode === 'IRS0003' || 
            $request->programCode === 'IRS0004' || $request->programCode === 'IRS0005' || $request->programCode === 'IRS0006' || 
            $request->programCode === 'IRS0007' || $request->programCode === 'IRS0008' || $request->programCode === 'IRS0009' || 
            $request->programCode === 'IRS0010' || $request->programCode === 'IRS0011' || $request->programCode === 'IRS0012') {

                $isCodeDuplicate = '';
                $isMeaningDuplicate = '';

                if ($request->LOOKUP_CODE) {
                    // $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                    // $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";
                    if (!$lookup) {
                        $isCodeDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                        ->where('lookup_code', $request->LOOKUP_CODE)
                                        ->first();
                    } 
    
                    // if ($isDuplicate) {
                    //     $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    //     return $result;
                    // }
                }
    
                if ($request->MEANING) {

                    // $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    // $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    if ($lookup) {
                        $isMeaningDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                        ->where('lookup_code', '!=', $lookup->lookup_code)
                                        ->where('meaning', $request->MEANING)
                                        ->first();
                    } else {
                        $isMeaningDuplicate = ValueSetup::where('lookup_type', $program->source_name)
                                        ->where('meaning', $request->MEANING)
                                        ->first();
                    }

                    // if ($isDuplicate) {
                    //     $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    //     return $result;
                    // }
                }

                if ($isCodeDuplicate && $isMeaningDuplicate) {
                    $code = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                    $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;

                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$code} และ {$meaning} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;

                } else {
                    if ($isCodeDuplicate) {
                        $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                        $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                        $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                        return $result;
                    }

                    if ($isMeaningDuplicate) {
                        $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                        $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                        $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                        return $result;
                    }
                }
        }

        if ($request->programCode === 'PDS0001') {
            if ($request->MEANING) {
                $data = strtoupper($request->MEANING);
                $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                $msg  = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                if ($lookup) {
                    $isDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {
                    $isDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                }

                if ($isDuplicate) {
                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
        }

        if ($request->programCode === 'PDS0003') {
            $isCodeDuplicate = '';
            $isMeaningDuplicate = '';

            if ($request->LOOKUP_CODE) {
                if (!$lookup) {

                    $data = strtoupper($request->LOOKUP_CODE);

                    $isCodeDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code = '{$data}'")
                                ->first();
                } 
            }

            if ($request->MEANING) {
                if ($lookup) {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(meaning) like '{$data}'")
                                    ->first();
                }
            }

            if ($isCodeDuplicate && $isMeaningDuplicate) {
                $code = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;

                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$code} และ {$meaning} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;

            } else {
                if ($isCodeDuplicate) {
                    $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }

                if ($isMeaningDuplicate) {
                    $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        if ($request->programCode === 'PMS0040') {
            $isMeaningDuplicate = '';
            $isDescriptionDuplicate = '';

            if ($request->MEANING) {
                if ($lookup) {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(meaning) like '{$data}'")
                                    ->first();
                }
            }

            if ($request->DESCRIPTION) {
                if ($lookup) {

                    $data = strtoupper($request->DESCRIPTION);

                    $isDescriptionDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("description = '{$data}'")
                                ->whereRaw("tag = '{$lookup->tag}'")
                                ->first();
                } else {

                    $data = strtoupper($request->DESCRIPTION);

                    $isDescriptionDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(description) like '{$data}'")
                                    ->whereRaw("tag = '{$user->organization_id}'")
                                    ->first();
                }
                
            }

            if ($isMeaningDuplicate && $isDescriptionDuplicate) {
                $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                $description = $programColumns->where('column_name', 'DESCRIPTION')->first()->column_prompt;

                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$meaning} และ {$description} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;

            } else {
                if ($isMeaningDuplicate) {
                    $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }

                if ($isDescriptionDuplicate) {
                    $text = $programColumns->where('column_name', 'DESCRIPTION')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        if ($request->programCode === 'PDS0008') {
            $isMeaningDuplicate = '';
            $isDescriptionDuplicate = '';

            if ($request->MEANING) {
                if ($lookup) {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(meaning) like '{$data}'")
                                    ->first();
                }
            }

            if ($request->DESCRIPTION) {
                if ($lookup) {

                    $data = strtoupper($request->DESCRIPTION);

                    $isDescriptionDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("description = '{$data}'")
                                ->first();
                } else {

                    $data = strtoupper($request->DESCRIPTION);

                    $isDescriptionDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(description) like '{$data}'")
                                    ->first();
                }
                
            }

            if ($isMeaningDuplicate && $isDescriptionDuplicate) {
                $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                $description = $programColumns->where('column_name', 'DESCRIPTION')->first()->column_prompt;

                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$meaning} และ {$description} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;

            } else {
                if ($isMeaningDuplicate) {
                    $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }

                if ($isDescriptionDuplicate) {
                    $text = $programColumns->where('column_name', 'DESCRIPTION')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        //-------------- OM --------------//
        if ($request->programCode === 'OMS0041') {
            $isCodeDuplicate = '';
            $isMeaningDuplicate = '';

            if ($request->LOOKUP_CODE) {
                if (!$lookup) {

                    $data = strtoupper($request->LOOKUP_CODE);

                    $isCodeDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code = '{$data}'")
                                ->first();
                } 
            }

            if ($request->MEANING) {
                if ($lookup) {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                ->whereRaw("lookup_code != '{$lookup->lookup_code}'")
                                ->whereRaw("meaning = '{$data}'")
                                ->first();
                } else {

                    $data = strtoupper($request->MEANING);

                    $isMeaningDuplicate = ValueSetup::whereRaw("lookup_type = '{$program->source_name}'")
                                    ->whereRaw("UPPER(meaning) like '{$data}'")
                                    ->first();
                }
            }

            if ($isCodeDuplicate && $isMeaningDuplicate) {
                $code = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                $meaning = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;

                $msg = "ทำการเพิ่ม/แก้ไขข้อมูล {$code} และ {$meaning} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                return $result;

            } else {
                if ($isCodeDuplicate) {
                    $text = $programColumns->where('column_name', 'LOOKUP_CODE')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }

                if ($isMeaningDuplicate) {
                    $text = $programColumns->where('column_name', 'MEANING')->first()->column_prompt;
                    $msg = "ทำการเพิ่ม/แก้ไขข้อมูล{$text} ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ";

                    $result[] = ['valid' => false, 'err_code'=>'', 'err_msg'=> $msg ];
                    return $result;
                }
            }
            
        }

        return $result;
    }

    public function dataUpdateHeader($headerDescription, $dataType, $program, $lookup)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_message               varchar2(2000);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;

                            v_tran_id               varchar2(2000);
                            p_message               varchar2(2000);

                            cursor data(p_tran_id number) is
                            select interface_msg 
                            from PTFND_LOOKUP_VALUE_T
                            where tran_id = p_tran_id;

                        BEGIN
                            dbms_output.put_line('------  S T A R T ------');

                            v_lookup_rec  := NULL;
                            v_lookup_rec.INTERFACE_NAME         := 'WEB_CREATE_LOOKUP';
                            v_lookup_rec.DATA_TYPE              := '".$dataType."';
                            v_lookup_rec.LOOKUP_TYPE            := '".$program->source_name."';  
                            v_lookup_rec.LOOKUP_CODE            := '".$lookup->lookup_code."';  
                            v_lookup_rec.MEANING                := '".$lookup->meaning."'; 
                            v_lookup_rec.DESCRIPTION            := '".$lookup->description."'; 
                            v_lookup_rec.ENABLED_FLAG           := '".$lookup->enabled_flag."'; 
                            v_lookup_rec.TAG                    := '".$lookup->tag."';
                            v_lookup_rec.START_DATE_ACTIVE      := '".$lookup->start_date_active."';       
                            v_lookup_rec.END_DATE_ACTIVE        := '".$lookup->end_date_active."'; 
                            v_lookup_rec.ATTRIBUTE1             := '".$headerDescription."';
                            v_lookup_rec.ATTRIBUTE2             := '".$lookup->attribute2."';
                            v_lookup_rec.ATTRIBUTE3             := '".$lookup->attribute3."';
                            v_lookup_rec.ATTRIBUTE4             := '".$lookup->attribute4."';
                            v_lookup_rec.ATTRIBUTE5             := '".$lookup->attribute5."';
                            v_lookup_rec.ATTRIBUTE6             := '".$lookup->attribute6."';
                            v_lookup_rec.ATTRIBUTE7             := '".$lookup->attribute7."';
                            v_lookup_rec.ATTRIBUTE8             := '".$lookup->attribute8."';
                            v_lookup_rec.ATTRIBUTE9             := '".$lookup->attribute9."';
                            v_lookup_rec.ATTRIBUTE10            := '".$lookup->attribute10."';
                            v_lookup_rec.ATTRIBUTE11            := '".$lookup->attribute11."';
                            v_lookup_rec.ATTRIBUTE12            := '".$lookup->attribute12."';
                            v_lookup_rec.ATTRIBUTE13            := '".$lookup->attribute13."';
                            v_lookup_rec.ATTRIBUTE14            := '".$lookup->attribute14."';
                            v_lookup_rec.ATTRIBUTE15            := '".$lookup->attribute15."';
                            v_lookup_rec.ATTRIBUTE_CATEGORY     := '".$lookup->attribute_category."';
                            v_lookup_rec.RETURN_STATUS          := NULL;
                            v_lookup_rec.RETURN_MESSAGE         := NULL;
                            v_lookup_rec.TRAN_ID                := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;
                            :v_message := v_lookup_rec.return_message;
                            :v_tran_id := v_lookup_rec.tran_id;


                            dbms_output.put_line('Output : interface_name  = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output : return_status   = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output : return_message  = '|| v_lookup_rec.return_message );

                            dbms_output.put_line('Output : tran_id  = '|| v_lookup_rec.tran_id );

                            if v_lookup_rec.return_status not in ('S','C') then

                                for rec in data(v_lookup_rec.TRAN_ID) loop          
                                        dbms_output.put_line('Output :  return_message = '||rec.interface_msg ); 

                                        :p_message := rec.interface_msg;

                                end loop;
                                
                            end if;

                            dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_tran_id', $result['tran_id'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':p_message', $result['p_message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        return $result;
    }
}