<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CT\Ajax\PtglAccountsInfoController;
use Illuminate\Http\Request;

use App\Models\CT\AccountCodeLedgersV;
use App\Models\CT\AccountCodeDetailsV;
use App\Models\CT\AccountCodeLedger;
use App\Models\CT\AccountCodeLedgerDetail;
use App\Models\CT\Account;
use App\Models\CT\PtglAccountsInfo;
use App\Models\CT\PtinvOrganizationsInfo;

class AccountCodeLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const url = '/ct/account_code_ledger';

    public function index()
    {
        $segment = new PtglAccountsInfoController;
        $segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];

        foreach ($segment_arr as $item) {
            $segment_text = 'SEGMENT'.$item;
            $data[$segment_text] = $segment->getDataBySegment($segment_text)->getData();
        }

        $acLedgerId = request()->get('ac_ledger_id', false);
        $searchData = [
            'ac_ledger_id'   => $acLedgerId,
            'search_url'     => route('ct.account_code_ledger.index')
        ];

        $lines = [];
        if ($acLedgerId) {
            $lines = AccountCodeLedgerDetail::where('ac_ledger_id', $acLedgerId)->orderBy('ac_ledger_detail_id', 'asc')->get();
        }

        // dd(request()->all(), $searchData);

        $headers = AccountCodeLedger::all();

        $alls = AccountCodeLedgersV::all();

        // dd($alls->pluck('account_id'));

        $accounts = Account::whereIn('account_id', $alls->pluck('account_id'))
                ->orderBy("seq")
                ->get();

        // dd($accounts);

        return view('ct.account_code_ledger.index',[
            'segment_data' => $data,
            'headers'      => $headers,
            'searchData'   => $searchData,
            'accounts'     => $accounts,
            'lines'        => $lines,
            'alls'         => $alls,
        ]);
    }

    public function create()
    {
        $segment = new PtglAccountsInfoController;
        $segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];

        foreach ($segment_arr as $item) {
            $segment_text = 'SEGMENT'.$item;
            $data[$segment_text] = $this->getDataSegment($segment_text)->getData();
        }

        $organizations = PtinvOrganizationsInfo::get();
        // dd('create', $data);

        return view('ct.account_code_ledger.create',[
            'segment_data'  => $data,
            'organizations' => $organizations,
        ]);
    }

    public function edit($id)
    {
        $detail = AccountCodeLedgerDetail::find($id);
        $header = $detail->acLedger;
        // dd('edit', $id, $detail, $detail->acLedger);
        $segment = new PtglAccountsInfoController;
        $segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];

        $detailSegment = (object) [];
        $detailSegment->SEGMENT1  = $detail->code_segment1;
        $detailSegment->SEGMENT2  = $detail->code_segment2;
        $detailSegment->SEGMENT3  = $detail->code_segment3;
        $detailSegment->SEGMENT4  = $detail->code_segment4;
        $detailSegment->SEGMENT5  = $detail->code_segment5;
        $detailSegment->SEGMENT6  = $detail->code_segment6;
        $detailSegment->SEGMENT7  = $detail->code_segment7;
        $detailSegment->SEGMENT8  = $detail->code_segment8;
        $detailSegment->SEGMENT9  = $detail->code_segment9;
        $detailSegment->SEGMENT10 = $detail->code_segment10;
        $detailSegment->SEGMENT11 = $detail->code_segment11;
        $detailSegment->SEGMENT12 = $detail->code_segment12;

        foreach ($segment_arr as $item) {
            $segment_text = 'SEGMENT'.$item;
            $data[$segment_text] = $this->getDataSegment($segment_text, $detailSegment)->getData();
        }

        $organizations = PtinvOrganizationsInfo::get();
        // dd('create', $data);

        return view('ct.account_code_ledger.edit',[
            'segment_data'  => $data,
            'detail'        => $detail,
            'header'        => $header,
            'organizations' => $organizations,
        ]);
    }

    public function getDataSegment($segment, $detail = null)
    {
        $text = $detail ? $detail->$segment : '';
        $res = [];

        $lists = PtglAccountsInfo::select('ptgl_accounts_info.application_column_name', 'pcv.flex_value', 'pcv.description')
        ->join('ptgl_coa_v AS pcv', 'ptgl_accounts_info.flex_value_set_id', '=', 'pcv.flex_value_set_id')
        ->where('ptgl_accounts_info.application_column_name', $segment)
        // ->whereNotNull('pcv.description')
        ->groupBy('ptgl_accounts_info.application_column_name','pcv.flex_value','pcv.description')
        ->orderBy('flex_value', 'asc')
        ->limit(20)
        ->get();

        foreach ($lists as $list) {
            array_push($res, $list);
        }
        
        if ($text) {
            $lists2 = PtglAccountsInfo::select('ptgl_accounts_info.application_column_name', 'pcv.flex_value', 'pcv.description')
            ->join('ptgl_coa_v AS pcv', 'ptgl_accounts_info.flex_value_set_id', '=', 'pcv.flex_value_set_id')
            ->where('ptgl_accounts_info.application_column_name', $segment)
            ->where('pcv.flex_value', 'like', "%${text}%")
            ->groupBy('ptgl_accounts_info.application_column_name','pcv.flex_value','pcv.description')
            ->orderBy('flex_value', 'asc')
            ->limit(20)
            ->get();


            foreach ($lists2 as $list2) {
                array_push($res, $list2);
            }

            $res = collect($res)->unique('flex_value');
        }
        

        return response()->json($res);
    }


    // public function getDataSegment($segment)
    // {
    //     $res = collect(\DB::select("
    //         SELECT  /*+ PARALLEL(2) */ ptgl_accounts_info.application_column_name, ptgl_coa_v.flex_value, ptgl_coa_v.description
    //         FROM    ptgl_accounts_info, ptgl_coa_v
    //         where   ptgl_accounts_info.flex_value_set_id = ptgl_coa_v.flex_value_set_id
    //         and     ptgl_accounts_info.application_column_name = '$segment'
    //         and     ptgl_coa_v.enabled_flag = 'Y'
    //         and     trunc(sysdate) between trunc(nvl(ptgl_coa_v.start_date_active,sysdate)) and trunc(nvl(ptgl_coa_v.end_date_active,sysdate))
    //         group by ptgl_accounts_info.application_column_name, ptgl_coa_v.flex_value, ptgl_coa_v.description
    //     "));

    //     return response()->json($res);
    // }
}
