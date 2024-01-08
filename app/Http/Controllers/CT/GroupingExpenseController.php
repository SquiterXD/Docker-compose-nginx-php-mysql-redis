<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\GroupingExpenseV;
use App\Models\CT\GroupingBudgetV;

class GroupingExpenseController extends Controller
{
    public function index()
    {
        $groupingExpenses = GroupingExpenseV::selectRaw('distinct group_exp_head_id, dept_code, description')
                                ->orderBy('dept_code')
                                ->get();

        $groupingBudgets  = GroupingBudgetV::selectRaw('distinct group_budget_head_id, dept_code, description')
                                ->orderBy('dept_code')
                                ->get();

        $departments = collect(\DB::select("
            SELECT DISTINCT D.dept_code
                , apps.gl_flexfields_pkg.get_description_sql  
                (D.COA_ID, 3,  DEPT_CODE)     Dept_desc
            FROM  PTCT_ACCOUNT_DEPT_V       D
        "));


        return view('ct.grouping_expense.index', [
            'groupingExpenses' => $groupingExpenses,
            'groupingBudgets'  => $groupingBudgets,
            'departments'      => $departments
        ]);
    }

    public function create()
    {
        dd('CTM0011 create');
        // return view('ct.grouping_expense.create');
    }

    public function edit($id)
    {
        $type     = request()->type;
        $headerId = $id;

        if (request()->type == 'expense') {
            $header = GroupingExpenseV::where('group_exp_head_id', $id)->first();

            $details = GroupingExpenseV::where('group_exp_head_id', $id)
                    ->whereNotNull('group_exp_line_id')
                    ->orderBy('dept_code')
                    ->get();
        }

        if (request()->type == 'budget') {
            $header = GroupingBudgetV::where('group_budget_head_id', $id)->first();

            $details = GroupingBudgetV::where('group_budget_head_id', $id)
                    ->whereNotNull('group_budget_line_id')
                    ->orderBy('dept_code')
                    ->get();
        }

        $departments = collect(\DB::select("
            SELECT DISTINCT D.dept_code
                , apps.gl_flexfields_pkg.get_description_sql  
                (D.COA_ID, 3,  DEPT_CODE)     Dept_desc
            FROM  PTCT_ACCOUNT_DEPT_V       D
        "));

        $allocates = collect(\DB::select("
            SELECT  FFS.FLEX_VALUE            DEPARTMENT
                    ,VALUE_DESCRIPTION         DEPT_DESC
                    ,ffv.flex_value             COST_CODE
                    ,ffv.description            COST_CODE_DESC       
            FROM    FND_FLEX_KEY_SEG_VSET_V  ffs
                    ,FND_FLEX_VALUES_VL   ffv
            WHERE  (ID_FLEX_NAME = 'Accounting Flexfield')
            AND (SEGMENT_NAME = 'Cost Center')
            and id_flex_code = 'GL#'
            AND (ffs.FLEX_VALUE =   '{$header->dept_code}' )
            and  ffs.flex_value_set_id = ffv.FLEX_VALUE_SET_ID
            and ffs.FLEX_VALUE =  ffv.parent_flex_value_low 
            and ffv.enabled_flag  = 'Y'
            order by FFS.FLEX_VALUE ,ffv.flex_value 
        "));

        // dd($header->dept_code, $allocates);

        return view('ct.grouping_expense.edit', [
            'header'      => $header,
            'details'     => $details,
            'departments' => $departments,
            'allocates'   => $allocates,
            'type'        => $type,
            'headerId'    => $headerId,
        ]);
        // return view('ct.grouping_expense.create');
    }
}
