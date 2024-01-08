<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0032ApiController;
use App\Models\PM\MtlUomConversions;
use App\Models\PM\PtpmStampHeader;
use App\Models\PM\PtpmStampLine;

class PM0032Controller extends BaseController
{

    /**
     * @var PM0032ApiController
     */
    private $api;

    /**
     * StampUsingApiController constructor.
     * @param PM0032ApiController $api
     */
    public function __construct(PM0032ApiController $api)
    {
        $this->api = $api;
    }


    public function index()
    {
        $user = auth()->user();
        $organization = $this->getOrganization($user);
        $coreCodes = [];//$this->api->getAllCoreCodes();
        $conversion_rate_master = MtlUomConversions::select('CONVERSION_RATE')->where('UOM_CLASS', 'แสตมป์')->where('UOM_CODE', 'STR')->first();
        $machines = $this->getMachines();
        $data = [
            'header_id' => null,
            'init_header' => (object)[
                'used_date' => date('Y-m-d'),
                'machines' => $machines,
            ],
            'init_lines' => (array)[],
            'core_codes' => [],//$coreCodes->toArray(),
            'user' => $user,
            'organization' => $organization,
            'conversion_rate_master' => $conversion_rate_master,
        ];
        return $this->vue('pm0032', $data);
    }

    public function show($stampHeaderId)
    {
        $user = auth()->user();
        $organization = $this->getOrganization($user);
        $info = $this->api->show($stampHeaderId)->getData();

        $coreCodes = PtpmStampLine::query()
            ->whereDate('used_date', '=', $info->header->used_date)
            ->get();

        $initHeader = $info->header;
        $initHeader->machines = $this->getMachines();

        $data = [
            'header_id' => $stampHeaderId,
            'init_header' => $initHeader,
            'init_lines' => $info->lines,
            'init_machine_groups' => $info->machineGroups,
            'core_codes' => $coreCodes->toArray(),
            'user' => $user,
            'organization' => $organization,
        ];
        return $this->vue('pm0032', $data);
    }

    public function create()
    {
        $user = auth()->user();
        $organization = $this->getOrganization($user);
        $coreCodes = [];//$this->api->getAllCoreCodes();
        $data = [
            'pk' => null,
            'init_header' => (object)[],
            'init_lines' => (array)[],
            'core_codes' => [],//$coreCodes->toArray(),
            'user' => $user,
            'organization' => $organization,
        ];
        return $this->vue('pm0032', $data);
    }

    public function getMachines()
    {
        $machines = \App\Models\PM\PtpmMachineRelationsV::selectRaw("
                            distinct
                            machine_set value,
                            machine_set label
                        ")
                        ->orderBy('label')
                        ->get();

        return $machines;
    }
}
