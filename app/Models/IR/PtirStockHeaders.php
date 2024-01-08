<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\IR\PtirStockLines;
class PtirStockHeaders extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_headers";
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
        'year',
        'period_name',
        'period_from',
        'period_to',
        'policy_set_header_id',
        'policy_set_description',
        'department_code',
        'department_desc',
        'total_amount',
        'total_cover_amount',
        'total_insu_amount',
        'manual_amount',
        'manual_cover_amount',
        'manual_insu_amount',
        'inventory_amount',
        'inventory_cover_amount',
        'inventory_insu_amount',
        'expense_flag',
        'item_exp_account_id',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ];

    public function updateStockHeaders($data)
    {
        $db = PtirStockHeaders::find($data['header_id']);
        $db->status                 = $data['status'];
        $db->document_number        = $data['document_number'];
        $db->total_amount           = $data['total_amount'];
        $db->total_cover_amount     = $data['total_cover_amount'];
        $db->total_insu_amount      = $data['total_insu_amount'];
        $db->manual_amount          = $data['manual_amount'];
        $db->manual_cover_amount    = $data['manual_cover_amount'];
        $db->manual_insu_amount     = $data['manual_insu_amount'];
        $db->inventory_amount       = $data['inventory_amount'];
        $db->inventory_cover_amount = $data['inventory_cover_amount'];
        $db->inventory_insu_amount  = $data['inventory_insu_amount'];
        $db->expense_flag           = $data['expense_flag'];
        $db->updated_at             = $data['update_at'];
        $db->last_updated_by        = $data['last_updated_by'];
        $db->last_update_date       = $data['last_update_date'];
        $db->save();
    }

    public function ptirStocklines()
    {
        return $this->belongsTo(PtirStockLines::class, 'header_id', 'header_id');
    }

    public function policySetHeader()
    {
        return $this->belongsTo('\App\Models\IR\Settings\PolicySetHeader', 'policy_set_header_id', 'policy_set_header_id');
    }

}

