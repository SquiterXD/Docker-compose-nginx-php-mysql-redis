<?php

namespace App\Http\Controllers\OM\Web;

use App\Http\Controllers\Controller;
use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\PTOM_AUTHORITY_LISTS;
use App\Models\Ptom\PtomActingPosition;
use App\Models\Ptom\PtomClaimHeader;
use App\Models\Ptom\PtomClaimLine;
use Illuminate\Http\Request;

class ClaimApproveController extends Controller
{
    const VIEW_INDEX = 'om.claim.claim-approve';

    // VIEW VUE
    const VIEW_COMPONENT_CLAIM = 'claim-approve';
    const VIEW_COMPONENT_REQUEST_CLAIM = 'request-for-change';

    // ROUTE API
    const ROUTE_API_LIST_CLAIM = 'om.api.getListHeader';
    const ROUTE_API_LIST_STATUS = 'om.api.claimStatusList';
    const ROUTE_API_UPDATE_HEADER = 'om.api.updateHeader';
    const ROUTE_API_CLOSE_HEADER = 'om.api.closeHeaderClaim';
    const ROUTE_API_TAKE_CLAIM_NUMBER = 'om.api.getClaimNumber';


    // ROUTE VIEW
    const ROUTE_PRINT_REQUEST = 'om.claim/request-for-change.requestPdf';
    const ROUTE_PRINT_CLAIM = 'om.claim/request-for-change.requestClaimPdf';

