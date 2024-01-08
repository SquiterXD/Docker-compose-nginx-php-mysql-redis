<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ModulePaths;
use App\Http\Controllers\ValidationErrorMessages;
use App\Models\PD\FndLookupValues;
use App\Models\PD\PtinvOnhandQuantitiesV;
use App\Models\PD\PtpdBlendFlavour;
use App\Models\PD\PtpdFormulaBlendD;
use App\Models\PD\PtpdFormulaBlendH;
use App\Models\PD\PtpdFormulaBlendL;
use App\Models\PD\PtpdFormulaWrap;
use App\Models\PD\PtpdInvMaterialItem;
use App\Models\PD\PtpmItemNumberV;
use App\Models\PD\PtpmSetupMfgDepartmentsV;
use App\Models\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\Oci8\Query\OracleBuilder;

class PD0006ApiController extends Controller
{
    //DB::connection()->enableQueryLog();
    //print_r(DB::getQueryLog());

    const PROGRAM_CODE = 'PD0006';
    const FORMULA_TYPE = '20';

    const TAB_TYPE_LEAF_FORMULA = 'Leaf Formula';
    const TAB_TYPE_CASING = 'Casing';
    const TAB_TYPE_FLAVOUR = 'Flavour';
    const TAB_TYPE_EXAMPLE_CIGARETTE = 'Example Cigarette';

    const HEADER_COLUMNS = [
        'blend_id',
        'blend_num',
        'taste',
        'blend_qty',
        'blend_uom',
        'description',
        'remark',
        'approved_date',
        'start_date',
        'status',
        'created_at',
        'updated_at',
        'updated_by_id',
    ];

    const USER_COLUMNS = [
        'user_id',
        'name',
        'email',
        'username',
        'department_code',
        'active',
    ];

    const FLAVOUR_COLUMNS = [
        'lookup_code',
        'meaning',
        'description',
        'start_date_active',
        'end_date_active',
        'enabled_flag',
        'organization_id',
        'department_code',
    ];

    const LINE_COLUMNS = [
        'blend_line_id',
        'blend_id',
        'tab_type',
        'tab_id',
        'tab_num',
        'tab_desc',
        'leaf_formula_num',
        'ratio',
    ];

    const WRAP_COLUMNS = [
        'wrap_id',
        'blend_id',
        'wrap_no',
        'description',
        'program_code',
        'created_at',
        'updated_at',
        'created_by_id',
        'updated_by_id',
    ];

    public function index(): JsonResponse
    {
        $defaultData = getDefaultData(ModulePaths::PD_0006);
        $userId = $defaultData->user_id;

        $header = [];
        $header['blend_num'] = null;
        $header['taste'] = null;
        $header['blend_qty'] = null;
        $header['blend_uom'] = 'KG'; //default to KG
        $header['description'] = null;
        $header['remark'] = null;
        $header['creation_date'] = date('Y-m-d');
        $header['last_update_date'] = date('Y-m-d');
        $header['status'] = 'N';
        $header['created_by_id'] = $userId;
        $header['approved_date'] = null;
        $header['start_date'] = null;

        $leafFormulae = [];
        $leafFormulae[] = [
            'blend_line_id' => '1001',
            'tab_type' => 'Leaf Formula',
            'tab_num' => 'A',
            'tab_desc' => 'Leaf Formula A',
            'ratio' => '80.00',
            'details' => [
                [
                    'blend_detail_id' => '11',
                    'blend_line_id' => '1001',
                    'item_number' => '1002000AA',
                    'inventory_item_id' => '40001',
                    'item_desc' => 'AA',
                    'lot_number' => '10001',
                    'item_ratio' => '20.00',
                ],
                [
                    'blend_detail_id' => '12',
                    'blend_line_id' => '1001',
                    'item_number' => '1002000AA',
                    'inventory_item_id' => '40002',
                    'item_desc' => 'AB',
                    'lot_number' => '10002',
                    'item_ratio' => '35.00',
                ],
                [
                    'blend_detail_id' => '13',
                    'blend_line_id' => '1001',
                    'item_number' => '1002000AA',
                    'inventory_item_id' => '40003',
                    'item_desc' => 'AC',
                    'lot_number' => '10003',
                    'item_ratio' => '45.00',
                ],
            ],
        ];

        $leafFormulae[] = [
            'blend_line_id' => '1002',
            'tab_type' => 'Leaf Formula',
            'tab_num' => 'B',
            'tab_desc' => 'Leaf Formula B',
            'ratio' => '20.00',
            'details' => [
                [
                    'blend_detail_id' => '21',
                    'blend_line_id' => '1002',
                    'item_number' => '1002000AA',
                    'inventory_item_id' => '40001',
                    'item_desc' => 'BA',
                    'lot_number' => '20001',
                    'item_ratio' => '60.00',
                ],
                [
                    'blend_detail_id' => '22',
                    'blend_line_id' => '1002',
                    'item_number' => '1002000AA',
                    'inventory_item_id' => '40002',
                    'item_desc' => 'BB',
                    'lot_number' => '20002',
                    'item_ratio' => '40.00',
                ],
            ],
        ];

        $lookupData = $this->getLookupData();

        $blendFormula = [];
        $blendFormula['header'] = $header;
        $blendFormula['leaf_formulae'] = $leafFormulae;
        $blendFormula['lookup_leaf_formulae'] = $lookupData['lookup_leaf_formulae'];
        $blendFormula['lookup_tastes'] = $lookupData['lookup_tastes'];
        $blendFormula['lookup_statuses'] = $lookupData['lookup_statuses'];

        return response()->json($blendFormula);
    }

