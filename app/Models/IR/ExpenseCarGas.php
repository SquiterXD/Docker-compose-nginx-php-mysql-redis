<?php

namespace App\Models\IR;

use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\Views\PtBiweeklyView;
use App\Models\IR\Views\PtirCarsView;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

class ExpenseCarGas extends Model
{
    use HasFactory;

    public function getExpenseCarGas($year, $month, $type, $groupCode, $typeCode, $status, $licensePlate, $renewType)
    {
        if ($year == null || $year == '') {
            $periodYear =  (new GlPeriodYearView())->getYear($month);
            $periodYear =  isset($periodYear->period_year) ? $periodYear->period_year : '';
            $year = isset($periodYear) ? $periodYear : '';
        }

        $new_expenses_case_renew_inspection_id = DB::table('oair.ptir_expense_car_gas as expense')
        ->select(DB::raw("
            expense.expense_id
        "))
        ->join('oair.ptir_cars_v as car_v', 'expense.document_header_id', '=', 'car_v.car_id')
        ->whereRaw("
            to_date(?, 'mm/yyyy') between to_date(to_char(car_v.start_date, 'mm/yyyy'), 'mm/yyyy') and last_day(to_date(to_char(car_v.end_date -1, 'mm/yyyy'), 'mm/yyyy'))
            and car_v.row_type = 'PTIR_RENEW_CAR_INSPECTION' 
            and car_v.group_code = nvl(?, car_v.group_code)
            and car_v.license_plate = nvl(?, car_v.license_plate) 
            and car_v.status = 'CONFIRMED'
            and expense.expense_type_code = 'CAR001'
            and expense.status = 'NEW'
            and expense.group_code = nvl(?, expense.group_code) 
            and expense.license_plate = nvl(?, expense.license_plate)
            and expense.renew_type = nvl(?, expense.renew_type)
            and 'CAR001' = nvl(?, 'CAR001')
        ",
            [$month, $groupCode, $licensePlate, $groupCode, $licensePlate, $renewType, $type]
        )
        ->pluck('expense.expense_id');

        $remove_new_expenses_case_renew_inspection = PtirExpenseCarGas::whereIn('expense_id', $new_expenses_case_renew_inspection_id)
        ->delete();

        $remove_new_expenses = PtirExpenseCarGas::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$month])
        ->where(function ($q){
            return $q->where('status', 'NEW');
        })
        ->when(!!$groupCode, function($q) use($groupCode){
            return $q->where('group_code', $groupCode);
        })
        ->when(!!$typeCode, function($q) use($typeCode){
            return $q->where('gas_station_type_code', $typeCode);
        })
        ->when(!!$licensePlate, function($q) use($licensePlate){
            return $q->where('license_plate', $licensePlate);
        })
        ->when(!!$renewType, function($q) use($renewType){
            return $q->where('renew_type', $renewType);
        })
        ->where('expense_type_code', $type)
        ->delete();

        $has_expense_car_gas = PtirExpenseCarGas::whereRaw("period_name = to_char(to_date(?, 'mm/yyyy'), 'Mon-yy')", [$month])
        ->where('status', '!=', 'CANCELLED')
        ->when(!!$groupCode, function($q) use($groupCode){
            return $q->where('group_code', $groupCode);
        })
        ->when(!!$typeCode, function($q) use($typeCode){
            return $q->where('gas_station_type_code', $typeCode);
        })
        ->when(!!$licensePlate, function($q) use($licensePlate){
            return $q->where('license_plate', $licensePlate);
        })
        ->when(!!$renewType, function($q) use($renewType){
            return $q->where('renew_type', $renewType);
        })
        ->where('expense_type_code', $type)
        ->pluck('document_header_id')
        ->toArray();

        $gasStation = DB::table('oair.ptir_extend_gas_stations_v as a')->select(DB::raw(
            "   
                null as expense_id,
                null as document_number,
                a.expense_flag,
                a.reference_header_id ,
                a.reference_line_id,
                null as reference_document_number,
                null as expense_type_code,
                'NEW' as status,
                a.department_code,
                a.department_name, 
                a.group_code, 
                a.group_name, 
                null as renew_type, 
                null as renew_type_code,
                null as license_plate, 
                a.type_code,
                a.type_name,
                to_char(a.start_date, 'dd/mm/yyyy') as start_date,
                to_char(a.end_date, 'dd/mm/yyyy') as end_date, 
                a.expense_account_id, 
                a.expense_account, 
                a.expense_account_desc,
                a.prepaid_account_id, 
                a.prepaid_account, 
                a.prepaid_account_desc,
                a.policy_set_header_id,
                b.policy_set_description,
                a.insurance_amount, 
                a.discount, 
                a.duty_amount, 
                a.vat_amount, 
                (case when a.vat_refund = 'Y' then 
                    (case when ? = to_char(a.start_date, 'mm/yyyy') then
                        round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) * (to_number(to_char(last_day(a.start_date), 'dd')) -  to_number(to_char(a.start_date, 'dd')) + 1) / a.total_days, 2)
                    when ? = to_char(a.end_date - 1, 'mm/yyyy') then
                        round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) - (select nvl(sum(net_amount), 0) 
                            from ptir_expense_car_gas 
                            where document_header_id = a.ex_gas_station_id
                            and status != 'CANCELLED'), 2)
                    else 
                        round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) * to_number(to_char(last_day(to_date(?, 'mm/yyyy')), 'dd')) / a.total_days, 2)
                    end)
                when a.vat_refund = 'N' then
                    (case when ? = to_char(a.start_date, 'mm/yyyy') then
                        round(round(a.net_amount, 2) * (to_number(to_char(last_day(a.start_date), 'dd')) -  to_number(to_char(a.start_date, 'dd')) + 1) / a.total_days, 2)
                    when ? = to_char(a.end_date - 1, 'mm/yyyy') then
                        round(round(a.net_amount, 2) - (select nvl(sum(net_amount), 0) 
                            from ptir_expense_car_gas 
                            where document_header_id = a.ex_gas_station_id
                            and status != 'CANCELLED'), 2)
                    else 
                        round(round(a.net_amount, 2) * to_number(to_char(last_day(to_date(?, 'mm/yyyy')), 'dd')) / a.total_days, 2)
                    end) 
                end) net_amount, 
                a.vat_refund,
                'GAS001' as flag,
                a.ex_gas_station_id as document_header_id, 
                to_number(to_char(a.end_date, 'dd'))-1 day,
                abs(trunc(a.start_date - a.end_date)) as total_days,
                to_char(add_months(to_date(?, 'mm/yyyy'), 6516), 'mm/yyyy') period_name,
                null old_period_name,
                null month_between,
                null sold_flag,
                null flag_date,
                null row_type,
                null renew_program_code
            "))
            ->leftJoin('oair.ptir_policy_set_headers as b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
            ->whereRaw("to_date(?, 'mm/yyyy') between to_date(to_char(a.start_date, 'mm/yyyy'), 'mm/yyyy') and last_day(to_date(to_char(a.end_date -1, 'mm/yyyy'), 'mm/yyyy'))
                and a.group_code = nvl(?, a.group_code)
                and a.type_code = nvl(?, a.type_code)
                and 'GAS001' = nvl(?, 'GAS001')
                and a.status in ('CONFIRMED', 'INTERFACE')",
                [$month, $month, $month, $month, $month, $month, $month, 
                $month, $groupCode, $typeCode, $type]);

        if(count($has_expense_car_gas)){
            $gasStation->whereNotIn("a.ex_gas_station_id", $has_expense_car_gas);
        }

        $car = DB::table('oair.ptir_cars_v as a')->select(DB::raw(
            "
                null expense_id,
                null document_number,
                a.expense_flag,
                a.reference_header_id,
                a.reference_line_id,
                null reference_document_number,
                null expense_type_code,
                'NEW' status,
                a.location_code department_code, 
                a.location_description department_name, 
                a.group_code, 
                a.group_name, 
                a.renew_type, 
                a.renew_type_code, 
                a.license_plate, 
                null as type_code,
                null as type_name,
                to_char(a.start_date, 'dd/mm/yyyy') start_date,
                to_char(a.end_date, 'dd/mm/yyyy') end_date, 
                a.expense_account_id, 
                a.expense_account, 
                a.expense_account_desc,
                a.prepaid_account_id, 
                a.prepaid_account, 
                a.prepaid_account_desc,
                a.policy_set_header_id,
                a.policy_set_description,
                a.insurance_amount,
                a.discount,
                a.duty_amount, 
                a.vat_amount,
                (case when a.row_type = 'PTIR_RENEW_CAR_INSPECTION' then
                    a.insurance_expense
                else 
                    (case when c.sold_flag = 'Y' then 
                        (case when a.vat_refund = 'Y' then 
                            round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) - (select nvl(sum(net_amount), 0) 
                                from ptir_expense_car_gas 
                                where document_header_id = a.car_id
                                and status != 'CANCELLED'), 2)
                        when a.vat_refund = 'N' then
                            round(round(a.net_amount, 2) - (select nvl(sum(net_amount), 0) 
                                from ptir_expense_car_gas 
                                where document_header_id = a.car_id
                                and status != 'CANCELLED'), 2)
                        end) 
                    else
                    (case when a.vat_refund = 'Y' then 
                        (case when ? = to_char(a.start_date, 'mm/yyyy') then
                            round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) * (to_number(to_char(last_day(a.start_date), 'dd')) -  to_number(to_char(a.start_date, 'dd')) + 1) / a.total_days, 2)
                        when ? = to_char(a.end_date - 1, 'mm/yyyy') then
                            round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) - (select nvl(sum(net_amount), 0) 
                                from ptir_expense_car_gas 
                                where document_header_id = a.car_id
                                and status != 'CANCELLED'), 2)
                        else 
                            round(((round(a.insurance_amount, 2) - round(a.discount, 2)) + round(a.duty_amount, 2)) * to_number(to_char(last_day(to_date(?, 'mm/yyyy')), 'dd')) / a.total_days, 2)
                        end)
                        when a.vat_refund = 'N' then
                            (case when ? = to_char(a.start_date, 'mm/yyyy') then
                                round(round(a.net_amount, 2) * (to_number(to_char(last_day(a.start_date), 'dd')) -  to_number(to_char(a.start_date, 'dd')) + 1) / a.total_days, 2)
                            when ? = to_char(a.end_date - 1, 'mm/yyyy') then
                                round(round(a.net_amount, 2) - (select nvl(sum(net_amount), 0) 
                                    from ptir_expense_car_gas 
                                    where document_header_id = a.car_id
                                    and status != 'CANCELLED'), 2)
                            else 
                                round(round(a.net_amount, 2) * to_number(to_char(last_day(to_date(?, 'mm/yyyy')), 'dd')) / a.total_days, 2)
                            end) 
                        end)
                    end)
                end) net_amount,
                a.vat_refund, 
                'CAR001' flag,
                a.car_id document_header_id,
                to_number(to_char(last_day(a.start_date), 'dd')) day,
                abs(trunc(a.start_date - a.end_date)) total_days,
                to_char(add_months(to_date(?, 'mm/yyyy'), 6516), 'mm/yyyy') period_name,
                null old_period_name,
                trunc(MONTHS_BETWEEN(last_day(to_date(?, 'mm/yyyy')), a.start_date)) month_between,
                c.sold_flag,
                (case when c.sold_flag = 'Y' then
                    'Y'
                else 
                    'N'
                end) flag_date,
                a.row_type,
                (case when a.row_type = 'PTIR_RENEW_CAR_INSURANCES' then
                    'IRS0002'
                when a.row_type = 'PTIR_RENEW_CAR_ACT' then 
                    'IRS0003'
                when a.row_type = 'PTIR_RENEW_CAR_LICENSE_PLATE' then 
                    'IRS0004'
                when a.row_type = 'PTIR_RENEW_CAR_INSPECTION' then 
                    'IRS0005'
                else 
                    a.row_type
                end) renew_program_code
            "))
            // ->leftJoin('ptir_expense_car_gas as h', 'a.car_id', '=', 'h.document_header_id')
            ->leftJoin('oair.ptir_cars as b', 'a.car_id', '=', 'b.car_id')
            ->leftJoin('oair.ptir_vehicles as c', 'a.license_plate', '=', 'c.license_plate')
            ->whereRaw("to_date(?, 'mm/yyyy') between to_date(to_char(a.start_date, 'mm/yyyy'), 'mm/yyyy') and last_day(to_date(to_char(a.end_date -1, 'mm/yyyy'), 'mm/yyyy'))
                and a.group_code = nvl(?, a.group_code)
                and a.license_plate = nvl(?, a.license_plate) 
                and a.status = 'CONFIRMED'
                and 'CAR001' = nvl(?, 'CAR001')
                and b.receivable_code is null
                and b.renew_type = nvl(?, b.renew_type)
                ",
                [$month, $month, $month, $month, $month, $month, $month, $month,
                $month, $groupCode, $licensePlate, $type, $renewType]);

        if(count($has_expense_car_gas)){
            $car->whereNotIn("a.car_id", $has_expense_car_gas);
        }

        $has_car_confirm = PtirExpenseCarGas::whereRaw("to_date(period_name, 'Mon-yy') > to_date(?, 'mm/yyyy')", [$month])
            ->whereIn('status', ['CONFIRMED', 'INTERFACE'])
            ->where('expense_type_code', 'CAR001')
            ->when(!!$groupCode, function($q) use($groupCode){
                return $q->where('group_code', $groupCode);
            })
            ->when(!!$licensePlate, function($q) use($licensePlate){
                return $q->where('license_plate', $licensePlate);
            })
            ->when(!!$renewType, function($q) use($renewType){
                return $q->where('renew_type', $renewType);
            })
            ->pluck('document_header_id')
            ->toArray();

        if(count($has_car_confirm)){
            $car->whereNotIn("a.car_id", $has_car_confirm);
        }

        $has_car_renew_type_inspection = DB::table('oair.ptir_cars_v as car_v')
        ->select(DB::raw("
            car_v.car_id
        "))
        ->join('oair.ptir_expense_car_gas as expense', 'car_v.car_id', '=', 'expense.document_header_id')
        ->whereRaw("
            to_date(?, 'mm/yyyy') between to_date(to_char(car_v.start_date, 'mm/yyyy'), 'mm/yyyy') and last_day(to_date(to_char(car_v.end_date -1, 'mm/yyyy'), 'mm/yyyy'))
            and car_v.row_type = 'PTIR_RENEW_CAR_INSPECTION' 
            and car_v.group_code = nvl(?, car_v.group_code)
            and car_v.license_plate = nvl(?, car_v.license_plate) 
            and car_v.status = 'CONFIRMED'
            and expense.expense_type_code = 'CAR001'
            and UPPER(expense.status) in ('CONFIRMED', 'INTERFACE')
            and 'CAR001' = nvl(?, 'CAR001')
        ",
            [$month, $groupCode, $licensePlate, $type]
        )
        ->pluck('car_v.car_id')
        ->toArray();
        
        if(count($has_car_renew_type_inspection)){
            $car->whereNotIn("a.car_id", $has_car_renew_type_inspection);
        }

        $collection = $car
            ->union($gasStation)
            ->orderByRaw("group_code asc, renew_program_code asc, renew_type_code asc, license_plate asc")
            ->get();

        $collection2 = [];    
        $arrData = [];

        foreach($collection as $element) { 

            if($element->flag == 'CAR001') {
                if( !in_array($element->row_type, ['PTIR_RENEW_CAR_INSPECTION']) ){
                    if(Carbon::createFromFormat('d/m/Y', $element->end_date)->format('m/Y') != $month){

                        $last_period = optional(PtirExpenseCarGas::selectRaw("
                            to_char(to_date(period_name, 'Mon-yy'), 'mm/yyyy') old_period_name,
                            to_char(to_date(period_name, 'Mon-yy'), 'yyyy-mm') order_period
                        ")
                        ->where(function($q){
                            $q->where('status', '!=', 'CANCELLED')
                            ->whereIn('status', ['CONFIRMED', 'INTERFACE']);
                        })
                        ->where('expense_type_code', $type)
                        ->where('document_header_id', $element->document_header_id)
                        ->orderByRaw('order_period desc')
                        ->first())->old_period_name;

                        $diff = $last_period 
                            ? Carbon::createFromFormat('m/Y', $last_period)->addMonths(1)->diffInMonths(Carbon::createFromFormat('m/Y', $month)) 
                            : Carbon::createFromFormat('d/m/Y', $element->start_date)->diffInMonths(Carbon::createFromFormat('m/Y', $month)->endOfMonth());

                        if (!!$diff && $element->flag_date == 'N') {
                            for($i=1; $i <= $diff;$i++){
                                $negativeMonth = -1 * $i;
                                $netAmount = PtirCarsView::selectRaw(
                                    "(case when vat_refund = 'Y' then 
                                        (case when to_char(add_months(to_date(?, 'mm/yyyy'), ?), 'mm/yyyy') = to_char(start_date, 'mm/yyyy') then
                                            round(((round(insurance_amount, 2) - round(discount, 2)) + round(duty_amount, 2)) * (to_number(to_char(last_day(start_date), 'dd')) -  to_number(to_char(start_date, 'dd')) + 1) / total_days, 2)
                                        when to_char(add_months(to_date(?, 'mm/yyyy'), ?), 'mm/yyyy') = to_char(end_date, 'mm/yyyy') then
                                            round(((round(insurance_amount, 2) - round(discount, 2)) + round(duty_amount, 2)) - (select nvl(sum(net_amount), 0) 
                                                from ptir_expense_car_gas 
                                                where document_header_id = car_id
                                                and status != 'CANCELLED'), 2)
                                        else 
                                            round(((round(insurance_amount, 2) - round(discount, 2)) + round(duty_amount, 2)) * to_number(to_char(last_day(add_months(to_date(?, 'mm/yyyy'), ?)), 'dd')) / total_days, 2)
                                        end)
                                    when vat_refund = 'N' then
                                        (case when to_char(add_months(to_date(?, 'mm/yyyy'), ?), 'mm/yyyy') = to_char(start_date, 'mm/yyyy') then
                                            round(round(net_amount, 2) * (to_number(to_char(last_day(start_date), 'dd')) -  to_number(to_char(start_date, 'dd')) + 1) / total_days, 2)
                                        when to_char(add_months(to_date(?, 'mm/yyyy'), ?), 'mm/yyyy') = to_char(end_date, 'mm/yyyy') then
                                            round(round(net_amount, 2) - (select nvl(sum(net_amount), 0) 
                                                from ptir_expense_car_gas 
                                                where document_header_id = car_id
                                                and status != 'CANCELLED'), 2)
                                        else 
                                            round(round(net_amount, 2) * to_number(to_char(last_day(add_months(to_date(?, 'mm/yyyy'), ?)), 'dd')) / total_days, 2)
                                        end) 
                                    end) net_amount", 
                                    [
                                        $month, $negativeMonth, $month, $negativeMonth, $month, $negativeMonth, $month, $negativeMonth, $month, $negativeMonth, $month, $negativeMonth
                                    ]) 
                                ->where('car_id', $element->document_header_id)
                                ->first();

                                $element->net_amount += $netAmount->net_amount;
                            }
                        }
                    }
                }
            }
            // if ($element->reference_document_number != null && $element->old_period_name == $month) {
            //     array_push($collection2, $element);
            // }
        }

        $now = Carbon::now();
        foreach($collection as $element) {
            $expense                            = new PtirExpenseCarGas;
            $expense->status                    = $element->status;
            $expense->period_name               = Carbon::createFromFormat('m/Y', $element->period_name)->subYears(543)->format('M-y');
            $expense->document_header_id        = $element->document_header_id;
            $expense->expense_type_code         = $element->flag;
            $expense->policy_set_header_id      = $element->policy_set_header_id;
            $expense->policy_set_description    = $element->policy_set_description;
            $expense->group_code                = $element->group_code;
            $expense->department_code           = $element->department_code;
            $expense->department_name           = $element->department_name;
            $expense->renew_type_code           = $element->renew_type_code;
            $expense->renew_type                = $element->renew_type;
            $expense->license_plate             = $element->license_plate;
            $expense->gas_station_type_code     = $element->type_code;
            $expense->gas_station_type_name     = $element->type_name;
            $expense->net_amount                = $element->net_amount;
            $expense->start_date                = Carbon::createFromFormat('d/m/Y', $element->start_date)->format('Y-m-d');
            $expense->end_date                  = Carbon::createFromFormat('d/m/Y', $element->end_date)->format('Y-m-d');
            $expense->total_days                = $element->total_days;
            $expense->expense_account_id        = $element->expense_account_id;
            $expense->expense_account           = $element->expense_account;
            $expense->expense_account_desc      = $this->getAccountDesc($expense->expense_account);
            $element->expense_account_desc      = $expense->expense_account_desc;
            // $expense->expense_account_desc      = $element->expense_account_desc;
            $expense->prepaid_account_id        = $element->prepaid_account_id;
            $expense->prepaid_account           = $element->prepaid_account;
            $expense->prepaid_account_desc      = $this->getAccountDesc($expense->prepaid_account);
            $element->prepaid_account_desc      = $expense->prepaid_account_desc;
            // $expense->prepaid_account_desc      = $element->prepaid_account_desc;
            $expense->program_code              = 'IRP0009';
            $expense->created_at                = $now;
            $expense->updated_at                = $now;
            $expense->created_by_id             = optional(auth()->user())->user_id ?? -1;
            $expense->updated_by_id             = optional(auth()->user())->user_id ?? -1;
            $expense->created_by                = optional(auth()->user())->user_id ?? -1;
            $expense->last_updated_by           = optional(auth()->user())->user_id ?? -1;
            $expense->creation_date             = $now;
            $expense->last_update_date          = $now;
            $expense->expense_flag              = $element->expense_flag;
            $expense->save();

            $arrData[$element->flag][$element->document_header_id] = $element;
            $element->expense_id                = $expense->expense_id;
        }

        foreach($arrData as $index) {
            foreach($index as $obj) {
                if ($obj->net_amount != 0) {
                    array_push($collection2, $obj);
                }
            }
        }
        return $collection2;
    }

    private function getAccountDesc($account)
    {
        //// return only segment 3, 9, 10
        $segment = explode('.', $account);
        if(count($segment) == 12){
            $desc = $this->getDesc(3, $segment[2]).'.'.$this->getDesc(9, $segment[8]).'.'.$this->getDesc(10, $segment[9], $segment[8]);
        }else $desc = null;

        return $desc;
    }

    private function getDesc($segment, $value, $parentValue = null)
    {
        switch ($segment) {
            case 1:
                $desc = (new Company)->getDesciption($value);
                break;
            case 2:
                $desc = (new Evm)->getDesciption($value);
                break;
            case 3:
                $desc = (new Department)->getDesciption($value);
                break;
            case 4:
                $desc = (new CostCenter)->getDesciption($value, $parentValue);
                break;
            case 5:
                $desc = (new BudgetYear)->getDesciption($value);
                break;
            case 6:
                $desc = (new BudgetType)->getDesciption($value);
                break;
            case 7:
                $desc = (new BudgetDetail)->getDesciption($value, $parentValue);
                break;
            case 8:
                $desc = (new BudgetReason)->getDesciption($value);
                break;
            case 9:
                $desc = (new MainAccount)->getDesciption($value);
                break;
            case 10:
                $desc = (new SubAccount)->getDesciption($value, $parentValue);
                break;
            case 11:
                $desc = (new Reserved1)->getDesciption($value);
                break;
            case 12:
                $desc = (new Reserved2)->getDesciption($value);
                break;
            default:
                $desc = null;
        }

        return $desc;
    }
}
