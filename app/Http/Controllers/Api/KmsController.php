<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KmsController extends Controller
{

    public function expenseAll($type, $budgetYear, $periodNo)
    {
        try {

            $data = collect(\DB::select("
                SELECT
                    *
                FROM TOAT_KMS_EXPENSE_ALL_V
                WHERE  1=1
                and request_type    = {$type}
                and period_no       = {$periodNo}
                and budget_year     = '{$budgetYear}'
            "));

            if (count($data)) {
                $data = $data->first();
            } else {
                $data = '';
            }
            // throw new \Exception("ไม่พบค่า to_currency_code");
            $data = [
                'status' => 'S',
                'data' => $data,
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        // return response()->json($data);
        return response()->json(['data' => $data]);
    }

    // toat_kms_expense_departments_v

    public function expenseDept($oaDepartment, $budgetYear, $periodNo)
    {
        try {

            $data = collect(\DB::select("
                SELECT
                    *
                FROM TOAT_KMS_EXPENSE_DEPARTMENTS_V
                WHERE  1=1
                and oa_department   = '{$oaDepartment}'
                and budget_year     = {$budgetYear}
                and period_no       = {$periodNo}
            "));

            if (count($data)) {
                $data = $data;
            } else {
                $data = '';
            }
            // throw new \Exception("ไม่พบค่า to_currency_code");
            $data = [
                'status' => 'S',
                'data' => $data,
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        // return response()->json($data);
        return response()->json(['data' => $data]);
    }

    public function sumExpDepartment($budgetYear, $periodNo)
    {
        try {

            $data = collect(\DB::select("
                SELECT
                    *
                FROM    PTKMS_SUM_EXP_DEPARTMENTS_V
                WHERE  1=1
                and budget_year     = {$budgetYear}
                and period_no       = {$periodNo}
            "));

            if (count($data)) {
                $data = $data;
            } else {
                $data = '';
            }
            // throw new \Exception("ไม่พบค่า to_currency_code");
            $data = [
                'status' => 'S',
                'data' => $data,
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        // return response()->json($data);
        return response()->json(['data' => $data]);
    }

    public function sumExpAll($budgetYear, $periodNo)
    {
        try {

            $data = collect(\DB::select("
                SELECT
                    line_item,
                    sum(amount) amount
                FROM    PTKMS_SUM_EXP_ALL_V
                WHERE  1=1
                and budget_year     = {$budgetYear}
                and period_no       = {$periodNo}
                GROUP BY line_item
                order by line_item
            "));

            if (count($data)) {
                $data = $data;
            } else {
                $data = '';
            }
            // throw new \Exception("ไม่พบค่า to_currency_code");
            $data = [
                'status' => 'S',
                'data' => $data,
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        // return response()->json($data);
        return response()->json(['data' => $data]);
    }
}
