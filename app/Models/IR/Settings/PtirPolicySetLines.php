<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirPolicySetLines extends Model
{
    use HasFactory;

    protected $table = "ptir_policy_set_lines";
    public $primaryKey = 'policy_set_line_id';
    public $timestamps = false;

    private $limit = 50;

      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'policy_set_header_id',
        'company_id',
        'company_name',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];
}
