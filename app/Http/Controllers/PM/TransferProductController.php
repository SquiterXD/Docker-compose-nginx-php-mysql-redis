<?php

namespace App\Http\Controllers\PM;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PM\PtpmProductTransferH;

use App\Repositories\PM\TransferProductRepository;

class TransferProductController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        $url = (new TransferProductRepository)->url(request());

        $ptpmExCigDepartment = \DB::table('PTPM_EX_CIG_DEPARTMENT')
        ->select('DESCRIPTION')
        ->get();
        return view('pm.transfer-products.index', compact('url', 'ptpmExCigDepartment'));
    }

    private function data($request)
    {
        try {
            $transferProductRepository = new TransferProductRepository;
            if($request->action == 'search') {
                return $this->search($request);
                $profile = getDefaultData('/pm/transfer-products');
                $programCode = $profile->program_code ?? 'PMP0041';
                $headers = $transferProductRepository->search($request, $programCode);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } elseif($request->action == 'get-param') {
                return $this->getParam($request);
            } else {
                $info = $transferProductRepository->info($request);
                $data = [
                    'status' => 'S',
                    'info' => $info
                ];
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

    private function getParam($request)
    {
        $inventoryItemList[]    = ['value'  => '', 'label'  => ''];
        $transferNumberList[]   = ['value'  => '', 'label'  => ''];
        $transferObjectiveList[] = ['value'  => '', 'label'  => ''];
        $transferStatusList[]   = ['value'  => '', 'label'  => ''];

        $productDateFrom       = request()->product_date_from ?? false;
        $productDateTo         = request()->product_date_to ?? false;

        $transferDateFrom       = request()->transfer_date_from ?? false;
        $transferDateTo         = request()->transfer_date_to ?? false;
        $inventoryItemId        = request()->inventory_item_id ?? false;
        $transferNumber         = request()->transfer_number ?? false;
        $transferObjective      = request()->transfer_objective ?? false;
        $transferStatus         = request()->transfer_status ?? false;
        $organizationId         = session('organization_id');

        $conditions = "and h.organization_id = $organizationId ";
        if ($productDateFrom && $productDateFrom != 'Invalid date') {
            $productDateFrom = parseFromDateTh($productDateFrom);
            $conditions .= "and TRUNC(h.product_date) >= to_date('$productDateFrom', 'YYYY-MM-DD') ";
        }
        if ($productDateTo && $productDateTo != 'Invalid date') {
            $productDateTo = parseFromDateTh($productDateTo);
            $conditions .= "and TRUNC(h.product_date) <= to_date('$transferDateTo', 'YYYY-MM-DD') ";
        }

        if ($transferDateFrom && $transferDateFrom != 'Invalid date') {
            $transferDateFrom = parseFromDateTh($transferDateFrom);
            $conditions .= "and TRUNC(h.transfer_date) >= to_date('$transferDateFrom', 'YYYY-MM-DD') ";
        }
        if ($transferDateTo && $transferDateTo != 'Invalid date') {
            $transferDateTo = parseFromDateTh($transferDateTo);
            $conditions .= "and TRUNC(h.transfer_date) <= to_date('$transferDateTo', 'YYYY-MM-DD') ";
        }
        if ($inventoryItemId) {
            $conditions .= "and l.inventory_item_id = $inventoryItemId ";
        }
        if ($transferNumber) {
            $conditions .= "and h.transfer_number = '$transferNumber' ";
        }
        if ($transferObjective) {
            $conditions .= "and h.transfer_objective = '$transferObjective' ";
        }
        if ($transferStatus) {
            $conditions .= "and h.transfer_status = $transferStatus ";
        }

        $datas = collect(\DB::select("
            SELECT
                distinct
                h.transfer_date
                , h.transfer_number
                , l.inventory_item_id
                , msi.segment1 || ': ' || msi.description item_number
                , h.transfer_status
                , pts.description transfer_status_desc
                , h.transfer_objective
                , lto.description transfer_objective_desc
            FROM OAPM.PTPM_PRODUCT_TRANSFER_H h
                , OAPM.PTPM_PRODUCT_TRANSFER_L l
                , mtl_system_items_b msi
                , PTPM_TRANSFER_STATUS pts
                , PTPM_TRANSFER_OBJECTIVE lto
            WHERE   1=1
            and     h.transfer_header_id = l.transfer_header_id
            and     l.inventory_item_id = msi.inventory_item_id
            and     h.organization_id = msi.organization_id
            and     h.transfer_status = pts.lookup_code
            and     h.transfer_objective = lto.lookup_code
            and     h.program_code = 'PMP0041'
            $conditions
            order by h.transfer_date, h.transfer_number
        "));

        if (count($datas)) {
            foreach ($datas->sortBy('item_number')->pluck('item_number', 'inventory_item_id') as $value => $label) {
                $inventoryItemList[] = ['value'  => $value, 'label'  => $label];
            }
            foreach ($datas->sortBy('transfer_number')->pluck('transfer_number', 'transfer_number') as $value => $label) {
                $transferNumberList[] = ['value'  => $value, 'label'  => $label];
            }
            foreach ($datas->sortBy('transfer_objective_desc')->pluck('transfer_objective_desc', 'transfer_objective') as $value => $label) {
                $transferObjectiveList[] = ['value'  => $value, 'label'  => $label];
            }
            foreach ($datas->sortBy('transfer_status_desc')->pluck('transfer_status_desc', 'transfer_status') as $value => $label) {
                $transferStatusList[] = ['value'  => $value, 'label'  => $label];
            }
        }
        $responseResult['inventory_item_list'] = $inventoryItemList;
        $responseResult['transfer_number_list'] = $transferNumberList;
        $responseResult['transfer_objective_list'] = $transferObjectiveList;
        $responseResult['transfer_status_list'] = $transferStatusList;
        return $responseResult;
    }

    private function search($request)
    {
        $productDateFrom        = request()->product_date_from ?? false;
        $productDateTo          = request()->product_date_to ?? false;
        $transferDateFrom       = request()->transfer_date_from;
        $transferDateTo         = request()->transfer_date_to;
        $searchInputs = [
            // "transfer_number"           => $transferNumber,
            // "product_date_from"         => $productDateFrom,
            // "product_date_to"           => $productDateTo,
            "product_date_from"         => (is_null($productDateFrom)  || $productDateFrom == 'Invalid date' ) ? '' : $productDateFrom,
            "product_date_to"           => (is_null($productDateTo)  || $productDateTo == 'Invalid date' ) ? '' : $productDateTo,
            "transfer_date_from"        => (is_null($transferDateFrom)  || $transferDateFrom == 'Invalid date' ) ? '' : $transferDateFrom,
            "transfer_date_to"          => (is_null($transferDateTo)  || $transferDateTo == 'Invalid date' ) ? '' : $transferDateTo,
            "inventory_item_id"         => request()->inventory_item_id ?? false,
            "transfer_number"           => request()->transfer_number ?? false,
            "transfer_objective"        => request()->transfer_objective ?? false,
            "transfer_status"           => request()->transfer_status ?? false,
        ];
        // dd('xxx', request()->all());

        $transferHeaders = PtpmProductTransferH::with([
                                'objective:lookup_code,description',
                                'status:lookup_code,description'
                            ])
                            ->where("program_code", 'PMP0041')
                            ->where('organization_id', session('organization_id'))
                            ->with(['status'])
                            ->search($searchInputs)
                            ->orderBy('transfer_date')
                            ->orderBy('transfer_number')
                            ->get();
        $responseResult['transfer_headers'] = json_encode($transferHeaders);
        return $responseResult;
    }
}
