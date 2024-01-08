<?php

namespace App\Http\Controllers\IR\Ajax;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mail;
use Carbon\Carbon;
use App\Repositories\IR\ClaimRepo;
use App\Models\IR\PtirClaimHeader;
use App\Models\IR\PtirAttachments;
use Illuminate\Support\Facades\Storage;
use App\Mail\IR\IRP0010\ConfirmClaimEmail;
use App\Models\IR\Settings\Email;
use App\Models\IR\Settings\PtirLookup;
use App\Repositories\IR\AttachmentRepo;


class ClaimController extends Controller
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

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $profile = getDefaultData('/ir/claim-insurance');
            $result = (new ClaimRepo)->create($profile, $request);
            // URL
            $url = (object)[];
            $url->claim = route('ir.claim-insurance.index');
            $url->ajax_update_claim = route('ir.ajax.claim-insurance.update', $result['claim_header_id']);
            $url->ajax_confirm_claim = route('ir.ajax.claim-insurance.confirm', $result['claim_header_id']);
            $url->ajax_delete_file_irp0010 = route('ir.ajax.claim-insurance.delete-file');
            $url->ajax_get_data_default = route('ir.ajax.claim-insurance.get-data-default');
            $url->ajax_cancel_claim= route('ir.ajax.claim-insurance.cancel', $result['claim_header_id']);
            $url->get_report_irr9130 = route('ir.claim-insurance.get-report-irr9130', $result['claim_header_id']);
            // Attachment
            $claim = PtirClaimHeader::findOrFail($result['claim_header_id']);
            $insurance = $claim->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
            $approve = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
            $fileInsurance = $this->mappingFileLists($insurance);
            $fileApprove = $this->mappingFileLists($approve);
            //---------------------------------------
            \DB::commit();
            $data = ['status' => 'S'
                        , 'msg' => ''
                        , 'url' => $url
                        , 'header' => $result['header']
                        , 'file_insurance' => $fileInsurance
                        , 'file_approve' => $fileApprove
                        , 'redirect_show_page' => route('ir.claim-insurance.edit', $result['claim_header_id'])
                    ];
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['msg'] ?? 'มีข้อผิดพลาด'
                ];
            }
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

    public function update($id, Request $request)
    {
        try {
            \DB::beginTransaction();
            $profile = getDefaultData('/ir/claim-insurance');
            $result = (new ClaimRepo)->update($id, $profile, $request);
            // URL
            $url = (object)[];
            $url->claim = route('ir.claim-insurance.index');
            $url->ajax_update_claim = route('ir.ajax.claim-insurance.update', $result['claim_header_id']);
            $url->ajax_confirm_claim = route('ir.ajax.claim-insurance.confirm', $result['claim_header_id']);
            $url->ajax_delete_file_irp0010 = route('ir.ajax.claim-insurance.delete-file');
            $url->ajax_get_data_default = route('ir.ajax.claim-insurance.get-data-default');
            $url->ajax_cancel_claim= route('ir.ajax.claim-insurance.cancel', $result['claim_header_id']);
            $url->get_report_irr9130 = route('ir.claim-insurance.get-report-irr9130', $result['claim_header_id']);

            // Attachment
            $claim = PtirClaimHeader::findOrFail($result['claim_header_id']);
            $insurance = $claim->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
            $approve = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
            $fileInsurance = $this->mappingFileLists($insurance);
            $fileApprove = $this->mappingFileLists($approve);
            \DB::commit();
            $data = ['status' => 'S'
                        , 'msg' => ''
                        , 'redirect_show_page' => route('ir.claim-insurance.index')
                        , 'url' => $url
                        , 'header' => $result['header']
                        , 'file_insurance' => $fileInsurance
                        , 'file_approve' => $fileApprove
                    ];
            if ($result['status'] == 'E') {
                $data = [
                    'status' => 'E',
                    'msg' => $result['msg'] ?? 'มีข้อผิดพลาด'
                ];
            }
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

    public function cancel($id)
    {
        try{
            \DB::beginTransaction();
                $header = PtirClaimHeader::findOrFail($id);
                $header->status             = 'CANCELLED';
                $header->insurance_status   = 'CANCELLED';
                $header->irp0011_status     = 'CANCELLED';
                $header->irp0011_insurance_status = 'CANCELLED';
                $header->cancelled_date     = date('Y-m-d');
                $header->last_updated_by    = \Auth::user()->user_id;
                $header->last_update_date   = Carbon::now();
                $header->save();
            \DB::commit();
            $data = ['status' => 'S', 'claim_status' => $header->status, 'insurance_status' => $header->insurance_status];
        } catch (Exception $e) {
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->message()
            ];
        }
        return response()->json(['data' => $data]);
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
                $insurance = $claim->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
                $approve = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
                $fileInsurance = $this->mappingFileLists($insurance);
                $fileApprove = $this->mappingFileLists($approve);
                $data = ['status' => 'S'
                        , 'file_insurance' => $fileInsurance
                        , 'file_approve' => $fileApprove
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

    public function confirmClaim($cliamHeaderId)
    {
        try{
            \DB::beginTransaction();
            $header = PtirClaimHeader::findOrFail($cliamHeaderId);
            $header->status             = 'CONFIRMED';
            $header->confirmed_date     = date('Y-m-d');
            $header->last_updated_by    = \Auth::user()->user_id;
            $header->insurance_date     = date('Y-m-d');
            $header->insurance_status   = 'แจ้งบริษัทประกันแล้ว';
            $header->irp0011_insurance_status = optional($header->company()->first())->invoice_date? 'บริษัทประกันยืนยันการชดใช้': 'แจ้งบริษัทประกันแล้ว';
            $header->last_update_date   = Carbon::now();
            $header->save();

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
                                            ->where('file_type', 'insurance')
                                            ->where('program_code', 'IRP0010')
                                            ->orderBy('attachment_id')
                                            ->get();
                $attachId = $attachments? $attachments->pluck('attachment_id')->toArray(): null;
                PtirAttachments::whereIn('attachment_id', $attachId)->update(['send_flag' => 'Y']);
                $fileInsurance = $header->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
                $fileInsurance = $this->mappingFileLists($fileInsurance);
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
                'fileInsurance' => $fileInsurance
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

    public function getDataDefault(Request $request)
    {
        $header = PtirClaimHeader::where('claim_header_id', $request->claimHeaderId)->first();
        // Attachment
        $attachments = $header->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
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

    public function storeFileUpload($claimHeaderId, Request $request)
    {
        try {
            \DB::beginTransaction();
            // Validate size file 2MB
            $sizeFileInsurance = $request->file('fileListInsurance')? $request->file('fileListInsurance')[0]->getSize() *  0.001: 0; // KB
            $sizeFileApprove = $request->file('fileListApprove')? $request->file('fileListApprove')[0]->getSize() *  0.001: 0; // KB
            if ($sizeFileInsurance > 5000 || $sizeFileApprove > 5000) {
                $data = [
                    'status' => 'E',
                    'msg' => 'ขนาดไฟล์ใหญ่เกินกว่าที่ระบบกำหนด'
                ];
                return response()->json($data);
            }

            $profile = getDefaultData('/ir/claim-insurance');
            $claim = PtirClaimHeader::findOrFail($claimHeaderId);
            if($request->file('fileListInsurance')){
                $file = $request->fileListInsurance;
                $pahtConfig = 'ir/IRP0010/'.date('Y');
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($claim, $request, $pahtConfig, $profile);
            }

            if($request->file('fileListApprove')){
                $file = $request->fileListApprove;
                $pahtConfig = 'ir/IRP0010/'.date('Y');
                $attachmentRepo = new AttachmentRepo;
                $attachmentRepo->create($claim, $request, $pahtConfig, $profile);
            }
            \DB::commit();

            // Attachment
            $fileInsurance = $claim->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
            $fileApprove = $claim->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
            $fileInsurance = $this->mappingFileLists($fileInsurance);
            $fileApprove = $this->mappingFileLists($fileApprove);
            //---------------------------------------
            $data = ['status' => 'S'
                        , 'msg' => ''
                        , 'file_insurance' => $fileInsurance
                        , 'file_approve' => $fileApprove
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
}
