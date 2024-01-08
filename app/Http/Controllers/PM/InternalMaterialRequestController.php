<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;

use Illuminate\Http\JsonResponse;
use DB;

use App\Repositories\PM\InternalMaterialRequestRepository;

class InternalMaterialRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        $id = null;
        $inventoryItemId = request()->inventory_item_id;
        $profile = getDefaultData('/pm/internal-material-requests?case=2');
        $headerId   = request()->request_header_id ?? '-1';
        $lines = [];

        $materialRequestRepo = new InternalMaterialRequestRepository;
        $dataInfo = $materialRequestRepo->setData($profile, request());


        $data = $dataInfo->data;
        $header = $dataInfo->header;

        $url = (object)[];
        $url->ajax_lines = route('pm.ajax.internal-material-requests.lines');
        $url->ajax_lines = route('pm.ajax.internal-material-requests.lines');
        $url->ajax_store = route('pm.ajax.internal-material-requests.store');
        $url->ajax_get_item = route('pm.ajax.internal-material-requests.get-item');
        $url->ajax_set_status = route('pm.ajax.internal-material-requests.set-status', $headerId);
        $url->ajax_set_status = route('pm.ajax.internal-material-requests.set-status', $headerId);

        $url->print_pdf = '';
        if ($header->request_number) {
            $url->print_pdf = "/pm/sample-report1-pdf/{$header->request_number}";
        }
        $url->material_requests_index = route('pm.internal-material-requests.index', ['case' => $header->attribute2]);
        $url->index = route('pm.internal-material-requests.index');


        // $header = PtpmRequestHeader::find($headerId);
        // if ($header) {

        // } else {
        //     $header = new PtpmRequestHeader();
        //     $can = $header->can;

        //     $requestStatusList = $data->request_status_list;
        //     $ingredientGroupList = $data->ingredient_group_list;
        //     $objectiveCodeList = $data->objective_code_list;

        //     $header = array_flip($header->getFillable());
        //     $header = (object) data_set($header, '*', '');
        //     $header->can                = $can;
        //     $header->request_status     = optional($requestStatusList->first())->lookup_code ?? "1";
        //     $header->department_code    = $profile->department_code;
        //     $header->request_date_format= parseToDateTh(now());
        //     $header->blend_no           = '';
        //     $header->ingredient_group   = optional($ingredientGroupList->first())->item_classification_code ?? '';
        //     $header->objective_code     = optional($objectiveCodeList->first())->lookup_code ?? '';
        // }
        // $header->blend_no           = '';
        // $header->type_code          = 'selectAll';


        return view('pm.internal-material-requests.index', compact(
            "header", "lines", "data",
            'url', 'profile'
        ));
    }

    private function data($request)
    {
        try {
            $repo = new InternalMaterialRequestRepository;

            if($request->action == 'search_get_param') {
                $headers = $repo->searchGetParam($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else if($request->action == 'search') {
                $headers = $repo->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else {
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return $data;
    }
}
