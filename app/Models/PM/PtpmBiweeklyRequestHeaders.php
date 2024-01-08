<?php

namespace App\Models\PM;

use App\Models\PM\PtpmBiweeklyRequestLines;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmBiweeklyRequestHeaders extends Model
{
    use HasFactory;

    protected $table = 'oapm.ptpm_biweekly_request_headers';

    protected $primaryKey = 'bi_request_header_id';
 
    protected $fillable = [
        'biweekly_id',
        'tobacco_group',
        'request_date',
        'product_date_from',
        'product_date_to',
        'department_desc',
        'department_code',
        'requesy_by', 
        'send_date'
    ];

    protected $attributes = [
        'program_id' => 'PMP0027',
    ];

    public function lines()
    {
        return $this->hasMany(PtpmBiweeklyRequestLines::class, 'bi_request_header_id', 'bi_request_header_id');
    }

    public function insert($data)
    {
        $db = new PtpmBiweeklyRequestHeaders();
        foreach($data AS $column => $value){
            $db->$column = $value;
        }
        $db->save();
        return $db;
    }

}
