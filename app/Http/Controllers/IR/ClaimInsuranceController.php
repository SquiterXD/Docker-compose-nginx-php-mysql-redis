<?php

namespace App\Http\Controllers\IR;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\IR\ClaimRequest;

use App\Models\IR\PtirClaimHeader;
use App\Models\IR\PtirClaimLines;
use App\Models\IR\PtirAttachments;
use App\Models\IR\PtirClaimApplyCompany;
use App\Models\IR\PtirClaimApplyDetails;
use App\Models\IR\PtirClaimPolicyGroups;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Views\GlPeriodYearView;

use App\Repositories\IR\ClaimRepo;

class ClaimInsuranceController extends Controller
{
    protected $perPage = 20;
    public function index(Request $request)
    {
        $search = $request->search;
        $btnTrans = trans('btn');
        $fixUrl = '/ir/claim-insurance';
        $profile = getDefaultData($fixUrl);
        $url = (object)[];
        $url->submit_claim = route('ir.claim-insurance.index');

        $claims = PtirClaimHeader::search($search, $profile)
                                ->whereNull('reference_document_number')
                                ->orderBy('document_number', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
        if ($search) {
            $claims = PtirClaimHeader::search($search, $profile)
                                    ->whereNull('reference_document_number')
                                    ->orderBy('document_number', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }

        return view('ir.claim-insurance.index', compact('search', 'btnTrans', 'fixUrl', 'url', 'claims', 'profile'));
    }

    public function create()
    {
        $user = \Auth::user();
        $btnTrans = trans('btn');
        $fixUrl = '/ir/claim-insurance';
        $profile = getDefaultData($fixUrl);
        $url = (object)[];
        $url->claim = route('ir.claim-insurance.index');
        $url->ajax_store_claim = route('ir.ajax.claim-insurance.store');

        return view('ir.claim-insurance.agency.create', compact('user', 'btnTrans', 'url', 'profile'));
    }

    public function edit(PtirClaimHeader $claimHeader)
    {
        $user = \Auth::user();
        $btnTrans = trans('btn');
        $fixUrl = '/ir/claim-insurance';
        $profile = getDefaultData($fixUrl);
        $url = (object)[];
        $url->claim = route('ir.claim-insurance.index');
        $url->ajax_update_claim = route('ir.ajax.claim-insurance.update', $claimHeader->claim_header_id);
        $url->ajax_confirm_claim = route('ir.ajax.claim-insurance.confirm', $claimHeader->claim_header_id);
        $url->ajax_delete_file_irp0010 = route('ir.ajax.claim-insurance.delete-file');
        $url->ajax_get_data_default = route('ir.ajax.claim-insurance.get-data-default');
        $url->get_report_irr9130 = route('ir.claim-insurance.get-report-irr9130', $claimHeader->claim_header_id);
        $url->ajax_cancel_claim = route('ir.ajax.claim-insurance.cancel', $claimHeader->claim_header_id);

        // Attachment
        $insurance = $claimHeader->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
        $approve = $claimHeader->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
        $fileInsurance = $this->mappingFileLists($insurance);
        $fileApprove = $this->mappingFileLists($approve);

        return view('ir.claim-insurance.agency.edit', compact('claimHeader', 'user', 'btnTrans', 'url', 'fileInsurance', 'fileApprove', 'profile'));
    }

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

    public function report(PtirClaimHeader $claimHeader, Request $request)
    {
        $programCode = 'IRR9130';
        $year = $claimHeader->year;
        $claims = PtirClaimHeader::where('claim_header_id', $claimHeader->claim_header_id)->get();
        $period = GlPeriodYearView::selectRaw('min(start_date) start_date, max(end_date) end_date')
                                ->where('period_year', $year)
                                ->first();
        $request['accident_start_date'] = $request['accident_end_date'] = date('d/m/Y', strtotime($claims->first()->accident_date));

        if (count($claims) > 0) {
            $fileName = date('Ymdhms');
            $pdf = \PDF::loadView('ir.reports.irr9130.main_page',compact('claims', 'request', 'period', 'programCode'))
                        ->setOption('header-html',view('ir.reports.irr9130.header',compact('request', 'period', 'programCode', 'year')))
                        ->setOption('margin-top','40')
                        ->setOption('margin-bottom','25')
                        ->setOption('encoding','UTF-8')
                        ->setOption('lowquality', false)
                       ->setOption('disable-javascript', true)
                        ->setOption('disable-smart-shrinking', false)
                        ->setOption('print-media-type', true)
                       ->setOption('orientation', "Landscape")
                        ->setPaper('a4');
            return $pdf->stream();
        }else{
            return 'ไม่พบข้อมูลที่ค้นหาในระบบ';
        }
    }
}
