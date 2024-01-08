<?php

namespace App\Http\Controllers\PD\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Lookup\SimulationType;
use App\Models\PD\Settings\SimuRawMaterials;
use App\Models\Lookup\PtinvUomV;

use App\Models\PD\PtpdSimuAdditiveL;

class SimuRawMaterialController extends Controller
{
    public function index()
    {
        if (request()->action === 'search_get_param') {
            return $this->getParam(request());
        }

        $simuType    = request()->get('simu_type', false);
        $simuRawNum  = request()->get('simu_raw_num', false);

        $searchData = [
            'simu_type'     => $simuType,
            'simu_raw_num'  => $simuRawNum,
            'search_url'    => route('pd.settings.simu-raw-material.index')
        ];

        // dd($searchData, request()->all());


        $simuType        = request()->simu_type;
        $simulationTypes = SimulationType::whereIn('lookup_code', ['CASING', 'FLAVOR'])->get();
        $simuRaws        = SimuRawMaterials::search($simuType, $simuRawNum)->orderBy('simu_raw_id', 'asc')
                            ->paginate(25);

        return view('pd.settings.simu-raw-material.index', compact('simuRaws', 'simulationTypes', 'simuType', 'searchData'));
    }

    public function create()
    {
        $simulationTypes = SimulationType::whereIn('lookup_code', ['CASING', 'FLAVOR'])->get();
        $uoms            = PtinvUomV::orderBy('description', 'asc')->get();

        $simuRaw         = new SimuRawMaterials;

        return view('pd.settings.simu-raw-material.create', compact('simulationTypes', 'uoms', 'simuRaw'));
    }

