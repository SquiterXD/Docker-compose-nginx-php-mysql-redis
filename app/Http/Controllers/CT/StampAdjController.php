<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\StampAdj;

use App\Models\CT\PtglCoaCompanyV;
use App\Models\CT\PtglCoaEvmV;
use App\Models\CT\PtglCoaDeptCodeV;
use App\Models\CT\PtglCoaCostCenterV;
use App\Models\CT\PtglCoaBudgetYearV;
use App\Models\CT\PtglCoaBudgetTypeV;
use App\Models\CT\PtglCoaBudgetDetailV;
use App\Models\CT\PtglCoaBudgetReasonV;
use App\Models\CT\PtglCoaMainAccountV;
use App\Models\CT\PtglCoaSubAccountV;
use App\Models\CT\PtglCoaReserved1V;
use App\Models\CT\PtglCoaReserved2V;

use App\Models\CT\ProductTypeDomestic;
use App\Models\CT\StampAdjustGLINT;
use App\Models\CT\StampAdjustTemp;
use App\Models\CT\PtPeriodsV;
use App\Models\CT\PtYearsV;

class StampAdjController extends Controller
{
    public function index()
    {
        $stampAdjs = StampAdj::with('productType')->get();

        return view('ct.stamp_adj.index', [
            'stampAdjs' => $stampAdjs,
        ]);
    }

    public function create()
    {
        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1  =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2  =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3  =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4  =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9  =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 =  getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        $segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];

        foreach ($segment_arr as $item) {
            $segment_text        = 'segment'.$item;
            $data[$segment_text] = $this->getDataSegment($defaultValueSetName->$segment_text, null);
        }

        $stampTypes  = ProductTypeDomestic::where('enabled_flag', 'Y')->orderBy('lookup_code')->get();

