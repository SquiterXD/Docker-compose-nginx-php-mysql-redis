<?php

namespace App\Http\Controllers\IR\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\CarsServiceInterface;
use App\Http\Requests\IR\CarsRequest;
use App\Models\IR\Cars;
use App\Models\IR\PtirCars;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\Settings\PtirVehicles;
use App\Models\IR\Views\PtirRenewCarInsurancesView;
use App\Models\IR\Views\PtirCarsView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use Validator;

use App\Models\IR\Views\PtglCoaDeptCodeView;

class CarsController extends Controller
{
    protected $userId;
    protected $listId = [];
    private $service;

    public function __construct(CarsServiceInterface $service)
    {
        $this->service = $service;
        $this->userId = optional(auth()->user())->user_id ?? -1;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  App\Http\Requests\IR\Settings\CarsRequest
     * @return \Illuminate\Http\Response
     */
    public function index(CarsRequest $request)
    {
        $data = $request->all();
        $year           = isset($data['year']) ? ($data['year'] - 543) : '';
        $renewType      = isset($data['renew_type']) ? $data['renew_type'] : '';
        $groupCode      = isset($data['group_code']) ? $data['group_code'] : '';
        $licensePlate   = isset($data['license_plate']) ? $data['license_plate'] : '';
        $departmentFrom = isset($data['department_from']) ? $data['department_from'] : '';
        $departmentTo   = isset($data['department_to']) ? $data['department_to'] : '';
        $status         = isset($data['status']) ? $data['status'] : '';
        $response = $this->service->search(
            $year,
            $renewType,
            $groupCode,
            $licensePlate,
            $departmentFrom,
            $departmentTo,
            $status
        );

        return response($response, $response['status']);
    }

    public function fetch(CarsRequest $request)
    {
        // dd($request->all());
        $result = (new Cars())->callGetCars(
            $request->year,
            $request->renew_type,
            $request->group_code,
            $request->license_plate,
            $request->department_from,
            $request->department_to,
            $request->date_from,
            $request->date_to
        );
        // dd($result);  // S
        if ($result['status'] == 'E') {
            $response = error($result['msg']);
            return response($response, $response['status']);
        }
        $data = $request->all();
        $year           = isset($data['year']) ? $data['year'] : '';
        $renewType      = isset($data['renew_type']) ? $data['renew_type'] : '';
        $groupCode      = isset($data['group_code']) ? $data['group_code'] : '';
        $licensePlate   = isset($data['license_plate']) ? $data['license_plate'] : '';
        $departmentFrom = isset($data['department_from']) ? $data['department_from'] : '';
        $departmentTo   = isset($data['department_to']) ? $data['department_to'] : '';
        $status         = isset($data['status']) ? $data['status'] : '';
        $dateFrom     = isset($data['date_from']) ? $data['date_from'] : '';
        $dateTo        = isset($data['date_to']) ? $data['date_to'] : '';

        if ($dateFrom) {
            //----date-from-----
            list($day, $month, $yearx) = explode('/', $dateFrom);
            $yearx = $yearx - 543;
            $date = new \DateTime("$yearx-$month-$day");
            $dateFrom = $date->format('Y-m-d');
        } else {
            $dateFrom = null;
        }
        if ($dateTo) {
            //----date-to-----
            list($day, $month, $yeary) = explode('/', $dateTo);
            $yeary = $yeary - 543;
            $date = new \DateTime("$yeary-$month-$day");
            $dateTo = $date->format('Y-m-d');
        } else {
            $dateTo = null;
        }
        $collection = $this->service->getAll(
            $year - 543,
            $renewType,
            $groupCode,
            $licensePlate,
            $departmentFrom,
            $departmentTo,
            $status,
            $dateFrom,
            $dateTo
        );
        $response   = getResponse($collection);
        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\CarsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(CarsRequest $request)
    {
        $requestData = $request->all()['data'];
        $cars = array();
        foreach ($requestData as $index) {
            $vehicle = PtirVehicles::where('license_plate', $index['license_plate'])->first();
            
            $coa            = explode('.', $vehicle->account_number);
            $flexValue      = PtglCoaDeptCodeView::where('department_code', $coa[2])->first();    
            $departmentCode = $flexValue ? $flexValue->department_code : '';
            $departmentName = $flexValue ? $flexValue->description     : '';      

            $car = new CarsStruct();
            $car->car_id                 = isset($index['car_id']) ? $index['car_id'] : '';
            $car->document_number        = isset($index['document_number']) ? $index['document_number'] : '';
            $car->status                 = isset($index['status']) ? strtoupper($index['status']) : '';
            $car->asset_status           = isset($index['asset_status']) ? strtoupper($index['asset_status']) : '';
            $car->year                   = isset($index['year']) ? convertYearToAD($index['year']) : '';
            $car->renew_type_code        = isset($index['renew_type_code']) ? $index['renew_type_code'] : '';
            $car->renew_type             = isset($index['renew_type']) ? $index['renew_type'] : PtirRenewCarInsurancesView::where('lookup_code', $index['renew_type_code'])->first()->meaning;
            $car->start_date             = isset($index['start_date']) ? parseFromDateTh($index['start_date']) : '';
            $car->end_date               = isset($index['end_date']) ? parseFromDateTh($index['end_date']) : '';
            $car->total_days             = isset($index['total_days']) ? $index['total_days'] : '';
            $car->department_code        = isset($index['department_code']) ? $index['department_code'] : $departmentCode;
            $car->department_name        = isset($index['department_name']) ? $index['department_name'] : $departmentName;
            $car->license_plate          = isset($index['license_plate']) ? $index['license_plate'] : '';
            $car->group_code             = isset($index['group_code']) ? $index['group_code'] : '';
            $car->group_name             = isset($index['group_name']) ? $index['group_name'] : '';
            $car->insurance_amount       = isset($index['insurance_amount']) ? $index['insurance_amount'] : '';
            $car->discount               = isset($index['discount']) ? str_replace(',', '', $index['discount']) : 0;
            $car->duty_amount            = isset($index['duty_amount']) ? str_replace(',', '', $index['duty_amount']) : '';
            $car->vat_amount             = isset($index['vat_amount']) ? str_replace(',', '', $index['vat_amount']) : '';
            $car->net_amount             = isset($index['net_amount']) ?  str_replace(',', '', $index['net_amount']) : '';
            $car->vat_refund             = isset($index['vat_refund']) ? (($index['vat_refund'] == 'Yes') ? 'Y'  : 'N') : '';
            $car->insurance_expense      = isset($index['insurance_expense']) ? str_replace(',', '', $index['insurance_expense']) : '';
            $car->car_type_code          = isset($index['car_type_code']) ? $index['car_type_code'] : $vehicle->vehicle_type_code;
            $car->car_type               = isset($index['car_type']) ? $index['car_type'] : '';
            $car->policy_number          = isset($index['policy_number']) ? $index['policy_number'] : '';
            $car->policy_set_header_id   = isset($index['policy_set_header_id']) ? $index['policy_set_header_id'] : '';
            $car->policy_set_description = isset($index['policy_set_description']) ? $index['policy_set_description'] : '';
            $car->company_id             = isset($index['company_id']) ? $index['company_id'] : '';
            $car->company_name           = isset($index['company_name']) ? $index['company_name'] : '';
            $car->asset_number           = isset($index['asset_number']) ? $index['asset_number'] : '';
            $car->asset_description      = isset($index['asset_description']) ? $index['asset_description'] : '';
            $car->date_placed_in_service = isset($index['date_placed_in_service']) ? $index['date_placed_in_service'] : '';
            $car->expense_account        = isset($index['expense_account']) ? $index['expense_account'] : '';
            $car->expense_account_id     = isset($index['expense_account_id']) ? $index['expense_account_id'] : '';
            $car->expense_account_desc   = isset($index['expense_account_desc']) ? $index['expense_account_desc'] : '';
            $car->car_brand_code         = isset($index['car_brand_code']) ? $index['car_brand_code'] : '';
            $car->car_brand              = isset($index['car_brand']) ? $index['car_brand'] : '';
            $car->car_cc                 = isset($index['car_cc']) ? $index['car_cc'] : '';
            $car->engine_number          = isset($index['engine_number']) ? $index['engine_number'] : '';
            $car->tank_number            = isset($index['tank_number']) ? $index['tank_number'] : '';
            $car->line_type              = isset($index['line_type']) ? $index['line_type'] : '';
            $car->expense_flag           = isset($index['expense_flag']) ? $index['expense_flag'] : 'N';
            $car->receivable_code        = isset($index['receivable_code']) ? $index['receivable_code'] : '';
            $car->receivable_name        = isset($index['receivable_name']) ? $index['receivable_name'] : '';
            $car->row_type               = '';
            $car->program_code           = 'IRP0005';
            $car->row_id                 = isset($index['row_id']) ? $index['row_id'] : '';

            array_push($cars, $car);
        }
        $response = $this->service->createOrUpdate($cars);

        return response($response, $response['status']);
    }

    private function getlookuptype($lvcode, $params = [])
    {
        foreach ($params as $param) {
            // dd($param);
            if ($lvcode == $param->lookup_code) {
                return $param->lookup_type;
                break;
            }
        }
        return 'xxx';
    }


    public function duplicateCheck(CarsRequest $request)
    {
        $requestData = $request->all()['data'];
        $params = DB::select("select  lookup_type,lookup_code||':'|| meaning as lookup_code  from ptir_renew_car_insurances p  where p.ENABLED_FLAG = 'Y'");

        // dd($requestData);
        // "year" => "2565"
        // "renew_type_code" => "02"
        // "license_plate" => "ฎค-5651

        // null:null


        $rows = $requestData['rows'];

        $cars = [];
        foreach ($rows as $row) {
            if ( !in_array(strtoupper($row['status']), ['CANCELLED']) && $row['renew_type_code'] != null && $row['renew_type'] != null) {
                $typex = $row['renew_type_code'] . ':' . $row['renew_type'];
                $rtc = $this->getlookuptype($typex, $params);
                // dump($row['renew_typex'], $rtc);
                if (!isset($cars[$row['license_plate'] . $row['year'] . $rtc. $row['receivable_name']])) {
                    $cars[$row['license_plate'] . $row['year'] . $rtc. $row['receivable_name']] = 0;
                }
                $cars[$row['license_plate'] . $row['year'] . $rtc. $row['receivable_name']] += 1;
                if ($cars[$row['license_plate'] . $row['year'] . $rtc. $row['receivable_name']] > 1) {
                    $response = duplicate();
                    $response['data'] = $cars;
                    return response($response, $response['status']);
                }
                // $carx = PtirCars::where('year', convertYearToAD($row['year']))
                //     ->where('license_plate', $row['license_plate'])
                //     ->where('status', '!=', 'CANCELLED')
                //     ->get();
                // foreach ($carx as $c) {
                //     $rtc = $this->getlookuptype($row['renew_typex'], $params);
                //     if (!isset($cars[$c->license_plate . $c->year . $rtc])) {
                //         $cars[$c->license_plate . $c->year . $rtc] = 0;
                //     }
                //     $cars[$c->license_plate . $c->year . $rtc] += 1;

                //     if ($cars[$c->license_plate . $c->year . $rtc] > 1) {
                //         $response = duplicate();
                //         $response['data'] = $cars;
                //         return response($response, $response['status']);
                //     }
                // }
            }
        }
        foreach ($cars as $key => $val) {
            if ($val > 1) {
                $response = duplicate();
                $response['data'] = $cars;
                $rspoonse['cupicate'] = $key . '=' . $val;
                return response($response, $response['status']);
            }
        }
        $response = duplicate('ข้อมูลไม่ซ้ำ', 200);

        // เพิ่ม check กับข้อมูลในระบบด้วย W. 16/02/23
        if ($response['message'] == 'ข้อมูลไม่ซ้ำ' && $requestData['type'] == 'renew_type') {

            $year  = $requestData['year'] ? $requestData['year']-543 : '';
            $check = PtirCarsView::where('year', $year)
                                ->where('license_plate', $requestData['license_plate'])
                                ->where('renew_type', $requestData['renew_type'])
                                ->first();
            if ($check) {
                $response = duplicate();
                $response['message'] = 'ไม่สามารถเลือกรายการซ้ำได้';
                $response['status'] = 'E';
                return response($response);
            }

            // foreach ($rows as $row) {
            //     // dd($row['renew_type']);
            //     $year  = $row['year'] ? $row['year']-543 : '';
            //     $check = PtirCarsView::where('year', $year)
            //                     ->where('license_plate', $row['license_plate'])
            //                     ->where('renew_type', $row['renew_type'])
            //                     ->first();
            //     if ($check) {
            //         $response = duplicate();
            //         $response['message'] = 'ไม่สามารถเลือกรายการซ้ำได้';
            //         $response['status'] = 'E';
            //         return response($response);
            //     }
            // }
        }

        $response['data'] = $cars;
        return response($response, $response['status']);
    }



    public function updateStatus(CarsRequest $request)
    {
        $requestData = $request->all()['data'];
        foreach ($requestData as $index) {
            $db = PtirCars::find($index['car_id']);
            $db->status                = isset($index['status']) ? $index['status'] : $db->status;
            $db->updated_at            = Carbon::now();
            $db->last_updated_by       = $this->userId;
            $db->last_update_date      = Carbon::now();
            $db->save();
        }
    }

    public function remove(CarsRequest $request)
    {
        if(!$request->car_id) {
            $response = error('ไม่พบข้อมูล');
            return response($response, $response['status']);
        }

        $car = PtirCars::find($request->car_id);
        $car->delete();

        $response = success();
        return response($response, $response['status']);
    }
}
