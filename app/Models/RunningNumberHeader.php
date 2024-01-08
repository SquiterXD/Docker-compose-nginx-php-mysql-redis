<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningNumberHeader extends Model
{
    use HasFactory;

    protected $table = "pt_doc_seq_headers";
    public $primaryKey = "doc_seq_header_id";
    protected $fillable = [
        'doc_seq_code', 'doc_seq_description', 'org_id', 'module_code', 'start_date', 'end_date', 'year_type', 
        'format_date', 'reset_every', 'reset_day', 'reset_date', 'prefix_number_digit','active_flag', 
        'format1', 'format2', 'format3', 'format4', 'format5', 'format6', 'format7', 'format8', 'format9', 'format10', 
        'format11', 'format12', 'format13', 'format14', 'format15', 'format16', 'format17', 'format18', 'format19', 'format20', 
        'prefix', 'suffix', 'format_combine', 'format_option', 'attribute1',  'attribute2', 'attribute3', 'attribute4',
        'attribute5', 'program_code', 'created_by_id', 'updated_by_id', 'deleted_by_id', 'created_by', 'last_updated_by', 
        'start_with', 'last_number'
    ];

    public function scopeSearch($q, $running_code, $system_module)
    {
        return $q->when($running_code, function($q) use($running_code) {
            $q->where('doc_seq_code', $running_code);
            })
            ->when($system_module, function($q) use($system_module) {
                $q->where('module_code', $system_module);
        });
    }

    public function assignments()
    {
        return $this->hasMany(SeqAssignment::class, 'doc_seq_header_id', 'doc_seq_header_id');
    }

}
