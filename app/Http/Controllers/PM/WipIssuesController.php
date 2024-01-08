<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtpmMesReviewIssueHeaders;
use App\Repositories\PM\WipIssueRequestRepository;
use App\Models\PM\OapmPtmesProductLine;
use Carbon\Carbon;

class WipIssuesController extends Controller
{
    public function index()
    {

        // $result = (new WipIssueRequestRepository)->submit("60b4b05e7c09b");
        // dd( $result);
        // dd($result);
        // dd('xxx');

        $url = (object)[];
        $url->findClassification        = route('pm.ajax.find-classification');
        $url->urlUpdateData             = route('pm.ajax.update-data');
        $url->urlGetMesReviewIssuesV    = route('pm.ajax.get-me-review-issues-v');
        $url->urlOpt                    = route('pm.ajax.opt-from-blend-no');
        $url->urlGetOprnByItem          = route('pm.ajax.get-oprn-by-item');
        $url->urlFormulas               = route('pm.ajax.get-formulas');
        // $url->userProfile = getDefaultData('/pm/wip-issue');
        $url->urlSaveData               = route('pm.ajax.save-data');
        $url->getHeaders                = route('pm.ajax.get-headers');
        $url->cancelData                = route('pm.ajax.cancel-data');
        $url->searchHeader              = route('pm.ajax.search-header');
        // $url->searchHeaderFromMonth = route('pm.ajax.search-header-from-month');
        $userProfile                    = getDefaultData('/pm/wip-issue');
        $programCode                    = "PMP0007";


        return view('pm.wip-issues.index', [
            // 'urlGetMesReviewIssuesV'    => $urlGetMesReviewIssuesV,
            // 'urlOpt'                    => $urlOpt,
            // 'urlGetOprnByItem'          => $urlGetOprnByItem,
            // 'urlFormulas'               => $urlFormulas,
            'userProfile'               => $userProfile,
            // 'urlSaveData'               => $urlSaveData,
            'mesReviewIssueHeaders'     => [],
            'url'                       => $url,
            'programCode'               => $programCode,

            ]);
    }

    public function casingFlavorIndex()
    {
        $url = (object)[];
        $url->findClassification        = route('pm.ajax.find-classification');
        $url->urlUpdateData             = route('pm.ajax.update-data');
        $url->urlGetMesReviewIssuesV    = route('pm.ajax.get-me-review-issues-v');
        $url->urlOpt                    = route('pm.ajax.opt-from-blend-no');
        $url->urlGetOprnByItem          = route('pm.ajax.get-oprn-by-item');
        $url->urlFormulas               = route('pm.ajax.get-formulas');
        // $url->userProfile = getDefaultData('/pm/wip-issue');
        $url->urlSaveData               = route('pm.ajax.save-data');
        $url->getHeaders                = route('pm.ajax.get-headers');
        $url->cancelData                = route('pm.ajax.cancel-data');
        $url->searchHeader              = route('pm.ajax.search-header');
        // $url->searchHeaderFromMonth = route('pm.ajax.search-header-from-month');
        $userProfile                    = getDefaultData('/pm/wip-issue');
        $programCode                    = "PMP0048";

        return view('pm.wip-issues.casing_flavor_index', [
            'userProfile'               => $userProfile,
            'mesReviewIssueHeaders'     => [],
            'url'                       => $url,
            'programCode'               => $programCode,
            ]);
    }


