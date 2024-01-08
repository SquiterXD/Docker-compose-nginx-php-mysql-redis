<?php

namespace App\Http\Controllers\IR\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Http\Requests\IR\Settings\AccountsMappingRequest;
// use App\Http\Requests\IR\Settings\StoreAccountsMappingRequest;
use App\Models\IR\Settings\PtirAccountsMapping as AccountsMapping;
// use App\Models\IR\Settings\PtglCoaCompanyView;
// use App\Models\IR\Settings\PtglCoaEvmView;
// use App\Models\IR\Settings\PtglCoaDeptCodeView;
// use App\Models\IR\Settings\PtglCoaCostCenterView;
// use App\Models\IR\Settings\PtglCoaBudgetYearView;
// use App\Models\IR\Settings\PtglCoaBudgetTypeView;
// use App\Models\IR\Settings\PtglCoaBudgetDetailView;
// use App\Models\IR\Settings\PtglCoaBudgetReasonView;
// use App\Models\IR\Settings\PtglCoaMainAccountView;
// use App\Models\IR\Settings\PtglCoaSubAccountView;
// use App\Models\IR\Settings\PtglCoaReserved1View;
// use App\Models\IR\Settings\PtglCoaReserved2View;
use Carbon\Carbon;
use Validator;

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

class AccountMappingController extends Controller
{

   public function index(Request $request)
   {
      // dd(request()->all(), '5555');
      $setName = request()->flex_value_set_name;
      $text  = request()->get('query');

      $request->validate([
         'flex_value_set_name' => 'required',
      ]);
      $setParent = $request->flex_value_parent;

      // dd(request()->flex_value_set_name);

      if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
         $data = Company::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-EVM') {

         $data = Evm::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {

         $data = CostCenter::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->where('department_code', $setParent)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE') {

         $data = Department::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR') {

         $data = BudgetYear::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE') {

         $data = BudgetType::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                     ->when($text, function ($query, $text) {
                        return $query->where(function($r) use ($text) {
                           $r->where('description', 'like', "%${text}%")
                              ->orWhere('meaning', 'like', "${text}%");
                        });
                  })
                  ->get();

         return response()->json($data);
         

      }  elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL') {

         $data = BudgetDetail::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->where('budget_type', $setParent)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON') {

         $data = BudgetReason::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT') {

         $data = MainAccount::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();
                     
         return response()->json($data);

      }  elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT') {

         $data = SubAccount::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->where('main_account', $setParent)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1') {

         $data = Reserved1::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2') {

