<?php

namespace App\Http\Controllers\IE\Settings;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\IE\Currency;
use App\Models\IE\MileageUnit;
use App\Models\IE\Preference;
use App\Models\User;
use App\Models\IE\HrOperatingUnit;
use App\Models\IE\PurposeSetup;
// use App\Models\IE\Job;

class PreferenceController extends Controller
{
    protected $perPage = 10;
    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->orgId = getDefaultData()->bu_id;
            return $next($request);
        });
    }

    public function index()
    {
        $currency = Preference::getBaseCurrency();
        // $mileageUnit = Preference::getBaseMileageUnit();
    	// $mileageUnitLists = MileageUnit::active()->pluck('description','mileage_unit_id')->all();
        $pendingDayBlocking = Preference::getPendingDayBlocking();
        $pendingNumberBlocking = Preference::getPendingNumberBlocking();
        // $jobLists = Job::orderBy('approval_authority','desc')->pluck('job_name','job_id')->all();
        // $overBudgetApproverJob = Preference::getOverBudgetApproverJob();
        $unblockers = Preference::getUnblockers();
        $chageApprovers = Preference::getChangeApprovers();
        $accountantUsers = Preference::getAccountantUsers();
        $showAllUsers = Preference::getShowAllUsers();
        $users = User::all();
        $userLists = User::select(\DB::raw("user_id || ' : ' || name AS full_description"),'user_id')
                        ->orderBy('user_id')
                        ->pluck('full_description','user_id')
                        ->all();
        $ous = HrOperatingUnit::all();
        $mappingOU = Preference::getMappingOU();
        $purpose = PurposeSetup::getPurpose();
        
    	return view('ie.settings.preferences.index',
    					compact('currency',
                                // 'mileageUnit',
                                'users',
                                'userLists',
                                'unblockers',
                                'chageApprovers',
                                'accountantUsers',
    							// 'mileageUnitLists',
                                'pendingDayBlocking',
                                'pendingNumberBlocking',
                                'showAllUsers',
                                'mappingOU',
                                'ous',
                                'purpose',
                                // 'jobLists',
                                // 'overBudgetApproverJob'
                            ));
    }

    public function update(Request $request)
    {
        $code = $request->code;
        $dataValue = $request->data_value;
        $preference = Preference::whereCode($code)->first();
        $preference->data_value = encodeDataValue($preference->data_type,$dataValue);
        $preference->save();
    }

    public function sliceJson(Request $request)
    {
        $code = $request->code;
        $sliceDataValue = $request->data_value;
        $preference = Preference::whereCode($code)->first();
        $jsonData = decodeDataValue($preference->data_type, $preference->data_value);
        // SLICE DATA IN JSON ARRAY
        if(($key = array_search($sliceDataValue, $jsonData)) !== false) {
            unset($jsonData[$key]);
        }
        $jsonData = array_values($jsonData);
        $preference->data_value = encodeDataValue($preference->data_type,$jsonData);
        $preference->save();
    }

    public function updateMappingOU(Request $request)
    {
        $code = 'mapping_ou';
        $dataValue = $request->mapping_ou;
        $preference = Preference::whereCode($code)->first() ?? new Preference();
        $preference->code = $code;
        $preference->data_type = 'json';
        $preference->data_value = json_encode($dataValue);
        $preference->last_updated_by = auth()->user()->user_id;
        $preference->created_by = auth()->user()->user_id;
        $preference->save();
        
        return back()->with('success', 'Update mapping success !');
    }

    public function updatePurpose(Request $request)
    {
        $dataValue = collect($request->purpose)->filter()->unique();

        $purposes = collect($request->purpose);

        $seqs = collect($request->seq);

        PurposeSetup::whereNotNull('purpose_setup_id')->delete();

        foreach ($dataValue as $value) {
            $index = $purposes->search($value);
            // dd($purposes,$value, $index , $seqs[$index]);
            $purpose = new PurposeSetup();
            $purpose->purpose = $value;
            $purpose->seq = $seqs[$index];
            $purpose->last_updated_by = auth()->user()->user_id;
            $purpose->created_by = auth()->user()->user_id;
            $purpose->save();
        }

        return back()->with('success', 'Update purpose success!');
    }
}