    public function store(Request $request)
    {
        $test = $request->active_flag ? 'Y' : 'N';
        // dd(request()->all(), $test);
        $data = $request->validate([
            'simu_raw_num'   => 'required',
            'description'    => 'required',
            'simu_type'      => 'required',
            'price_per_unit' => 'required',
            'simu_uom'       => 'required'
        ],[
            'simu_raw_num.required'     => 'รหัสวัตถุดิบ',
            'description.required'      => 'รายละเอียด',
            'simu_type.required'        => 'ประเภทวัตถุดิบจำลอง',
            'price_per_unit.required'   => 'ราคาต่อหน่วย',
            'simu_uom.required'         => 'หน่วย'
        ]);

        $simu_raw_num = strtoupper(request()->simu_raw_num);
        $checkDup     = SimuRawMaterials::whereRaw("UPPER(simu_raw_num) like '{$simu_raw_num}'")->first();

        if ($checkDup) {
           return redirect()->back()->withInput()->with('error', 'ทำการเพิ่ม/แก้ไขข้อมูล รหัสวัตถุดิบ ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ');
        }

        $user = auth()->user();
        $data['price_per_unit']   = $request->price_per_unit;
        $data['active_flag']      = $request->active_flag ? 'Y' : 'N';
        // $data['start_date']       = $request->start_date ? date('Y-M-d', strtotime($request->start_date)) : '';
        // $data['end_date']         = $request->end_date   ? date('Y-M-d', strtotime($request->end_date))   : '';
        $data['remark']           = $request->remark;
        $data['status']           = '10';
        $data['created_by']       = $user->user_id;
        $data['last_updated_by']  = $user->user_id;

        // dd(request()->all(), $data);  
        SimuRawMaterials::create($data);

        return redirect()->route('pd.settings.simu-raw-material.index')->with('success','เพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($Id)
    {
        $simulationTypes  = SimulationType::whereIn('lookup_code', ['CASING', 'FLAVOR'])->get();
        $uoms             = PtinvUomV::orderBy('description', 'asc')->get();
        $simuRaw          = SimuRawMaterials::find($Id);
        $transection      = PtpdSimuAdditiveL::where('raw_material_id', $simuRaw->simu_raw_id)->first();
        $checkTransection = $transection ? true : false;

        return view('pd.settings.simu-raw-material.edit', compact('simulationTypes', 'uoms', 'simuRaw', 'checkTransection'));
    }

    public function update(Request $request, $Id)
    {
        // dd('update', request()->all());
        $data = $request->validate([
            'description'    => 'required',
            'simu_type'      => 'required',
            'price_per_unit' => 'required',
            'simu_uom'       => 'required'
        ],[
            'description.required'    => 'รายละเอียด',
            'simu_type.required'      => 'ประเภทวัตถุดิบจำลอง',
            'price_per_unit.required' => 'ราคาต่อหน่วย',
            'simu_uom.required'       => 'หน่วย'
        ]);

        $simu_raw_num = strtoupper(request()->simu_raw_num);
        $checkDup     = SimuRawMaterials::whereRaw("simu_raw_id != '{$Id}'")
                                        ->whereRaw("UPPER(simu_raw_num) like '{$simu_raw_num}'")
                                        ->first();

        if ($checkDup) {
           return redirect()->back()->withInput()->with('error', 'ทำการเพิ่ม/แก้ไขข้อมูล รหัสวัตถุดิบ ไม่สำเร็จเนื่องจากข้อมูลซ้ำกับในระบบ');
        }

        $user = auth()->user();
        // $data['price_per_unit']   = $request->price_per_unit;
        // $data['from_date']        = $request->from_date ? date('Y-M-d', strtotime($request->from_date)) : '';
        // $data['to_date']          = $request->to_date   ? date('Y-M-d', strtotime($request->to_date))   : '';
        // $data['remark']           = $request->remark;
        // $data['status']           = '10';
        // $data['created_by']       = $user->user_id;
        // $data['last_updated_by']  = $user->user_id;

        $simuRaw = SimuRawMaterials::find($Id);
        $simuRaw->description     = $request->description;
        $simuRaw->simu_type       = $request->simu_type;
        $simuRaw->price_per_unit  = $request->price_per_unit;
        $simuRaw->simu_uom        = $request->simu_uom;
        $simuRaw->active_flag     = $request->active_flag ? 'Y' : 'N';
        // $simuRaw->start_date      = $request->start_date ? date('Y-M-d', strtotime($request->start_date)) : '';
        // $simuRaw->end_date        = $request->end_date   ? date('Y-M-d', strtotime($request->end_date))   : '';
        $simuRaw->remark          = $request->remark;
        $simuRaw->status          = '10';
        $simuRaw->last_updated_by = $user->user_id;
        $simuRaw->save();

        // dd(request()->all(), $data);  
        // SimuRawMaterials::update($data);
        // SimuRawMaterials::where('simu_raw_id', $Id)->update($data);

        return redirect()->route('pd.settings.simu-raw-material.index')->with('success','แก้ไขในระบบเรียบร้อยแล้ว');
    }
    
    public function createInv($Id)
    {
        $simuRaw = SimuRawMaterials::find($Id);
        $inv = (new SimuRawMaterials)->createInv($simuRaw->simu_raw_id);

        return redirect()->back();
    }

    public function getParam(Request $request)
    {
        $simuTypeList    = [];
        $simuRawNumList  = [];

        $data        = SimuRawMaterials::whereNotnull('simu_raw_id');

        $simuType    = request()->get('simu_type', false);
        $simuRawNum  = request()->get('simu_raw_num', false);

        if ($simuType || $simuRawNum) {
            $data = $data->when($simuType, function($q) use ($simuType) {
                $q->where('simu_type', $simuType);
            })->when($simuRawNum, function($q) use ($simuRawNum) {
                $q->where('simu_raw_num', $simuRawNum);
            });
        }

        $simuTypeData   = clone $data;
        $simuRawNumData = clone $data;
        $data           = $data->count();

        if ($data) {
            $simuTypeData    = $simuTypeData->selectRaw("distinct simu_type as value")->get();
            $simuRawNumData  = $simuRawNumData->selectRaw("distinct simu_raw_num as value")->get();

            if (count($simuTypeData)) {

                $query = (new SimuRawMaterials)->simulationType()->getRelated()->selectRaw("
                        distinct lookup_code value,
                        description as label
                    ")
                    ->orderBy("label")
                    ->whereIn('lookup_code', $simuTypeData->pluck('value'))
                    ->get();

                $simuTypeList = array_merge($simuTypeList, $query->toArray());
            }
            if (count($simuRawNumData)) {
                $simuRawNumList = array_merge($simuRawNumList, $simuRawNumData->toArray());
            }

        }

        $data = [
            'simu_type_list'    => $simuTypeList,
            'simu_raw_num_list' => $simuRawNumList,
        ];

        return $data;
    }
}
