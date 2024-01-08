<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetHeaders extends Model
{
    use HasFactory;
    protected $table = "ptir_asset_headers";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number',
        'status',
        'asset_status',
        'year',
        'policy_set_header_id',
        'policy_set_description',
        'count_asset',
        'total_cost',
        'total_cover_amount',
        'total_insu_amount',
        'total_vat_amount',
        'total_net_amount',
        'total_rec_insu_amount',
        'as_of_date',
        'start_calculate_date',
        'end_calculate_date',
        'start_addition_date',
        'end_addition_date',
        'insurance_start_date',
        'insurance_end_date',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'creation_date',
        'last_update_date',
        'revision'
    ];

    public function updateAssetHeaders($data)
    {
        $db = PtirAssetHeaders::find($data['header_id']);
        $db->status                = $data['status'];
        $db->document_number       = $data['document_number'];
        $db->count_asset           = $data['count_asset'];
        $db->revision              = $data['revision'];
        $db->updated_at            = $data['updated_at'];
        $db->updated_by_id         = $data['updated_by_id'];
        $db->last_update_date      = $data['last_update_date'];
        $db->save();
    }
}