    public function show($blendId): JsonResponse
    {
        $blendId = trim($blendId);
        $validatingData['blendId'] = $blendId;

        $validator = Validator::make($validatingData, [
            'blendId' => 'required|numeric|integer',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        try {
            $response = $this->getBlendFormula($blendId);
            if (!$response->isSuccess()) {
                return response()->json($response->getResponse(), $response->getHttpCode());
            }

            $blendFormula = $response->getResponse();
            $lookupData = $this->getLookupData();

            $blendFormula = array_merge($blendFormula, $lookupData);

            return response()->json($blendFormula);

        } catch (Exception $e) {
            throw $e;
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = $this->blendFormulaValidation($request, false);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }

        try {
            $blendFormula = $request->all();

            if (isset($blendFormula['header']['blend_id'])) {
                $existingBlendFormula = PtpdFormulaBlendH::query()
                    ->find($blendFormula['header']['blend_id']);

                if (isset($existingBlendFormula)) {
                    return response()->json([
                        'Error' => 'Resource Already Exist',
                    ], 409);
                }
            }

            $response = $this->createOrUpdateBlendFormula($blendFormula);
            if ($response->isSuccess()) {
                return response()->json($response->getResponse());
            } else {
                return response()->json($response->getResponse(), $response->getHttpCode());
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function update(Request $request, $blendId): JsonResponse
    {
        $validator = $this->blendFormulaValidation($request, false);
        if ($validator->fails()) {
            return response()->json($validator->messages()->toArray(), 400);
        }
        $blendId = intval(trim($blendId));

        $blendFormula = $request->all();
        if ($blendId !== intval($blendFormula['header']['blend_id'])) {
            return response()->json(['URL and JSON id mismatch'], 400);
        }

        try {
            DB::beginTransaction();
            $response = $this->createOrUpdateBlendFormula($blendFormula);
            DB::commit();

            if ($response->isSuccess()) {
                return response()->json($response->getResponse());
            } else {
                return response()->json($response->getResponse(), $response->getHttpCode());
            }

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    private function getBlendFormula($blendId): Response
    {
        $header = PtpdFormulaBlendH::query()
            ->with('updatedByUser')
            ->with(array('updatedByUser' => function ($query) {
                $query->select(self::USER_COLUMNS);
            }))
            ->with(array('tasteInfo' => function ($query) {
                $query->select(self::FLAVOUR_COLUMNS);
            }))
            ->select(self::HEADER_COLUMNS)
            ->find($blendId);

        if (empty($header)) {
            return Response::Error(['Not Found'], 404);
        }

        $leafFormulae = $this->getLeafFormulae($blendId, $header);
        $casings = $this->getCasings($blendId);
        $flavours = $this->getFlavours($blendId);
        $exampleCigarette = $this->getExampleCigarette($blendId);
        $rawMaterials = $this->getRawMaterialsForTabs($casings, $flavours);

        $lookupData = $this->getLookupData();

        $blendFormula = [
            'header' => $header,
            'leaf_formulae' => $leafFormulae,
            'casings' => $casings,
            'flavours' => $flavours,
            'example_cigarette' => $exampleCigarette,
            'raw_materials' => $rawMaterials,
        ];

        $blendFormula = array_merge($blendFormula, $lookupData);

        return Response::Success($blendFormula);
    }

    private function getLookupData(): array
    {
        $lookupTastes = PtpdBlendFlavour::query()
            ->select(self::FLAVOUR_COLUMNS)
            ->get();

        $lookupStatuses = [
            ['code' => 'Y', 'description' => 'Active'],
            ['code' => 'N', 'description' => 'Inactive'],
        ];

        $lookupLeafFormulae = FndLookupValues::query()
            ->where('lookup_type', '=', 'PTPD_LEAF_FORMULA')
            ->get([
                'lookup_code',
                'meaning',
                'description',
            ]);

        return [
            'lookup_leaf_formulae' => $lookupLeafFormulae,
            'lookup_tastes' => $lookupTastes,
            'lookup_statuses' => $lookupStatuses,
        ];
    }

    private function getLeafFormulae(int $blendId, $header): array
    {
        $flavour = PtpdBlendFlavour::query()
            ->where('meaning', '=', $header['taste'])
            ->select(self::FLAVOUR_COLUMNS)
            ->first();

        $organizationId = $flavour['organization_id'];

        $leafFormulae = PtpdFormulaBlendL::query()
            ->select(self::LINE_COLUMNS)
            ->where('blend_id', '=', $blendId)
            ->where('tab_type', '=', self::TAB_TYPE_LEAF_FORMULA)
            ->with(['details'])
            ->get()
            ->toArray();

        $allInventoryItemIds = [];
        foreach ($leafFormulae as $leafFormula) {
            foreach ($leafFormula['details'] as $detail) {
                $allInventoryItemIds[] = $detail['inventory_item_id'];
            }
        }

        $allInventoryItemIds = array_unique($allInventoryItemIds, SORT_STRING);

        $ptpmItemNumberV = PtpmItemNumberV::query();
        $ptpmItemNumberVName = $ptpmItemNumberV->getModel()->getTable();

        $itemNumberQuery = $ptpmItemNumberV
            ->where('organization_id', '=', $organizationId)
            ->whereIn("$ptpmItemNumberVName.tobacco_group_code", ['1001', '1002', '1007'])
            ->whereIn('inventory_item_id', $allInventoryItemIds);

        $itemNumbers = $this->retrieveLots($itemNumberQuery, $flavour);
        $itemNumberMapping = [];
        foreach ($itemNumbers as $itemNumber) {
            $itemNumberMapping[$itemNumber['inventory_item_id']] = $itemNumber;
        }

        array_walk($leafFormulae, function (&$leafFormula) use ($itemNumberMapping) {
            $details = $leafFormula['details'] ?? [];

            array_walk($details, function (&$detail) use ($itemNumberMapping) {
                $itemNumber = $itemNumberMapping[$detail['inventory_item_id']] ?? [];

                $detail['item_number'] = $itemNumber['item_number'];
                $detail['item_desc'] = $itemNumber['item_desc'];
                $detail['lots'] = $itemNumber['lots'];
            });

            $leafFormula['details'] = $details;
        });

        return $leafFormulae;
    }

    private function retrieveLots($itemNumbersQuery, $flavour): array
    {
        $departmentCode = $flavour['department_code'];

        $ptpmItemNumberVName = $itemNumbersQuery->getModel()->getTable();

        $setupMfgDepartment = PtpmSetupMfgDepartmentsV::query();
        $setupMfgDepartmentName = $setupMfgDepartment->getModel()->getTable();

        $itemNumbers = $itemNumbersQuery
            ->join($setupMfgDepartmentName,
                function ($join)
                use ($ptpmItemNumberVName, $setupMfgDepartmentName, $departmentCode) {
                    $join->on("$ptpmItemNumberVName.tobacco_group_code", '=', "$setupMfgDepartmentName.tobacco_group_code");
                    $join->where("$setupMfgDepartmentName.department_code", "=", $departmentCode);
                })
            ->select([
                "$ptpmItemNumberVName.*",
                'from_organization_id',
                'from_subinventory',
                'from_locator_id',
            ])
            ->get()
            ->toArray();

        array_walk($itemNumbers, function (&$itemNumber) {
            $lots = PtinvOnhandQuantitiesV::query()
                ->where('inventory_item_id', '=', $itemNumber['inventory_item_id'])
                ->where('organization_id', '=', $itemNumber['from_organization_id'])
                ->where('subinventory_code', '=', $itemNumber['from_subinventory'])
                ->where('locator_id', '=', $itemNumber['from_locator_id'])
                ->orderBy('origination_date')
                ->get([
                    'locator_id',
                    'locator_code',
                    'item_desc',
                    'lot_number',
                ])
                ->toArray();

            //these fields only use for joining
            unset($itemNumber['from_organization_id']);
            unset($itemNumber['from_subinventory']);
            unset($itemNumber['from_locator_id']);

            $itemNumber['lots'] = $lots;
        });

        return $itemNumbers;
    }

    private function getCasings(int $blendId): array
    {
        $casings = PtpdFormulaBlendL::query()
            ->select(self::LINE_COLUMNS)
            ->where('blend_id', '=', $blendId)
            ->where('tab_type', '=', self::TAB_TYPE_CASING)
            ->with('leafFormula')
            ->get()
            ->toArray();

        array_walk($casings, function (&$casing) {
            $casing['leaf_formula_desc'] = $casing['leaf_formula']['tab_desc'];
            unset($casing['leaf_formula']);
        });

        return $casings;
    }

    private function getFlavours(int $blendId): array
    {
        return PtpdFormulaBlendL::query()
            ->select(self::LINE_COLUMNS)
            ->where('blend_id', '=', $blendId)
            ->where('tab_type', '=', self::TAB_TYPE_FLAVOUR)
            ->get()
            ->toArray();
    }

    private function getExampleCigarette(int $blendId): array
    {
        $exampleCigarette = PtpdFormulaBlendL::query()
            ->select(self::LINE_COLUMNS)
            ->where('blend_id', '=', $blendId)
            ->where('tab_type', '=', self::TAB_TYPE_EXAMPLE_CIGARETTE)
            ->first()
            ->toArray();

        $wraps = PtpdFormulaWrap::query()
            ->select(self::WRAP_COLUMNS)
            ->where('blend_id', '=', $blendId)
            ->orderBy('wrap_no')
            ->get()
            ->toArray();

        $exampleCigarette = array_merge($exampleCigarette, [
            'wraps' => $wraps,
        ]);

        return $exampleCigarette;
    }

    private function getRawMaterialsForTabs(array $casings, array $flavours): array
    {
        $mapCasing = function ($casing) {
            return $casing['tab_id'];
        };

        $mapFlavour = function ($flavour) {
            return $flavour['tab_id'];
        };

        $tabIds = array_merge(
            array_map($mapCasing, $casings),
            array_map($mapFlavour, $flavours),
        );

        return $this->getRawMaterials($tabIds);
    }

    private function getRawMaterials(array $tabIds): array
    {
        $rawMaterials = DB::table('PSAH.SIMU_FORMULA_NO')
            ->selectRaw('PSAH.SIMU_FORMULA_ID AS simu_formula_id')
            ->selectRaw('PSAL.RAW_MATERIAL_NUM AS raw_material_no')
            ->selectRaw('PSAL.DESCRIPTION AS description')
            ->selectRaw('PSAL.ACTUAL_QTY AS quantity')
            ->selectRaw('PSAL.ACTUAL_UOM AS uom')
            ->fromRaw('OAPD.PTPD_SIMU_ADDITIVE_H PSAH')
            ->join('OAPD.PTPD_SIMU_ADDITIVE_L PSAL', function ($join) use ($tabIds) {
                $join->on('PSAH.SIMU_FORMULA_ID', '=', 'PSAL.SIMU_FORMULA_ID');
                $join->whereIn('PSAH.SIMU_FORMULA_ID', $tabIds);
            })
            ->get()
            ->toArray();

        $rawMaterialMapping = [];
        foreach ($rawMaterials as $rawMaterial) {
            $rawMaterialMapping[$rawMaterial->simu_formula_id][] = $rawMaterial;
        }

        return $rawMaterialMapping;
    }

    private function createOrUpdateBlendFormula($blendFormula, $isCreateNew = false): Response
    {
        // TODO
        // check for example cigarette duplication

        $header = $blendFormula['header'];
        $leafFormulae = $blendFormula['leaf_formulae'];
        $casings = $blendFormula['casings'];
        $flavours = $blendFormula['flavours'];
        $exampleCigarette = $blendFormula['example_cigarette'];

        if (!$this->leafFormulaeRatioValidate($leafFormulae)) {
            return Response::Error(
                ['leaf_formulae.*.ratio' => 'สัดส่วนของสูตรใบยาต้องรวมกันได้ 100%'],
                400
            );
        }

        $defaultData = getDefaultData(ModulePaths::PD_0006);

        $this->createOrUpdateHeader($header, $defaultData, $isCreateNew);
        $this->createOrUpdateLeafFormula($header, $leafFormulae);
        $this->createOrUpdateCasings($header, $casings);
        $this->createOrUpdateFlavours($header, $flavours);
        $this->createOrUpdateExampleCigarette($header, $exampleCigarette, $defaultData, $isCreateNew);

        return $this->getBlendFormula($header['blend_id']);
    }

    private function createOrUpdateHeader($header, $defaultData, $isCreateNew): array
    {
        $userId = $defaultData->user_id;

        $header = array_merge(
            $header,
            [
                'formula_type' => self::FORMULA_TYPE,
                'program_code' => self::PROGRAM_CODE,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by_id' => $userId,
            ],
        );

        if ($isCreateNew) {
            $header = array_merge(
                $header,
                [
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by_id' => $userId,
                ],
            );
        }

        // the formula is inactive; clear approved date & start date
        if (strcmp($header['status'], 'Y') !== 0) {
            $header = array_merge(
                $header,
                [
                    'approved_date' => null,
                    'start_date' => null,
                ],
            );
        }

        if ($isCreateNew) {
            return PtpdFormulaBlendH::query()
                ->create($header)
                ->toArray();
        } else {
            $updateQuery = PtpdFormulaBlendH::query()
                ->find($header['blend_id']);

            $updateQuery->update($header);
            return $header;
        }
    }

    private function createOrUpdateLeafFormula($header, $leafFormulae): array
    {
        $blendId = $header['blend_id'];
        $updatedLeafFormulae = [];

        // set default value
        array_walk($leafFormulae, function (&$leafFormula) use ($blendId) {
            $leafFormula = array_merge($leafFormula, [
                'blend_id' => $blendId,
                'tab_type' => self::TAB_TYPE_LEAF_FORMULA,
            ]);
        });

        $this->deleteMissingLines($blendId, self::TAB_TYPE_LEAF_FORMULA, $leafFormulae);

        // perform update or create
        foreach ($leafFormulae as $leafFormula) {
            $details = $leafFormula['details'];

            $updatedLeafFormulae[] = PtpdFormulaBlendL::query()
                ->updateOrCreate(
                    ['blend_line_id' => $leafFormula['blend_line_id']],
                    $leafFormula
                );

            foreach ($details as $detail) {
                PtpdFormulaBlendD::query()
                    ->updateOrCreate(
                        ['blend_detail_id' => $detail['blend_detail_id']],
                        $detail
                    );
            }
        }

        return $updatedLeafFormulae;
    }

    /** @noinspection DuplicatedCode */
    // duplicated code is intended as each line type may has difference logic
    private function createOrUpdateCasings($header, $casings): array
    {
        $blendId = $header['blend_id'];
        $updatedCasings = [];

        // set default value
        array_walk($casings, function (&$casing) use ($blendId) {
            $casing = array_merge($casing, [
                'blend_id' => $blendId,
                'tab_type' => self::TAB_TYPE_CASING,
            ]);
        });

        $this->deleteMissingLines($blendId, self::TAB_TYPE_CASING, $casings);

        // perform update or create
        foreach ($casings as $casing) {
            $updatedCasings[] = PtpdFormulaBlendL::query()
                ->updateOrCreate(
                    ['blend_line_id' => $casing['blend_line_id'] ?? null],
                    $casing
                );
        }

        return $updatedCasings;
    }

    /** @noinspection DuplicatedCode */
    // duplicated code is intended as each line type may has difference logic
    private function createOrUpdateFlavours($header, $flavours): array
    {
        $blendId = $header['blend_id'];
        $updatedFlavours = [];

        // set default value
        array_walk($flavours, function (&$flavour) use ($blendId) {
            $flavour = array_merge($flavour, [
                'blend_id' => $blendId,
                'tab_type' => self::TAB_TYPE_FLAVOUR,
            ]);
        });

        $this->deleteMissingLines($blendId, self::TAB_TYPE_FLAVOUR, $flavours);

        // perform update or create
        foreach ($flavours as $flavour) {
            $updatedFlavours[] = PtpdFormulaBlendL::query()
                ->updateOrCreate(
                    ['blend_line_id' => $flavour['blend_line_id'] ?? null],
                    $flavour
                );
        }

        return $updatedFlavours;
    }

    private function createOrUpdateExampleCigarette($header, $exampleCigarette, $defaultData, $isCreateNew): array
    {
        $blendId = $header['blend_id'];
        $wraps = $exampleCigarette['wraps'];

        $updatedExampleCigarette = $this->updateExampleCigaretteLine($blendId, $exampleCigarette);
        $this->deleteMissingWraps($blendId, $wraps);

        // set default value
        array_walk($wraps, function (&$wrap) use ($defaultData, $isCreateNew, $blendId) {
            $userId = $defaultData->user_id;

            $wrap = array_merge($wrap, [
                'blend_id' => $blendId,
                'program_code' => self::PROGRAM_CODE,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by_id' => $userId,
            ]);

            if ($isCreateNew) {
                $wrap = array_merge(
                    $wrap,
                    [
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by_id' => $userId,
                    ],
                );
            }
        });

        $updatedWraps = $this->createOrUpdateWraps($wraps);

        $updatedExampleCigarette = array_merge(
            $updatedExampleCigarette,
            [
                'wraps' => $updatedWraps,
            ]
        );

        return $updatedExampleCigarette;
    }

    private function createOrUpdateWraps($wraps): array
    {
        // perform update or create
        $updatedWraps = [];
        foreach ($wraps as $wrap) {
            $updatedWraps[] = PtpdFormulaWrap::query()
                ->updateOrCreate(
                    ['wrap_id' => $wrap['wrap_id'] ?? null],
                    $wrap,
                );
        }

        return $updatedWraps;
    }

    private function deleteMissingLines($blendId, $tabType, $lines): int
    {
        // filter only IDs that were save to database (have blend_line_id),
        // other lines that exist in database but not in the request must be deleted
        $requestBlendLineIds = array_map(function ($line) {
            return $line['blend_line_id'];

        }, array_filter($lines, function ($line) {
            return isset($line['blend_line_id']);
        }));

        if (!empty($requestBlendLineIds)) {
            //delete lines that are missing from the request
            return PtpdFormulaBlendL::query()
                ->where('blend_id', '=', $blendId)
                ->where('tab_type', '=', $tabType)
                ->whereNotIn('blend_line_id', $requestBlendLineIds)
                ->delete();
        } else {
            return 0;
        }
    }

    private function updateExampleCigaretteLine($blendId, $exampleCigarette): array
    {
        $blendLineId = $exampleCigarette['blend_line_id'] ?? null;

        $exampleCigarette = array_merge($exampleCigarette, [
            'blend_id' => $blendId,
            'tab_type' => self::TAB_TYPE_EXAMPLE_CIGARETTE,
        ]);

        //delete all to enforce single row
        PtpdFormulaBlendL::query()
            ->where('blend_id', '=', $blendId)
            ->where('tab_type', '=', self::TAB_TYPE_EXAMPLE_CIGARETTE)
            ->delete();

        return PtpdFormulaBlendL::query()
            ->updateOrCreate(
                ['blend_line_id' => $blendLineId],
                $exampleCigarette
            )
            ->toArray();
    }

    private function deleteMissingWraps($blendId, $wraps): int
    {

        // filter only IDs that were save to database (have wrap_id),
        // other lines that exist in database but not in the request must be deleted
        $requestWrapIds = array_map(function ($wrap) {
            return $wrap['wrap_id'];

        }, array_filter($wraps, function ($wrap) {
            return isset($wrap['wrap_id']);
        }));

        if (!empty($requestWrapIds)) {
            //delete lines that are missing from the request
            return PtpdFormulaWrap::query()
                ->where('blend_id', '=', $blendId)
                ->whereNotIn('wrap_id', $requestWrapIds)
                ->delete();
        } else {
            return 0;
        }
    }

    private function blendFormulaValidation(Request $request, $isCreateNew): \Illuminate\Contracts\Validation\Validator
    {
        $blendFormula = $request->all();

        $validatingRules = [
            'header.blend_id' => [Rule::requiredIf(!$isCreateNew), 'numeric', 'integer'],
            'header.blend_num' => 'required',
            'header.taste' => 'required',
            'header.blend_qty' => ['required', 'numeric'],
            'header.blend_uom' => ['required', Rule::in(['KG'])],
            'header.created_at' => ['nullable', 'date'],
            'header.updated_at' => ['nullable', 'date'],
            'header.status' => ['required', Rule::in(['Y', 'N'])],
            'header.updated_by_id' => ['nullable', 'numeric', 'integer'],
            'header.approved_date' => ['nullable', 'date'],
            'header.start_date' => ['nullable', 'date'],

            'leaf_formulae' => ['required', 'array'],
            'leaf_formulae.*.tab_num' => ['required', 'distinct'],
            'leaf_formulae.*.tab_desc' => ['required'],
            'leaf_formulae.*.ratio' => ['required', 'numeric'],

            'leaf_formulae.details' => ['array'],
            'leaf_formulae.details.*.blend_detail_id' => ['required', 'numeric', 'integer'],
            'leaf_formulae.details.*.blend_line_id' => ['required', 'numeric', 'integer'],
            'leaf_formulae.details.*.inventory_item_id' => ['required'],
            'leaf_formulae.details.*.item_ratio' => ['required', 'numeric'],
            'leaf_formulae.details.*.lot_number' => ['required'],
            'leaf_formulae.details.*.item_desc' => ['required'],

            'casings' => ['required', 'array'],
            'casings.*.leaf_formula_num' => ['required'],
            'casings.*.tab_num' => ['required'],
            'casings.*.tab_desc' => ['required'],

            'example_cigarette' => ['required'],
            'example_cigarette.tab_num' => ['required', 'numeric', 'integer'],
            'example_cigarette.tab_desc' => ['required'],
            'example_cigarette.wraps' => ['array'],
            'example_cigarette.wraps.*.wrap_no' => ['required', 'numeric', 'integer'],
            'example_cigarette.wraps.*.description' => ['required'],
        ];

        $attributeNames = [
            'header.blend_id' => 'รหัสสูตรทดลองยาเส้นปรุง',
            'header.blend_num' => 'ยาเส้นปรุงทดลอง',
            'header.taste' => 'รสชาติ',
            'header.blend_qty' => 'ปริมาณ',
            'header.blend_uom' => 'หน่วย',
            'header.created_at' => 'วันที่สร้าง',
            'header.updated_at' => 'วันที่แก้ไขล่าสุด',
            'header.status' => 'สถานะ',
            'header.updated_by_id' => 'ผู้่บันทึก',
            'header.approved_date' => 'วันที่อนุมัติ',
            'header.start_date' => 'วันที่เริ่มใช้',

            'leaf_formulae' => 'รายการสูตรใบยา',
            'leaf_formulae.*.tab_num' => 'รหัสสูตรใบยา',
            'leaf_formulae.*.tab_desc' => 'รายละเอียดของสูตรใบยา',
            'leaf_formulae.*.ratio' => 'สัดส่วนของสูตรใบยา',

            'leaf_formulae.details' => 'ส่วนประกอบของสูตรใบยาต',
            'leaf_formulae.details.*.blend_detail_id' => 'รหัสของส่วนประกอบของสูตรใบยา',
            'leaf_formulae.details.*.blend_line_id' => 'รหัสสูตรใบยาของส่วนประกอบของสูตรใบยา',
            'leaf_formulae.details.*.inventory_item_id' => 'รหัส inventory ของส่วนประกอบของสูตรใบยา',
            'leaf_formulae.details.*.item_ratio' => 'สัดส่วนของส่วนประกอบของสูตรใบยา',
            'leaf_formulae.details.*.lot_number' => 'หมายเลข lot ของส่วนประกอบของสูตรใบยา',
            'leaf_formulae.details.*.item_desc' => 'รายละเอียดของส่วนประกอบของสูตรใบยา',

            'casings' => 'รายการของสารหอม',
            'casings.*.leaf_formula_num' => 'รหัสสูตรใบยาของสารหอม',
            'casings.*.tab_num' => 'รหัสสารหอม',
            'casings.*.tab_desc' => 'รายละเอิียดของสารหอม',

            'example_cigarette' => 'บุหรี่ทดลอง',
            'example_cigarette.tab_num' => 'tab_num ของบุหรี่ทดลอง',
            'example_cigarette.tab_desc' => 'รายละเอียดของบุหรี่ทดลอง',
            'example_cigarette.wraps' => 'รายการของวัตถุห่อมวน',
            'example_cigarette.wraps.*.wrap_no' => 'รหัสของวัตถุห่อมวล',
            'example_cigarette.wraps.*.description' => 'รายละเอียดของวัตถุห่อมวล',
        ];

        return Validator::make(
            $blendFormula,
            $validatingRules,
            ValidationErrorMessages::TEMPLATES,
            $attributeNames,
        );
    }

    private function leafFormulaeRatioValidate($leafFormulae): bool
    {
        $totalRatio = array_reduce($leafFormulae, function ($result, $leafFormula) {
            $result += $leafFormula['ratio'];
            return $result;
        });

        return abs($totalRatio - 100) < PHP_FLOAT_EPSILON;
    }

    public function getMfgFormulae(): JsonResponse
    {
        try {
            $mfgFormulae = PtpdInvMaterialItem::query()
                ->from('oapd.ptpd_inv_material_item as pimi')
                ->whereNotExists(function (OracleBuilder $query) {
                    $query
                        ->select(DB::raw("'Y'"))
                        ->from('oapm.ptpm_mfg_formula_v')
                        ->whereRaw('product_item_id = pimi.inventory_item_id');
                })
                ->where('raw_material_type_code', '=', "91")// 91 is type of 'ยาเส้นปรุงทดลอง'
                ->whereNotNull('inventory_item_id')
                ->orderBy('blend_no')
                ->get();

            return response()->json([
                'mfg_formulae' => $mfgFormulae,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function lookupItemNumbers(Request $request): JsonResponse
    {
        try {
            $queryString = $request->all();
            $validator = Validator::make($queryString, [
                'flavourCode' => 'required|numeric|integer',
                'maxResults' => 'numeric|integer',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $query = $queryString['query'] ?? null;
            $flavourCode = $queryString['flavourCode'] ?? null;
            $maxResults = $queryString['maxResults'] ?? null;

            if (isset($query)) {
                $query = trim($query);
            } else {
                $query = '';
            }

            if (!isset($maxResults)) {
                $maxResults = 30;
            }

            $flavour = PtpdBlendFlavour::query()
                ->where('lookup_code', '=', $flavourCode)
                ->first();

            $organizationId = $flavour['organization_id'];

            $ptpmItemNumberV = PtpmItemNumberV::query();
            $itemNumberTable = $ptpmItemNumberV->getModel()->getTable();

            $ptpmItemNumberV = $ptpmItemNumberV
                ->whereIn("$itemNumberTable.tobacco_group_code", ['1001', '1002', '1007'])
                ->where('organization_id', '=', $organizationId)
                ->whereRaw("lower($itemNumberTable.item_number) like ?", [strtolower("%$query%")])
                ->take($maxResults);

            $itemNumbers = $this->retrieveLots($ptpmItemNumberV, $flavour);

            return response()->json([
                'item_numbers' => $itemNumbers,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    /** @noinspection DuplicatedCode */
    public function lookupCasings(Request $request): JsonResponse
    {
        try {
            /** @noinspection DuplicatedCode */
            $queryString = $request->all();
            $validator = Validator::make($queryString, [
                'maxResults' => 'numeric|integer',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $query = $queryString['query'] ?? '';
            $maxResults = $queryString['maxResults'] ?? 30;

            $casings = DB::table('OAPD.PTPD_SIMU_ADDITIVE_H as PSAH')
                ->where('SIMU_TYPE', '=', 'CASING')
                ->whereRaw("lower(SIMU_FORMULA_NO) LIKE lower('%$query%')")
                ->whereNotExists(function (OracleBuilder $query) {
                    $query->select(DB::raw("'Y'"))
                        ->fromRaw('OAPD.PTPD_SIMU_ADDITIVE_L PSAL, OAPD.PTPD_SIMU_RAW_MATERIALS PSRM')
                        ->whereRaw('PSAH.SIMU_FORMULA_ID = PSAL.SIMU_FORMULA_ID')
                        ->whereRaw('PSAL.RAW_MATERIAL_ID = PSRM.SIMU_RAW_ID');
                })
                ->take($maxResults)
                ->get()
                ->toArray();

            return response()->json([
                'casings' => $casings,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    /** @noinspection DuplicatedCode */
    public function lookupFlavours(Request $request): JsonResponse
    {
        try {
            /** @noinspection DuplicatedCode */
            $queryString = $request->all();
            $validator = Validator::make($queryString, [
                'maxResults' => 'numeric|integer',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $query = $queryString['query'] ?? '';
            $maxResults = $queryString['maxResults'] ?? 30;

            $flavours = DB::table('OAPD.PTPD_SIMU_ADDITIVE_H as PSAH')
                ->where('SIMU_TYPE', '=', 'FLAVOR')
                ->whereRaw("lower(SIMU_FORMULA_NO) LIKE lower('%$query%')")
                ->whereNotExists(function (OracleBuilder $query) {
                    $query->select(DB::raw("'Y'"))
                        ->fromRaw('OAPD.PTPD_SIMU_ADDITIVE_L PSAL, OAPD.PTPD_SIMU_RAW_MATERIALS PSRM')
                        ->whereRaw('PSAH.SIMU_FORMULA_ID = PSAL.SIMU_FORMULA_ID')
                        ->whereRaw('PSAL.RAW_MATERIAL_ID = PSRM.SIMU_RAW_ID');
                })
                ->take($maxResults);

            return response()->json([
                'flavours' => $flavours->get(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    /** @noinspection DuplicatedCode */
    public function lookupExampleCigarettes(Request $request): JsonResponse
    {
        try {
            $queryString = $request->all();
            $validator = Validator::make($queryString, [
                'maxResults' => 'numeric|integer',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->messages()->toArray(), 400);
            }

            $query = $queryString['query'] ?? '';
            $maxResults = $queryString['maxResults'] ?? 30;

            $casings = DB::table('OAPD.PTPD_EXAMPLE_CIGARETTE_V as PIMI')
                ->whereRaw("lower(ITEM_CODE) LIKE lower('%$query%')")
                ->whereNotExists(function (OracleBuilder $query) {
                    $query->select(DB::raw("'Y'"))
                        ->fromRaw('OAPD.PTPD_FORMULA_BLEND_L PFBL')
                        ->whereRaw('PFBL.TAB_ID = PIMI.INVENTORY_ITEM_ID');
                })
                ->take($maxResults);

            return response()->json([
                'example_cigarettes' => $casings->get(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e
            ], 500);
        }
    }
}