         $data = Reserved2::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $setName)
                        ->when($text, function ($query, $text) {
                           return $query->where(function($r) use ($text) {
                              $r->where('description', 'like', "%${text}%")
                                 ->orWhere('meaning', 'like', "${text}%");
                           });
                     })
                     ->get();

         return response()->json($data);

      }
      
   }

   public function validateCombination()
   {
      $valid = [
         'status' => 'S',
         'error_msg' => '',
      ];
      $segments = request()->segmentAlls; 
      $accountCode = request()->account_code; 
   
      $checkCompany      = Company::where('company_code', $segments[0])->first();
      $checkEVM          = Evm::where('evm_code', $segments[1])->first();
      $checkDepartment   = Department::where('department_code', $segments[2])->first();
      $checkCostCenter   = CostCenter::where('department_code', $segments[2])->where('cost_center_code', $segments[3])->first();
      $checkBudgetYear   = BudgetYear::where('budget_year', $segments[4])->first();
      $checkBudgetType   = BudgetType::where('budget_type', $segments[5])->first();
      $checkBudgetDetail = BudgetDetail::where('budget_type', $segments[5])->where('budget_detail', $segments[6])->first();
      $checkBudgetReason = BudgetReason::where('budget_reason', $segments[7])->first();
      $checkAccount      = MainAccount::where('main_account', $segments[8])->first();
      $checkSubAccount   = SubAccount::where('sub_account', $segments[9])->first();
      $checkReserve1     = Reserved1::where('reserved1', $segments[10])->first();
      $checkReserve2     = Reserved2::where('reserved2', $segments[11])->first();

      // dd($checkCompany, $checkEVM, $checkDepartment, $checkCostCenter, $checkBudgetYear, $checkBudgetType, $checkBudgetDetail,
      // $checkBudgetReason, $checkAccount, $checkSubAccount, $checkReserve1, $checkReserve2);

      if( !$checkCompany ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Company Code นี้';

         return response()->json($valid);
      }
      if( !$checkEVM ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Evm Code นี้';

         return response()->json($valid);
      }
      if( !$checkDepartment ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Department Code นี้';
         
         return response()->json($valid);
      }
      if( !$checkCostCenter ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Cost Center Code นี้';

         return response()->json($valid);
      }
      if( !$checkBudgetYear ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Budget Year Code นี้';

         return response()->json($valid);
      }
      if( !$checkBudgetType ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Budget Type Code นี้';

         return response()->json($valid);
      }
      if( !$checkBudgetDetail ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี BUDGET DETAIL นี้';

         return response()->json($valid);
      }
      if( !$checkBudgetReason ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Budget Reason Code นี้';

         return response()->json($valid);
      }
      if( !$checkAccount ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Account Code นี้';

         return response()->json($valid);
      }
      if( !$checkSubAccount ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Sub Account Code นี้';

         return response()->json($valid);
      }
      if( !$checkReserve1 ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Reserve1 Code นี้';

         return response()->json($valid);
      }
      if( !$checkReserve2 ){
         $valid['status'] = 'E';
         $valid['error_msg'] = 'ไม่มี Reserve2 Code นี้';

         return response()->json($valid);
      }
      $checkAccount = GlCodeCombination::where('concatenated_segments', $accountCode)->first();
      if ($checkAccount) {
         if ($checkAccount->enabled_flag != 'Y') {
            $valid['status']    = 'E';
            $valid['error_msg'] = $accountCode . '  Inactive';
         }
      } else {
         if (!$checkAccount) {
            $valid['status']    = 'E';
            $valid['error_msg'] = $accountCode . '  Not Found CCID';
         }
      }
      
      // $checkAccount = GlCodeCombination::where('concatenated_segments', $accountCode)->where('enabled_flag', 'Y')->first();

      // if (!$checkAccount) {
      //    $valid['status']    = 'E';
      //    $valid['error_msg'] = $accountCode . ' Inactive';
      // }

      return response()->json($valid);
   }

   public function costCenter()
   {
      dd('costCenter');
   }

   /**
    * Lov search account code combine
    */
   public function accountCodeCombineLov(AccountsMappingRequest $request) 
   {
       $data = (new AccountsMapping())->getAccountCodeCombine($request->account_code, $request->description);
       $response = new \stdClass();
       $response->data = $data;

       return response()->json($response);
  }
  
   public function showAccountMapping(AccountsMappingRequest $request) 
   {
       $data = (new AccountsMapping())->getSpecifiedAccountMapping($request->account_id, $request->active_flag);
       $response = new \stdClass();
       $response->data = $data;

       return response()->json($response);
   }

    /**
     * Display company code in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function companiesCode(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaCompanyView)->getCompanyCode($request->compnany_code, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display EVM in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function evmCode(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaEvmView)->getEvmCode($request->evm_code, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display department code in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function departmentCode(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaDeptCodeView)->getDepartmentCode($request->department_code, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display cost center code in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function costCenterCode(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaCostCenterView)->getCostCenterCode($request->cost_center_code, $request->description, $request->department_code);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display budget year in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function budgetYear(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaBudgetYearView)->getBudgetYear($request->budget_year, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }
    
    /**
     * Display budget type in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function budgetType(AccountsMappingRequest $request) 
    {
       $collection = (new PtglCoaBudgetTypeView)->getBudgetType($request->budget_type, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display budget detail in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function budgetDetail(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaBudgetDetailView)->getBudgetDetail($request->budget_detail, $request->description, $request->budget_type);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display budget reason in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function budgetReason(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaBudgetReasonView)->getBudgetReason($request->budget_reason, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display budget reason in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function mainAccount(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaMainAccountView)->getMainAccount($request->main_account, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display sub account in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function subAccount(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaSubAccountView)->getSubAccount($request->sub_account, $request->description, $request->main_account);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display reserved1 in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function reserved1(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaReserved1View)->getReserved1($request->reserved1, $request->description);
       $response = new \stdClass();
       $response->data = $collection;

       return response()->json($response);
    }

    /**
     * Display reserved2 in table
     * 
     * @return \Illuminate\Http\Response
     */
    public function reserved2(AccountsMappingRequest $request)
    {
       $collection = (new PtglCoaReserved2View)->getReserved2($request->reserved1, $request->description);
       $response = new \stdClass();
       $response->data = $collection;
       
       return response()->json($response);
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountsMappingRequest $request)
    {
      $requestData = $request->all()['data'];
      $validator = Validator::make($requestData, [
           'account_code_combine'     => 'required',
           'row.*.account_code'     => 'required|max:50',
           'row.*.description'      => 'required|max:250',
           'row.*.company_code'     => 'required|max:150',
           'row.*.department_code'  => 'required|max:150',
           'row.*.evm_code'         => 'required|max:150',
           'row.*.cost_center_code' => 'required|max:150',
           'row.*.budget_year'      => 'required|max:150',
           'row.*.budget_type'      => 'required|max:150',
           'row.*.budget_detail'    => 'required|max:150',
           'row.*.budget_reason'    => 'required|max:150',
           'row.*.main_account'     => 'required|max:150',
           'row.*.sub_account'      => 'required|max:150',
           'row.*.reserved1'        => 'required|max:150',
           'row.*.reserved2'        => 'required|max:150',
      ]);
      $validator->validate();
      
      $userId = optional(auth()->user())->user_id ?? -1;
      $data['account_combine_desc'] = $requestData['account_combine_desc'];
      $data['account_code_combine'] = $requestData['account_code_combine'];
      foreach($requestData['rows'] as $arrData) {
         $data['account_code']         = $arrData['account_code'];
         $data['description']          = $arrData['description'];
         $data['segment_1']            = $arrData['company_code'];
         $data['segment_2']            = $arrData['department_code'];
         $data['segment_3']            = $arrData['evm_code'];
         $data['segment_4']            = $arrData['cost_center_code'];
         $data['segment_5']            = $arrData['budget_year'];
         $data['segment_6']            = $arrData['budget_type'];
         $data['segment_7']            = $arrData['budget_detail'];
         $data['segment_8']            = $arrData['budget_reason'];
         $data['segment_9']            = $arrData['main_account'];
         $data['segment_10']           = $arrData['sub_account'];
         $data['segment_11']           = $arrData['reserved1'];
         $data['segment_12']           = $arrData['reserved2'];
         $data['active_flag']          = $arrData['active_flag'];
         $data['program_code']         = $arrData['program_code'];
         $data['created_at']           = Carbon::now();
         $data['created_by_id']        = $userId;
         $data['created_by']           = $userId;
         $data['last_updated_by']      = $userId;
         $data['creation_date']        = Carbon::now();
         $data['last_update_date']     = Carbon::now();

         AccountsMapping::create($data);

      }

      return response()->json('Success');

    }

   public function getAccountDesc()
   {
      $accountMapping  = AccountsMapping::find(request()->account_id);
      // dd(request()->all(), $accountMapping);
      $segment1  = (new Company)->getDesciption($accountMapping->segment_1);
      $segment2  = (new Evm)->getDesciption($accountMapping->segment_2);
      $segment3  = (new Department)->getDesciption($accountMapping->segment_3);
      $segment4  = (new CostCenter)->getDesciption($accountMapping->segment_4);
      $segment5  = (new BudgetYear)->getDesciption($accountMapping->segment_5);
      $segment6  = (new BudgetType)->getDesciption($accountMapping->segment_6);
      $segment7  = (new BudgetDetail)->getDesciption($accountMapping->segment_7);
      $segment8  = (new BudgetReason)->getDesciption($accountMapping->segment_8);
      $segment9  = (new MainAccount)->getDesciption($accountMapping->segment_9);
      $segment10 = (new SubAccount)->getDesciption($accountMapping->segment_10);
      $segment11 = (new Reserved1)->getDesciption($accountMapping->segment_11);
      $segment12 = (new Reserved2)->getDesciption($accountMapping->segment_12);

      $data = $segment1.'.'.$segment2.'.'.$segment3.'.'.$segment4.'.'.$segment5.'.'.$segment6.'.'.$segment7.'.'.$segment8.'.'.$segment9.'.'.$segment10.'.'.$segment11.'.'.$segment12;

      // dd($data);
      return response()->json($data);

   }

   public function validateAccountsMapping()
   {
      // dd('validateAccountsMapping', request()->all());
      if (request()->type == 'code') {
         $check = AccountsMapping::where('account_code', request()->account_code)->first();

         if ($check) {
            $data = true;
         } else {
            $data = false;
         }
         



         return response()->json($data);
      } else {

         if (request()->account_id) {
            $check = AccountsMapping::where('account_id', '!=', request()->account_id)
                                    ->where('description', request()->description)
                                    ->first();
         } else {
            $check = AccountsMapping::where('description', request()->description)->first();
         }

         if ($check) {
            $data = true;
         } else {
            $data = false;
         }

         return response()->json($data);
      }
      
   }

   public function updateActiveFlag()
   {
      $user = auth()->user();

      $accountMapping  = AccountsMapping::find(request()->account_id);

      // $accountMapping->active_flag             = request()->active_flag ? 'Y' : 'N';
      // $accountMapping->last_updated_by         = $user->user_id;
      // $accountMapping->save();

      // $data = ['status' => 'success'];

      // return response()->json($data);

      // dd('updateActiveFlag', request()->all(), $accountMapping);


      //   if($accountMapping != null){
            // if($accountMapping->active_flag == 'Y'){
            //     $data = ['status' => 'error'];
            //     return response()->json($data); 
            // }else {
                (new AccountsMapping)->updateActiveFlag(request()->account_id, request()->active_flag, $user->user_id);

                $data = ['status' => 'success'];
                
                return response()->json($data);
            // }
      //   }
      //   else {
      //       (new AccountsMapping)->updateActiveFlag(request()->account_id, request()->active_flag, $user->user_id);
      //       $data = ['status' => 'success'];
      //       return response()->json($data);
      //   }
   }
}
