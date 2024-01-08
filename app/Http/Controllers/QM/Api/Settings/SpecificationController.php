<?php

namespace App\Http\Controllers\QM\Api\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\QM\SpecificationsHT;
use App\Models\QM\SpecificationsLT;
use App\Models\QM\PtqmCheckPointV;
use App\Models\QM\PtqmSpecificationV;

use App\Models\QM\GmdSpecTest;

class SpecificationController extends Controller
{
    public function store()
    {
        try {
            $profile            = getDefaultData("/qm/settings/specifications?test_type=". request()->test_type['lookup_code']);
            $batchNo            = date('YmdHis') . rand(10000,99999);
            $specifications     = request()->specifications;
            $testType           = (object) request()->test_type;
            $searchRequest      = (object) request()->search_request ?? [];
            $searchLocatorId    = null;
            $attribute15        = '';
            if ($testType->lookup_code == 2) {
                $msg = false;
                if ( !data_get($searchRequest, 'qm_process_seq')  && !data_get($searchRequest, 'check_list_code')) {
                    $msg = "กรุณาเลือก 'กระบวนการตรวจคุณภาพบุหรี่' และ 'รายการตรวจสอบ'";
                }

                if (data_get($searchRequest, 'qm_process_seq')  && !data_get($searchRequest, 'check_list_code')) {
                    $msg = "กรุณาเลือก 'รายการตรวจสอบ'";
                }

                if (!data_get($searchRequest, 'qm_process_seq')  && data_get($searchRequest, 'check_list_code')) {
                    $msg = "กรุณาเลือก 'กระบวนการตรวจคุณภาพบุหรี่'";
                }
                if ($msg) {
                    throw new \Exception($msg);
                }
            }


            // กลุ่มผลิตด้านใบยา หรือ การระบาดของมอดยาสูบ
            if ($testType->lookup_code == 1 || $testType->lookup_code == 4) {
                $searchLocatorId = $searchRequest->locator_id;
            }

            //กลุ่มผลิตภัณฑ์สำเร็จรูป การตรวจคุณภาพด้วยเครื่อง QTM หรือ การตรวจอัตราลมรั่ว ของซองบุหรี่
            if (($testType->lookup_code == 2 || $testType->lookup_code == 3 || $testType->lookup_code == 5) && 
                (request()->machine_set || data_get($searchRequest, 'machine_set', ''))) {
                $machineSet = request()->machine_set ?? $searchRequest->machine_set;
                $searchLocatorId = PtqmCheckPointV::where('enabled_flag', 'Y')->whereNotNull('machine_set')
                                ->where('machine_set', $machineSet)
                                ->first();
                $searchLocatorId = optional($searchLocatorId)->inventory_location_id;
            }

            if ($testType->lookup_code == 3) {
                if (optional($searchRequest)->lot_number) {
                    $attribute15 = optional($searchRequest)->lot_number ?? null;
                } else {
                    $attribute15 = optional($searchRequest)->product_type_code ?? null;
                }
            }

            if (count($specifications)) {
                $user           = auth()->user();
                $specifications = collect($specifications);
                $firstLine      = $specifications->first();
                $firstLine      = (object)$firstLine;
                
                if ($testType->lookup_code == 2 && !(optional($firstLine)->spec_id ?? false)) {
                    $spec = $this->getSpec()->first();
                    $firstLine->spec_name = $spec->spec_name;
                    $firstLine->spec_desc = $spec->spec_desc;
                    $maxSeq = (new GmdSpecTest)->getMaxSeq(optional($spec)->spec_id ?? null) ?? 0;
                } else {
                    $maxSeq = (new GmdSpecTest)->getMaxSeq(optional($firstLine)->spec_id ?? null) ?? 0;
                }
                
                // Insert Header
                $header                     = new SpecificationsHT;
                $header->spec_name          = optional($firstLine)->spec_name ?? null;
                $header->spec_desc          = optional($firstLine)->spec_desc ?? $searchLocatorId;
                $header->locator_id         = optional($firstLine)->locator_id ?? $searchLocatorId;
                $header->record_type        = optional($firstLine)->spec_name ? 'UPDATE' : 'INSERT';
                $header->check_list_code    = optional($firstLine)->check_list_code ?? 
                                             (optional($searchRequest)->check_list_code ?? null);
                $header->machine_set        = optional($firstLine)->machine_set ?? 
                                             (optional($searchRequest)->machine_set ?? null);
                $header->qc_area            = optional($firstLine)->qc_area ?? 
                                             (optional($searchRequest)->qc_area ?? null);
                $header->test_process_code  = optional($firstLine)->qm_process_seq ?? 
                                             (optional($searchRequest)->qm_process_seq ?? null);
                $header->product_type_code  = optional($searchRequest)->product_type_code ?? null;

                // low_level_minor(attribute1)
                if (optional($searchRequest)->lot_number ?? false) {
                    $header->attribute1 = 'lot_number: ' . optional($searchRequest)->lot_number ?? null;
                }else{ 
                    if (optional($firstLine)->low_level_minor ?? false) {
                        $header->attribute1 = optional($firstLine)->low_level_minor ?? null;
                    }
                }
        
                // low_level_major(attribute2)
                if (optional($firstLine)->low_level_major ?? false) {
                    $header->attribute2 = optional($firstLine)->low_level_major ?? null;
                }

                // low_level_critical(attribute3)
                if (optional($firstLine)->low_level_critical ?? false) {
                    $header->attribute3 = optional($firstLine)->low_level_critical ?? null;
                }

                // high_level_minor(attribute4)
                if (optional($firstLine)->high_level_minor ?? false) {
                    $header->attribute4 = optional($firstLine)->high_level_minor ?? null;
                }

                // high_level_major(attribute5)
                if (optional($firstLine)->high_level_major ?? false) {
                    $header->attribute2 = optional($firstLine)->low_level_major ?? null;
                }

                //high_level_critical(attribute6)
                if (optional($firstLine)->high_level_critical ?? false) {
                    $header->attribute6 = optional($firstLine)->high_level_critical ?? null;
                }

                $header->attribute14        = $testType->lookup_code;
                $header->attribute15        = $attribute15;
                $header->web_batch_no       = $batchNo;
                $header->program_code       = $profile->program_code;
                $header->created_by_id      = $user->user_id;
                $header->updated_by_id      = $user->user_id;
                $header->created_by         = $user->fnd_user_id;
                $header->creation_date      = now();
                $header->last_updated_by    = $user->fnd_user_id;
                $header->last_update_date   = now();
                $header->save();

                $sysdate = now();
                $availableSeqArr = $specifications->pluck('seq', 'seq')->all();
                foreach ($specifications as $key => $spec) {
                    $spec = (object)$spec;
                    $seq = $spec->seq;
                    $recordType = 'UPDATE';
                    if (is_null($spec->seq)) {
                        $maxSeq = $maxSeq + 10;
                        $seq = $maxSeq;
                        $recordType = 'INSERT';
                    }

                    $line = (new SpecificationsLT)->createData(
                        $header, $spec, $seq, $recordType, $batchNo, $profile, $user, $sysdate
                    );
                }

                if (request()->del_test_id_arr ?? []) {
                    $specTests = PtqmSpecificationV::where('spec_name', $header->spec_name)
                                                    ->whereIn('test_id', request()->del_test_id_arr)
                                                    ->get();
                    foreach ($specTests as $key => $specTest) {
                        $line = (new SpecificationsLT)->createData(
                            $header,
                            $specTest,
                            $specTest->seq,
                            'DELETE',
                            $batchNo,
                            $profile,
                            $user,
                            $sysdate
                        );
                    }
                }
            }

            $result = (new SpecificationsHT)->interface($header, $profile);
            if ($result['status'] != 'S') {
                throw new \Exception($result['message']);
            }

            if ($testType->lookup_code == 2) {
                $findLine = SpecificationsLT::where('qm_spec_id', $header->qm_spec_id)->whereIn('record_type', ['INSERT', 'DELETE'])->get();
                // attribute4 -- PROCESS
                // attribute5 -- Entity
                // attribute8 -- Evaluation Flag
                foreach ($findLine as $key => $updateLine) {
                    if ($updateLine->record_type == 'INSERT') {
                        \DB::connection('oracle')->table('GMD_QC_TESTS_B')
                            ->where('test_id', $updateLine->test_id)
                            ->update(['attribute4' => $header->test_process_code, 'attribute5' => $header->check_list_code]);
                    }

                    if ($updateLine->record_type == 'DELETE') {
                        \DB::connection('oracle')->table('GMD_QC_TESTS_B')
                            ->where('test_id', $updateLine->test_id)
                            ->update(['attribute4' => null, 'attribute5' => null]);
                    }
                }
            }

            $data = [
                'status' => 'S',
                'msg' => ''
            ];
            // \DB::commit();
        } catch (\Exception $e) {
            // \DB::rollback();
            \Log::info($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function makeDateNewSpec($request)
    {
        $profile = getDefaultData("/qm/settings/specifications?test_type=". request()->test_type['lookup_code']);
        $batchNo = date('YmdHis') . rand(10000,99999);
        $specifications = $request->specifications;
        if (count($specifications)) {

            $user = auth()->user();
            $specifications = collect($specifications);
            $maxSeq = $specifications->max('seq') ?? 0;

            $firstLine = $specifications->first();
            $firstLine = (object)$firstLine;

            // Insert Header
            $header                     = new SpecificationsHT;
            $header->spec_name          = null;
            $header->spec_desc          = null;
            $header->locator_id         = $firstLine->locator_id;
            $header->record_type        = 'INSERT';

            $header->web_batch_no       = $batchNo;
            $header->program_code       = $profile->program_code;
            $header->created_by_id      = $user->user_id;
            $header->updated_by_id      = $user->user_id;
            $header->created_by         = $user->fnd_user_id;
            $header->creation_date      = now();
            $header->last_updated_by    = $user->fnd_user_id;
            $header->last_update_date   = now();
            $header->save();

            foreach ($specifications as $key => $spec) {
                $spec = (object)$spec;
                $seq = $spec->seq;
                if (is_null($spec->seq)) {
                    $maxSeq = $maxSeq + 10;
                    $seq = $maxSeq;
                }
                $recordType = 'INSERT';

                $line                       = new SpecificationsLT;
                $line->qm_spec_id           = $header->qm_spec_id ;
                $line->line_number          = $seq;
                $line->test_id              = $spec->test_id;
                $line->min_value            = $spec->min_value;
                $line->max_value            = $spec->max_value;
                $line->qc_unit_code         = $spec->test_unit;
                $line->low_level_minor      = $spec->low_level_minor;
                $line->low_level_major      = $spec->low_level_major;
                $line->low_level_critical   = $spec->low_level_critical;
                $line->high_level_minor     = $spec->high_level_minor;
                $line->high_level_major     = $spec->high_level_major;
                $line->high_level_critical  = $spec->high_level_critical;
                $line->optional_flag        = $spec->optional_ind ? 'Y' : 'N';
                $line->record_type          = $recordType;

                $line->web_batch_no         = $batchNo;
                $line->program_code         = $profile->program_code;
                $line->created_by_id        = $user->user_id;
                $line->updated_by_id        = $user->user_id;
                $line->created_by           = $user->fnd_user_id;
                $line->creation_date        = now();
                $line->last_updated_by      = $user->fnd_user_id;
                $line->last_update_date     = now();
                $line->save();
            }
        }
    }

    public function getSpec()
    {
        $data = collect(\DB::select("
            SELECT  ps.spec_id
                    , ps.spec_vers
                    , ps.spec_name
                    , ps.spec_desc
            FROM    PTQM_SPECIFICATIONS_V ps,
                    ptqm_test_type ptt
            where   ps.test_type_code = ptt.lookup_code
            and     ps.inventory_item_id = to_number(trim(ptt.attribute1))
            and     ps.organization_id = to_number(trim(ptt.attribute2))
            and     ps.test_type_code = 2
            and     ps.lot_number is null
            group by ps.spec_id
                    , ps.spec_vers
                    , ps.spec_name
                    , ps.spec_desc
        "));

        return $data;
    }
}
