<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtirReportInfos extends Model
{
    use HasFactory;

    protected $table = "ptir_report_infos";
    public $primaryKey = 'report_info_id';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at', 'creation_date', 'last_update_date'];
    protected $appends =['lists', 'format_date' , 'loading' , 'disable', 'where_from', 'where_to'];
    protected $casts = [
                    'options'  => 'array',
                    'option_1' => 'array',
                    'option_2' => 'array',
                    ];
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'policy_set_header_id',
        'company_id',
        'company_name',
        'created_at',
        'created_by_id',
        'seq',
        'program_code',
        'attribute_name',
        'purpose',
        'for_type',
        'form_value',
        'required',
        'active',
        'is_primary_info',
        'last_updated_by',
        'created_by',
        'creation_date',
        'last_update_date',
        'option_1'
    ];

    public static function getlistFormTypes()
    {
        $lists = [
                    'text'      =>  'Text',
                    'select'    =>  'SQL',
                    // 'sql'       =>  'SQL',
                    'options'   =>  'Options',
                    'date'      =>  'Date picker',
                    // 'checkbox'  =>  'Check Box',
                    // 'radio'     =>  'Radio',

                ];

        return $lists;
    }
    public function getListsData($t)
    {
        $getTests = collect(DB::select($t));
        return  $getTests;
    }
    public function getListsAttribute()
    {

        // $unDefaultLoad = $this->attribute_8;
        if($this->attribute_8 || $this->attribute_7){
            return [];
        }
        DB::beginTransaction();

        try {
            $lists = in_array($this->form_type, ['select', 'options']);

            if(!$lists){
                return [];
            }

            if($this->form_type == 'options'){

                return  collect(json_decode($this->options));
            }

            return  collect(DB::select($this->view_or_table));
        } catch (\Exception $e) {
            return [];
        }

        return  collect(DB::select($this->view_or_table));
        //return  $getTests;


    }

    public function getDisableAttribute()
    {
        // $defaultDisable  = $this->attribute_8;
        if( $this->attribute_8){
            return true;
        }

        if($this->attribute_7){
            return true;
        }


        if($this->attribute_4){
            return true;
        }

        return false;
    }

    public function getFormatDateAttribute()
    {
        if ($this->attribute_1) {
            return $this->attribute_1;
        }

        if($this->form_type !== 'date'){
            return "";
        }
        // dd($this->view_or_table);
        if ($this->date_type == 'year') {
            return 'YYYY';
        }

        if ($this->date_type == 'month') {
            return 'MMMM';
        }

        if ($this->date_type == 'date') {
            return 'DD/MM/YYYY';
        }
        return  "";

    }

    public function scopeElement($q)
    {
        return $q->where('function_flag', false)
                ->where('button_flag', false);

    }

    public function scopeFunction($q)
    {
        return $q->where('function_flag', true);

    }

    public function getLoadingAttribute()
    {
        return false;
    }
    public function getWhereFromAttribute()
    {
        return "";
    }

    public function getWhereToAttribute()
    {
        return "";
    }

    // public  function getIsDependentAttribute()
    // {
    //     $check =  PtirReportInfos::selectRaw('program_code,attribute_2')
    //                 ->where('program_code', $this->program_code)
    //                 ->where('attribute_3' ,$this->report_info_id)
    //                 ->first();
    //     if(!$check){
    //         return false;
    //     }

    //     return true;
    // }

}
