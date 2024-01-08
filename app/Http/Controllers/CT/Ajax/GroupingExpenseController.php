<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\GroupingExpenseV;
use App\Models\CT\GroupingBudgetV;

use App\Models\CT\GroupingExpenseHead;
use App\Models\CT\GroupingExpenseLine;

use App\Models\CT\GroupingBudgetHead;
use App\Models\CT\GroupingBudgetLine;

class GroupingExpenseController extends Controller
{
    public function store(Request $request)
    {
        // dd('CTM0011 store ', request()->all());
        if (request()->type == 'expense') {
            $department_code = request()->expense_department_code;

            $departments = collect(\DB::select("
                SELECT DISTINCT D.dept_code
                    , apps.gl_flexfields_pkg.get_description_sql  
                    (D.COA_ID, 3,  DEPT_CODE)     dept_desc
                FROM  PTCT_ACCOUNT_DEPT_V       D
                WHERE dept_code = '{$department_code}'
                and ROWNUM <=1
            "));

            $department = $departments[0];

            $expenseHead              = new GroupingExpenseHead;
            $expenseHead->dept_code   = $department->dept_code;
            $expenseHead->description = $department->dept_desc;
            $expenseHead->save();
        } 

        if (request()->type == 'budget') {
            $department_code = request()->budget_department_code;

            $departments = collect(\DB::select("
                SELECT DISTINCT D.dept_code
                    , apps.gl_flexfields_pkg.get_description_sql  
                    (D.COA_ID, 3,  DEPT_CODE)     dept_desc
                FROM  PTCT_ACCOUNT_DEPT_V       D
                WHERE dept_code = '{$department_code}'
                and ROWNUM <=1
            "));

            $department = $departments[0];

            $expenseHead              = new GroupingBudgetHead;
            $expenseHead->dept_code   = $department->dept_code;
            $expenseHead->description = $department->dept_desc;
            $expenseHead->save();
        }
        
        

        return response()->json(['msg' => 'success'], 200);
    }

    public function getDetail()
    {
        // dd('getDetail', request()->all());
        if (request()->type == 'expense') {
            $data = GroupingExpenseV::where('group_exp_head_id', request()->header_id)
                    ->orderBy('allocate_dept_code')
                    ->get();
        }

        if (request()->type == 'budget') {
            $data = GroupingBudgetV::where('group_budget_head_id', request()->header_id)
                    ->orderBy('allocate_dept_code')
                    ->get();
        }

        // dd('getDetail', request()->all(), $data);

        return response()->json($data);
    }

    public function storeDetail(Request $request)
    {
        // dd('storeDetail', request()->all());

        $department_code = request()->department_code;
        $cost_code_from  = request()->cost_code_from;
        $cost_code_to    = request()->cost_code_to;

        if (request()->type == 'expense') {
            $header = GroupingExpenseV::where('group_exp_head_id', request()->header_id)->first();

            $departments = collect(\DB::select("
                SELECT DISTINCT D.dept_code
                    , apps.gl_flexfields_pkg.get_description_sql  
                    (D.COA_ID, 3,  DEPT_CODE)     dept_desc
                FROM  PTCT_ACCOUNT_DEPT_V       D
                WHERE dept_code = '{$department_code}'
                and ROWNUM <=1
            "));

            $department = count($departments) > 0 ? $departments[0] : '';

            $costsFrom = $this->getCost($department_code, $cost_code_from);
            $costsTo   = $this->getCost($department_code, $cost_code_to);

            $costFrom = count($costsFrom) > 0 ? $costsFrom[0] : '';
            $costTo   = count($costsTo) > 0 ? $costsTo[0] : '';

            $line = new GroupingExpenseLine;
            $line->group_exp_head_id    = $header->group_exp_head_id;
            $line->allocate_dept_code   = request()->department_code;
            $line->allocate_description = $department->dept_desc;
            $line->cost_code_from       = request()->cost_code_from;
            $line->cost_code_from_desc  = $costFrom->cost_code_desc;
            $line->cost_code_to         = request()->cost_code_to;
            $line->cost_code_to_desc    = $costTo->cost_code_desc;
            $line->save();
        }

        if (request()->type == 'budget') {
            $header = GroupingBudgetV::where('group_budget_head_id', request()->header_id)->first();

            $departments = collect(\DB::select("
                SELECT DISTINCT D.dept_code
                    , apps.gl_flexfields_pkg.get_description_sql  
                    (D.COA_ID, 3,  DEPT_CODE)     dept_desc
                FROM  PTCT_ACCOUNT_DEPT_V       D
                WHERE dept_code = '{$department_code}'
                and ROWNUM <=1
            "));

            $department = count($departments) > 0 ? $departments[0] : '';

            $costsFrom = $this->getCost($department_code, $cost_code_from);
            $costsTo   = $this->getCost($department_code, $cost_code_to);

            $costFrom = count($costsFrom) > 0 ? $costsFrom[0] : '';
            $costTo   = count($costsTo) > 0 ? $costsTo[0] : '';

            $line = new GroupingBudgetLine;
            $line->group_budget_head_id    = $header->group_budget_head_id;
            $line->allocate_dept_code   = request()->department_code;
            $line->allocate_description = $department->dept_desc;
            $line->cost_code_from       = request()->cost_code_from;
            $line->cost_code_from_desc  = $costFrom->cost_code_desc;
            $line->cost_code_to         = request()->cost_code_to;
            $line->cost_code_to_desc    = $costTo->cost_code_desc;
            $line->save();
        }

        return response()->json(['msg' => 'success'], 200);
    }

    public function getCost($departmentCode, $costCode)
    {
        $costs = collect(\DB::select("
                SELECT  FFS.FLEX_VALUE            DEPARTMENT
                        ,VALUE_DESCRIPTION         DEPT_DESC
                        ,ffv.flex_value             COST_CODE
                        ,ffv.description            COST_CODE_DESC       
                FROM  FND_FLEX_KEY_SEG_VSET_V  ffs
                        ,FND_FLEX_VALUES_VL   ffv
                WHERE  (ID_FLEX_NAME = 'Accounting Flexfield')
                AND (SEGMENT_NAME = 'Cost Center')
                and id_flex_code = 'GL#'
                AND (ffs.FLEX_VALUE =   '{$departmentCode}' )
                AND (ffv.FLEX_VALUE =   '{$costCode}' )
                and  ffs.flex_value_set_id = ffv.FLEX_VALUE_SET_ID
                and ffs.FLEX_VALUE =  ffv.parent_flex_value_low 
                and ffv.enabled_flag  = 'Y'
                and ROWNUM <=1
                order by FFS.FLEX_VALUE ,ffv.flex_value 
        "));

        return $costs;
    }

    public function destroy($id)
    {
        if (request()->type == 'expense') {
            $header = GroupingExpenseHead::find($id);
            $header->delete();
            // dd('destroy', request()->all(), $id, $header);
        }

        if (request()->type == 'budget') {
            $header = GroupingBudgetHead::find($id);
            $header->delete();
            // dd('destroy', request()->all(), $id, $header);
        }
        return response()->json(['msg' => 'success'], 200);
    }

    public function destroyDetail($id)
    {
        if (request()->type == 'expense') {
            $line = GroupingExpenseLine::find($id);
            $line->delete();
        }

        if (request()->type == 'budget') {
            $line = GroupingBudgetLine::find($id);
            $line->delete();
        }

        return response()->json(['msg' => 'success'], 200);
    }

    public function checkDetail()
    {
        if (request()->type == 'expense') {
            $data = GroupingExpenseV::where('group_exp_head_id', request()->header_id)
                    ->whereNotNull('group_exp_line_id')
                    ->get();
        }

        if (request()->type == 'budget') {
            $data = GroupingBudgetV::where('group_budget_head_id', request()->header_id)
                    ->whereNotNull('group_budget_line_id')
                    ->get();
        }

        return response()->json($data);
    }
}
