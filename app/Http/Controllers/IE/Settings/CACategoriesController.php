<?php

namespace App\Http\Controllers\IE\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\IE\CACategoriesStoreRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\IE\CACategory;
use App\Models\IE\Icon;

class CACategoriesController extends Controller
{
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ca_categories = CACategory::active()->get();
        return view('ie.settings.ca-categories.index', compact('ca_categories'));
    }

    public function create()
    {
        $iconLists = Icon::data()->sortBy('name')->pluck('name','code')->all();

        return view('ie.settings.ca-categories.create', 
            compact('iconLists'));
    }

    public function store(CACategoriesStoreRequest $request)
    {
        $ca_category = new CACategory();
        $ca_category->icon = $request->icon ? $request->icon : null;
        $ca_category->name = $request->name;
        // $ca_category->org_id = $this->orgId;
        $ca_category->description = $request->description;
        $ca_category->last_updated_by = -1;
        $ca_category->created_by = -1;
        $ca_category->save();

        return redirect()->route('ie.settings.ca-categories.index');
    } 


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CACategory $ca_category)
    {
        $iconLists = Icon::data()->sortBy('name')->pluck('name','code')->all();

        return view('ie.settings.ca-categories.edit', 
            compact('ca_category','iconLists'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CACategoriesStoreRequest $request, CACategory $ca_category)
    {
    	$ca_category->name = $request->name;
        $ca_category->icon = $request->icon ? $request->icon : null;
        $ca_category->description = $request->description;
        $ca_category->last_updated_by = -1;
        $ca_category->save();

        return redirect()->route('ie.settings.ca-categories.index');
    }

    public function remove(Request $request, CACategory $ca_category)
    {
        \DB::beginTransaction();
        try {
            // REMOVE CATEGORY
            $ca_category->active = false;
            $ca_category->save();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }
        \DB::commit();

        if($request->ajax()){
            return \Response::json("success", 200);
        }else{
            return redirect()->route('ie.settings.ca-categories.index');
        }
    }
}