        return view('ct.stamp_adj.create', [
            'defaultValueSetName' => $defaultValueSetName,
            'segmentData'         => $data,
            'stampTypes'          => $stampTypes
        ]);
    }

    public function getDataSegment($setName, $setParent)
    {
        if ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE') {
            $data = PtglCoaCompanyV::selectRaw('company_code as code, meaning, description, flex_value_set_name')
                                    ->where('flex_value_set_name', $setName)
                                    ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-EVM') {
            $data = PtglCoaEvmV::selectRaw('evm_code as code, meaning, description, flex_value_set_name')
                                ->where('flex_value_set_name', $setName)
                                ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE') {
            $data = PtglCoaDeptCodeV::selectRaw('department_code as code, meaning, description, flex_value_set_name')
                                    ->where('flex_value_set_name', $setName)
                                    ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR') {
            $data = PtglCoaBudgetYearV::selectRaw('budget_year as code, meaning, description, flex_value_set_name')
                                        ->where('flex_value_set_name', $setName)
                                        ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE') {
            $data = PtglCoaBudgetTypeV::selectRaw('budget_type as code, meaning, description, flex_value_set_name')
                                        ->where('flex_value_set_name', $setName)
                                        ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON') {
            $data = PtglCoaBudgetReasonV::selectRaw('budget_reason as code, meaning, description, flex_value_set_name')
                                        ->where('flex_value_set_name', $setName)
                                        ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT') {
            $data = PtglCoaMainAccountV::selectRaw('main_account as code, meaning, description, flex_value_set_name')
                                    ->where('flex_value_set_name', $setName)
                                    ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1') {
            $data = PtglCoaReserved1V::selectRaw('reserved1 as code, meaning, description, flex_value_set_name')
                                    ->where('flex_value_set_name', $setName)
                                    ->get();
            return $data;
        } elseif ($setName == getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2') {
            $data = PtglCoaReserved2V::selectRaw('reserved2 as code, meaning, description, flex_value_set_name')
                                    ->where('flex_value_set_name', $setName)
                                    ->get();
            return $data;
        }
    }

    public function edit($id)
    {
        $defaultValue = StampAdj::find($id);

        $defaultValueSetName = (object)[];
        $defaultValueSetName->segment1  =  getPrefixValueSetName().'_GL_ACCT_CODE-COMPANY_CODE';
        $defaultValueSetName->segment2  =  getPrefixValueSetName().'_GL_ACCT_CODE-EVM';
        $defaultValueSetName->segment3  =  getPrefixValueSetName().'_GL_ACCT_CODE-DEPT_CODE';
        $defaultValueSetName->segment4  =  getPrefixValueSetName().'_GL_ACCT_CODE-COST_CENTER';
        $defaultValueSetName->segment5  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_YEAR';
        $defaultValueSetName->segment6  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_TYPE';
        $defaultValueSetName->segment7  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_DETAIL';
        $defaultValueSetName->segment8  =  getPrefixValueSetName().'_GL_ACCT_CODE-BUDGET_REASON';
        $defaultValueSetName->segment9  =  getPrefixValueSetName().'_GL_ACCT_CODE-MAIN_ACCOUNT';
        $defaultValueSetName->segment10 =  getPrefixValueSetName().'_GL_ACCT_CODE-SUB_ACCOUNT';
        $defaultValueSetName->segment11 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED1';
        $defaultValueSetName->segment12 =  getPrefixValueSetName().'_GL_ACCT_CODE-RESERVED2';

        $segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $data = [];

        foreach ($segment_arr as $item) {
            $segment_text        = 'segment'.$item;
            $data[$segment_text] = $this->getDataSegment($defaultValueSetName->$segment_text, null);
        }

        $stampTypes  = ProductTypeDomestic::where('enabled_flag', 'Y')->orderBy('lookup_code')->get();

        return view('ct.stamp_adj.edit', [
            'defaultValueSetName' => $defaultValueSetName,
            'segmentData'         => $data,
            'stampTypes'          => $stampTypes,
            'defaultValue'        => $defaultValue,
        ]);
    }

    // Process Piyawut --20221027
    public function process(Request $request)
    {
        $profile = getDefaultData('/ct/stamp-adjust/process');
        $searchInputs = $request->all();
        $btnTrans = trans('btn');
        $periodYears = PtYearsV::getListPeriodYears()->orderBy('period_year', 'desc')->get()->toArray();
        $interfaceGLFlag = false;
        $stamps = [];
        $manualTemps = [];
        // บุหรี่
        $setupStamps     = [];
        $stampCigarets   = [];
        $percentCigarets = [];
        // ยาเส้น
        $setupTobaccos   = [];
        $stampTobaccos   = [];
        $percentTobaccos = [];

        $url = (object)[];
        $url->search = route('ct.stamp-adjust.process');

        if ($searchInputs) {
            $url->update_stamp_adjust = route('ct.ajax.stamp-adjust.updateProcess', $searchInputs['period_name']);
            $url->ajax_interface_gl = route('ct.ajax.stamp-adjust.interface_gl');
            $url->ajax_cancel_interface_gl = route('ct.ajax.stamp-adjust.cancel_interface_gl');
            // New Function
            $url->ajax_manaul_stamp = route('ct.ajax.stamp-adjust.manaul_stamp');
            // บุหรี่
            $setupStamps = StampAdjustGLINT::selectRaw('distinct stamp_adj_id, fund_location, percent')
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 10)
                                            ->orderBy('stamp_adj_id')
                                            ->get();
            $stampCigarets = StampAdjustGLINT::selectRaw('distinct item_code, item_description, product_type, order_quantity_carton, stamp_quantity, stamp_amount, unit_price, interface_status')
                                            ->where('stamp_adj_id', -1)
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 10)
                                            ->orderBy('item_code')
                                            ->get();
            $dataCigarets = StampAdjustGLINT::selectRaw('distinct item_code, stamp_adj_id, sum(stamp_amount) stamp_amount')
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 10)
                                            ->orderBy('item_code')
                                            ->groupBy('item_code', 'stamp_adj_id')
                                            ->get();
            $percentCigarets = $dataCigarets->groupBy('stamp_adj_id')->mapWithKeys(function ($item, $group) {
                $groupName = $item->first()->stamp_adj_id;
                return [$groupName => $item->pluck('stamp_amount', 'item_code')->all()];
            })->toArray();

            // ยาเส้น
            $setupTobaccos = StampAdjustGLINT::selectRaw('distinct stamp_adj_id, fund_location, percent')
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 20)
                                            ->orderBy('stamp_adj_id')
                                            ->get();
            $stampTobaccos = StampAdjustGLINT::selectRaw("distinct item_code, item_description, item_code||'|'||item_description item, product_type, order_quantity_carton, stamp_quantity, stamp_amount, unit_price, interface_status")
                                            ->where('stamp_adj_id', -1)
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 20)
                                            ->orderByRaw('item_code asc, item_description asc')
                                            ->get();
            $dataTobaccos = StampAdjustGLINT::selectRaw("distinct item_code, item_description, item_code||'|'||item_description item,  stamp_adj_id, sum(stamp_amount) stamp_amount")
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->where('product_type', 20)
                                            ->orderByRaw('item_code, item_description')
                                            ->groupBy('item_code', 'stamp_adj_id', 'item_description')
                                            ->get();
            $percentTobaccos = $dataTobaccos->groupBy('stamp_adj_id')->mapWithKeys(function ($item, $group) {
                $groupName = $item->first()->stamp_adj_id;
                return [$groupName => $item->pluck('stamp_amount', 'item')->all()];
            })->toArray();

            // chack interface data gl
            if (count($stampCigarets) > 0) {
                $interfaceGLFlag = $stampCigarets->first()->interface_status == 'C' ? true: false;
            }
            // get manual stamp
            $manualTemps = StampAdjustTemp::where('period_name', $searchInputs['period_name'])
                                        ->orderBy('line_number')
                                        ->get();
            // cigaret/tobacco list
            $itemInTemps = $manualTemps->pluck('item_description')->toArray();
            $stamps = StampAdjustGLINT::selectRaw('distinct item_code, item_description, product_type')
                                            ->where('period_name', $searchInputs['period_name'])
                                            ->whereNotIn('item_description', $itemInTemps)
                                            ->orderBy('item_code')
                                            ->get();
        }

        return view('ct.stamp_adj.transaction.show'
                    , compact('searchInputs', 'setupStamps', 'setupTobaccos'
                        , 'stampCigarets', 'percentCigarets'
                        , 'stampTobaccos', 'percentTobaccos'
                        , 'periodYears', 'url', 'btnTrans', 'interfaceGLFlag'
                        , 'stamps', 'manualTemps'
                    )
                );
    }
}
