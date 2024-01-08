<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0027ApiController;
use \App\Models\Lookup\PtglCoaDeptCodeVLookup;
use App\Models\PM\PtpmDepartmentFromGl;
use Illuminate\Http\Request;

class PM0027Controller extends BaseController
{

    /**
     * @var PM0027ApiController
     */
    private $api;

    /**
     * RequestMaterialController constructor.
     * @param PM0027ApiController $api
     */
    public function __construct(PM0027ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        if (request()->action == 'get-dept') {
            $label = request()->label ?? '';
            $data = PtglCoaDeptCodeVLookup::selectRaw("
                        distinct
                        department_code as value,
                        department_code || ' : '  || description label
                    ")
                    ->when($label != '', function($q) use($label) {
                        $q->whereRaw("LOWER(department_code || ' : '  || description) like LOWER('%{$label}%')");
                    })
                    ->orderBy('label')
                    ->limit(50)
                    ->get();

            // dd('xx', $data, request()->all());
            return response()->json($data);
        }
        return redirect()->route('pm.sample-cigarettes.show', ['p_date' => date('Y-m-d')]);
    }

    public function show(Request $request, string $date = null)
    {
        $header = request()->header();
        if($date === "now") {
           $date = now()->format('Y-m-d');
        }
        $date = date('Y-m-d', strtotime($date));
        $sampleproducts = $this->api->show($request, $date)->getData();
        $department = PtpmDepartmentFromGl::get();
        $listSelectSampleProducts = collect($sampleproducts->productmes);
        $sampleproducts->listSelectSampleProducts = $listSelectSampleProducts->unique('segment1');
        $sampleproducts->department = $department;
        unset($listSelectSampleProducts, $department);
        $department = $this->api->getDepartment()->getData();
        $user = auth()->user();
        
        if($request->api == 'callback') {
            return response()->json([
                'init_lines' => $sampleproducts,
                'user' => $user,
                'p_date' => $date,
                'department' => $department
            ]);
        }

        return $this->vue('pm0027', [
            'init_lines' => $sampleproducts,
            'user' => $user,
            'p_date' => $date,
            'department' => $department
        ]);
    }
}
