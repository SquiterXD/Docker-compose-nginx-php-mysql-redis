<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramColumn extends Model
{
    use HasFactory;

    protected $table  = 'pt_program_columns_info';

    protected $fillable = ['program_code', 'column_name', 'column_prompt', 'enable_flag', 'column_seq_num',
                            'view_name', 'sql_text', 'required_flag'];

    protected $appends = ['strRequiredFlag'];

    // protected $primaryKey = 'program_code';
    public $incrementing = false;
    public $timestamps = false;

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_code', 'program_code');
    }

    public function getstrRequiredFlagAttribute()
    {
        
        if ($this->required_flag == 'Y') {
            return true;
        } else {
            return false;
        }
        
    }

    public function sqlDisplay($attribute1)
    {
        // dd($this);
        $sql = str_replace('$id', $attribute1, $this->sql_text_display);

        // dd($sql);
        $getTests = collect(\DB::select($sql))->first();
        
        return optional($getTests)->display ?? '';
        // return $getTests;

    }

    public function sqlDisplayMutiValue($tag, $attribute1)
    {
        // dd($tag, $attribute1);
        // $sql = str_replace(['$id', $tag, '$org', $attribute1], $this->sql_text_display);
        $sql = str_replace(array('$id', '$org'), array($tag, $attribute1), $this->sql_text_display);

        $getDatas = collect(\DB::select($sql))->first();
        
        // dd($getTests->display);
        return optional($getDatas)->display ?? '';
    }
}
