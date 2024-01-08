<?php

namespace App\Http\Controllers\IR\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use App\Models\IR\Settings\PtirReportInfos;
// dd('xxx', request()->all());
class ReportInfoController extends Controller
{

    protected $perPage = 10;
    public function index()
    {

        $programs = ProgramInfo::selectFieldTypeReport()
                            ->typeReport()
                            // ->ofModule('IR')
                            ->orderBy('program_code')
                            ->paginate($this->perPage);
        $url    =  (object)[];
        $url->getInfos   = route('report.ajax.report-get-info');

        // dd($url);
        return view('reports.infos.index', compact('programs', 'url'));

    }

    public function show($code)
    {
        // dd('xxxxxxxx');
        $program = ProgramInfo::where('program_code', $code)->first();
        $infos = PtirReportInfos::where('program_code', $code)
                                    ->element()
                                    ->orderBy('seq')
                                    ->get();
        $listFormTypes = PtirReportInfos::getlistFormTypes();
        $url = (Object)[];
        $url->storeInfo = route('ir.settings.report-info.store', $code);
        $url->saveFunction = route('report.report-info.save-function', $code);

        $func =   PtirReportInfos::where('program_code', $code)
                ->where('function_flag', true)
                ->first();
         
        $listInfos =  $infos->mapWithKeys(function($value, $key) {
            return [$value->attribute_name => $value];
        });

        // dd($infos->where('seq', 7)->first()->lists);
        return view('ir.settings.report-info.show', compact('program', 'infos', 'listFormTypes', 'url', 'func', 'listInfos'));

    }

    public function store(Request $request, $code)
    {
        // dd(str_replace(['\r\n', '\r', '\n'],$request->options));
        // $options  = str_ireplace(array("\r","\n",'\r','\n'),'', $request->options);
        // dd($request->all());
        try {
            // $seq = PtirReportInfos::where('program_code', $code)
            //                     ->element()
            //                     ->count();

            $options  = str_ireplace(array("\r","\n",'\r','\n'),'', $request->options);
            $user = auth()->user();

            // dd(auth()->user());
            $reportInfo                     = new PtirReportInfos();
            $reportInfo->seq                = $request->seq;
            $reportInfo->program_code       = $code;
            $reportInfo->attribute_name     = $request->attribute_name;
            $reportInfo->purpose            = $request->purpose;
            $reportInfo->form_type          = $request->form_type;
            $reportInfo->form_value         = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $reportInfo->required           = $request->required ? true : false ;
            $reportInfo->last_updated_by    = $user->user_id;
            $reportInfo->creation_date      = now();
            $reportInfo->last_update_date   = now();
            $reportInfo->created_by         = $user->user_id;
            $reportInfo->view_or_table      = $request->view_or_table;
            $reportInfo->field_value        = $request->field_value;
            $reportInfo->field_description  = $request->field_description;
            $reportInfo->group_by           = $request->group_by;
            $reportInfo->order_by           = $request->order_by;
            $reportInfo->default_value      = $request->default_value;
            $reportInfo->display_value      = $request->display_value;
            $reportInfo->date_type          = strtolower($request->date_type);
            $reportInfo->report_type        = 'excel';
            $reportInfo->options            = $options;
            $reportInfo->attribute_1         = $request->format_date;
            $reportInfo->attribute_2         = $request->default_value_field; 
            // dd($reportInfo);
            $reportInfo->save();

        } catch (\Exception $e) {

            return redirect()->back()->withErrors([$e->getMessage()]);

        }

        return redirect()->back()->with('success', 'Add info success.');
    }

