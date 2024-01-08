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
use App\Models\PtglCoaDeptCodeAllV;
use App\Models\PM\PtinvLocatorV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtInvUomV;
use App\Http\Controllers\PM\Ajax\ProductTranController as AjaxProductTranController;

use DB;

class ProductTranController extends Controller
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

        $mfgDepartment = AjaxProductTranController::findMfgDepartmentData();

        $locators = [];
        if($mfgDepartment) {
            $locators['WIP_COMPLETION'] = AjaxProductTranController::getLocators($mfgDepartment->to_organization_id);
        }


        $deptCodes = PtglCoaDeptCodeAllV::select(DB::raw("department_code ||' : '|| description as department_desc, description, department_code"))
                ->groupBy('department_code', 'description')
                ->orderBy('department_code')
                ->get();

        $searchInputs = $request->all();
        $objectiveCodes = [];
        if ($profile->organization_code == 'M06' || $profile->organization_code == 'M12' || $profile->organization_code == 'M03') {
            // วัตถุประสงค์ในการเบิก
            $objectiveCodes = AjaxProductTranController::getObjectiveCode();
            if (count($objectiveCodes)) {
                if ($profile->organization_code == 'M06') {
                    $objectiveCodes = $objectiveCodes->whereIn('lookup_code', ['10', '20', '30', '40']);
                } else if ($profile->organization_code == 'M12') {
                    $objectiveCodes = $objectiveCodes->whereIn('lookup_code', ['50']);
                } else if ($profile->organization_code == 'M03') {
                    $objectiveCodes = $objectiveCodes->whereIn('lookup_code', ['60']);
                }
                // dd('xx', $objectiveCodes);
                foreach ($objectiveCodes as $key => $obj) {
                    $mfgDepartment = AjaxProductTranController::findMfgDepartmentData($obj->lookup_code);
                    if ($mfgDepartment) {
                        $locatorList = AjaxProductTranController::getLocators($mfgDepartment->to_organization_id);
                        if (count($locatorList)) {
                            $locators[$obj->lookup_code] = $locatorList;
                            if ($profile->organization_code == 'M12') {
                                $locators[$obj->lookup_code] = array_values($locatorList->where('locator', 'FC6ROJ01.ZONE008')->toArray());
                            } else if ($profile->organization_code == 'M03') {
                                $locators[$obj->lookup_code] = array_values($locatorList->whereIn('locator', ['PURROJ06.99999999', 'PURROJ07.99999999'])->toArray());
                            }
                        }
                    }
                }
                $objectiveCodes = array_values($objectiveCodes->toArray());
            }
        }

        return view('pm.products.trans.index', compact('url', 'organizationCode', 'profile', 'transBtn', 'objectiveCodes', 'requestStatuses', 'locators', 'deptCodes', 'searchInputs'));

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
        $preFixRoute            = 'pm.products.trans';
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
                        subinventory_to, organization_id_from, inventory_item_id, attribute3, lot_number, transaction_uom, sum(transaction_qty) transaction_qty
                    ")
                    ->where('transfer_header_id', $header->transfer_header_id)
                    ->groupByRaw("subinventory_to, organization_id_from, inventory_item_id, attribute3, lot_number, transaction_uom")
                    ->orderByRaw('attribute3, lot_number')
                    ->get();

        $header->subinventory_to_desc = '';
        $header->dept_fm = '';
        $org = \App\Models\MtlParameter::where('organization_id', $profile->organization_id)->first();
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $header->dept_fm = $dept->description;
            }
        }
        if (count($lines)) {
            $subinventoryTo = $lines->first()->subinventory_to;
            $toSubinv = collect(\DB::select("
                SELECT secondary_inventory_name, description from MTL_SECONDARY_INVENTORIES where secondary_inventory_name = '$subinventoryTo'
            "))->first();
            $header->subinventory_to_desc = $subinventoryTo .": ". $toSubinv->description;


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

        $pdf = \PDF::loadView('pm.products.trans.reports.pdf._body', compact('lines'))
            // ->setOption('header-html',view('pm.products.trans.reports.pdf._haeder',compact('ptpmHead')))
            ->setOption('header-html',view('pm.products.trans.reports.pdf._header', compact('header')))
            ->setOption('margin-top','35')
            ->setOption('margin-bottom','3.5cm')
            ->setOption('encoding','UTF-8')
            ->setOption('lowquality', false)
            ->setOption('margin-left', '1cm')
            ->setOption('margin-right', '1cm')
//            ->setOption('disable-javascript', true)
            ->setOption('disable-smart-shrinking', false)
            ->setOption('print-media-type', true)
           // ->setOption('orientation', "Landscape")
            ->setPaper('A4');

            if ($organizationCode == 'M12' || $organizationCode == 'M03') {
                $pdf->setOption('footer-html', view('pm.products.trans.reports.pdf._footer'));
            } else {
                $pdf->setOption('margin-bottom', 10)
                    ->setOption('footer-center', 'Page [page] of [toPage]');
            }

        return $pdf->stream($header->transfer_number .'.pdf');
    }
}
