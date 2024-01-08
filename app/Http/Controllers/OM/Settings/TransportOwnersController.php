<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Settings\TransportOwner;
use App\Models\OM\Settings\PoVendorsV;
use Carbon\Carbon;

class TransportOwnersController extends Controller
{
    public function index()
    {
        $tranSportOwners = TransportOwner::orderBy('transport_owner_id')
                            ->get();

        return view('om.settings.transport-owners.index', compact('tranSportOwners'));
    }

    public function create()
    {

        $poVendors = PoVendorsV::get()->take(5);

        return view('om.settings.transport-owners.create', compact('poVendors'));
    }

    public function store(Request $request)
    {
        // dd(request()->all(), $request->transport_owner_code);
        request()->validate([
            'transport_owner_code'  => 'required',
            'transport_owner_name'  => 'required',
            'start_date'            => 'required',
            'vendor_id'             => 'required',
            'api_url'               => 'required',
            'api_token'             => 'required',
            'api_user'              => 'required',
        ], [
            'transport_owner_code.required'  => 'ระบุ เจ้าของรถขนส่ง',
            'transport_owner_name.required'  => 'ระบุ ชื่อเจ้าของรถขนส่ง',
            'start_date.required'            => 'เลือก วันที่เริ่มต้น',
            'vendor_id.required'             => 'เลือก รหัสเจ้าหนี้',
            'api_url.required'               => 'ระบุ api_url',
            'api_token.required'             => 'ระบุ api_token',
            'api_user.required'              => 'ระบุ api_user',
        ]);

        
        $user = auth()->user();
        $vendor = PoVendorsV::where('vendor_id', $request->vendor_id)->first();
        // dd(request()->all());
        // dd($vendor);
        // $tranSportOwnerID  =  TransportOwner::max('transport_owner_id') + 2;
        $stop = $request->stop_flag == true
                ? 'Y'
                : 'N';

        $startDate       = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate         = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        // \DB::beginTransaction();
        // try {
            $tranSportOwner = new TransportOwner;
            // $tranSportOwner->transport_owner_id = $tranSportOwnerID;
            $tranSportOwner->transport_owner_code   = $request->transport_owner_code;
            $tranSportOwner->transport_owner_name   = $request->transport_owner_name;
            $tranSportOwner->start_date             = $startDate;
            $tranSportOwner->end_date               = $endDate;
            $tranSportOwner->vendor_id              = $vendor->vendor_id;
            $tranSportOwner->vendor_code            = $vendor->vendor_code;
            $tranSportOwner->stop_flag              =  $stop;
            $tranSportOwner->program_code           = 'OMS0027';
            $tranSportOwner->created_by             = $user->user_id;
            $tranSportOwner->last_updated_by        = $user->user_id;
            $tranSportOwner->last_update_date       = now();
            $tranSportOwner->created_at             = now();
            $tranSportOwner->api_url                = $request->api_url;
            $tranSportOwner->api_token              = $request->api_token;
            $tranSportOwner->api_user               = $request->api_user;
            $tranSportOwner->save();

            return redirect()->route('om.settings.transport-owner.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        //     \DB::commit();
        // }catch (\Exception $e) {
        //     \DB::rollBack();
        //     \Log::error($e->getMessage());

        //     return response()->json(['message' => \Exception($e->getMessage())]);
        // }

        // return response()->json(['data' => ['tranSportOwner' => $tranSportOwner]]);
    }
    public function edit($id)
    {
        $tranSportOwner = TransportOwner::find($id);
        $poVendors = PoVendorsV::get()->take(5);
        return view('om.settings.transport-owners.edit', compact('tranSportOwner', 'poVendors'));
    }
    public function update($id)
    {
        // dd(request()->all());
        request()->validate([
            'transport_owner_code'  => 'required',
            'transport_owner_name'  => 'required',
            'start_date'            => 'required',
            'vendor_id'             => 'required',
            'api_url'               => 'required',
            'api_token'             => 'required',
            'api_user'              => 'required',
        ], [
            'transport_owner_code.required'  => 'ระบุ เจ้าของรถขนส่ง',
            'transport_owner_name.required'  => 'ระบุ ชื่อเจ้าของรถขนส่ง',
            'start_date.required'            => 'เลือก วันที่เริ่มต้น',
            'vendor_id.required'             => 'เลือก รหัสเจ้าหนี้',
            'api_url.required'               => 'ระบุ api_url',
            'api_token.required'             => 'ระบุ api_token',
            'api_user.required'              => 'ระบุ api_user',
        ]);

        // dd(Carbon::createFromFormat('d/m/Y', request()->start_date)->format('d-m-Y'));
        $user = auth()->user();

        $vendor = PoVendorsV::where('vendor_id', request()->vendor_id)->first();
        // dd(request()->all(), $vendor);
        // $tranSportOwnerID  =  TransportOwner::max('transport_owner_id') + 2;
        $stop = request()->stop_flag == true
                ? 'Y'
                : 'N';

        $startDate       = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate         = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        // dd('zz');

        // \DB::beginTransaction();
        //     try {
                $tranSportOwner =  TransportOwner::find($id);
                $tranSportOwner->transport_owner_code   = request()->transport_owner_code;
                $tranSportOwner->transport_owner_name   = request()->transport_owner_name;
                $tranSportOwner->start_date             = $startDate;
                $tranSportOwner->end_date               = $endDate;
                $tranSportOwner->vendor_id              = $vendor->vendor_id;
                $tranSportOwner->vendor_code            = $vendor->vendor_code;
                $tranSportOwner->stop_flag              = $stop;
                $tranSportOwner->last_updated_by        = $user->user_id;
                $tranSportOwner->last_update_date       = now();
                $tranSportOwner->api_url                = request()->api_url;
                $tranSportOwner->api_token              = request()->api_token;
                $tranSportOwner->api_user               = request()->api_user;
                $tranSportOwner->save();

                return redirect()->route('om.settings.transport-owner.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');

            //     \DB::commit();
            // }catch (\Exception $e) {
            //     \DB::rollBack();
            //     \Log::error($e->getMessage());

            // }
            // return response()->json(['data' => ['tranSportOwner' => $tranSportOwner]]);
    }

    public function destroy($id)
    {

        \DB::beginTransaction();
        try {
            $tranSportOwner =  TransportOwner::find($id)->delete();
            \DB::commit();
        }catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());

            return response()->json(['message' => \Exception($e->getMessage())]);
        }
    }
}
