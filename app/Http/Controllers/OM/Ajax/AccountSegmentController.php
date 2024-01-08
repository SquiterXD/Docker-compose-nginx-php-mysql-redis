<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\Company;
use App\Models\OM\Settings\Evm;
use App\Models\OM\Settings\Department;           
use App\Models\OM\Settings\CostCenter;
use App\Models\OM\Settings\BudgetYear;
use App\Models\OM\Settings\BudgetType;
use App\Models\OM\Settings\BudgetDetail;
use App\Models\OM\Settings\BudgetReason;
use App\Models\OM\Settings\MainAccount;
use App\Models\OM\Settings\SubAccount;
use App\Models\OM\Settings\Reserved1;
use App\Models\OM\Settings\Reserved2;


class AccountSegmentController extends Controller
{
    public function index(Request $request)
    {
        $setName = request()->flex_value_set_name;
        $text  = request()->get('query');

        $request->validate([
            'flex_value_set_name' => 'required',
        ]);

        // dd($request->all(), $setName, getPrefixValueSetName());
        $setParent = $request->flex_value_parent;

        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
            $data = Company::selectRaw('meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {
        // } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER') {
            $data = CostCenter::selectRaw('meaning, description, flex_value_set_name')
                            ->where('flex_value_set_name', $setName)
                            ->where('department_code', $setParent)
                            ->when($text, function ($query, $text) {
                            return $query->where(function($r) use ($text) {
                                $r->where('description', 'like', "%${text}%")
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
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
                                    ->orWhere('meaning', 'like', "%${text}%");
                            });
                        })
                        ->get();

            return response()->json($data);

        }
        
    }

    public function testSubAccount(Request $request)
    {
        // dd(request()->all());
        $setName = getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $valueName = request()->set_name;
        // $request->validate([
        //     'main_account' => 'required',
        // ]);

        $text  = request()->get('query');
        $data = SubAccount::selectRaw('meaning, description, flex_value_set_name')
                        ->where('flex_value_set_name', $valueName)
                        ->where('main_account', request()->main_account_id)
                        ->when($text, function ($query, $text) {
                        return $query->where(function($r) use ($text) {
                            $r->where('description', 'like', "%${text}%")
                                ->orWhere('meaning', 'like', "%${text}%");
                        });
                    })
                    ->get();

        return response()->json($data);
    }

}