    public function index()
    {
        $customer_lists = Customers::where('sales_classification_code', 'Export')->where('status', 'Active')->orderBy('customer_number')->get();
        $btnTrans = trans('btn');
        $urlAjax    = [
            'list_claim'  => route(self::ROUTE_API_LIST_CLAIM),
            'list_status' => route(self::ROUTE_API_LIST_STATUS),
            'update_header' => route(self::ROUTE_API_UPDATE_HEADER),
            'close_header' => route(self::ROUTE_API_CLOSE_HEADER),
            'take_claim_number' => route(self::ROUTE_API_TAKE_CLAIM_NUMBER),
            'claim_print'    => route(self::ROUTE_PRINT_CLAIM)
        ];
        $profile = getDefaultData('/om/claim-approve');
        $prop = [
            "btn_trans"     => $btnTrans,
            "url_ajax"      => $urlAjax,
            "title"         => 'Customer Search',
            "title2"        => 'หน้าแรก',
            "title3"        => 'ข้อมูลลูกค้า สำหรับขายต่างประเทศ',
            'auth'          => $profile,
            "customer_list" => $customer_lists
        ];
        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT_CLAIM,

        ] + $prop);
    }
    public function DateThai($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        // $strHour= date("H",strtotime($strDate));
        // $strMinute= date("i",strtotime($strDate));
        // $strSeconds= date("s",strtotime($strDate));
        $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear";
    }
    public function DateThaiTime($strDate)
    {
        $strYear = date("Y", strtotime($strDate)) + 543;
        $strMonth = date("n", strtotime($strDate));
        $strDay = date("j", strtotime($strDate));
        $strHour = date("H", strtotime($strDate));
        $strMinute = date("i", strtotime($strDate));
        $strSeconds = date("s", strtotime($strDate));
        $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $strMonthThai = $strMonthCut[$strMonth];
        return "$strDay $strMonthThai $strYear $strHour:$strMinute";
    }
    public function requestPdf(Request $request)
    {
        // Bind
        $fl              = $request->fl;
        $customer_id     = $request->customer_number;
        $claim_number    = $request->claim_number;
        $date            = $request->date;
        $signIt          = $request->signIt;
        $signDep         = $request->signDep;
        // get sign
        $signItAuthor = PTOM_AUTHORITY_LISTS::where('authority_id', $signIt)->first();
        // get pos
        $signDepActingPos = PtomActingPosition::where('lookup_code', $signDep)->first();
        // get customer info
        $customeInfo = Customers::where('customer_id', $customer_id)->first();
        // get claim info
        $claimInfo = PtomClaimHeader::where('claim_header_id', $claim_number)->where('customer_id', $customer_id)->first();

        // check Claim
        if (empty($claimInfo)) abort(404);

        $claimLineInfo = PtomClaimLine::where('claim_header_id', $claim_number)->get();
        $claimInfo['claim_date'] = $this->DateThai($claimInfo['claim_date']);
        // migrate Date 
        // DateThai( "2008-08-14 13:42:44");
        $date = $this->DateThai($date);
        $pdf = \PDF::loadView('om.claim.report.request-claim', compact(
            'fl',
            'customer_id',
            'customeInfo',
            'claim_number',
            'claimLineInfo',
            'date',
            'signIt',
            'claimInfo',
            'signDep',
            'signItAuthor',
            'signDepActingPos',
        ))
            ->setPaper('a4')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1cm')
            ->setOption('margin-left', '2cm')
            ->setOption('margin-right', '1cm');
        return $pdf->inline();
    }
    public function requestClaimPdf(Request $request)
    {
        $claimInfo = PtomClaimHeader::where('claim_header_id', $request->claim_header_id)->first();

        if (empty($claimInfo)) abort(404);
        $claimLineInfo = PtomClaimLine::where('claim_header_id', $request->claim_header_id)->get();

        $customeInfo = Customers::where('customer_id', $claimInfo['customer_id'])->first();

        $attech = AttachFiles::where('ATTACHMENT_PROGRAM_CODE', 'OMP0081')->where('HEADER_ID', $request->claim_header_id)->OrderBy('ATTACHMENT_ID', 'asc')->get();

        $claimInfo['claim_date'] = $this->DateThaiTime($claimInfo['claim_date']);
        // dd($attech, $claimLineInfo, $customeInfo, $claimInfo);
        // return view('om.claim.report.print-claim');
        $pdf = \PDF::loadView('om.claim.report.print-claim', compact('customeInfo', 'attech', 'claimInfo', 'claimLineInfo'))
            ->setPaper('a4')
            ->setOption('margin-top', '1cm')
            ->setOption('margin-bottom', '1cm')
            ->setOption('margin-left', '2cm')
            ->setOption('margin-right', '1cm');
        return $pdf->inline();
    }
    public function requestForChange()
    {
        $btnTrans = trans('btn');
        $urlAjax    = [
            'link_pdf' => route(self::ROUTE_PRINT_REQUEST),
            'take_claim_number' => route(self::ROUTE_API_TAKE_CLAIM_NUMBER)
        ];

        $customer_lists = Customers::select(\DB::raw('DISTINCT customer_number, customer_id'))
            ->where('status', 'Active')
            ->whereNotNull('customer_number')
            ->get()
            ->toArray();
        $authorityList = PTOM_AUTHORITY_LISTS::whereRaw('trunc(START_DATE) <= trunc(sysdate) AND (trunc(END_DATE) >= trunc(sysdate) OR END_DATE IS NULL)')->get()->toArray();
        $actingPos = PtomActingPosition::where('enabled_flag', 'Y')
            ->whereRaw('trunc(START_DATE_ACTIVE) <= trunc(sysdate) AND (trunc(END_DATE_ACTIVE) >= trunc(sysdate) OR END_DATE_ACTIVE IS NULL)')
            ->get()
            ->toArray();
        $profile = getDefaultData('/om/claim-approve');
        $prop = [
            "btn_trans"      => $btnTrans,
            "url_ajax"       => $urlAjax,
            "title"          => 'Customer Search',
            "title2"         => 'หน้าแรก',
            "title3"         => 'OMR0052 : ใบขอเปลี่ยนบุหรี่ชำรุด/เสียหาย หรือ ขาดบรรจุ',
            'auth'           => $profile,
            "customer_list"  => $customer_lists,
            "authority_list" => $authorityList,
            "acting_pos"    => $actingPos,
        ];
        return view(self::VIEW_INDEX, [
            'vueComponent' => self::VIEW_COMPONENT_REQUEST_CLAIM,

        ] + $prop);
    }
}
