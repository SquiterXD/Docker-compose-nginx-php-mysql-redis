<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\IR\Settings\StoreAccountsMappingRequest;

// use Carbon\Carbon;
// use stdClass;
use App\Models\IR\Settings\PtirAccountsMapping      as AccountsMapping;
use App\Models\IR\Settings\PtglCoaCompanyView       as Company;
use App\Models\IR\Settings\PtglCoaEvmView           as Evm;
use App\Models\IR\Settings\PtglCoaDeptCodeView      as Department;           
use App\Models\IR\Settings\PtglCoaCostCenterView    as CostCenter;
use App\Models\IR\Settings\PtglCoaBudgetYearView    as BudgetYear;
use App\Models\IR\Settings\PtglCoaBudgetTypeView    as BudgetType;
use App\Models\IR\Settings\PtglCoaBudgetDetailView  as BudgetDetail;
use App\Models\IR\Settings\PtglCoaBudgetReasonView  as BudgetReason;
use App\Models\IR\Settings\PtglCoaMainAccountView   as MainAccount;
use App\Models\IR\Settings\PtglCoaSubAccountView    as SubAccount;
use App\Models\IR\Settings\PtglCoaReserved1View     as Reserved1;
use App\Models\IR\Settings\PtglCoaReserved2View     as Reserved2;
use App\Models\IR\Settings\GlCodeCombination;


use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirGasStations;

class AccountMappingController extends Controller
{
    public function index()
    {
        // dd(getDefaultData()->bu_id);
        $accounts = AccountsMapping::orderBy('account_code', 'asc')->get();

        // $paginations = AccountsMapping::search(request()->account, request()->status)->orderBy('account_code', 'asc')->paginate(25);


        $accountAlls = AccountsMapping::search(request()->account, request()->status)->orderBy('account_code', 'asc')->get();
        $btnTrans = trans('btn');
        // $defaultValueSetName = (object)[];
        // $defaultValueSetName->segment1 =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        // $defaultValueSetName->segment2 =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        // $defaultValueSetName->segment3 =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        // $defaultValueSetName->segment4 =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        // $defaultValueSetName->segment5 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        // $defaultValueSetName->segment6 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        // $defaultValueSetName->segment7 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        // $defaultValueSetName->segment8 =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        // $defaultValueSetName->segment9 =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        // $defaultValueSetName->segment10 = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        // $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        // $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        // dd($defaultValueSetName);

        return view('ir.settings.account-mapping.index', compact('accounts', 'accountAlls', 'btnTrans'));

    }

