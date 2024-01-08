<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\RaTermsVL;
use App\Repositories\OM\Settings\PaymentTermRepository;

class PaymentTermExportController extends Controller
{
    public function index()
    {
        // dd(urlencode("http://toat-web-service.test/om/settings/term-export"));

        if (!canEnter('/om/settings/term-export') || !canView('/om/settings/term-export')) {
            return redirect()->back()->withError(trans('403'));
        }
        // $type = request()->type;
        $terms = RaTermsVL::where('sales_type', 'EXPORT')->get();

        return view('om.settings.terms-export.index', compact('terms'));
    }

    public function create()
    {

        $term = new RaTermsVL;

        return view('om.settings.terms-export.create', compact('term'));
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


        $insetData = (new PaymentTermRepository)->insertData($request, 'EXPORT', 'INSERT', null);

        return redirect()->route('om.settings.term-export.index')->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($termName)
    {

        $term = RaTermsVL::where('term_name', $termName)->first();

        // dd(urlencode("http://toat-web-service.test/om/settings/term-export/{$term->name}/edit"));
        
        return view('om.settings.terms-export.edit', compact('term'));
    }

    public function update(Request $request, $termName)
    {
        $term = RaTermsVL::where('term_name', $termName)->first();

        $request->validate([
            'description'       => 'required',
            'start_date_active' => 'required',
        ]);


        $insetData = (new PaymentTermRepository)->insertData($request, 'EXPORT', 'UPDATE', $term);

        return redirect()->route('om.settings.term-export.index')->with('success','ทำการแก้ไขข้อมูลเรียบร้อยแล้ว');
    }
}
