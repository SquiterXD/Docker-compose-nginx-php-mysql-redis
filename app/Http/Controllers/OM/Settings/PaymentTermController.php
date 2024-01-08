<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\RaTermsVL;

use App\Repositories\OM\Settings\PaymentTermRepository;

class PaymentTermController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/term') || !canView('/om/settings/term')) {
            return redirect()->back()->withError(trans('403'));
        }
        // $type = request()->type;
        $terms = RaTermsVL::where('sales_type', 'DOMESTIC')->get();

        return view('om.settings.terms-domestic.index', compact('terms'));
    }

    public function create()
    {
        // $type = request()->type;

        $term = new RaTermsVL;

        return view('om.settings.terms-domestic.create', compact('term'));
    }

    public function store(Request $request)
    {
        // $type = request()->type;
        $termData = RaTermsVL::where('term_name', $request->name)->first();

        if ($termData) {
            return redirect()->back()->with('error', 'มีข้อมูลอยู่แล้ว');
        }

        $request->validate([
            'name'              => 'required',
            'description'       => 'required',
            'start_date_active' => 'required',
        ]);


        $insetData = (new PaymentTermRepository)->insertData($request, 'DOMESTIC', 'INSERT', null);

        return redirect()->route('om.settings.term.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($termName)
    {
        $term = RaTermsVL::where('term_name', $termName)->first();
        // $type = request()->type;

        
        return view('om.settings.terms-domestic.edit', compact('term'));
    }

    public function update(Request $request, $termName)
    {
        $term = RaTermsVL::where('term_name', $termName)->first();

        $request->validate([
            'description' => 'required',
            'start_date_active' => 'required',
        ]);


        $insetData = (new PaymentTermRepository)->insertData($request, 'DOMESTIC', 'UPDATE', $term);

        return redirect()->route('om.settings.term.index')->with('success','ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
