<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\Country;
use App\Models\OM\Settings\ContinentV;
use App\Models\OM\Settings\CountryV;

class CountryController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/country') || !canView('/om/settings/country')) {
            return redirect()->back()->withError(trans('403'));
        }

        $countries = Country::all();

        return view('om.settings.country.index', compact('countries'));
    }

    public function create()
    {
        $continents = ContinentV::all();
        $allCountries = CountryV::all();
        
        $country = new Country;

        return view('om.settings.country.create', compact('country', 'continents', 'allCountries'));
    }
    
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'continent_name' => 'required',
            'country_code' => 'required',
            'status' => 'required',
        ], [
            'continent_name.required' => 'กรุณาเลือก ทวีป',
            'country_code.required'   => 'กรุณาเลือก ประเทศ',
            'status.required'         => 'กรุณาเลือก Status'
        ]);
        
        $allCountry = CountryV::where('country_code', request()->country_code)->first();
                  
        $country = new Country;
        $country->continent_name  = $request->continent_name;
        $country->country_name    = $allCountry->country_name;
        $country->country_code    = $allCountry->country_code;
        $country->status          = $request->status;
        $country->program_code    = 'OMS0011';
        $country->created_by      = $user->user_id;
        $country->last_updated_by = $user->user_id;
        $country->save();

        return redirect()->route('om.settings.country.index')->with('success', 'ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $country = Country::find($id);

        $continents = ContinentV::all();
        $allCountries = CountryV::all();
        
        return view('om.settings.country.edit', compact('country', 'continents', 'allCountries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'continent_name' => 'required',
            'country_code'   => 'required',
            'status'         => 'required',
        ], [
            'continent_name.required' => 'กรุณาเลือก ทวีป',
            'country_code.required'   => 'กรุณาเลือก ประเทศ',
            'status.required'         => 'กรุณาเลือก Status'
        ]);
        // dd('xxx');

        $user = auth()->user();
        $allCountry = CountryV::where('country_code', request()->country_code)->first();

        $country = Country::find($id);
        $country->continent_name  = $request->continent_name;
        $country->country_name    = $allCountry->country_name;
        $country->country_code    = $allCountry->country_code;
        $country->status          = $request->status;
        $country->last_updated_by = $user->user_id;
        $country->save();

        return redirect()->route('om.settings.country.index')->with('success', 'ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
