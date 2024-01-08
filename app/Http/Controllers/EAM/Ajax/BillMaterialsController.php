<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use App\Models\EAM\RequestEquipHT;
use App\Models\EAM\RequestEquipHTInterface;
use App\Models\EAM\RequestEquipHV;
use App\Models\EAM\RequestEquipLT;
use App\Models\EAM\RequestEquipLTInterface;
use App\Models\EAM\RequestEquipLV;
use App\Models\EAM\LOV\RequestStatusV;
use Illuminate\Http\Request;

class BillMaterialsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $code = 200;
            $params = $request->all();
            $webBatchNo = RequestEquipHT::getWebBatchNo();
            $head = RequestEquipHT::saveData($params, $params['program_code'], $webBatchNo);
            foreach ($params['line'] as $value) {
                $line = RequestEquipLT::saveData(   $value, 
                                                    $head->req_equ_h_id, 
                                                    $params['program_code'],
                                                    $webBatchNo                 );
            }

            $interface = (new RequestEquipHTInterface)->intRequestEquipHT($head->web_batch_no);
            if ($interface['status'] == 'E') {
                $code = 400;
            }

            $result = RequestEquipHT::where('req_equ_h_id', $head->req_equ_h_id)->first();
            return response()->json(['message' => $interface['message'], 'data' => $result], $code);
        } catch (\Throwable $th) {
            return response()->json(['interface_msg' => $th->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $requestEquipId = $request->request_equip_h_id;
            $limit          = $request->p_limit;
            $head = RequestEquipHV::where('request_equip_h_id', $requestEquipId)->first();
            if (!$head) {
                return response()->json(['message' => 'ไม่พบข้อมูล'], 400);
            }
            $lines = RequestEquipLV::listByRequestEquipId($head->request_equip_h_id, $limit);

            return response()->json(['data' => $lines], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function deleteLine(Request $request)
    {
        try {
            $code = 200;
            $params = $request->all();
            $webBatchNo = RequestEquipHT::getWebBatchNo();
            $head = RequestEquipHT::saveData($params, $params['program_code'], $webBatchNo);
            
            foreach ($params['line'] as $value) {
                $line = RequestEquipLT::deleteData($value, $head->req_equ_h_id, $params['program_code']);
                $interface = (new RequestEquipLTInterface)->intDeleteRequestEquipLT($line->web_batch_no);
                if ($interface['status'] == 'E') {
                    $code = 400;
                    break;
                }
            }
            
            return response()->json(['message' => $interface['message'], 'data' => $head], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function confirm(Request $request, $requestEquipId)
    {
        try {
            $code = 200;
            $programCode = $request->program_code;
            $requestStatus = RequestStatusV::where('meaning', 'Approve')->first();
            $flag = 'I';
            $head = RequestEquipHT::confirmOrCancel($requestEquipId, $programCode, $requestStatus, $flag);
            $interface = (new RequestEquipHTInterface)->confirm($head->request_equip_h_id, $head->request_equip_no, $head->web_batch_no);
            if ($interface['status'] == 'E') {
                $code = 400;
            }

            return response()->json(['message' => $interface['message'], 'data' => $head], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function cancel(Request $request, $requestEquipId)
    {
        try {
            $code = 200;
            $programCode = $request->program_code;
            $requestStatus = RequestStatusV::where('lookup_code', '4')->first();
            $flag = 'C';
            $head = RequestEquipHT::confirmOrCancel($requestEquipId, $programCode, $requestStatus, $flag);

            $interface = (new RequestEquipHTInterface)->cancel($head->request_equip_h_id, $head->request_equip_no, $head->web_batch_no);
            if ($interface['status'] == 'E') {
                $code = 400;
            }

            return response()->json(['message' => $interface['message'], 'data' => $head], $code);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function report(Request $request)
    {
        $reqestEquipNo      = trim($request->request_equip_no ?? "%");
        $reqestEquipNoTo    = trim($request->request_equip_no_to ?? $reqestEquipNo);
        $creationDate       = parseFromDateTh($request->creation_date) ?? null;
        $creationDateTo     = parseFromDateTh($request->creation_date_to) ?? $creationDate;
        $requestStatus      = trim($request->request_status ?? "%");
        $departmentCode     = trim($request->department_code ?? "%");

        if ($reqestEquipNo != "%") {
            $data = RequestEquipHV::select(
                'request_equip_h_id',
                'request_equip_no',
                'department_code',
                'department_desc',
                'to_subinventory',
                'to_locator_code',
                'creation_date',
                'send_date',
            )
                ->whereBetween('request_equip_no', [$reqestEquipNo, $reqestEquipNoTo])
                ->get();
        } else {
            $query = RequestEquipHV::select(
                'request_equip_h_id',
                'request_equip_no',
                'department_code',
                'department_desc',
                'to_subinventory',
                'to_locator_code',
                'creation_date',
                'send_date',
            );
            if ($creationDate != null) {
                $query = $query->whereRaw(" trunc(REQUEST_DATE) >= to_date('{$creationDate}') ");
            }
            if ($creationDateTo != null) {
                $query = $query->whereRaw(" trunc(REQUEST_DATE) <= to_date('{$creationDateTo}') ");
            }
            if ($requestStatus != "%") {
                $requestStatus = explode(".", $requestStatus);
                $query = $query->where('request_status_id', '=', $requestStatus[0]);
            }
            if ($departmentCode != "%") {
                $query = $query->where('department_code', '=', $departmentCode);
            }
            $data = $query->get();
        }

        $requestItemList = array();
        foreach ($data as $item) {
            $requestItems = RequestEquipLV::index($item->request_equip_h_id);
            if (isset($requestItems)) {
                if (count($requestItems)) {
                    $requestItemList[$item->request_equip_h_id] = $requestItems;
                } else {
                    $obj = new \stdClass;
                    $obj->items[] = (object)["item_code" => ""];
                    $requestItemList[$item->request_equip_h_id] = $obj;
                }
            }
        }

        $newItemList = array();
        foreach ($requestItemList as $key1 => $items) {
            $indexArr = 0;
            $indexItem = 0;
            foreach ($items as $item) {
                $newItemList[$key1][$indexArr][] = $item;
                // if (($indexItem % 11) == 10) {
                    // $indexArr++;
                // }
                // $indexItem++;
            }
        }

        // $newData = array();
        // foreach ($newItemList as $key1 => $newItem) {
        //     foreach ($newItem as $key2 => $item) {
        //         foreach ($data as $key3 => $dataItem) {
        //             if ($key1 == $dataItem->request_equip_h_id) {
        //                 $newData[] = array("data" => $dataItem, "items" => $item);
        //             }
        //         }
        //     }
        // }

        $newData = array();
        foreach ($newItemList as $key1 => $newItem) {
            foreach ($newItem as $key2 => $item) {
                foreach ($data as $key3 => $dataItem) {
                    if ($key1 == $dataItem->request_equip_h_id) {
                        $newData[] = array("data" => $dataItem, "items" => $item);
                    }
                }
            }
        }

        $pdf = \PDF::loadView('eam.exports.bill-material-p.pdf-bill-material-p', ['requestEquip' => $newData])
                    ->setPaper('a4')
                    ->setOption('margin-top', '43')
                    ->setOption('margin-bottom','105')
                    ->setOption('margin-left', '0.7cm')
                    ->setOption('margin-right', '0.7cm')
                    ->setOption('encoding', 'utf-8')
                    ->setOption('header-html',view('eam.exports.bill-material-p.header', ['requestEquip' => $newData]))
                    ->setOption('footer-html',view('eam.exports.bill-material-p.footer'))
                    ->setOption('footer-center', 'Page [page] of [toPage]');
        // ->setOption('orientation', 'Landscape');
        return $pdf->inline();
    }
}