    public function update(Request $request, $code , $reportInfoId)
    {
        // dd($request->all(), data_get($request, 'relation_type', ""), $request->enable_if);
        try {
            $options  = str_ireplace(array("\r","\n",'\r','\n'),'', $request->options);
            $user = auth()->user();

            $reportInfo                     = PtirReportInfos::find($reportInfoId);

            // dd( data_get($request->relation, 'attribute_name', ""));
            // dd( get_data()$request->relation["attribute_name"]);
            $reportInfo->seq                = $request->seq ?  $request->seq :$reportInfo->seq;
            $reportInfo->attribute_name     = $request->attribute_name ?  $request->attribute_name : $reportInfo->attribute_name;
            $reportInfo->purpose            = $request->purpose ? $request->purpose : $reportInfo->purpose;
            $reportInfo->form_type          = $request->form_type ? $request->form_type : $reportInfo->form_type ;
            $reportInfo->form_value         = $request->form_value ? $this->composeFormValue($request->form_type,$request->form_value) : null;
            $reportInfo->required           = $request->required ? true : false ;
            // $reportInfo->active             = $request->active;
            $reportInfo->last_updated_by    = 1;
            $reportInfo->creation_date      = now();
            $reportInfo->creation_date      = now();
            $reportInfo->created_by         = 1;
            $reportInfo->view_or_table      = $request->view_or_table ? $request->view_or_table : $reportInfo->view_or_table ;
            $reportInfo->options            = $options ? $options : $reportInfo->options;
            // $reportInfo->field_value        = $request->field_value;
            // $reportInfo->field_description  = $request->field_description;
            // $reportInfo->group_by           = $request->group_by;
            // $reportInfo->order_by           = $request->order_by;
            $reportInfo->default_value      = $request->default_value;
            $reportInfo->display_value      = $request->display_value;
            $reportInfo->date_type          = $request->date_type ? $request->date_type : $reportInfo->date_type;
            $reportInfo->attribute_1        = $request->format_date ? $request->format_date : $reportInfo->format_date;

            $reportInfo->attribute_7        = data_get($request, 'relation_type', "");

            if(data_get($request, 'relation_type', "") == 'where'){
                $reportInfo->option_1           = $request->relation;
                $reportInfo->attribute_8        = data_get($request->relation, 'attribute_name', "");
                $reportInfo->option_2           = null;
                $reportInfo->attribute_5        = null;
                $reportInfo->attribute_6        = null;
            }

            if(data_get($request, 'relation_type', "") == 'whereBetween'){
                $reportInfo->option_2           = $request->relation_between;
                $reportInfo->attribute_5        = data_get($request->relation_between, 'where_from', "");
                $reportInfo->attribute_6        = data_get($request->relation_between, 'where_to', "");

                $reportInfo->option_1           = null ;
                $reportInfo->attribute_8        = null ;
            }

            if(data_get($request, 'relation_type', "") == ""){
                $reportInfo->attribute_7        = null;
                $reportInfo->option_1           = null;
                $reportInfo->attribute_8        = null;
                $reportInfo->option_2           = null;
                $reportInfo->attribute_5        = null;
                $reportInfo->attribute_6        = null;
            }

            if($request->enable_if == 'true'){
                $reportInfo->attribute_4   = $request->enable_field;
            }
            if($request->enable_if == 'false'){
                $reportInfo->attribute_4   =null;
            }

            $reportInfo->save();

        } catch (\Exception $e) {

            return redirect()->back()->withErrors([$e->getMessage()]);

        }

        return redirect()->back()->with('success', 'Update info success.');
    }

    public function destroy($code,$reportInfoId)
    {
        // dd('xxx');
        $reportInfo = PtirReportInfos::find($reportInfoId);

        if(!!$reportInfoId){
            $reportInfo->delete();
        }

        return redirect()->back();
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

    public function saveFunction(Request $request, $code)
    {

        $hasFunction =  PtirReportInfos::where('program_code', $code)
                        ->where('function_flag', true)
                        ->get()
                        ->count();

        // dd($request->all());
        try {

            if($hasFunction){
                $reportInfo = PtirReportInfos::where('program_code', $code)
                        ->where('function_flag', true)
                        ->first();
                $reportInfo->function           = $request->function_name;
                $reportInfo->attribute_9        = $request->multi_type ? 'Y' : 'N';
                $reportInfo->save();

                return redirect()->back()->with('success', 'Update!! info success.');
            }

            $user = auth()->user();
            $reportInfo                     = new PtirReportInfos();
            $reportInfo->seq                = 99;
            $reportInfo->program_code       = $code;
            $reportInfo->attribute_name     = 'function';
            $reportInfo->form_type          = 'function';
            $reportInfo->required           = true;
            $reportInfo->last_updated_by    = $user->user_id;
            $reportInfo->creation_date      = now();
            $reportInfo->last_update_date   = now();
            $reportInfo->created_by         = $user->user_id;
            $reportInfo->function           = $request->function_name;
            $reportInfo->function_flag      = true;
            $reportInfo->attribute_9        = $request->multi_type  ? "Y" : "N";
            $reportInfo->save();

            return redirect()->back()->with('success', 'Add info success.');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
         }

    }

    public function getDependent()
    {
        dd(request()->all());
    }

    public function copy($programFrom , $programTo)
    {
        $olds =  PtirReportInfos::where('program_code' , $programFrom)
                ->get();
        

        foreach ($olds as $key => $value) {
            $old =  PtirReportInfos::find($value->report_info_id); 
            $newRow = $old->replicate();
            $newRow->program_code = $programTo;
            if($newRow->attribute_name == 'function'){
                $newRow->function = $programTo;
            }
            $newRow->save();
        }

        return redirect()->back();
    }

}
