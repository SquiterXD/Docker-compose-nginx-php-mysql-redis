<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\Settings\PolicyRequest; 
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirPolicySetLines;
use App\Models\IR\Settings\PtirPolicyTypeView;
use stdClass;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Support\Facades\DB;
class PolicyController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');

        $dataSearch                        = (object)[];
        $dataSearch->policy_set_header_id  = request()->policy_set_header_id;
        $dataSearch->active_flag           = request()->active_flag; 
        $dataSearch->url_search            = route('ir.settings.policy.index'); 

        $dataLists = PtirPolicySetHeaders::search($dataSearch)
                                    ->orderby('policy_set_number', 'asc')
                                    ->get();
        // dd($dataLists);

        return view('ir.settings.policy.index', compact('btnTrans', 'dataSearch', 'dataLists'));
    }

    public function create()
    {
        $btnTrans = trans('btn');

        $data = collect(\DB::select("
                        select MAX(to_number(policy_set_number)) as max
                        from ptir_policy_set_headers
                    "));

        $runningMax = isset($data) ? $data->first() : '';

        if ($runningMax) {
            $runningNo =$runningMax->max + 1;
        } else {
            $runningNo =  1;
        }

        return view('ir.settings.policy.create', compact('btnTrans', 'runningNo'));
    }

    public function edit()
    {
        $btnTrans = trans('btn');
        return view('ir.settings.policy.edit', compact('btnTrans'));
    }
}
