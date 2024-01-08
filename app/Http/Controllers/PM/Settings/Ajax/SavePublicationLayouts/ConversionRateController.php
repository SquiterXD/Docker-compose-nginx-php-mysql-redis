<?php

namespace App\Http\Controllers\PM\Settings\Ajax\SavePublicationLayouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PtpmConvertItemsInfo;
use App\Models\PM\Settings\ItemNumberV;
use DB;
use Carbon\Carbon;

use App\Repositories\PM\Settings\SavePublicationLayoutRepository;

class ConversionRateController extends Controller
{

    const url = '/pm/settings/save-publication-layout';

    public function index(Request $request)
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json($data);
        }

        if (request()->ajax() || request()->test) {
            $data = [];
            if ($request->action == 'get-info') {
                $data = $this->dataInfo($request);
            }
            return response()->json([$data]);
        }
    }

    public function store(Request $request)
    {
        $profile        = $this->getProfile();
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();
        $ptpmSetupMfgDepartmentId = false;

        $setup  = $this->getSetupOrgTransfer($request->from_inventory_item_id, $ptpmSetupMfgDepartmentId);
        if (!$setup) {
            throw new \Exception("ไม่สามารถบันทึกรายการได้ เนื่องจากไม่พบการตั้งค่าการจ่ายข้าม Item (หน้าจอบันทึกคลังสินค้าในการรับ-ส่งข้อมูล)");
        }

        if ($request->convert_item_id) {
            $conversion = PtpmConvertItemsInfo::where('convert_item_id', $request->convert_item_id)->first();
            $ptpmSetupMfgDepartmentId = $conversion->org_transfer_id ?? false;
        } else {
            $setup  = $setup->where('to_organization_id', $request->to_organization_id);
            if (count($setup) == 0) {
                $org = collect(DB::select("
                            SELECT
                                    organization_code || ' : ' || organization_name label
                            from    ORG_ORGANIZATION_DEFINITIONS
                            where  1=1
                            and     organization_id = $request->to_organization_id
                        "));
                throw new \Exception("ไม่สามารถบันทึกรายการได้ เนื่องจากไม่พบการตั้งค่าการจ่ายข้าม Item ของ Org: {$org->first()->label} (หน้าจอบันทึกคลังสินค้าในการรับ-ส่งข้อมูล)");
            }

            $conversionIsDup = PtpmConvertItemsInfo::where('from_inventory_item_id', $request->from_inventory_item_id)
                                ->where('from_organization_id', $request->from_organization_id)
                                ->count();
            if ($conversionIsDup) {
                throw new \Exception("ไม่สามารถบันทึกรายการได้ เนื่องจากมีการ Setup ในระบบแล้ว");
            }


            $conversionIsDup = PtpmConvertItemsInfo::where('from_inventory_item_id', $request->from_inventory_item_id)
                                ->where('from_organization_id', $request->from_organization_id)
                                // ->where('to_organization_id', $request->to_organization_id)
                                ->where('to_inventory_item_id', $request->to_inventory_item_id)
                                ->first();
            if ($conversionIsDup) {
                throw new \Exception("ไม่สามารถบันทึกรายการได้ เนื่องจาก Item: {$request->to_inventory_item_number} มีการ Setup ในระบบแล้ว");
            }

            $conversion = new PtpmConvertItemsInfo;
            $conversion->created_by                 = $profile->fnd_user_id;
            $conversion->created_by_id              = $profile->user_id;
            $conversion->created_at                 = $sysdate;
            $conversion->creation_date              = $sysdate;
        }

        // $conversion->from_inventory_item_id     = $request->from_inventory_item_id;
        // $conversion->from_uom                   = $request->from_uom;
        // $conversion->from_organization_id       = $request->from_organization_id;
        // $conversion->from_subinv                = $request->from_subinv;
        // $conversion->from_locator_id            = $request->from_locator_id;
        // $conversion->transaction_type_id        = $request->transaction_type_id;
        // $conversion->to_organization_id         = $request->to_organization_id;
        // $conversion->to_subinv                  = $request->to_subinv;
        // $conversion->to_locator_id              = $request->to_locator_id;
        // $conversion->to_inventory_item_id       = $request->to_inventory_item_id;
        // $conversion->to_uom                     = $request->to_uom;
        // $conversion->conversion_rate            = $request->conversion_rate;

        $conversion->from_inventory_item_id     = $request->from_inventory_item_id;
        $conversion->from_uom                   = $request->from_uom;
        $conversion->from_organization_id       = $request->from_organization_id;
        $conversion->to_organization_id         = $request->to_organization_id;
        $conversion->to_inventory_item_id       = $request->to_inventory_item_id;
        $conversion->to_uom                     = $request->to_uom;
        $conversion->conversion_rate            = $request->conversion_rate;
        $conversion->enable_flag                = 'Y';

        if ($request->start_date) {
            $conversion->start_date             = Carbon::parse($request->start_date)->format('Y-m-d');
        }
        if ($request->end_date) {
            $conversion->end_date               = Carbon::parse($request->end_date)->format('Y-m-d');
        }

        $conversion->start_date                 = Carbon::parse('2000-01-01')->format('Y-m-d');
        $conversion->end_date                   = null;

        $conversion->program_code               = $profile->program_code;
        $conversion->updated_by_id              = $profile->user_id;
        $conversion->last_updated_by            = $profile->fnd_user_id;
        $conversion->updated_at                 = $sysdate;
        $conversion->last_update_date           = $sysdate;
        $conversion->save();

        (new SavePublicationLayoutRepository)->conversionInfoUpdateSetup($conversion, $setup->first());

        $conversion->refresh();
        $item = ItemNumberV::where('inventory_item_id', $conversion->from_inventory_item_id)
                    ->where('organization_id', $conversion->from_organization_id)
                    ->first();
        $conversion->from_uom                   = $item->primary_uom_code ?? $request->from_uom;
        $conversion->save();

        $data = [
            'status' => 'S',
            'msg' => ''
        ];
        return response()->json($data);
    }


    private function data($request)
    {
        try {
            if ($request->action == 'get-info') {
                $data = $this->dataInfo($request);
            }

            if ($request->action == 'search_get_param') {
                $data = $this->searchGetParam($request);
            }

            if ($request->action == 'get-convert-items-info') {
                $data = $this->getConvertItemsInfo($request);
            }

            $res = [
                'status' => 'S',
                'data' => $data
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $res = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }
        return $res;
    }
    private function getConvertItemsInfo($request)
    {
        $fromInventoryItemId = $request->from_inventory_item_id;

        $items = PtpmConvertItemsInfo::where('from_inventory_item_id', $fromInventoryItemId)
                    ->orderBy('enable_flag', 'desc')
                    ->orderBy('convert_item_id')
                    ->get();
        if (count($items)) {
            $items->map(function ($item) {
                $toOrg      = data_get($this->getOrg($item->to_organization_id), 0, collect([]));
                // $toItem     = data_get($this->getToItemId(
                //                 $item->to_inventory_item_id,
                //                 $item->to_organization_id,
                //                 $item->to_inventory_item_id,
                //               ), 0, collect([]));
                $toItem     = ItemNumberV::where('organization_id', $item->to_organization_id)
                                ->where('inventory_item_id', $item->to_inventory_item_id)
                                ->first();
                $toUom      = data_get($this->getToUom($item->to_organization_id, $item->to_inventory_item_id, $item->to_uom), 0, collect([]));

                $item->start_date_display           = '';
                $item->end_date_display             = '';

                $item->from_organization_display    = '';
                $item->from_subinv_display          = '';
                $item->from_locator_display         = '';

                $item->to_organization_display      = optional($toOrg)->label;
                $item->to_subinv_display            = '';
                $item->to_locator_display           = '';

                $item->transaction_type_display     = '';
                $item->to_inventory_item_display    = "$toItem->item_number: $toItem->item_desc";
                $item->conversion_rate_display       = number_format($item->conversion_rate ?? 0, 0);
                $item->to_uom_display               = optional($toUom)->label;
                $item->enable_icon_html             = view('shared._status_active', ['isActive' => $item->enable_flag == 'Y'])->render();
            });
        }

        return $items;


        $fromInventoryItemId = $request->from_inventory_item_id;

        $items = PtpmConvertItemsInfo::where('from_inventory_item_id', $fromInventoryItemId)
                    ->orderBy('convert_item_id')
                    ->get();
        if (count($items)) {
            $items->map(function ($item) {

                $fmOrg      = data_get($this->getOrg($item->from_organization_id), 0, collect([]));
                $fmLocator  = data_get($this->getLocator($item->from_organization_id, $item->from_subinv, $item->from_locator_id), 0, collect([]));

                $toOrg      = data_get($this->getOrg($item->to_organization_id), 0, collect([]));
                $toLocator  = data_get($this->getLocator($item->to_organization_id, $item->to_subinv, $item->to_locator_id), 0, collect([]));
                $toItem     = data_get($this->getToItemId($item->to_organization_id, $item->to_inventory_item_id), 0, collect([]));
                $toUom      = data_get($this->getToUom($item->to_organization_id, $item->to_inventory_item_id, $item->to_uom), 0, collect([]));
                $transType  = data_get($this->getTransactionType($item->transaction_type_id), 0, collect([]));

                $item->start_date_display           = $item->start_date ?  parseToDateTh($item->start_date): '';
                $item->end_date_display             = $item->end_date ?  parseToDateTh($item->end_date): '';

                $item->from_organization_display    = optional($fmOrg)->label;
                $item->from_subinv_display          = $item->from_subinv;
                $item->from_locator_display         = optional($fmLocator)->label;

                $item->to_organization_display      = optional($toOrg)->label;
                $item->to_subinv_display            = $item->to_subinv;
                $item->to_locator_display           = optional($toLocator)->label;

                $item->transaction_type_display     = $item->transaction_type_id ? optional($transType)->label : '';
                $item->to_inventory_item_display    = optional($toItem)->label;
                $item->conversion_rate_display       = number_format($item->conversion_rate ?? 0, 0);
                $item->to_uom_display               = optional($toUom)->label;
            });
        }

        return $items;
    }

    private function dataInfo($request)
    {
        $form = (object) [];


        $form->start_date                   = '';
        $form->end_date                     = '';

        $form->from_inventory_item_id       = '';
        $form->from_organization_id         = '';
        $form->from_subinv                  = '';
        $form->from_locator_id              = '';

        $form->transaction_type_id          = '';
        $form->to_organization_id           = '';
        $form->to_subinv                    = '';
        $form->to_locator_id                = '';
        $form->to_inventory_item_id         = '';
        $form->to_inventory_item_id_dummy   = '';
        $form->to_uom                       = '';
        $form->conversion_rate              = '';
        $form->enable_flag                  = true;

        if ($request->convert_item_id != '') {
            $form = PtpmConvertItemsInfo::where('convert_item_id', $request->convert_item_id)->first();
            $form->start_date = $form->start_date ? Carbon::parse($form->start_date)->format('Y-m-d') : '';
            $form->end_date = $form->end_date ? Carbon::parse($form->end_date)->format('Y-m-d') : '';
            $form->enable_flag = ($form->enable_flag == 'Y') ? true : false;


            $form->to_inventory_item_id_dummy = (string) ($form->to_inventory_item_id * $form->to_organization_id);
            $form->to_organization_id       = (int) $form->to_organization_id;
        }


        // $form->from_organization_id         = 182;
        // $form->from_subinv                  = 'FC3SP004';

        $data = [
            'form' => $form,
        ];
        return $data;
    }

    private function searchGetParam($request)
    {
        $fromInventoryItemId    = data_get($request->all(), 'from_inventory_item_id', false) ?? false;
        $fromOrganizationId     = data_get($request->all(), 'from_organization_id', false) ?? false;
        $toOrganizationId       = data_get($request->all(), 'to_organization_id', false) ?? false;
        $toInventoryItemId      = data_get($request->all(), 'to_inventory_item_id', false) ?? false;
        $toUom                  = data_get($request->all(), 'to_uom', false) ?? false;

        // $toOrganizationIdData       = array_merge([(object)['value' => '', 'label' => '']], $this->getOrg(false));
        $toOrganizationIdData       = [(object)['value' => '', 'label' => '']];
        $toInventoryItemIdData      = [(object)['value' => '', 'label' => '']];
        $toUomData                  = [(object)['value' => '', 'label' => '']];

        // to_inventory_item_id
        $toInventoryItemIdQuery = $this->getToItemId($fromInventoryItemId, $toOrganizationId, $toInventoryItemId);
        if (count($toInventoryItemIdQuery)) {
            $toInventoryItemIdData = array_merge($toInventoryItemIdData, $toInventoryItemIdQuery);
        }
        if ($toOrganizationId) {

            // to_uom
            if ($toInventoryItemId) {
                $toUomDataQuery = $this->getToUom($toOrganizationId, $toInventoryItemId, $toUom);
                if (count($toUomDataQuery)) {
                    $toUomData = array_merge($toUomData, $toUomDataQuery);
                }
            }

        }

        $data = [
            'to_organization_id_list'       => $toOrganizationIdData,
            'to_inventory_item_id_list'     => $toInventoryItemIdData,
            'to_uom_list'                   => $toUomData,
        ];
        return $data;


        $toInventoryItemId      = data_get($request->all(), 'to_inventory_item_id', false) ?? false;
        $toUom                  = data_get($request->all(), 'to_uom', false) ?? false;
        $toOrganizationId       = data_get($request->all(), 'to_organization_id', false) ?? false;

        $toInventoryItemIdData      = [(object)['value' => '', 'label' => '']];
        $toUomData                  = [(object)['value' => '', 'label' => '']];
        // $toOrganizationIdData       = array_merge([(object)['value' => '', 'label' => '']], $this->getOrg($toOrganizationId));
        $toOrganizationIdData       = [(object)['value' => '', 'label' => '']];

        // to_inventory_item_id
        $toInventoryItemIdQuery = $this->getToItemId($toOrgId = false, $toInventoryItemId);
        if (count($toInventoryItemIdQuery)) {
            $toInventoryItemIdData = array_merge($toInventoryItemIdData, $toInventoryItemIdQuery);
        }
        // to_organization_id_
        if ($toInventoryItemId) {
            $toOrgQuery = $this->getOrgByItem($toInventoryItemId);
            $toOrganizationIdData = array_merge($toOrganizationIdData, $toOrgQuery);

            // to_uom
            $toUomDataQuery = $this->getToUomByItem($toInventoryItemId, $toOrganizationId, $toUom);
            if (count($toUomDataQuery)) {
                $toUomData = array_merge($toUomData, $toUomDataQuery);
            }
        }

        $data = [
            'to_organization_id_list'       => $toOrganizationIdData,
            'to_inventory_item_id_list'     => $toInventoryItemIdData,
            'to_uom_list'                   => $toUomData,
        ];
        return $data;


        dd('C');
        $fromOrganizationId     = data_get($request->all(), 'from_organization_id', false) ?? false;
        $fromSubinv             = data_get($request->all(), 'from_subinv', false) ?? false;
        $fromLocatorId          = data_get($request->all(), 'from_locator_id', false) ?? false;
        $toOrganizationId       = data_get($request->all(), 'to_organization_id', false) ?? false;
        $toSubinv               = data_get($request->all(), 'to_subinv', false) ?? false;
        $toLocatorId            = data_get($request->all(), 'to_locator_id', false) ?? false;
        $toInventoryItemId      = data_get($request->all(), 'to_inventory_item_id', false) ?? false;
        $toUom                  = data_get($request->all(), 'to_uom', false) ?? false;
        $transactionTypeId      = data_get($request->all(), 'transaction_type_id', false) ?? false;

        $fromOrganizationIdData     = array_merge([(object)['value' => '', 'label' => '']], $this->getOrg($fromOrganizationId));
        $fromSubinvData             = [(object)['value' => '', 'label' => '']];
        $fromLocatorIdData          = [(object)['value' => '', 'label' => '']];
        $toOrganizationIdData       = array_merge([(object)['value' => '', 'label' => '']], $this->getOrg($toOrganizationId));
        $toSubinvData               = [(object)['value' => '', 'label' => '']];
        $toLocatorIdData            = [(object)['value' => '', 'label' => '']];
        $toInventoryItemIdData      = [(object)['value' => '', 'label' => '']];
        $toUomData                  = [(object)['value' => '', 'label' => '']];
        $transactionTypeIdData      = [(object)['value' => '', 'label' => '']];

        if ($fromOrganizationId) {
            // from_subinv
            $fromSubinvQuery = $this->getSubinv($fromOrganizationId, $fromSubinv);
            if (count($fromSubinvQuery)) {
                $fromSubinvData = array_merge($fromSubinvData, $fromSubinvQuery);
            }

            // from_locator_id
            if ($fromSubinv) {
                $fromLocatorIdQuery = $this->getLocator($fromOrganizationId, $fromSubinv, $fromLocatorId);
                if (count($fromLocatorIdQuery)) {
                    $fromLocatorIdData = array_merge($fromLocatorIdData, $fromLocatorIdQuery);
                }
            }
        }

        if ($toOrganizationId) {
            // to_subinv
            $toSubinvQuery = $this->getSubinv($toOrganizationId, $toSubinv);
            if (count($toSubinvQuery)) {
                $toSubinvData = array_merge($toSubinvData, $toSubinvQuery);
            }

            // to_locator_id
            if ($toSubinv) {
                $toLocatorIdQuery = $this->getLocator($toOrganizationId, $toSubinv, $toLocatorId);
                if (count($toLocatorIdQuery)) {
                    $toLocatorIdData = array_merge($toLocatorIdData, $toLocatorIdQuery);
                }
            }

            // to_inventory_item_id
            $toInventoryItemIdQuery = $this->getToItemId($toOrganizationId, $toInventoryItemId);
            if (count($toInventoryItemIdQuery)) {
                $toInventoryItemIdData = array_merge($toInventoryItemIdData, $toInventoryItemIdQuery);
            }

            // to_uom
            if ($toInventoryItemId) {
                $toUomDataQuery = $this->getToUom($toOrganizationId, $toInventoryItemId, $toUom);
                if (count($toUomDataQuery)) {
                    $toUomData = array_merge($toUomData, $toUomDataQuery);
                }
            }

            // transaction_type_id
            $getTransactionTypeQuery = $this->getTransactionType($transactionTypeId);
            if (count($getTransactionTypeQuery)) {
                $transactionTypeIdData = array_merge($transactionTypeIdData, $getTransactionTypeQuery);
            }
        }

        $data = [
            'from_organization_id_list'     => $fromOrganizationIdData,
            'from_subinv_list'              => $fromSubinvData,
            'from_locator_id_list'          => $fromLocatorIdData,
            'to_organization_id_list'       => $toOrganizationIdData,
            'to_subinv_list'                => $toSubinvData,
            'to_locator_id_list'            => $toLocatorIdData,
            'to_inventory_item_id_list'     => $toInventoryItemIdData,
            'to_uom_list'                   => $toUomData,
            'transaction_type_id_list'      => $transactionTypeIdData,
        ];
        return $data;
    }


    private function getOrg($value = false, $onlyOrgIdArr = [])
    {
        $condition = 'and 1=1';
        if ($value) {
            $condition = "and organization_id = '$value'";
        }

        $organization = collect(DB::select("
            SELECT
                    organization_id value,
                    organization_code || ' : ' || organization_name label
            from    ORG_ORGANIZATION_DEFINITIONS
            where  1=1
            and     inventory_enabled_flag = 'Y'
            and     trunc(sysdate) BETWEEN trunc(user_definition_enable_date) and trunc(nvl(disable_date, sysdate))
            $condition
            order by label
        "))
        ->when(count($onlyOrgIdArr), function ($collection) use ($onlyOrgIdArr) {
            return $collection->whereIn('value', $onlyOrgIdArr);
        });

        return $organization->toArray();
    }

    private function getSubinv($orgId, $value = false)
    {
        $condition = 'and 1=1';
        if ($value) {
            $condition = "and segment1 = '$value'";
        }

        $data = collect(DB::select("
            SELECT  distinct
                    segment1 value,
                    segment1 label
            from    mtl_item_locations_kfv
            where  1=1
            and     organization_id = $orgId
            $condition
            order by label
        "));

        return $data->toArray();
    }

    private function getLocator($orgId, $subinv, $value = false)
    {
        $conditionSubinv = "and 1=1";
        if ($subinv) {
            $conditionSubinv = "and segment1 = '$subinv'";
        }
        $condition = 'and 1=1';
        if ($value) {
            $condition = "and inventory_location_id = '$value'";
        }

        $data = collect(DB::select("
            SELECT  distinct
                    inventory_location_id value,
                    concatenated_segments label
            from    mtl_item_locations_kfv
            where  1=1
            and     organization_id = $orgId
            $conditionSubinv
            $condition
            order by label
        "));

        return $data->toArray();
    }

    private function getOrgByItem($itemId)
    {
        $itemTable = (new \App\Models\PM\Settings\ItemNumberV)->getTable();
        $conditionItemId = 'and 1=1';
        if ($itemId) {
            $conditionItemId = "and inventory_item_id = '$itemId'";
        }


        $data = collect(DB::select("
            SELECT  distinct organization_id
            from    {$itemTable}
            where  1=1
            and     organization_code <> 'A00'
            $conditionItemId
        "));

        if (!$data) {
            return [];
        }

        $data = $this->getOrg($value = false, $data->pluck('organization_id', 'organization_id')->all());
        return $data;
    }

    private function getToItemId($fmItemId, $orgId = false, $value = false)
    {
        $itemTable = (new \App\Models\PM\Settings\ItemNumberV)->getTable();
        $condition = 'and 1=1';
        // if ($value) {
        //     $condition = "and inventory_item_id = '$value'";
        // }

        $setup = $this->getSetupOrgTransfer($fmItemId);

        if (count($setup) == 0) {
            return [];
        }
        $conditionOrg = 'and 1=1';
        // if ($orgId) {
        //     $conditionOrg = "and     organization_id = {$orgId}";
        // } else {
        // }
        $toOrganizations = $setup->pluck('to_organization_id', 'to_organization_id')->all();
        $toOrganizations = implode(',', $toOrganizations);
        $conditionOrg = "and     organization_id in ($toOrganizations)";

        $data = collect(DB::select("
            SELECT  distinct
                    organization_id,
                    organization_code,
                    inventory_item_id,
                    item_number,
                    item_desc,
                    primary_unit_of_measure,
                    primary_uom_code,
                    inventory_item_id * organization_id value,
                    item_number || ' : ' || item_desc label
            from    {$itemTable}
            where  1=1
            and     organization_code <> 'A00'
            and     item_type in ('FG', 'SFG')
            --and     (inventory_item_id = 41122 or inventory_item_id = 635)
            $conditionOrg
            $condition
            order by label, organization_code
        "));

        return $data->toArray();
    }

    private function getToUom($orgId, $itemId, $value = false)
    {
        $itemTable = (new \App\Models\PM\Settings\ItemNumberV)
                        ->where('organization_id', $orgId)
                        ->where('inventory_item_id', $itemId)
                        ->first();
        $table = (new \App\Models\PM\Lookup\PtpmItemConvUomV)->getTable();

        $condition = 'and 1=1';
        $value = $itemTable->primary_uom_code;
        if ($value) {
            $condition = "and from_uom_code = '$value'";
        }

        $data = collect(DB::select("
            SELECT  distinct
                    from_uom_code value,
                    from_unit_of_measure  label
            from    {$table}
            where  1=1
            and     organization_id = {$orgId}
            and     inventory_item_id = {$itemId}
            and     to_uom_code = '{$itemTable->primary_uom_code}'
            $condition
            order by label
        "));

        return $data->toArray();
    }

    private function getToUomByItem($itemId, $orgId, $value = false)
    {

        $itemTable = (new \App\Models\PM\Settings\ItemNumberV)->getTable();
        $conditionItem = 'and 1=1';
        if ($itemId) {
            $conditionItem = "and inventory_item_id = '$itemId'";
        }

        $conditionOrg = 'and 1=1';
        if ($orgId) {
            $conditionOrg = "and     organization_id = {$orgId}";
        }

        $data = collect(DB::select("
            SELECT  distinct
                    organization_id,
                    primary_uom_code
                    primary_unit_of_measure
            from    {$itemTable}
            where  1=1
            and     organization_code <> 'A00'
            $conditionOrg
            $conditionItem
        "));

        return $data->toArray();

    }

    private function getTransactionType($value = false)
    {
        $condition = 'and 1=1';
        if ($value) {
            $condition = "and transaction_type_id = '$value'";
        }

        $data = collect(DB::select("
            SELECT  distinct
                    transaction_type_id value,
                    transaction_type_name  label
            from    mtl_transaction_types
            where  1=1
            $condition
            order by label
        "));

        return $data->toArray();
    }

    private function getProfile($lookupCode = false)
    {
        $data = getDefaultData($this::url);

        return $data;
    }

    private function getSetupOrgTransfer($fmItemId, $ptpmSetupMfgDepartmentId = false)
    {
        $fmItem = ItemNumberV::where('inventory_item_id', $fmItemId)->first();

        $letterTranTypeName = (new SavePublicationLayoutRepository)->getLetterTranTypeName(); // 'T16:จ่าย-Letterข้ามItem'
        $setup = \App\Models\PM\PtpmSetupMfgDepartmentsV::where('transaction_type_name', $letterTranTypeName)
                    ->when($fmItem->tobacco_group_code != '', function ($q) use ($fmItem) {
                        $q->where('tobacco_group_code', $fmItem->tobacco_group_code);
                    })
                    // ->when($fmOrgId, function ($q) use ($fmOrgId) {
                    //     $q->where('from_organization_id', $fmOrgId);
                    // })
                    ->when($ptpmSetupMfgDepartmentId, function ($q) use ($ptpmSetupMfgDepartmentId) {
                        $q->where('id', $ptpmSetupMfgDepartmentId);
                    })
                    ->where('enable_flag', 'Y')
                    ->get();

        if (count($setup) == 0) {
            return false;
        }

        return $setup;
    }
}
