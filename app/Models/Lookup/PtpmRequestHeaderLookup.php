<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Model;

class PtpmRequestHeaderLookup extends Model
{
    protected $table = 'PTPM_REQUEST_HEADERS';
    public $primaryKey = 'request_header_id';
    public $timestamps = false;
}
