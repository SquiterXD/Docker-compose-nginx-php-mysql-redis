<?php

namespace App\Http\Controllers\OM\CreditNote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\CreditNote\CustomerModel;
use App\Models\OM\CreditNote\ThaiTerritoryModel;
use App\Models\OM\CreditNote\AccountsMappingModel;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\CreditNote\PeriodModel;
use App\Models\OM\CreditNote\InvoiceHeaderModel;

// ptgl
use App\Models\OM\CreditNote\Ptgl\CoaCompanyVModel;
use App\Models\OM\CreditNote\Ptgl\CoaEvmVModel;
use App\Models\OM\CreditNote\Ptgl\CoaDeptCodeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaCostCenterVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetYearVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetTypeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetDetailVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetReasonVModel;
use App\Models\OM\CreditNote\Ptgl\CoaMainAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaSubAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved1VModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved2VModel;

class CreditNoteOtherController extends Controller
{
    public function index()
    {
        $list  = InvoiceHeaderModel::where('program_code','OMP0033')->orderBy('creation_date','desc')->get();
        $account_list = AccountsMappingModel::select('ptom_accounts_mapping_v.*','ptom_mapping_account_code_gl.account_combine_desc')
                                            ->leftJoin('ptom_mapping_account_code_gl','ptom_mapping_account_code_gl.account_code','=','ptom_accounts_mapping_v.account_code')
                                            ->get();
        foreach($account_list as $acc_item){
            $account_mapping[$acc_item->account_code] = [
                'account_code'          => $acc_item->account_code,
                'account_combine'       => $acc_item->account_combine,
                'account_description'   => $acc_item->account_description,
                'combine_desc'          => $acc_item->account_combine_desc,
            ];
        }

        $accont_gl      = MappingAccountModel::where('account_code','06')->first();
        $accont_cr_gl   = MappingAccountModel::where('account_code','TRX-DOM-Sales Invoice-01')->first();
        
        $period     = PeriodModel::where('start_period','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_period','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_period');
                                    })->first();
        if(!empty($period->budget_year)){
            $budget_year = $period->budget_year + 543;
        }else{
            $budget_year = date('Y') + 543;
        }
        
        $buget_year_segment =  substr($budget_year,-2);

        $segment = [
           'company'        => CoaCompanyVModel::where('company_code','01')->get(),
           'evm'            => CoaEvmVModel::get(),
           'dept'           => CoaDeptCodeVModel::get(),
           'costCenter'     => CoaCostCenterVModel::get(),
           'budgetYear'     => CoaBudgetYearVModel::get(),
           'budgetType'     => CoaBudgetTypeVModel::get(),
           'budgetDetail'   => CoaBudgetDetailVModel::get(),
           'budgetReason'   => CoaBudgetReasonVModel::get(),
           'mainAccount'    => CoaMainAccountVModel::get(),
           'subAccount'     => CoaSubAccountVModel::get(),
           'reserved1'      => CoaReserved1VModel::get(),
           'reserved2'      => CoaReserved2VModel::get()
        ];

        return view('om.creditnote.other',compact('segment','account_mapping','accont_gl','accont_cr_gl','buget_year_segment','list'));
    }
}
