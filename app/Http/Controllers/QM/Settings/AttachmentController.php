<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use App\Models\QM\Settings\Attachments;
use App\Models\QM\Settings\ProgramsInfoV;
use App\Models\QM\Settings\CheckPointsV;
use Illuminate\Support\Facades\Storage;

use DB;
use PDO;

class AttachmentController extends Controller
{
    public function download(Attachments $attachment)
    {
        if (!\File::exists($attachment->attribute1.$attachment->file_name)) {
            return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
        }
        $filePath =  $attachment->attribute1 . $attachment->file_name ;
        return response()->download($filePath, $attachment->attribute2);
    }

    public function imageCheckPoints(Attachments $attachment)
    {
        $qmTestTypeCode = CheckPointsV::where('attachment_id',$attachment['attachment_id'])
                                    ->value('qm_test_type_code');
        if($qmTestTypeCode == '1'){
            $profile = getDefaultData('/qm/settings/check-points-tobacco-leaf');
            $imagePath = ProgramsInfoV::where('program_code',$profile->program_code)
                                        ->value('image_path');
            if ( !\File::exists(storage_path($imagePath.$attachment->file_name)) ) {
                return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
            }
            $img = Image::make(storage_path($imagePath.$attachment->file_name));
            return $img->response();
        }elseif ($qmTestTypeCode == '4') {
            $profile = getDefaultData('/qm/settings/check-points-tobacco-beetle');
            $imagePath = ProgramsInfoV::where('module_name',$attachment['module_name'])
                                        ->where('program_code',$profile->program_code)
                                        ->value('image_path');
            if ( !\File::exists(storage_path($imagePath.$attachment->file_name)) ) {
                return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
            }
            $img = Image::make(storage_path($imagePath.$attachment->file_name));
            return $img->response();
        }
    }

    public function deleteByPKGCheckPoints(Attachments $attachment, $programCode)
    {
        $imagePath = ProgramsInfoV::where('program_code', $programCode)->value('image_path');
        if (\File::exists(storage_path($imagePath . $attachment['file_name']))) {
            \File::delete(storage_path($imagePath . $attachment['file_name']));
            $attachment->delete();
            $db = DB::connection('oracle')->getPdo();
            $sql  = "
                        declare
                            v_status        varchar2(200);
                            v_err_msg       varchar2(2000);
                        begin
                            ptweb_utilities.del_attachment( p_attachment_id => {$attachment['attachment_id']},
                                                            p_status        => :v_status,
                                                            p_error_msg     => :v_err_msg                       );
                            dbms_output.put_line('Status : ' || v_status);
                            dbms_output.put_line('Error : ' || v_err_msg);
                        end;
                    ";
            \Log::info($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            \Log::info('status', $result);
            return response()->json(['message' => 'Success', 'code' => 200]);
        } else {
            return response()->json(['message' => 'File does not exists.', 'code' => 400]);
        }
    }

    public function imageDefineTests(Attachments $attachment, $testTypeCode)
    {
        if($testTypeCode){
            if($testTypeCode == '5'){
                $testType = 'QMS0012';
            }elseif ($testTypeCode == '2') {
                $testType = 'QMS0009';
            }elseif ($testTypeCode == '3') {
                $testType = 'QMS0010';
            }elseif ($testTypeCode == '4') {
                $testType = 'QMS0011';
            }elseif ($testTypeCode == '1') {
                $testType = 'QMS0007';
            }
            $imagePath = ProgramsInfoV::where('module_name',$attachment['module_name'])
                                        ->where('program_code',$testType)
                                        ->value('image_path');
            if ( !\File::exists(storage_path($imagePath.$attachment->file_name)) ) {
                return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
            }
            $img = Image::make(storage_path($imagePath.$attachment->file_name));
            return $img->response();
        }
    }

    public function deleteByPKGDefineTests(Attachments $attachment, $testTypeCode)
    {
        if($testTypeCode == '5'){
            $testType = 'QMS0012';
        }elseif ($testTypeCode == '2') {
            $testType = 'QMS0009';
        }elseif ($testTypeCode == '3') {
            $testType = 'QMS0010';
        }elseif ($testTypeCode == '4') {
            $testType = 'QMS0011';
        }elseif ($testTypeCode == '1') {
            $testType = 'QMS0007';
        }
        $imagePath = ProgramsInfoV::where('module_name',$attachment['module_name'])
                                    ->where('program_code',$testType)
                                    ->value('image_path');
        if (\File::exists(storage_path($imagePath . $attachment['file_name']))) {
            \File::delete(storage_path($imagePath . $attachment['file_name']));
            $attachment->delete();
            $db = DB::connection('oracle')->getPdo();
            $sql  = "
                        declare
                            v_status        varchar2(200);
                            v_err_msg       varchar2(2000);
                        begin
                            ptweb_utilities.del_attachment( p_attachment_id => {$attachment['attachment_id']},
                                                            p_status        => :v_status,
                                                            p_error_msg     => :v_err_msg                       );
                            dbms_output.put_line('Status : ' || v_status);
                            dbms_output.put_line('Error : ' || v_err_msg);
                        end;
                    ";
            \Log::info($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':v_err_msg', $result['message'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            \Log::info('status', $result);
            return response()->json(['message' => 'Success', 'code' => 200]);
        } else {
            return response()->json(['message' => 'File does not exists.', 'code' => 400]);
        }
    }
}
