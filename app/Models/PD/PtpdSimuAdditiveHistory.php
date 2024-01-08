<?php

namespace App\Models\PD;

use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveH;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdSimuAdditiveHistory extends Model
{
    use HasFactory;

    protected $table = 'ptpd_simu_additive_history';
    protected $primaryKey = 'simu_for_history_id';

    protected $fillable = [
        'simu_formula_id',
        'edit_no',
        'edit_by',
        'edit_date',
        'edit_field',
        'old_data',
        'new_data',
        'created_by',
        'last_updated_by',
        'item_code'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'program_code' => 'PDP001',
    ];

    /**
     * Get the header that owns the history.
     */
    public function header()
    {
        return $this->belongsTo(PtpdSimuAdditiveH::class, 'simu_formula_id', 'simu_formula_id');
    }

    protected static function booted()
    {
        static::creating(function($history) {
            $id = Auth::id()? Auth::id(): 27;
            $edit_by = User::find($id)->name;
            $history->created_by = $id;
            $history->edit_by = $edit_by;
            $history->edit_date = Carbon::now();
            $history->last_updated_by = $id;
        });
    }
}
