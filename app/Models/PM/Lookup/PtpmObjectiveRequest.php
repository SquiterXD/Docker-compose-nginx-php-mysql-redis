<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use DB;


class PtpmObjectiveRequest extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Objective_Request';
    public $timestamps = false;

    public function scopeGetListObjectiveRequests($query)
    {
        return $query->select(DB::raw("lookup_code as objective_request_value, description as objective_request_label, lookup_code, meaning, description"))
            ->groupBy('lookup_code', 'meaning', 'description');

    }

}
