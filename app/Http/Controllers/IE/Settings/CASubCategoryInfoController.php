<?php

namespace App\Http\Controllers\IE\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\IE\CASubCategoryInfosStoreRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\IE\CACategory;
use App\Models\IE\CASubCategory;
use App\Models\IE\CASubCategoryInfo;

class CASubCategoryInfoController extends Controller
{
    protected $orgId;
    protected $perPage = 10;

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
    public function index(CACategory $ca_category, CASubCategory $ca_sub_category)
    {

        $ca_sub_category_infos = CASubCategoryInfo::where('ca_sub_category_id',$ca_sub_category->ca_sub_category_id)->active()->paginate($this->perPage);
        $listFormTypes = CASubCategoryInfo::getlistFormTypes();

        return view('ie.settings.ca-sub-categories.infos.index',
        	compact('ca_category',
        			'ca_sub_category',
        			'ca_sub_category_infos',
                    'listFormTypes'));
    }

    public function inputFormType(CACategory $ca_category, CASubCategory $ca_sub_category, $formType)
    {
        return view('ie.settings.ca-sub-categories.infos._input_form_value',
                            compact('formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  CASubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function store(CASubCategoryInfosStoreRequest $request, CACategory $ca_category, CASubCategory $ca_sub_category)
    {
        try {

            $ca_sub_category_info  = new CASubCategoryInfo();
            // $ca_sub_category_info->org_id = $this->orgId;
            $ca_sub_category_info->ca_category_id = $ca_category->ca_category_id;
            $ca_sub_category_info->ca_sub_category_id = $ca_sub_category->ca_sub_category_id;
            $ca_sub_category_info->attribute_name  = $request->attribute_name;
            $ca_sub_category_info->purpose = $request->purpose;
            $ca_sub_category_info->form_type   = $request->form_type;
            $ca_sub_category_info->form_value  = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $ca_sub_category_info->required = $request->required ? true : false ;
            $ca_sub_category_info->last_updated_by = -1;
            $ca_sub_category_info->created_by = -1;
            $ca_sub_category_info->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.ca-sub-categories.infos.index',[
                                    $ca_category->ca_category_id,
                                    $ca_sub_category->ca_sub_category_id
                                ])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.ca-sub-categories.infos.index',[
		        					$ca_category->ca_category_id,
		        					$ca_sub_category->ca_sub_category_id
		        				]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  CASubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(CACategory $ca_category, CASubCategory $ca_sub_category, $caSubCategoryInfoId)
    {
        $ca_sub_category_info = CASubCategoryInfo::find($caSubCategoryInfoId);
        $ca_sub_category_info->form_value = $ca_sub_category_info->form_value ? implode(', ', json_decode($ca_sub_category_info->form_value)) : '';
        $listFormTypes = CASubCategoryInfo::getlistFormTypes();
        $formType = $ca_sub_category_info->form_type;

        return view('ie.settings.ca-sub-categories.infos._modal_edit_form',
                        compact('ca_category',
                        		'ca_sub_category',
                        		'ca_sub_category_info',
                                'listFormTypes',
                                'formType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  CASubCategory $ca_sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(CASubCategoryInfosStoreRequest $request, CACategory $ca_category, CASubCategory $ca_sub_category, $caSubCategoryInfoId)
    {
        try {

            $ca_sub_category_info = CASubCategoryInfo::find($caSubCategoryInfoId);
            $ca_sub_category_info->attribute_name  = $request->attribute_name;
            $ca_sub_category_info->purpose = $request->purpose;
            $ca_sub_category_info->form_type   = $request->form_type;
            $ca_sub_category_info->form_value  = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $ca_sub_category_info->required = $request->required ? true : false ;
            $ca_sub_category_info->last_updated_by = -1;
            $ca_sub_category_info->save();

        } catch (\Exception $e) {
            return redirect()->route('ie.settings.ca-sub-categories.infos.index',[
                                    $ca_category->ca_category_id,
                                    $ca_sub_category->ca_sub_category_id
                                ])->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.ca-sub-categories.infos.index',[
        							$ca_category->ca_category_id,
        							$ca_sub_category->ca_sub_category_id
        						]);
    }

    public function inactive(Request $request,CACategory $ca_category, CASubCategory $ca_sub_category, $caSubCategoryInfoId)
    {
        try {
            $ca_sub_category_info = CASubCategoryInfo::find($caSubCategoryInfoId);
            $ca_sub_category_info->active = !$ca_sub_category_info->active;
            $ca_sub_category_info->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    private function composeFormValue($form_type,$form_value)
    {
        if(!$form_value){ return ; }

        if($form_type == 'select'){
            return json_encode(array_map('trim',explode(',',$form_value )));
        }else if($form_type == 'date'){
            $arr = array_map('trim',explode(',',$form_value ));
            $data = \DateTime::createFromFormat(trans('date.format'), $arr[0])->format('Y-m-d');
            return json_encode([$data]);
        }else{
            $arr = array_map('trim',explode(',',$form_value ));
            $data = $arr[0];
            return json_encode([$data]);
        }
    }
}
