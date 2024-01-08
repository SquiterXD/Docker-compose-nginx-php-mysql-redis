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
use App\Models\IR\Views\PtirPolicyGroupV;
use App\Models\IR\Views\PtirPolicyGroupSetV;
use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\PtirClaimHeaderIRP0011V;

use App\Repositories\IR\ClaimRepo;

class ClaimAccountingController extends Controller
{
    protected $perPage = 20;
    public function index(Request $request)
    {
        $search = $request->search;
        $btnTrans = trans('btn');
        $fixUrl = '/ir/claim-accounting';
        $profile = getDefaultData($fixUrl);
        $url = (object)[];
        $url->submit_claim = route('ir.claim-accounting.index');

        $claims = PtirClaimHeaderIRP0011V::search($search, $profile)
                                ->orderBy('document_number', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
        if ($search) {
            $claims = PtirClaimHeaderIRP0011V::search($search, $profile)
                                    ->orderBy('document_number', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }

        return view('ir.claim-insurance.index', compact('search', 'btnTrans', 'fixUrl', 'url', 'claims', 'profile'));
    }

    public function edit(PtirClaimHeader $claimHeader)
    {
        $user = \Auth::user();
        $btnTrans = trans('btn');
        $fixUrl = '/ir/claim-accounting';
        $profile = getDefaultData($fixUrl);
        $url = (object)[];
        $url->claim = route('ir.claim-accounting.index');
        $url->ajax_update_claim = route('ir.ajax.claim-accounting.update', $claimHeader->claim_header_id);
        $url->ajax_get_data_default = route('ir.ajax.claim-accounting.get-data-default');
        $url->ajax_confirm_claim = route('ir.ajax.claim-accounting.confirm', $claimHeader->claim_header_id);
        $url->ajax_cancel_claim = route('ir.ajax.claim-accounting.cancel', $claimHeader->claim_header_id);
        $url->ajax_update_confirm = route('ir.ajax.claim-accounting.update-confirm', $claimHeader->claim_header_id);
        $url->ajax_update_claim_header = route('ir.ajax.claim-accounting.update-cliam-header', $claimHeader->claim_header_id);
        $url->get_report_irr9140 = route('ir.claim-accounting.get-report-irr9140', $claimHeader->claim_header_id);
        $url->ajax_delete_file_irp0011 = route('ir.ajax.claim-accounting.delete-file');
        // del policy/detail
        $url->ajax_delete_claim_policy_irp0011 = route('ir.ajax.claim-accounting.delete-policy', $claimHeader->claim_header_id);
        $url->ajax_delete_claim_detail_irp0011 = route('ir.ajax.claim-accounting.delete-detail', $claimHeader->claim_header_id);

        // Master data list
        // GL Peroid
        $year = GlPeriodYearView::selectRaw('start_date, end_date, period_year')
                            ->where('period_year', $claimHeader->year)
                            // ->whereRaw('trunc(sysdate) between trunc(start_date) and nvl(trunc(end_date), trunc(sysdate))')
                            ->first();
        // Policy Header
        $policyGroups = PtirPolicyGroupV::selectRaw('distinct group_code, group_header_id, group_description')
                                        ->where('year', $year->period_year)
                                        ->orderBy('group_code')
                                        ->get();
        $companies = PtirPolicyGroupV::selectRaw('distinct group_code, group_header_id, group_description, company_id, company_code, company_name, company_percent, policy_number')
                                        ->where('year', $year->period_year)
                                        ->where('company_percent', '>', 0)
                                        ->orderBy('group_code')
                                        ->get();
        $policyGroupSets = PtirPolicyGroupSetV::where('active_flag', 'Y')->orderByRaw('cast(policy_set_number as int) asc')->get();

        // TEMP
        // claim policy group
        $claimPolicyGroup = PtirClaimPolicyGroups::where('claim_header_id', $claimHeader->claim_header_id)->orderBy('claim_group_id')->get();
        // claim apply detail
        $claimApplyDetail = PtirClaimApplyDetails::with(['claimPolicyGroup'])
                                            ->where('claim_header_id', $claimHeader->claim_header_id)
                                            ->orderBy('line_number')
                                            ->get();
        // claim apply company
        $claimApplyComp = PtirClaimPolicyGroups::with(['claimPolicyDetail.claimApplyCompany'])
                                            ->where('claim_header_id', $claimHeader->claim_header_id)
                                            ->get();

        // Attachment
        $fileInsurance = $claimHeader->attachments()->where('file_type', 'insurance')->orderBy('attachment_id')->get();
        $fileApprove = $claimHeader->attachments()->where('file_type', 'approve')->whereNull('send_flag')->orderBy('attachment_id')->get();
        $fileAll = $claimHeader->attachments()->where('file_type', 'approve')->orderBy('attachment_id')->get();
        $fileInsurance = $this->mappingFileLists($fileInsurance); // file type insurance
        $fileApprove = $this->mappingFileLists($fileApprove); // file type approve and send to insurance
        $fileAll = $this->mappingFileLists($fileAll); // file type approve all

        return view('ir.claim-insurance.accounting.edit', compact('claimHeader', 'claimPolicyGroup', 'claimApplyDetail', 'claimApplyComp', 'user', 'btnTrans', 'url', 'fileInsurance', 'fileApprove', 'fileAll', 'profile', 'policyGroups', 'policyGroupSets', 'companies'));
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

    public function report($claimHeaderID)
    {
        $programCode = 'IRR9140';
        $claimHeader = PtirClaimHeader::where('claim_header_id', $claimHeaderID)->first();
        $year = $claimHeader->year;
        $period = GlPeriodYearView::selectRaw('min(start_date) start_date, max(end_date) end_date')
                                ->where('period_year', $year)
                                ->first();
        $claims = PtirClaimHeader::with(['company' => function ($query) {
                                            $query->orderBy('company_id');
                                        }
                                        , 'details' => function ($query) {
                                            $query->orderBy('line_number')
                                                ->orderBy('claim_group_id');
                                        }
                                        ,'details.claimApplyCompany' => function ($query) {
                                            $query->orderBy('company_id');
                                        }
                                        , 'details.claimPolicyGroup'
                                    ])
                                    ->has('details')
                                    ->where('claim_header_id', $claimHeaderID)
                                    ->get();
        $request['accident_start_date'] = $request['accident_end_date'] = date('d/m/Y', strtotime($claims->first()->accident_date));

        if (count($claims) > 0) {
            $fileName = date('Ymdhms');
            $pdf = \PDF::loadView('ir.reports.irr9140.main_page', compact('claims', 'programCode', 'year', 'request', 'period'))
                ->setOption('header-html',view('ir.reports.irr9140.header',compact('request', 'period', 'programCode', 'year')))
                ->setOption('margin-top','40.63')
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
