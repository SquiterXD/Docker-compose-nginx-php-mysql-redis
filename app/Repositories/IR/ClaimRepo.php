<?php 

namespace App\Repositories\IR;

use App\Models\IR\PtirClaimHeader;
use App\Models\IR\Views\PtirLocationView;
use App\Models\IR\Views\PtglCoaDeptCodeView;
use App\Models\IR\PtirWebUtilitiesPkg;

use App\Repositories\IR\AttachmentRepo;
use App\Models\IR\Views\GlPeriodYearView;
use Carbon\Carbon;

class ClaimRepo
{
    public function create($profile, $request)
    {
        try {
            // Convert Date
            $accidentDate = parseFromDateTh($request->accident_date);
            // Convert Time
            $dateString = preg_replace('/\(.*$/', '', $request->accident_time);
            $acc_time = Carbon::parse($dateString)->format('H:i:s');
            $time = $accidentDate.' '.$acc_time;
            $accidentTime = date('Y-m-d H:i:s', strtotime($time));
            // get year by budget_year 15062022
            $period = GlPeriodYearView::selectRaw('start_date, end_date, period_year')
                                ->whereRaw("TO_DATE('{$accidentDate}', 'RRRR-MM-DD') between trunc(start_date) and trunc(end_date)")
                                ->first();

            // Store
            $header                 = new PtirClaimHeader();
            $header->year           = $period->period_year;
            $header->accident_date  = date('Y-m-d', strtotime($accidentDate));
            $header->accident_time  = $accidentTime;
            $header->location_name  = $request->location_name;
            $header->department_code = $request->department_code;
            $header->department_name = (new PtglCoaDeptCodeView)->departmentDescSeg3(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $request->department_code);
            $header->requestor_id   = $request->requestor_id ?? $profile->user_id;
            $header->requestor_name = $request->requestor_name;
            $header->requestor_tel  = $request->requestor_tel;
            $header->total_claim_amount = 0;
            $header->claim_amount   = $request->claim_amount != ''? str_replace(',', '', $request->claim_amount): 0;
            $header->program_code   = $profile->program_code;
            $header->claim_title    = $request->claim_title;
            $header->remarks        = preg_replace("/\r|\n/", " ", $request->remarks);
            $header->created_by_id  = $profile->user_id;
            $header->created_by     = $profile->user_id;
            $header->last_updated_by = $profile->user_id;
            $header->status           = 'NEW';
            $header->irp0011_status   = 'NEW';
            $header->insurance_status = 'NEW';
            $header->irp0011_insurance_status = 'NEW';
            $header->save();
            \DB::commit();

            // Create
            if ($header->document_number == '' || $header->document_number == null) {
                $document_number = (new PtirWebUtilitiesPkg())->genDocumentNumber($profile->program_code, $header->claim_header_id)['document_number'];
                $header->document_number = $document_number;
                $header->save();
            }

            $data = ['status' => 'S', 'header' => $header, 'claim_header_id' => $header->claim_header_id];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return $data;
        }
    }

    public function update($headerId, $profile, $request)
    {   
        // $xx = preg_replace("/\r|\n/", " ", $request->remarks);
        // $cc = substr(json_encode($xx), 0, 100);

        // dd(str_replace("  "," ", preg_replace("/\r|\n/", " ", $request->remarks)));
        try {
            // Convert Date
            $accidentDate = parseFromDateTh($request->accident_date);
            // Convert Time
            $dateString = preg_replace('/\(.*$/', '', $request->accident_time);
            $acc_time = Carbon::parse($dateString)->format('H:i:s');
            $time = $accidentDate.' '.$acc_time;
            $accidentTime = date('Y-m-d H:i:s', strtotime($time));
            // get year by budget_year 15062022
            $period = GlPeriodYearView::selectRaw('start_date, end_date, period_year')
                                ->whereRaw("TO_DATE('{$accidentDate}', 'RRRR-MM-DD') between trunc(start_date) and trunc(end_date)")
                                ->first();
            // Store
            $header = PtirClaimHeader::findOrFail($headerId);
            $header->year           = $period->period_year;
            $header->accident_date  = date('Y-m-d', strtotime($accidentDate));
            $header->accident_time  = $accidentTime;
            $header->location_name  = $request->location_name;
            $header->department_code = $request->department_code;
            $header->department_name = (new PtglCoaDeptCodeView)->departmentDescSeg3(getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE', $request->department_code);
            $header->requestor_id   = $request->requestor_id ?? $profile->user_id;
            $header->requestor_name = $request->requestor_name;
            $header->requestor_tel  = $request->requestor_tel;
            $header->claim_amount   = $request->claim_amount != ''? str_replace(',', '', $request->claim_amount): 0;
            $header->program_code   = $profile->program_code;
            $header->claim_title    = $request->claim_title;
            $header->remarks        = str_replace("  ", " ", preg_replace("/\r|\n/", " ", $request->remarks));
            $header->last_updated_by = $profile->user_id;
            $header->save();
            \DB::commit();
            // Update
            if ($header->document_number == '' || $header->document_number == null) {
                $document_number = (new PtirWebUtilitiesPkg())->genDocumentNumber($profile->program_code, $header->claim_header_id)['document_number'];
                $header->document_number = $document_number;
                $header->save();
            }

            $data = ['status' => 'S', 'header' => $header, 'claim_header_id' => $header->claim_header_id];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return $data;
        }
    }
}
