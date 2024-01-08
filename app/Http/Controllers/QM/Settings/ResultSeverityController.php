<?php

namespace App\Http\Controllers\QM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lookup\ProgramColumn;
use App\Models\Lookup\Program;

use App\Models\Lookup\ValueSetup;
use App\Repositories\LookUpRepository;

class ResultSeverityController extends Controller
{
    public function index()
    {
        $program =  Program::where('source_name', 'PTQM_RESULT_SEVERITY')->first();

        // dd($program);

        $programColumns = $program->programColumns;

        // $lookup = ValueSetup::where('lookup_type', $program->source_name)->first() ?? new ValueSetup;
        $lookups = ValueSetup::where('lookup_type', $program->source_name)
                                ->where('enabled_flag', 'Y')
                                ->orderBy('lookup_code','asc')
                                ->get();

        // dd()

        return view('qm.settings.result-severity.index', compact('lookups', 'programColumns', 'program'));
    }

    public function store(Request $request)
    {
        $program =  Program::where('source_name', 'PTQM_RESULT_SEVERITY')->first();

        $errors = [];

        foreach (request()->attribute10 as $key => $data) {
            $lookup = ValueSetup::where('lookup_type', $program->source_name)
                            ->where('lookup_code', $key)
                            ->first();

                            
            // dd(request()->all(), request()->attribute10, $key, $data, $lookup);

            $interfaceData = $this->dataUpdate($lookup, $program, $data, 'UPDATE');

            if ($interfaceData['status'] == 'E') {
                array_push($errors, $interfaceData['message']);
                // return back()->with('error', 'ทำการบันทึกไม่สำเร็จ');
            }

            // dd(request()->all(), request()->attribute10, $key, $data, $lookup);
            

            // $this->dataUpdate($lookup, $program, $data, 'UPDATE');
        }

        // dd($errors);

        return back()->with('success', 'ทำการบันทึกเรียบร้อยแล้ว');
    }

    public function dataUpdate($lookup, $program, $data, $dataType)
    {
        // dd($data);
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                        DECLARE
                            v_debug         NUMBER :=0;
                            v_status                varchar2(20);
                            v_lookup_rec        PTFND_LOOKUPVAL_PKG.LOOKUP_REC ;
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
                            v_lookup_rec.ATTRIBUTE1             := '".$lookup->attribute1."';
                            v_lookup_rec.ATTRIBUTE2             := '".$lookup->attribute2."';
                            v_lookup_rec.ATTRIBUTE3             := '".$lookup->attribute3."';
                            v_lookup_rec.ATTRIBUTE4             := '".$lookup->attribute4."';
                            v_lookup_rec.ATTRIBUTE5             := '".$lookup->attribute5."';
                            v_lookup_rec.ATTRIBUTE6             := '".$lookup->attribute6."';
                            v_lookup_rec.ATTRIBUTE7             := '".$lookup->attribute7."';
                            v_lookup_rec.ATTRIBUTE8             := '".$lookup->attribute8."';
                            v_lookup_rec.ATTRIBUTE9             := '".$lookup->attribute9."';
                            v_lookup_rec.ATTRIBUTE10            := '".$data."';
                            v_lookup_rec.ATTRIBUTE11            := '".$lookup->attribute11."';
                            v_lookup_rec.ATTRIBUTE12            := '".$lookup->attribute12."';
                            v_lookup_rec.ATTRIBUTE13            := '".$lookup->attribute13."';
                            v_lookup_rec.ATTRIBUTE14            := '".$lookup->attribute14."';
                            v_lookup_rec.ATTRIBUTE_CATEGORY     := '".$lookup->attributeCategory."';
                            v_lookup_rec.RETURN_STATUS          := NULL;
                            v_lookup_rec.RETURN_MESSAGE         := NULL;

                            PTFND_LOOKUPVAL_PKG.QUICK_UPLOAD( P_DATA_DATA       => v_lookup_rec);

                            :v_status := v_lookup_rec.return_status;
                            :v_message := v_lookup_rec.return_message;


                            dbms_output.put_line('Output : interface_name  = '|| v_lookup_rec.INTERFACE_NAME );
                            dbms_output.put_line('Output : return_status   = '|| v_lookup_rec.return_status );
                            dbms_output.put_line('Output : return_message  = '|| v_lookup_rec.return_message );

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
        $stmt->execute();
        \Log::info($result);

        return $result;
    }
}
