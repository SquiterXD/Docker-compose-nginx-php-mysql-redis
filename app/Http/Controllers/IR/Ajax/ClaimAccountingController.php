<?php

namespace App\Http\Controllers\IR\Ajax;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IR\ClaimRepo;

use App\Models\IR\PtirClaimHeader;
use App\Models\IR\PtirAttachments;
use App\Models\IR\PtirClaimPolicyGroups;
use App\Models\IR\Settings\PtirPolicyGroupHeaders;
use App\Models\IR\Views\PtirPolicySetHeadersView;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Views\PtirPolicyGroupV;
use App\Models\IR\PtirClaimApplyCompany;
use App\Models\IR\PtirClaimApplyDetails;
use App\Models\IR\Views\GlPeriodYearView;

use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Mail\IR\IRP0010\ConfirmClaimEmail;
use App\Models\IR\Settings\Email;
use App\Models\IR\Settings\PtirLookup;
use App\Repositories\IR\AttachmentRepo;

class ClaimAccountingController extends Controller
{
    public function mappingFileLists($files)
    {
        // mapping
        $data = [];
        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                $list = [];
                $list['uid'] = $file->attachment_id;
                $list['name'] = $file->original_file_name;
                $list['status'] = 'success';
                $list['type'] = $file->file_type;
                $list['send_flag'] = $file->send_flag;
                $list['program_code'] = $file->program_code;

                array_push($data, $list);
            }
        }

        return $data;
    }

    public function update($id, Request $request)
    {
        try {
            \DB::beginTransaction();
            $profile = getDefaultData('/ir/claim-accounting');
            $data = $request->params;
            $totalArInvoiceAmount = 0;
            $claimHeader = PtirClaimHeader::find($id);
            // remove all for new insert
            $group = PtirClaimPolicyGroups::where('claim_header_id', $id)->delete();
            $detail = PtirClaimApplyDetails::where('claim_header_id', $id)->delete();
            $company = PtirClaimApplyCompany::where('claim_header_id', $id)->delete();
            \DB::commit();
            // Store
            foreach ($data['policyLists'] as $key => $value) {
                $policyHeader = PtirPolicyGroupHeaders::where('group_header_id', $value['policy_group'])->first();
                $policySetHeader = PtirPolicySetHeadersView::where('policy_set_header_id', $value['policy_set'])->first();
                $policySet = PtirPolicyGroupSets::where('group_header_id', $value['policy_group'])
                                                    ->where('policy_set_header_id', $value['policy_set'])
                                                    ->first();

                $totalArInvoiceAmount += $value['claim_amount'];
                $policy = PtirClaimPolicyGroups::updateOrCreate(
                        [
                            'claim_header_id'       => $id
                            , 'group_header_id'     => $value['policy_group']
                            , 'policy_set_header_id' => $value['policy_set']
                        ],
                        [
                            'claim_header_id'       => $id
                            , 'group_header_id'     => $value['policy_group']
                            , 'group_code'          => $policyHeader->group_code
                            , 'group_description'   => $policyHeader->group_description
                            , 'policy_set_header_id' => $value['policy_set']
                            , 'group_set_id'        => $policySet->group_set_id
                            , 'policy_set_description' => $policySet->policy_set_description
                            , 'amount'              => $value['claim_amount']
                            , 'program_code'        => $profile->program_code
                            , 'created_by_id'       => $profile->user_id
                            , 'created_by'          => $profile->user_id
                            , 'last_updated_by'     => $profile->user_id
                        ]);
                \DB::commit();

                foreach ($data['insuranceLists'] as $key => $value) {
                    if ($value['policy'] === $policy['group_header_id'].'|'.$policy['policy_set_header_id']) {
                        $apply = PtirClaimApplyDetails::updateOrCreate(
                                [
                                    'line_number'       => $value['line_number']
                                    , 'claim_header_id' => $id
                                    , 'claim_group_id'  => $policy['claim_group_id']
                                ],
                                [
                                    'claim_header_id'   => $id
                                    , 'claim_group_id'  => $policy['claim_group_id']
                                    , 'line_number'     => $value['line_number']
                                    , 'line_description' => $value['accident_desc']
                                    , 'line_amount'     => $value['amount']
                                    , 'program_code'    => $profile->program_code
                                    , 'created_by_id'   => $profile->user_id
                                    , 'created_by'      => $profile->user_id
                                    , 'last_updated_by' => $profile->user_id
                                ]);
                        \DB::commit();

                        foreach ($data['detailLists'] as $company => $value) {
                            if ($value['policy_group'].'|'.$value['policy_set'] === $policy['group_header_id'].'|'.$policy['policy_set_header_id']) {
                                $year = GlPeriodYearView::selectRaw('start_date, end_date, period_year')
                                                        // ->whereRaw('trunc(sysdate) between trunc(start_date) and nvl(trunc(end_date), trunc(sysdate))')
                                                        ->where('period_year', $claimHeader->year)
                                                        ->first();
                                $company = PtirPolicyGroupV::where('company_code', $value['company'])
                                                        ->where('group_code', $policy['group_code'])
                                                        ->where('year', $year->period_year)
                                                        ->where('company_percent', '>', 0)
                                                        ->first();

                                $insurance = PtirClaimApplyCompany::updateOrCreate(
                                        [
                                            'claim_header_id'   => $id
                                            , 'claim_detail_id' => $apply['claim_detail_id']
                                            , 'company_id'      => $company->company_id
                                        ],
                                        [
                                            'claim_header_id'   => $id
                                            , 'claim_detail_id' => $apply['claim_detail_id']
                                            , 'company_id'      => $company->company_id
                                            , 'company_name'    => $company->company_name
                                            , 'claim_percent'   => $company->company_percent
                                            , 'claim_amount'    => ($apply['line_amount'] * $company->company_percent) / 100
                                            , 'policy_number'   => $company->policy_number
                                            , 'program_code'    => $profile->program_code
                                            , 'created_by_id'   => $profile->user_id
                                            , 'created_by'      => $profile->user_id
                                            , 'last_updated_by' => $profile->user_id
                                            , 'claim_group_id'  => $policy['claim_group_id']
                                            , 'amount_ratio'    => ($apply['line_amount'] * 100) / $policy['amount']
                                        ]);
                                \DB::commit();
                            }
                        }
                    }
                }
            }

            // Update Claim Header
            $claim = PtirClaimHeader::where('claim_header_id', $id)
                                    ->update(['ar_invoice_amount' => $totalArInvoiceAmount
                                        , 'total_claim_amount' => $data['totalClaimAmount']
                                        , 'irp0011_status' => 'NEW'
                                        , 'last_update_date' => Carbon::now()
                                    ]);

            // Update Claim Header when have referance#
            $claim = PtirClaimHeader::findOrFail($id);
            if ($claim->reference_document_number) {
                $claim = PtirClaimHeader::where('document_number', $claim->reference_document_number)
                                        ->whereNull('reference_document_number')
                                        ->update(['ar_invoice_amount' => $totalArInvoiceAmount
                                            , 'total_claim_amount' => $data['totalClaimAmount']
                                            , 'last_update_date' => Carbon::now()
                                        ]);
            }

            \DB::commit();
            // TEMP
            $claim = PtirClaimHeader::findOrFail($id);
            // claim policy group
            $claimPolicyGroup = PtirClaimPolicyGroups::where('claim_header_id', $claim->claim_header_id)->orderBy('claim_group_id')->get();
            // claim apply detail
            $claimApplyDetail = PtirClaimApplyDetails::with(['claimPolicyGroup'])
                                                ->where('claim_header_id', $claim->claim_header_id)
                                                ->orderBy('line_number')
                                                ->get();
            // claim apply company
            $claimApplyComp = PtirClaimPolicyGroups::with(['claimPolicyDetail.claimApplyCompany'])
                                                ->where('claim_header_id', $claim->claim_header_id)
                                                ->get();

            $data = ['status' => 'S'
                        , 'msg' => ''
                        , 'header' => $claim
                        , 'claimPolicyGroup' => $claimPolicyGroup
                        , 'claimApplyDetail' => $claimApplyDetail
                        , 'claimApplyComp' => $claimApplyComp
                    ];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            logger('claim error');
            logger($e);
            logger('-----------------------------------------------------');
            logger($e->message());
            return response()->json($data);
        }
    }

    public function download($attachment_id)
    {
        $attachment = PtirAttachments::find($attachment_id);
        $filePath = storage_path().$attachment->path ;
        return response()->download($filePath, $attachment->original_file_name);
    }

    public function storeFileUpload($claimHeaderId, Request $request)
    {
        try {
            \DB::beginTransaction();
            // Validate size file 2MB
            $sizeFile = $request->file('fileListApprove')? $request->file('fileListApprove')[0]->getSize() *  0.001: 0; // KB
            if ($sizeFile > 5000) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ขนาดไฟล์ใหญ่เกินกว่าที่ระบบกำหนด'
                ];
                return response()->json($data);
            }

            $profile = getDefaultData('/ir/claim-accounting');
            $claim = PtirClaimHeader::findOrFail($claimHeaderId);
            if($request->file('fileListApprove')){
                $file = $request->fileListApprove;
                $pahtConfig = 'ir/IRP0010/'.date('Y');
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($claim, $request, $pahtConfig, $profile);
            }
            \DB::commit();

            // Attachment
            $fileApprove = $claim->attachments()->where('file_type', 'approve')->whereNull('send_flag')->orderBy('attachment_id')->get();
            $fileAll = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
            $fileApprove = $this->mappingFileLists($fileApprove);
            $fileAll = $this->mappingFileLists($fileAll);
            //---------------------------------------
            $data = ['status' => 'S'
                        , 'msg' => ''
                        , 'file_approve' => $fileApprove
                        , 'file_all' => $fileAll
                    ];
            return response()->json($data);
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
            return response()->json($data);
        }
    }

    public function getDataDefault(Request $request)
    {
        $header = PtirClaimHeader::where('claim_header_id', $request->claimHeaderId)->first();
        // Attachment Approve
        $attachments = $header->attachments()->where('file_type', 'approve')->whereIn('attachment_id', $request->attachments)->orderBy('attachment_id')->get();
        $receivers = (new Email)->composeReceivers();
        $ccReceivers = (new Email)->composeCCReceivers();
        // Lookup
        $defaultDesc = PtirLookup::where('lookup_type', 'PTIR_EMAIL_CLIAM')->where('enabled_flag', 'Y')->orderBy('lookup_code')->get();
        // -------------------------------------------------------------------
        $data = self::templateConfirmClaim($header, $receivers, $ccReceivers);
        $accidentDate = convertToFormatMail(date('d-m-Y', strtotime($header->accident_date)));
        $accidentTime = date('H:i', strtotime($header->accident_time));

        $data = [
            'status' => 'S',
            'detail' => $data,
            'accidentDate' => $accidentDate,
            'accidentTime' => $accidentTime,
            'defaultDesc' => $defaultDesc,
            'attachments' => $attachments
        ];
        return response()->json(['data' => $data]);
    }

    public function confirmClaim($cliamHeaderId, Request $request)
    {
        try{
            \DB::beginTransaction();
            $param = $request->param;
            $header = PtirClaimHeader::findOrFail($cliamHeaderId);
            // get data email
            $sender = (new Email)->composeSender();
            if (!$sender) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่มีข้อมูล Setup Email ผู้ส่งจากหน้า Master: IRM0010'
                ];
                return response()->json(['data' => $data]);
            }
            $receivers = (new Email)->composeReceivers();
            $ccReceivers = (new Email)->composeCCReceivers();
            // Lookup
            $defaultDesc = PtirLookup::where('lookup_type', 'PTIR_EMAIL_CLIAM')->where('enabled_flag', 'Y')->orderBy('lookup_code')->get();
            // -------------------------------------------------------------------
            if(count($receivers) > 0){
                $data = self::templateConfirmClaim($header, $receivers, $ccReceivers);
                $to = $data['receiverEmail'];
                $cc = $ccReceivers? $data['ccReceiverEmail']: '';
                $subject = $data['subject'];
                // attachment
                $attachments = PtirAttachments::where('document_header_id', $cliamHeaderId)
                                            ->where('file_type', 'approve')
                                            ->whereIn('attachment_id', $param['attachments'])
                                            ->orderBy('attachment_id')
                                            ->get();
                // Update file approve ที่มีการส่งไปยังประกันภัยแล้ว
                PtirAttachments::whereIn('attachment_id', $param['attachments'])->update(['send_FLAG' => 'Y']);
                $fileAll = $header->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
                $fileAll = $this->mappingFileLists($fileAll);
                Mail::send('ir.claim-insurance.emails.template', [
                                'data'        => $data,
                                'header'      => $header,
                                'sender'      => $sender,
                                'defaultDesc' => $defaultDesc,
                                'subject'     => $data['subject'],
                                'receiverNames' => $data['receiverNames']
                            ],
                            function ($message) use ($subject, $attachments, $to, $cc, $sender) {
                                $email = $sender->email;
                                $message->from($email, $sender->employee_name);
                                $message->to($to);
                                if ($cc) {$message->cc($cc);}
                                $message->subject($subject);

                                foreach ($attachments as $key => $attachment) {
                                    $file = storage_path($attachment->path);
                                    $message->attach($file, [
                                        'as' => $attachment->original_file_name,
                                        'mime' => 'application/vnd.pdf'
                                    ]);
                                }
                            }
                        );
            }

            \DB::commit();
            $data = [
                'status' => 'S',
                'header' => $header,
                'file_all' => $fileAll
            ];
            return response()->json(['data' => $data]);
        } catch (\Exception $e) {
            \DB::rollBack();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
            return response()->json(['data' => $data]);
        }
    }

    private static function templateConfirmClaim($header, $receivers, $ccReceivers)
    {
        // Name ----------------------------------------
        $receiverNames = $receivers ? implode(', ', array_map(function($receiver){
                                              return $receiver['name'];
                                            }, $receivers)) : '';
        $ccReceiverName = $ccReceivers ? implode(', ', array_map(function($ccReceiver){
                                              return $ccReceiver['name'];
                                            }, $ccReceivers)) : '';
        // Email ----------------------------------------
        $receiverEmail = $receivers ? implode(', ', array_map(function($receiver){
                                              return $receiver['email'];
                                            }, $receivers)) : '';
        $ccReceiverEmail = $ccReceivers ? implode(', ', array_map(function($ccReceiver){
                                              return $ccReceiver['email'];
                                            }, $ccReceivers)) : '';

        $data = [
            'subject' => 'การยาสูบฯ แจ้งเคลมประกันภัย_'.$header->department_name.'_'.$header->location_name.'_'.convertToFormatMail(date('d-m-Y', strtotime($header->accident_date))),
            'claimHeaderId' => $header->claim_header_id,
            'receiverNames' => $receiverNames,
            'ccReceiverName' => $ccReceiverName,
            'receiverEmail' => explode(',', str_replace(' ', '', $receiverEmail)),
            'ccReceiverEmail' => explode(',', str_replace(' ', '', $ccReceiverEmail))
        ];
        return $data;
    }

    public function deleteFile(Request $request)
    {
        try {
            $attachment = PtirAttachments::findOrFail($request->params['attachment_id']);
            if ($attachment) {
                // Storage::delete($attachment->path);
                $attachment->delete();
                // Attachment
                $claim = PtirClaimHeader::findOrFail($request->params['claim_header_id']);
                $fileApprove = $claim->attachments()->where('file_type', 'approve')->whereNull('send_flag')->orderBy('attachment_id')->get();
                $fileAll = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
                $fileApprove = $this->mappingFileLists($fileApprove);
                $fileAll = $this->mappingFileLists($fileAll);
                $data = ['status' => 'S'
                        , 'file_approve' => $fileApprove
                        , 'file_all' => $fileAll
                    ];
            }else {
                $data = ['status' => 'E', 'msg' => 'ไม่พบไฟล์เอกสารที่ต้องการในระบบ'];
            }
            // dd($request->all(), $file, storage_path().'/'.$file->original_file_path.'/'.$file->file_name);
            // dd(\File::exists(public_path($attachment->path)), public_path($attachment->path));
            // dd('xxxx');
            // if (Storage::exists($attachment->original_file_path .'/'. $attachment->file_name)) {
            //     Storage::delete($attachment->original_file_path .'/'. $attachment->file_name);
            //     $data = ['status' => 'S'];
            // } else {
            //     $data = ['status' => 'S', 'msg' => 'ไม่พบไฟล์เอกสารที่ต้องการในระบบ'];
            // }
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json(['data' => $data]);
    }

    // ยกเลิกเคลม
    public function cancel($id, Request $request)
    {
        try{
            \DB::beginTransaction();
            $header = PtirClaimHeader::findOrFail($id);
            $header->status             = 'CANCELLED';
            $header->irp0011_status     = 'CANCELLED';
            $header->insurance_status   = 'CANCELLED';
            $header->irp0011_insurance_status = 'CANCELLED';
            $header->cancelled_reason   = $request['reason'];
            $header->cancelled_date     = date('Y-m-d');
            $header->last_updated_by    = \Auth::user()->user_id;
            $header->last_update_date   = Carbon::now();
            $header->save();
            \DB::commit();
            $data = ['status' => 'S', 'header' => $header];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json(['data' => $data]);
    }

    // ยืนยันเคลม
    public function updateConfirm($id, Request $request)
    {
        try{
            \DB::beginTransaction();
            $header = PtirClaimHeader::findOrFail($id);
            $header->irp0011_status     = 'CONFIRMED';
            $header->last_updated_by    = \Auth::user()->user_id;
            $header->last_update_date   = Carbon::now();
            $header->save();
            \DB::commit();
            $data = ['status' => 'S', 'irp0011_status' => $header->irp0011_status];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json($data);
    }

    // บันทึกข้อมูล Header เมื่อ status == INTERFACE
    public function updateCliamHeader($id, Request $request)
    {
        $param = $request->params;
        try{
            \DB::beginTransaction();
            $header = PtirClaimHeader::findOrFail($id);
            $header->journal_number     = $param['journalNumber'];
            $header->total_claim_amount = $param['totalClaimAmount'];
            $header->last_updated_by    = \Auth::user()->user_id;
            $header->last_update_date   = Carbon::now();
            $header->save();
            \DB::commit();
            $data = ['status' => 'S', 'header' => $header];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json($data);
    }

    public function deleteClaimPolicy($id, Request $request)
    {
        try{
            \DB::beginTransaction();
            $policy = $request->params['policy'];
            $findPolicy = PtirClaimPolicyGroups::findOrFail($policy['id']);
            if ($findPolicy) {
                $group = PtirClaimPolicyGroups::findOrFail($policy['id']);
                $detail = PtirClaimApplyDetails::where('claim_group_id', $policy['id'])->get();
                $arr = $detail->pluck('claim_detail_id')->toArray();
                $detail = PtirClaimApplyDetails::whereIn('claim_detail_id', $arr)->delete();
                $company = PtirClaimApplyCompany::whereIn('claim_detail_id', $arr)->delete();
                $group->delete();
                \DB::commit();
            }
            $data = ['status' => 'S'];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json($data);
    }

    public function deleteClaimDetail($id, Request $request)
    {
        try{
            \DB::beginTransaction();
            $line = $request->params['line'];
            $findDetail = PtirClaimApplyDetails::where('claim_detail_id', $line['id'])->get();
            if ($findDetail) {
                $detail = PtirClaimApplyDetails::where('claim_detail_id', $line['id'])->delete();
                $company = PtirClaimApplyCompany::where('claim_detail_id', $line['id'])->delete();
            }
            \DB::commit();
            $data = ['status' => 'S'];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json($data);
    }

}
