<?php

namespace App\Models\PD;

use App\Models\User;
use App\Models\PD\PtpdExpandedTobaccoH;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdExpandedTobaccoHistory extends Model
{
    use HasFactory;

    protected $table = 'ptpd_expanded_tobacco_history';
    protected $primaryKey = 'exp_tobacco_his_id';

    protected $fillable = [
        'edit_field',
        'edit_no',
        'new_data',
        'old_data',
    ];

    protected $attributes = [
        'program_code' => 'PDP009',
    ];

    public function header()
    {
        return $this->hasMany(PtpdExpandedTobaccoH::class, 'exp_tobacco_id', 'exp_tobacco_id');
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
