<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use App\Models\EAM\ClosedWO2V;
use App\Models\EAM\ClosedWOV;
use App\Models\EAM\IssueMatV;
use App\Models\EAM\JobAccountDelV;
use App\Models\EAM\RequestMatInvV;
use App\Models\EAM\RequestMatNonV;
use App\Models\EAM\SummaryMatStatusV;
use App\Models\EAM\WOComStatusV;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function exportSummaryMonth(Request $request)
    {
        $params = $request->all();
        $service = new IssueMatV();
        $pdf = $service->reportMonthExcel($params);

        return $pdf;
    }

    public function closedWorkOrder(Request $request)
    {
        try {
            $params = $request->all();
            $service = new ClosedWOV();
            $data = $service->search($params);
            $pdf = \PDF::loadView('eam.exports.pdf-closed-wo', ['data' => $data])
                ->setPaper('a4')
                ->setOptions([
                    'margin-top' => '0.5cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8'
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>ใบปิดงานซ่อม</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function closedWorkOrder2(Request $request)
    {
        try {
            $params = $request->all();
            $service = new ClosedWO2V();
            $data = $service->search($params);
            // $html = view('eam.exports.pdf-closed-wo2', ['data' => $data])->render();
            // echo $html;
            $pdf = \PDF::loadView('eam.exports.pdf-closed-wo2', ['data' => $data])
                ->setPaper('a4')
                ->setOptions([
                    'margin-top' => '0.5cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8'
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>ใบปิดงานซ่อม (โรงพิมพ์)</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function jobAccountDel(Request $request)
    {
        try {
            $params = $request->all();
            $service = new JobAccountDelV();
            $data = $service->report($params);

            $pdf = \PDF::loadView('eam.exports.job-account-del.body', $data)
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOptions([
                    'margin-top'    => '2cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left'   => '0.7cm',
                    'margin-right'  => '0.7cm',
                    'encoding'      => 'utf-8',
                    'header-html'   => view('eam.exports.job-account-del.header', $data)
                ]);
            return $pdf->inline();
            return $pdf;
        } catch (\Throwable $th) {
            \Log::error($th);
            return \PDF::loadHTML("<title>รายงานบัญชีงานระหว่างประกอบ (แยกรายละเอียด)</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function requestMatInv(Request $request)
    {
        try {
            $params = $request->all();
            $service = new RequestMatInvV();
            $data = $service->report($params);
            $pdf = \PDF::loadView('eam.exports.request-mat-inv', ['data' => $data])
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOptions([
                    'margin-top' => '0.5cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8'
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>ใบเบิกวัสดุ (Inventory)</title><p style='color: black;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function requestMatNon(Request $request)
    {
        try {
            $params = $request->all();
            $service = new RequestMatNonV();
            $data = $service->report($params);

            $pdf = \PDF::loadView('eam.exports.request-mat-non', ['data' => $data])
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOptions([
                    'margin-top' => '0.5cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8'
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>ใบเบิกวัสดุ (Non Stock)</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function woComStatus(Request $request)
    {
        try {
            $params = $request->all();
            $service = new WOComStatusV();
            $data = $service->report($params);
            $pdf = \PDF::loadView('eam.exports.wo-com-status.body', $data)
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOptions([
                    'margin-top' => '2cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8',
                    'header-html' => view('eam.exports.wo-com-status.header', $data)
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            return \PDF::loadHTML("<title>รายงานสรุปสถานะใบสั่งซ่อมที่ส่งมอบเสร็จสิ้นแต่ยังไม่ปิดค่าใช้จ่าย</title><p style='color: white;'>" . $th->getMessage() . "</p>")
                ->setPaper('a4')
                ->setOptions(['encoding' => 'utf-8'])
                ->inline();
        }
    }

    public function summaryMatStatus(Request $request)
    {
        try {
            $params = $request->all();
            $service = new SummaryMatStatusV();
            $data = $service->report($params);
            $pdf = \PDF::loadView('eam.exports.summary-mat-status.body', $data)
                ->setPaper('a4')
                ->setOrientation('landscape')
                ->setOptions([
                    'margin-top' => '2cm',
                    'margin-bottom' => '0.5cm',
                    'margin-left' => '0.7cm',
                    'margin-right' => '0.7cm',
                    'encoding' => 'utf-8',
                    'header-html' => view('eam.exports.summary-mat-status.header', $data)
                ]);
            return $pdf->inline();
        } catch (\Throwable $th) {
            dd($th);
            throw $th;
        }
    }
}
