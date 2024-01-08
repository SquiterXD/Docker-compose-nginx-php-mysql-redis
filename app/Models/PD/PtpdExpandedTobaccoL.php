<?php

namespace App\Models\PD;

use App\Models\PD\PtpdExpandedTobaccoH;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdExpandedTobaccoL extends Model
{
    use HasFactory;

    protected $table = 'ptpd_expanded_tobacco_l';
    public $primaryKey = 'exp_tobacco_line_id';

    protected $fillable = [
        'created_by',
        'inventory_item_code',
        'inventory_item_id',
        'item_ratio',
        'last_updated_by',
        'lot_number',
    ];

    protected $attributes = [
        'program_code' => 'PDP009',
    ];

    public function header()
    {
        return $this->belongsTo(PtpdExpandedTobaccoH::class, 'exp_tobacco_id', 'exp_tobacco_id');
    }

    public function history()
    {
        return $this->hasMany(PtpdExpandedTobaccoHistory::class, 'exp_tobacco_id', 'exp_tobacco_id');
    }

    protected static function booted()
    {
        static::creating(function($line) {
            $id = Auth::id()? Auth::id(): 27;
            $line->created_by = $id;
            $line->last_updated_by = $id;
        });

        static::updating(function($line) {
            $id = Auth::id()? Auth::id(): 27;
            $line->last_updated_by = $id;
        });

        static::updated(function($line) {
            $watch_attribute = ['inventory_item_code', 'item_ratio', 'lot_number'];
            $edit_no = 1;
            $max_edit_no = $line->header->history()->where('exp_tobacco_id', $line->header->exp_tobacco_id)->max('edit_no');
            if($max_edit_no > 0) {
                $edit_no = $max_edit_no + 1;
            }

            foreach($line->getOriginal() as $attribute_name => $attribute_value) {
                if($line->wasChanged($attribute_name) && in_array($attribute_name, $watch_attribute)) {
//                    $edit_no = 1;
//                    $max_edit_no = $line->header->history()->where('edit_field', $attribute_name)->max('edit_no');
//                    if($max_edit_no > 0) {
//                        $edit_no = $max_edit_no + 1;
//                    }
                    $line->header->history()->create([
                        'edit_no' => $edit_no,
                        'edit_field' => $attribute_name,
                        'old_data' => $attribute_value,
                        'new_data' => $line->$attribute_name,
                    ]);
                }
            }
        });
    }
}