    public function wipIssueAll()
    {

        $url = (object)[];
        $url->findClassification        = route('pm.ajax.find-classification');
        $url->urlUpdateData             = route('pm.ajax.update-data');
        $url->urlGetMesReviewIssuesV    = route('pm.ajax.get-me-review-issues-v');
        $url->urlOpt                    = route('pm.ajax.opt-from-blend-no');
        $url->urlGetOprnByItem          = route('pm.ajax.get-oprn-by-item');
        $url->urlFormulas               = route('pm.ajax.get-formulas');
        // $url->userProfile = getDefaultData('/pm/wip-issue');
        $url->urlSaveData               = route('pm.ajax.save-data');
        $url->getHeaders                = route('pm.ajax.get-headers');
        $url->cancelData                = route('pm.ajax.cancel-data');
        $url->searchHeader              = route('pm.ajax.search-header');
        $userProfile                    = getDefaultData('/pm/wip-issue');
        // $url->searchHeaderFromMonth = route('pm.ajax.search-header-from-month');
        $programCode                    = "PMP0049";

        return view('pm.wip-issues.wip_issue', [
            'userProfile'               => $userProfile,
            'mesReviewIssueHeaders'     => [],
            'url'                       => $url,
            'programCode'               => $programCode,
            ]);
    }

    public function wipIssueCutOf()
    {

        // $header = PtpmMesReviewIssueHeaders::where('issue_header_id', 502)->first();
        // $profile =  getDefaultData(\Request::path());
        // if ($header->interface_status == 'S'  && ($profile->organization_code == 'MG6' || $profile->organization_code == 'M05')) {
        //     $productLine = OapmPtmesProductLine::where('organization_id', auth()->user()->organization_id)
        //             ->where('wip_step', $header->wip_step)
        //             ->where('batch_id', $header->batch_id)
        //             ->whereDate('product_date', Carbon::parse($header->complete_date))
        //             ->first();
        //     $productLine->transaction_flag = 'N';
        //     $productLine->save();
        // }

        // dd('xxxx----');
        $url = (object)[];
        $url->findClassification        = route('pm.ajax.find-classification');
        $url->urlUpdateData             = route('pm.ajax.update-data');
        $url->urlGetMesReviewIssuesV    = route('pm.ajax.get-me-review-issues-v');
        $url->urlOpt                    = route('pm.ajax.opt-from-blend-no');
        $url->urlGetOprnByItem          = route('pm.ajax.get-oprn-by-item');
        $url->urlFormulas               = route('pm.ajax.get-formulas');
        // $url->userProfile = getDefaultData('/pm/wip-issue');
        $url->urlSaveData               = route('pm.ajax.save-data');
        $url->getHeaders                = route('pm.ajax.get-headers');
        $url->cancelData                = route('pm.ajax.cancel-data');
        $url->searchHeader              = route('pm.ajax.search-header');
        // $url->searchHeaderFromMonth = route('pm.ajax.search-header-from-month');
        $userProfile                    = getDefaultData('/pm/wip-issue');
        $programCode                    = "PMP0051";

        return view('pm.wip-issues.wip_issue_cut_of', [
            'userProfile'               => $userProfile,
            'mesReviewIssueHeaders'     => [],
            'url'                       => $url,
            'programCode'               => $programCode,
            ]);
    }

    public function stamp()
    {
        $url = (object)[];
        $url->findClassification        = route('pm.ajax.find-classification');
        $url->urlUpdateData             = route('pm.ajax.update-data');
        $url->urlGetMesReviewIssuesV    = route('pm.ajax.get-me-review-issues-v');
        $url->urlOpt                    = route('pm.ajax.opt-from-blend-no');
        $url->urlGetOprnByItem          = route('pm.ajax.get-oprn-by-item');
        $url->urlFormulas               = route('pm.ajax.get-formulas');
        // $url->userProfile = getDefaultData('/pm/wip-issue');
        $url->urlSaveData               = route('pm.ajax.save-data');
        $url->getHeaders                = route('pm.ajax.get-headers');
        $url->cancelData                = route('pm.ajax.cancel-data');
        $url->searchHeader              = route('pm.ajax.search-header');
        $userProfile                    = getDefaultData('/pm/wip-issue');
        // $url->searchHeaderFromMonth = route('pm.ajax.search-header-from-month');
        $programCode                    = "PMP0059";

        return view('pm.wip-issues.stamp', [
            'userProfile'               => $userProfile,
            'mesReviewIssueHeaders'     => [],
            'url'                       => $url,
            'programCode'               => $programCode,
            ]);
    }
}
