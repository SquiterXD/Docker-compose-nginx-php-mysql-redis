<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeqAssignment extends Model
{
    use HasFactory;
    protected $table = "pt_doc_seq_assignments";

    public $primaryKey = "assignment_id";

    protected $fillable = ['assignment_id', 'doc_seq_header_id', 'assign_program_code', 
                           'active_flag', 'program_code', 'created_by_id', 'created_by', 'last_updated_by'];


    public function runningNumber()
    {
        return $this->belongsTo(RunningNumberHeader::class, 'doc_seq_header_id', 'doc_seq_header_id');
    }
}