    public function create()
    {
        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1  =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2  =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3  =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4  =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9  =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 =  getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        $btnTrans = trans('btn');

        return view('ir.settings.account-mapping.create', compact('defaultValueSetName', 'btnTrans'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        $user = auth()->user();

        $orgId = $user->organization_id;

        $this->validate(request(), [
            'account_code' => 'required',
            'description'  => 'required',
            'segment1'     => 'required',
            'segment2'     => 'required',
            'segment3'     => 'required',
            'segment4'     => 'required',
            'segment5'     => 'required',
            'segment6'     => 'required',
            'segment7'     => 'required',
            'segment8'     => 'required',
            'segment9'     => 'required',
            'segment10'    => 'required',
            'segment11'    => 'required',
            'segment12'    => 'required',
        ]);

        $checkaccount = AccountsMapping::where('account_code', request()->account_code)->first();

        if ($checkaccount) {
            // return redirect()->back();

            request()->validate([
                'check_date'    => 'required',
            ], [
                'check_date.required'    => 'ไม่สามารถสร้างข้อมูลได้ เนื่องจาก description ซ้ำกับในระบบ',
            ]);
        }

        $codeCombine = request()->segment1.'.'.request()->segment2.'.'.request()->segment3.'.'.request()->segment4.'.'.request()->segment5.'.'.request()->segment6.'.'.request()->segment7.'.'.request()->segment8.'.'.request()->segment9.'.'.request()->segment10.'.'.request()->segment11.'.'.request()->segment12;
        
        $combineDesc = $this->accountCombineDesc(request());

        $glCode = GlCodeCombination::where('concatenated_segments', $codeCombine)->first();

        $orgId = getPrefixValueSetName() == 'TOAT' ? 121 : 81;

        // $autoCombine = '';

        // if (!$glCode) {
        //     // dd('glCode');
        //     $autoCombine = $this->autoCombine($codeCombine, $orgId);

        //     // dd($autoCombine, $codeCombine['combination_id']);
        // }
        // dd($glCode, $codeCombine);

        // dd($codeCombine, $glCode, $autoCombine);

        $accountMapping                          = new AccountsMapping;
        $accountMapping->account_code            = request()->account_code;
        $accountMapping->description             = request()->description;
        $accountMapping->account_combine         = $codeCombine;
        $accountMapping->segment_1               = request()->segment1;
        $accountMapping->segment_2               = request()->segment2;
        $accountMapping->segment_3               = request()->segment3;
        $accountMapping->segment_4               = request()->segment4;
        $accountMapping->segment_5               = request()->segment5;
        $accountMapping->segment_6               = request()->segment6;
        $accountMapping->segment_7               = request()->segment7;
        $accountMapping->segment_8               = request()->segment8;
        $accountMapping->segment_9               = request()->segment9;
        $accountMapping->segment_10              = request()->segment10;
        $accountMapping->segment_11              = request()->segment11;
        $accountMapping->segment_12              = request()->segment12;
        $accountMapping->active_flag             = request()->active_flag ? 'Y' : 'N';
        $accountMapping->account_combine_desc    = $combineDesc;
        $accountMapping->code_combination_id     = $glCode->code_combination_id;
        $accountMapping->program_code            = 'IRM0006';
        $accountMapping->created_by_id           = $user->user_id;
        $accountMapping->created_by              = $user->user_id;
        $accountMapping->last_updated_by         = $user->user_id;
        $accountMapping->save();

        return redirect()->route('ir.settings.account-mapping.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');

    }

    public function edit($id)
    {
        $accountMapping  = AccountsMapping::find($id);

        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1  =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2  =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3  =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4  =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9  =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 =  getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        $btnTrans = trans('btn');

        return view('ir.settings.account-mapping.edit', compact('accountMapping', 'defaultValueSetName', 'btnTrans'));

    }

    public function update(Request $request, $id)
    {
        // dd('update', request()->all());
        $this->validate(request(), [
            'description'  => 'required',
        ],[
            "description.required" => 'โปรดระบุ Description'
        ]);
        
        $user = auth()->user();

        $checkaccount = AccountsMapping::where('account_id', '!=', $id)
                            ->where('account_code', request()->account_code)
                            ->first();

        // dd($checkaccount, request()->all());

        if ($checkaccount) {
            request()->validate([
                'check_date'    => 'required',
            ], [
                'check_date.required'    => 'ไม่สามารถสร้างข้อมูลได้ เนื่องจาก description ซ้ำกับในระบบ',
            ]);
        }

        $accountMapping  = AccountsMapping::find($id);

        if (!request()->active_flag) { 
            // dd('1');      
            //IRM0002
            $IRM0002 = PtirPolicySetHeaders::where('account_id', $accountMapping->account_id)->where('active_flag', 'Y')->first();

            //IRM0004
            $IRM0004 = PtirGroupProducts::where('account_id', $accountMapping->account_id)->where('active_flag', 'Y')->first();

            //IRM0008
            $IRM0008 = PtirGasStations::where('account_id', $accountMapping->account_id)->where('active_flag', 'Y')->first();

            if ($IRM0002 || $IRM0004  || $IRM0008) {
                return redirect()->back()->with('error', 'ไม่สามารถ Inactive Account ชุดนี้ได้เนื่องจากมีการใช้ Account ชุดนี้อยู่');
            }

        } 

        $codeCombine = request()->segment1.'.'.request()->segment2.'.'.request()->segment3.'.'.request()->segment4.'.'.request()->segment5.'.'.request()->segment6.'.'.request()->segment7.'.'.request()->segment8.'.'.request()->segment9.'.'.request()->segment10.'.'.request()->segment11.'.'.request()->segment12;
        $combineDesc = $this->accountCombineDesc(request());

        $glCode = GlCodeCombination::where('concatenated_segments', $codeCombine)->first();

        // $orgId  = getPrefixValueSetName() == 'TOAT' ? 121 : 81;

        // if (!$glCode) {
        //     $autoCombine = $this->autoCombine($codeCombine, $orgId);
        // }

        $accountMapping->description             = request()->description;
        $accountMapping->account_combine         = $codeCombine;
        $accountMapping->segment_1               = request()->segment1;
        $accountMapping->segment_2               = request()->segment2;
        $accountMapping->segment_3               = request()->segment3;
        $accountMapping->segment_4               = request()->segment4;
        $accountMapping->segment_5               = request()->segment5;
        $accountMapping->segment_6               = request()->segment6;
        $accountMapping->segment_7               = request()->segment7;
        $accountMapping->segment_8               = request()->segment8;
        $accountMapping->segment_9               = request()->segment9;
        $accountMapping->segment_10              = request()->segment10;
        $accountMapping->segment_11              = request()->segment11;
        $accountMapping->segment_12              = request()->segment12;
        $accountMapping->active_flag             = request()->active_flag ? 'Y' : 'N';
        $accountMapping->last_updated_by         = $user->user_id;
        $accountMapping->account_combine_desc    = $combineDesc;
        $accountMapping->code_combination_id     = $glCode->code_combination_id;
        $accountMapping->save();

        return redirect()->route('ir.settings.account-mapping.index')->with('success','ทำการเปลี่ยนข้อมูลเรียบร้อยแล้ว');
    }

    public function accountCombineDesc($request)
    {
        $segment1  = (new Company)->getDesciption(request()->segment1);
        $segment2  = (new Evm)->getDesciption(request()->segment2);
        $segment3  = (new Department)->getDesciption(request()->segment3);
        $segment4  = (new CostCenter)->getDesciption(request()->segment4, request()->segment3);
        $segment5  = (new BudgetYear)->getDesciption(request()->segment5);
        $segment6  = (new BudgetType)->getDesciption(request()->segment6);
        $segment7  = (new BudgetDetail)->getDesciption(request()->segment7, request()->segment6);
        $segment8  = (new BudgetReason)->getDesciption(request()->segment8);
        $segment9  = (new MainAccount)->getDesciption(request()->segment9);
        $segment10 = (new SubAccount)->getDesciption(request()->segment10, request()->segment9);
        $segment11 = (new Reserved1)->getDesciption(request()->segment11);
        $segment12 = (new Reserved2)->getDesciption(request()->segment12);

        $combineDesc = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;


        return $combineDesc;
    }

    public static function autoCombine($concatSegment, $orgId)
    {
        try {

            $db = \DB::connection()->getPdo();

            $sql = "DECLARE
                        lv_return_status          varchar2(100);
                        lv_return_msg             varchar2(4000);
                        lv_code_combination_id    varchar2(100);
                    BEGIN

                        PTIE_WEB_INF_APINVOICE_PKG.GET_ACCOUNT_ID(
                            i_org_id                    =>  :org_id
                            , i_account_combine         =>  :concatenated_segments
                            , o_code_combination_id     =>  :lv_code_combination_id
                            , O_RETURN_STATUS           =>  :lv_return_status
                            , O_RETURN_MSG              =>  :lv_return_msg
                        );    
                        
                        dbms_output.put_line('lv_code_combination_id = '||lv_code_combination_id);
                        dbms_output.put_line('lv_return_status = '||lv_return_status);
                        dbms_output.put_line('lv_return_msg = '||lv_return_msg);
                    END;";

            $sql = preg_replace("/[\r\n]*/","",$sql);
            logger($sql);

            $stmt = $db->prepare($sql);

            $stmt->bindParam(':org_id', $orgId, \PDO::PARAM_STR);
            $stmt->bindParam(':concatenated_segments', $concatSegment, \PDO::PARAM_STR);

            $stmt->bindParam(':lv_return_status', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':lv_return_msg', $result['err_msg'], \PDO::PARAM_STR, 4000);
            $stmt->bindParam(':lv_code_combination_id', $result['combination_id'], \PDO::PARAM_STR, 100);

            $stmt->execute();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }


}
