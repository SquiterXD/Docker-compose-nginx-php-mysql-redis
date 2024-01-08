<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\CustomerApproval;
use App\Models\OM\Settings\CustomerTypeExport;
use App\Models\OM\Settings\AuthoRityList;
use App\Models\OM\Settings\UserV;

class CustomerApprovalController extends Controller
{
    public function index()
    {
        // dd('index');
        $customers = CustomerApproval::orderBy('customer_approval_id', 'asc')->paginate(25);

        return view('om.settings.customer.index', compact('customers'));
    }

    public function create()
    {
        // dd('create');
        $types      = CustomerTypeExport::all();
        $authoRityLists = AuthoRityList::when('start_date' != '', function ($q) {
                            return $q->where('start_date', '<=', date("Y-m-d"));
                        })
                        ->when('end_date' != '', function ($q) {
                            return $q->where('end_date', '>=', date("Y-m-d"));
                        })
                        ->orWhere('start_date', null)
                        ->orWhere('end_date', null)
                        ->orderBy('employee_name', 'asc')
                        ->get();

        // dd($authoRityLists);

        return view('om.settings.customer.create', compact('types', 'authoRityLists'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        $user = auth()->user();

        $this->validate(request(), [
            'customer_type' => 'required',
            'authority_id'  => 'required',
            'status'        => 'required',
            'email'         => 'required',
        ], [
            'customer_type.required' => 'โปรดเลือก ประเภทลูกค้า',
            'authority_id.required'  => 'โปรดเลือก ผู้มีอำนาจอนุมัติ',
            'status.required'        => 'โปรดเลือก status',
            'email.required'         => 'โปรดระบุ Email', 
        ]);

        if (request()->primary_approval) {
            $old = CustomerApproval::where('customer_type', request()->customer_type)->where('primary_approval', 'Y')->first();

            if ($old) {
                return redirect()->back()->with('error','ประเภทลูกค้าที่เลือก ได้มีการกำหนด Primary Approval เรียบร้อยแล้ว');
            }
        }
        $authoRity  = AuthoRityList::find(request()->authority_id);
        // $userOM       = UserV::find($authoRity->employee_id);

        // dd('store', request()->all(), $authoRity, $user);

        $type = CustomerTypeExport::where('meaning', request()->customer_type)->first();
        // dd('store', request()->all(), $authoRity, $type);
        $customer = new CustomerApproval;
        $customer->customer_type_code = $type->customer_type;
        $customer->customer_type      = request()->customer_type;
        $customer->employee_id        = '-1';
        $customer->employee_name      = $authoRity->employee_name;
        $customer->position_name      = $authoRity->position_name;
        $customer->status             = request()->status;
        $customer->email              = request()->email;
        $customer->program_code       = 'OMS0016';
        $customer->created_by         = $user->user_id;
        $customer->last_updated_by    = $user->user_id;
        $customer->primary_approval   = request()->primary_approval ? 'Y' : 'N';
        $customer->authority_id       = request()->authority_id;
        $customer->employee_number    =$authoRity->employee_number;
        $customer->save();

        return redirect()->route('om.settings.customer.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        // dd('edit', $id);     
        $customer = CustomerApproval::find($id);
        // dd('edit', $id, $customer); 
        $types      = CustomerTypeExport::all();

        $authoRityLists = AuthoRityList::when('start_date' != '', function ($q) {
                                return $q->where('start_date', '<=', date("Y-m-d"));
                            })
                            ->when('end_date' != '', function ($q) {
                                return $q->where('end_date', '>=', date("Y-m-d"));
                            })
                            ->orWhere('start_date', null)
                            ->orWhere('end_date', null)
                            ->orderBy('employee_name', 'asc')
                            ->get();

        return view('om.settings.customer.edit', compact('customer', 'types', 'authoRityLists'));
    }

    public function update(Request $request, $id)
    {
        // dd('update', request()->all());

        $user = auth()->user();

        $this->validate(request(), [
            'customer_type' => 'required',
            'authority_id'  => 'required',
            'status'        => 'required',
            'email'         => 'required',
        ], [
            'customer_type.required' => 'โปรดเลือก ประเภทลูกค้า',
            'authority_id.required'  => 'โปรดเลือก ผู้มีอำนาจอนุมัติ',
            'status.required'        => 'โปรดเลือก status',
            'email.required'         => 'โปรดระบุ Email', 
        ]);

        if (request()->primary_approval) {
            $old = CustomerApproval::where('customer_approval_id', '!=', $id)->where('customer_type', request()->customer_type)->where('primary_approval', 'Y')->first();

            if ($old) {
                return redirect()->back()->with('error','ประเภทลูกค้าที่เลือก ได้มีการกำหนด Primary Approval เรียบร้อยแล้ว');
            }
        }

        $authoRity  = AuthoRityList::find(request()->authority_id);
        // $userOM     = UserV::find($authoRity->employee_id);
        $type       = CustomerTypeExport::where('meaning', request()->customer_type)->first();


        $customer = CustomerApproval::find($id);
        $customer->customer_type_code = $type->customer_type;
        $customer->customer_type      = request()->customer_type;
        $customer->employee_id        = '-1';
        $customer->employee_name      = $authoRity->employee_name;
        $customer->position_name      = $authoRity->position_name;
        $customer->status             = request()->status;
        $customer->email              = request()->email;
        $customer->last_updated_by    = $user->user_id;
        $customer->primary_approval   = request()->primary_approval ? 'Y' : 'N';
        $customer->authority_id       = request()->authority_id;
        $customer->employee_number    =$authoRity->employee_number;
        $customer->save();

        return redirect()->route('om.settings.customer.index')->with('success','ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
    public function primaryApproval()
    {
        // dd(request()->all(), '111', request()->customer_type);
        $customer = CustomerApproval::where('customer_type', request()->customer_type)->where('primary_approval', 'Y')->first();
        // dd($customer);
        return $customer;
    }
}
