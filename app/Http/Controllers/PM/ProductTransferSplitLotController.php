<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmCompleteStatus;
use App\Repositories\PM\CommonRepository;
use App\Repositories\PM\TransferProductRepository;

use App\Models\PM\PtpmProductTransferH;
use App\Models\PM\PtpmProductTransferL;
use App\Models\PM\PtpmTransferObjective;
use App\Models\PM\PtpmTransferStatus;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PtglCoaDeptCodeV;
use App\Models\PM\PtinvLocatorV;
use App\Http\Controllers\PM\Ajax\ProductTransferSplitLotController as AjaxProductTransferSplitLotController;

use DB;

class ProductTransferSplitLotController extends Controller
{
    public function index(Request $request)
    {

        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        $url = self::url(request());
        $profile    = getDefaultData('/pm/products/transfers');
        $departmentCode = $profile->department_code;
        $organizationId = $profile->organization_id;
        $organizationCode = $profile->organization_code;
        $programCode = $profile->program_code;
        $transBtn   = trans('btn');

        // วัตถุประสงค์ในการเบิก
        $objectiveCodes = PtpmTransferObjective::select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                                ->active()
                                ->get();
        // สถานะขอเบิก
        $requestStatuses = PtpmTransferStatus::select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                                ->active()
                                ->get();

        $mfgDepartment = PtpmSetupMfgDepartmentsV::wipCompleteType()->where('organization_id', $organizationId)->first();

        $locators = [];
        if($mfgDepartment) {
            $locators = AjaxProductTransferSplitLotController::getLocators($mfgDepartment->to_organization_id);
        }
        
        $deptCodes = PtglCoaDeptCodeV::select(DB::raw("department_code ||' : '|| description as department_desc, description, department_code"))
                ->groupBy('department_code', 'description')
                ->orderBy('department_code')
                ->get();

        $searchInputs = $request->all();
        // วัตถุประสงค์ในการเบิก
        $objectiveCodes = \App\Models\PM\FndLookupValue::selectRaw("
                                    LOOKUP_CODE, MEANING, DESCRIPTION
                                ")
                                ->where('lookup_type', 'PTPM_PMP0052')
                                ->where('enabled_flag','Y')
                                ->orderBy('lookup_code')
                                ->get();

        return view('pm.products.transfer-split-lots.index', compact('url', 'organizationCode', 'profile', 'transBtn', 'objectiveCodes', 'requestStatuses', 'locators', 'deptCodes', 'searchInputs'));

    }

    private function data($request)
    {
        try {

            $transferProductRepository = new TransferProductRepository;

            if($request->action == 'search') {

                $headers = $transferProductRepository->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
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

    public static function url($request, $headerId = -999)
    {
        $url                    = (object)[];
        $preFixRoute            = 'pm.products.transfer-split-lots';
        // $preFixAjaxRoute        = 'pm.products.ajax.transfers';
        $url->index             = route("{$preFixRoute}.index", $request->all() ?? []);
        // $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        // $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        // $url->ajax_get_item     = route("{$preFixAjaxRoute}.get-item");
        // $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
        
    }
}
