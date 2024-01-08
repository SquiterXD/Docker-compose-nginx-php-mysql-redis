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
use App\Http\Controllers\PM\Ajax\ProductTransferController as AjaxProductTransferController;

use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtInvUomV;

use DB;

class ProductTransferController extends Controller
{
    public function index(Request $request)
    {

        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        if (request()->report == 'pdf') {
            return self::pdfReport($request);
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
            $locators = AjaxProductTransferController::getLocators($mfgDepartment->to_organization_id);
        }
        
        $deptCodes = PtglCoaDeptCodeV::select(DB::raw("department_code ||' : '|| description as department_desc, description, department_code"))
                ->groupBy('department_code', 'description')
                ->orderBy('department_code')
                ->get();

        $searchInputs = $request->all();

        return view('pm.products.transfers.index', compact('url', 'organizationCode', 'profile', 'transBtn', 'objectiveCodes', 'requestStatuses', 'locators', 'deptCodes', 'searchInputs'));

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
        $preFixRoute            = 'pm.products.transfers';
        // $preFixAjaxRoute        = 'pm.products.ajax.transfers';
        $url->index             = route("{$preFixRoute}.index", $request->all() ?? []);
        // $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        // $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        // $url->ajax_get_item     = route("{$preFixAjaxRoute}.get-item");
        // $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
        
    }

    public function pdfReport($request)
    {
        $transferNumber = $request->transfer_number;
        $profile = getDefaultData('/pm/products/transfers');
        $departmentCode = $profile->department_code;
        $organizationId = $profile->organization_id;
        $organizationCode = $profile->organization_code;
        $programCode = $profile->program_code;

        $header = PtpmProductTransferH::selectRaw("
                        PTPM_PRODUCT_TRANSFER_H.*
                        , REPLACE(to_char(transfer_date, 'DD MONTHYYYY', 'nls_calendar=''thai buddha''nls_date_language=thai'),'   ',' ') transfer_date_format
                    ")
                    ->where("program_code", $programCode)
                    ->where('organization_id', $organizationId)
                    ->where('transfer_number', $transferNumber)
                    ->first();
        $lines = PtpmProductTransferL::selectRaw("
                        subinventory_to, organization_id_from, inventory_item_id, transaction_uom, sum(transaction_qty) transaction_qty
                    ")
                    ->where('transfer_header_id', $header->transfer_header_id)
                    ->groupByRaw("subinventory_to, organization_id_from, inventory_item_id, transaction_uom")
                    ->get();

        $header->subinventory_to = '';
        $header->dept_fm = optional($profile->department)->description;
        if (count($lines)) {
            $header->subinventory_to = $lines->first()->subinventory_to;
            $lines = $lines->map(function ($line) {
                $item = PtpmItemNumberV::where('organization_id', $line->organization_id_from)
                            ->where('inventory_item_id', $line->inventory_item_id)
                            ->first();
                $uom = PtInvUomV::where('uom_code', $line->transaction_uom)->first();


                $line->item_number = optional($item)->item_number;
                $line->item_desc = optional($item)->item_desc;
                $line->unit_of_measure = optional($uom)->unit_of_measure;
                $line->transaction_qty_format = number_format($line->transaction_qty ?? 0, 2) ;
                return $line;
            });
        }

        $pdf = \PDF::loadView('pm.products.transfers.reports.pdf._body', compact('lines'))
            // ->setOption('header-html',view('pm.products.transfers.reports.pdf._haeder',compact('ptpmHead')))
            ->setOption('header-html',view('pm.products.transfers.reports.pdf._header', compact('header')))
            ->setOption('margin-top','30')
            ->setOption('encoding','UTF-8')
            ->setOption('lowquality', false)
            ->setOption('margin-left', '1cm')
            ->setOption('margin-right', '1cm')
//            ->setOption('disable-javascript', true)
            ->setOption('disable-smart-shrinking', false)
            ->setOption('print-media-type', true)
           // ->setOption('orientation', "Landscape")
            ->setPaper('a4');

            if ($organizationCode == 'M12' || $organizationCode == 'M03') {
                $pdf->setOption('footer-html', view('pm.products.transfers.reports.pdf._footer'))
                    ->setOption('margin-bottom','30');
            } else {
                $pdf->setOption('margin-bottom', 10)
                    ->setOption('footer-center', 'Page [page] of [toPage]');
            }

        return $pdf->stream();
    }
}
