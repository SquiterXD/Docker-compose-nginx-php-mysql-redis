<?php

namespace App\Http\Controllers\INV;

use App\Http\Controllers\Controller;
use App\Models\INV\CarInfoV;
use App\Models\INV\WebFuelOil;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebFuelReportController extends Controller
{
    public function fuelSupplyReport()
    {
        return view('inv.disbursement_fuel.report.fuel_supply_report');
    }

    public function createFuelSupplyPDF()
    {
        $fromDate = request()->start_date;
        $toDate = request()->end_date;
        if (!$fromDate || !$toDate) {
            return redirect()->back()->with('error', 'กรุณาเลือกข้อมูลให้ครบถ้วน');
        }
        
        $webFuelOil = WebFuelOil::query()
            ->join('ptinv_web_fuel_dist', 'ptinv_web_fuel_oil.transaction_id', '=', 'ptinv_web_fuel_dist.transaction_id')
            ->join('PTINV_CAR_INFO_V', 'PTINV_CAR_INFO_V.car_license_plate', '=', 'PTINV_WEB_FUEL_OIL.car_license_plate')
            ->selectRaw("
                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' AND ptinv_web_fuel_dist.tax_amount != 0 THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as sum_gasoline_quantity,
                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' AND ptinv_web_fuel_dist.tax_amount = 0 THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as sum_gasoline_vat_quantity,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' AND ptinv_web_fuel_dist.tax_amount != 0 THEN 1 END) as count_gasoline_transaction,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' AND ptinv_web_fuel_dist.tax_amount = 0 THEN 1 END) as count_gasoline_vat_transaction,

                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' AND ptinv_web_fuel_dist.tax_amount != 0 THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as sum_diesel_quantity,
                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' AND ptinv_web_fuel_dist.tax_amount = 0 THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as sum_diesel_vat_quantity,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' AND ptinv_web_fuel_dist.tax_amount != 0 THEN 1 END) as count_diesel_transaction,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' AND ptinv_web_fuel_dist.tax_amount = 0 THEN 1 END) as count_diesel_vat_transaction,

                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as total_gasoline_quantity,
                SUM(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as total_diesel_quantity,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100002' THEN 1 END) as total_gasoline_transaction,
                COUNT(CASE WHEN PTINV_CAR_INFO_V.car_fuel = '180100008' THEN 1 END) as total_diesel_transaction
            ")
            ->when(request()->start_date, function($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)
                    ->setHour()
                    ->setMinute()
                    ->setSecond();
                $q->where('gl_date', '>=', $startDate);
            })
            ->when(request()->end_date, function($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)
                    ->setHour(23)
                    ->setMinute(59)
                    ->setSecond(59);
                $q->where('gl_date', '<=', $endDate);
            })
            ->whereNotNull('tran_id')
            ->first();

        $pdf = \DomPDF::loadView('inv.disbursement_fuel.report.fuel_supply_pdf', [
            "currentDate" => date('Ymd'),
            "startDate" => request()->start_date,
            "endDate" => request()->end_date,
            "webFuelOil" => $webFuelOil
        ])
        ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - 01 - WEB_FUEL_ยอดจ่ายน้ำมันเชื้อเพลิง_'.date('Ymd').'.pdf');
    }

    public function fuelPaymentSummaryReport()
    {
        return view('inv.disbursement_fuel.report.fuel_payment_summary_report');
    }

    public function createFuelPaymentSummaryPDF()
    {
        $fromDate = request()->start_date;
        $toDate = request()->end_date;
        $user = auth()->user();

        if (!$fromDate || !$toDate) {
            return redirect()->back()->with('error', 'กรุณาเลือกข้อมูลให้ครบถ้วน');
        }

        $webFuelOils = WebFuelOil::query()
            ->join('ptinv_car_info_v', 'ptinv_web_fuel_oil.car_license_plate', '=', 'ptinv_car_info_v.car_license_plate')
            ->join('fnd_shorthand_flex_aliases', 'ptinv_web_fuel_oil.gl_alias_name', '=', 'fnd_shorthand_flex_aliases.alias_name')
            ->join('ptinv_web_fuel_dist', 'ptinv_web_fuel_oil.transaction_id', '=', 'ptinv_web_fuel_dist.transaction_id')
            ->selectRaw("
                ptinv_web_fuel_oil.account_code,
                fnd_shorthand_flex_aliases.description,
                ptinv_web_fuel_dist.lot_number,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as gasoline_quantity ,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.amount ELSE 0 END) as gasoline_amount ,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as gasoline_tax_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.tax_amount+ptinv_web_fuel_dist.amount ELSE 0 END) as gasoline_total,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as diesel_quantity ,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.amount ELSE 0 END) as diesel_amount ,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as diesel_tax_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.tax_amount+ptinv_web_fuel_dist.amount ELSE 0 END) as diesel_total,
                SUM(ptinv_web_fuel_dist.quantity) as total_quantity,
                SUM(ptinv_web_fuel_dist.amount) as total_amount,
                SUM(ptinv_web_fuel_dist.tax_amount) as total_tax_amount,
                SUM(ptinv_web_fuel_dist.tax_amount+ptinv_web_fuel_dist.amount) as total
            ")
            ->when(request()->start_date, function($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)
                    ->setHour()
                    ->setMinute()
                    ->setSecond();
                $q->whereDate('gl_date', '>=', $startDate);
            })
            ->when(request()->end_date, function($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)
                    ->setHour(23)
                    ->setMinute(59)
                    ->setSecond(59);
                $q->whereDate('gl_date', '<=', $endDate);
            })
            ->whereNotNull('tran_id')
            ->groupBy(
                'ptinv_web_fuel_oil.account_code',
                'fnd_shorthand_flex_aliases.description',
                'ptinv_web_fuel_dist.lot_number'
            )
            ->orderBy('account_code')
            ->get();

        $totalWebFuelOils = WebFuelOil::query()
            ->join('fnd_shorthand_flex_aliases', 'ptinv_web_fuel_oil.gl_alias_name', '=', 'fnd_shorthand_flex_aliases.alias_name')
            ->join('ptinv_web_fuel_dist', 'ptinv_web_fuel_oil.transaction_id', '=', 'ptinv_web_fuel_dist.transaction_id')
            ->join('ptinv_car_info_v', 'ptinv_web_fuel_oil.car_license_plate', '=', 'ptinv_car_info_v.car_license_plate')
            ->selectRaw("
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as total_gasoline_quantity,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.amount ELSE 0 END) as total_gasoline_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as total_gasoline_tax_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100002' THEN (ptinv_web_fuel_dist.tax_amount + ptinv_web_fuel_dist.amount) ELSE 0 END) as total_gasoline,
                
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as total_diesel_quantity,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.amount ELSE 0 END) as total_diesel_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as total_diesel_tax_amount,
                SUM(CASE WHEN ptinv_car_info_v.car_fuel = '180100008' THEN (ptinv_web_fuel_dist.tax_amount + ptinv_web_fuel_dist.amount) ELSE 0 END) as total_diesel,

                SUM(ptinv_web_fuel_dist.quantity) as total_quantity,
                SUM(ptinv_web_fuel_dist.amount) as total_amount,
                SUM(ptinv_web_fuel_dist.tax_amount) as total_tax_amount,
                SUM(ptinv_web_fuel_dist.tax_amount+ptinv_web_fuel_dist.amount) as total
            ")
            ->when(request()->start_date, function($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)
                    ->setHour()
                    ->setMinute()
                    ->setSecond();
                $q->whereDate('gl_date', '>=', $startDate);
            })
            ->when(request()->end_date, function($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)
                    ->setHour(23)
                    ->setMinute(59)
                    ->setSecond(59);
                $q->whereDate('gl_date', '<=', $endDate);
            })
            ->whereNotNull('tran_id')
            ->first();

        $pdf = \DomPDF::loadView('inv.disbursement_fuel.report.fuel_payment_summary_pdf', [
                "webFuelOils"   => $webFuelOils,
                "totalWebFuelOils"   => $totalWebFuelOils,
                "username"      => $user->username,
                "fromDate"      => $fromDate,
                "toDate"        => $toDate,
            ])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - 02 - WEB_FUEL_ยอดจ่ายน้ำมันเชื้อเพลิงตามค่าใช้จ่าย_'.date('Ymd').'.pdf');
    }

    public function OilConsumptionPublicCarReport()
    {
        $carInfos = CarInfoV::select('car_fuel', 'item_description')
            ->whereNotNull('item_description')
            ->distinct()
            ->get();

        return view('inv.disbursement_fuel.report.oil_consumption_public_car_report', [
            'carInfos' => $carInfos,
        ]);
    }

    public function createOilConsumptionPublicCarPDF()
    {
        $fromDate = request()->start_date;
        $toDate = request()->end_date;
        $carFuel = request()->car_fuel;
        $user = auth()->user();

        if (!$fromDate || !$toDate || !$carFuel) {
            return redirect()->back()->with('error', 'กรุณาเลือกข้อมูลให้ครบถ้วน');
        }

        $startDate = request()->start_date ? \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)->startOfDay() : null;
        $endDate = request()->end_date ? \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)->endOfDay() : null;

        $oilType = CarInfoV::select('item_description')->firstWhere('car_fuel', $carFuel);
        $carInfos = CarInfoV::query()
            ->join('PTINV_WEB_FUEL_OIL', 'PTINV_WEB_FUEL_OIL.car_license_plate', '=', 'PTINV_CAR_INFO_V.car_license_plate')
            ->join('PTINV_WEB_FUEL_DIST', 'PTINV_WEB_FUEL_DIST.transaction_id', '=', 'PTINV_WEB_FUEL_OIL.transaction_id')
            ->selectRaw("
                PTINV_CAR_INFO_V.CAR_GROUP_DESC, PTINV_CAR_INFO_V.CAR_LICENSE_PLATE, PTINV_CAR_INFO_V.QUOTA_PER_MONTH,
                PTINV_WEB_FUEL_OIL.GL_ALIAS_NAME,
                SUM(PTINV_WEB_FUEL_DIST.QUANTITY) as sum_quantity
            ")
            ->when($carFuel, function ($q) use ($carFuel) {
                $q->where('car_fuel', $carFuel);
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('PTINV_WEB_FUEL_OIL.gl_date', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('PTINV_WEB_FUEL_OIL.gl_date', '<=', $endDate);
            })
            ->whereNull('PTINV_WEB_FUEL_OIL.deleted_at')
            ->whereNotNull('PTINV_WEB_FUEL_OIL.tran_id')
            ->groupBy(
                'PTINV_CAR_INFO_V.CAR_GROUP_DESC', 'PTINV_CAR_INFO_V.CAR_LICENSE_PLATE', 'PTINV_CAR_INFO_V.QUOTA_PER_MONTH',
                'PTINV_WEB_FUEL_OIL.GL_ALIAS_NAME'
            )
            ->get();

        $totalCarInfo = [];
        $totalCarInfo['total_quota_per_month'] = collect($carInfos ?? [])->sum('quota_per_month');
        $totalCarInfo['total_quantity'] = collect($carInfos ?? [])->sum('sum_quantity');

        $pdf = \DomPDF::loadView('inv.disbursement_fuel.report.oil_consumption_public_car_pdf', [
                "oilType"    => $oilType,
                "username"   => $user->username,
                "fromDate"   => $fromDate,
                "toDate"     => $toDate,
                "carInfos"   => $carInfos,
                "totalCarInfo"   => (object)($totalCarInfo),
            ])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - 05 - WEB_FUEL_รายงานยอดการใช้น้ำมันรถยนต์ส่วนกลาง_'.date('Ymd').'.pdf');
    }

    public function summaryFuelTypeReport()
    {
        $carInfos = CarInfoV::select('car_fuel', 'item_description')
            ->whereNotNull('item_description')
            ->distinct()
            ->get();

        return view('inv.disbursement_fuel.report.summary_fuel_type_report', [
            'carInfos' => $carInfos,
        ]);
    }

    public function createSummaryFuelTypePDF()
    {
        $fromDate = request()->start_date;
        $toDate = request()->end_date;
        $carFuel = request()->car_fuel;
        $user = auth()->user();

        if (!$fromDate || !$toDate || !$carFuel) {
            return redirect()->back()->with('error', 'กรุณาเลือกข้อมูลให้ครบถ้วน');
        }

        $webFuels = WebFuelOil::query()
            ->join('fnd_shorthand_flex_aliases', 'ptinv_web_fuel_oil.gl_alias_name', '=', 'fnd_shorthand_flex_aliases.alias_name')
            ->join('ptinv_web_fuel_dist', 'ptinv_web_fuel_oil.transaction_id', '=', 'ptinv_web_fuel_dist.transaction_id')
            ->join('ptinv_car_info_v', 'ptinv_web_fuel_oil.car_license_plate', '=', 'ptinv_car_info_v.car_license_plate')
            ->selectRaw("
                fnd_shorthand_flex_aliases.description,
                ptinv_car_info_v.item_description,
                ptinv_car_info_v.tax_refund_yn,
                ptinv_car_info_v.car_fuel,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'N' THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as quantity_n,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'Y' OR ptinv_car_info_v.tax_refund_yn IS NULL THEN ptinv_web_fuel_dist.quantity ELSE 0 END) as quantity_y,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'N' THEN ptinv_web_fuel_dist.amount ELSE 0 END) as amount_n,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'Y' OR ptinv_car_info_v.tax_refund_yn IS NULL THEN ptinv_web_fuel_dist.amount ELSE 0 END) as amount_y,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'N' THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as tax_amount_n,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'Y' OR ptinv_car_info_v.tax_refund_yn IS NULL THEN ptinv_web_fuel_dist.tax_amount ELSE 0 END) as tax_amount_y,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'N' THEN ptinv_web_fuel_dist.total_amount ELSE 0 END) as total_amount_n,
                SUM(CASE WHEN ptinv_car_info_v.tax_refund_yn = 'Y' OR ptinv_car_info_v.tax_refund_yn IS NULL THEN ptinv_web_fuel_dist.total_amount ELSE 0 END) as total_amount_y
            ")
            ->when(request()->start_date, function($q) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->start_date)
                    ->setHour()
                    ->setMinute()
                    ->setSecond();
                $q->whereDate('gl_date', '>=', $startDate);
            })
            ->when(request()->end_date, function($q) {
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', request()->end_date)
                    ->setHour(23)
                    ->setMinute(59)
                    ->setSecond(59);
                $q->whereDate('gl_date', '<=', $endDate);
            })
            ->when(request()->car_fuel, function($q) {
                $q->whereHas('carInfos', function($r) {
                    $r->where('car_fuel', request()->car_fuel);
                });
            })
            ->whereNotNull('tran_id')
            ->groupBy(
                'fnd_shorthand_flex_aliases.description', 
                'ptinv_car_info_v.item_description', 'ptinv_car_info_v.tax_refund_yn', 'ptinv_car_info_v.car_fuel'
            )
            ->get();

            $carFuel = CarInfoV::select('car_fuel', 'item_description')
                ->where('car_fuel', request()->car_fuel)
                ->distinct()
                ->get();

        $pdf = \DomPDF::loadView('inv.disbursement_fuel.report.summary_fuel_type_pdf', [
                "username"   => $user->username,
                "fromDate"   => $fromDate,
                "toDate"     => $toDate,
                "webFuels"   => $webFuels,
                "carFuel"   => $carFuel,
            ])
            ->setPaper('a4', 'landscape');

        return $pdf->stream('TOAT - 03 - WEB_FUEL_รายงานสรุปยอดจ่ายน้ำมันตามประเภท_'.date('Ymd').'.pdf');
    }
}
