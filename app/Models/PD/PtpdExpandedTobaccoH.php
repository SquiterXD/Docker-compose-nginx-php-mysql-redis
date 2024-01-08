<?php

namespace App\Models\PD;

use App\Models\PD\PtpdExpandedTobaccoHistory;
use App\Models\PD\PtpdExpandedTobaccoL;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdExpandedTobaccoH extends Model
{
    use HasFactory;

    protected $table = 'ptpd_expanded_tobacco_h';
    protected $primaryKey = 'exp_tobacco_id';

    protected $fillable = [
        'created_by',
        'last_updated_by',
        'expanded_tobacco',
        'inventory_item_code',
        'inventory_item_id',
        'description',
        'remark',
        'folmula_type',
        'quantity',
        'formula_creation_date',
        'formula_last_update_date',
        'formula_status',
        'user_name',
        'formula_approval_date',
        'formula_start_date',
        'uom',
        'program_code',
    ];

    protected $attributes = [
        'program_code' => 'PDP009',
    ];

    public function history()
    {
        return $this->hasMany(PtpdExpandedTobaccoHistory::class, 'exp_tobacco_id', 'exp_tobacco_id');
    }

    public function lines()
    {
        return $this->hasMany(PtpdExpandedTobaccoL::class, 'exp_tobacco_id', 'exp_tobacco_id');
    }

    public function getCreatedByAttribute($value)
    {
        $user = User::find($value);
        return $user? $user->name: $value;
    }

    protected static function booted()
    {
        static::creating(function($header) {
            $id = Auth::id()? Auth::id(): 27;
            $header->created_by = $id;
            $header->last_updated_by = $id;
        });

        static::updating(function($header) {
            $id = Auth::id()? Auth::id(): 27;
            $header->last_updated_by = $id;
        });

        static::updated(function($header) {
            $watch_attribute = ['description', 'remark', 'description', 'quantity', 'formula_status'];

            $edit_no = 1;
            $max_edit_no = $header->history()->where('exp_tobacco_id', $header->exp_tobacco_id)->max('edit_no');
            if($max_edit_no > 0) {
                $edit_no = $max_edit_no + 1;
            }

            foreach($header->getOriginal() as $attribute_name => $attribute_value) {
                if($header->wasChanged($attribute_name) && in_array($attribute_name, $watch_attribute)) {
//                    $edit_no = 1;
//                    $max_edit_no = $header->history()->where('edit_field', $attribute_name)->max('edit_no');
//                    if($max_edit_no > 0) {
//                        $edit_no = $max_edit_no + 1;
//                    }
                    $header->history()->create([
                        'edit_no' => $edit_no,
                        'edit_field' => $attribute_name,
                        'old_data' => $attribute_value,
                        'new_data' => $header->$attribute_name,
                    ]);
                }
            }
        });
    }
}
