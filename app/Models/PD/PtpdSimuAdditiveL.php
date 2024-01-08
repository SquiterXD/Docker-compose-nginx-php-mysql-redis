<?php

namespace App\Models\PD;

use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveH;
use App\Models\PD\Lookup\PtpdRawMateCasingV;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PtpdSimuAdditiveL extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ptpd_simu_additive_l';
    public $primaryKey = 'simu_formula_line_id';

    protected $fillable = [
        'raw_material_id',
        'raw_material_num',
        'description',
        'actual_qty',
        'actual_uom',
        'actual_cost',
        'created_by',
        'last_updated_by',
        'program_code'
    ];

    /**
     * Get the header that owns the line.
     */
    public function header()
    {
        return $this->belongsTo(PtpdSimuAdditiveH::class, 'simu_formula_id', 'simu_formula_id');
    }

    /**
     * Get the raw mat associated with the line.
     */
    public function material()
    {
        return $this->hasOne(PtpdRawMateCasingV::class, 'inventory_item_id', 'raw_material_id');
    }

    protected static function booted()
    {
        static::updated(function($line) {

            //$user = User::find($line->header->last_updated_by);

            if(User::where('user_id', $line->header->last_updated_by)->first() !== null){
                $editBy = User::where('user_id', $line->header->last_updated_by)->first()->name;
                $createdBy = User::where('user_id', $line->header->last_updated_by)->first()->user_id;
                $lastUpdatedBy = User::where('user_id', $line->header->last_updated_by)->first()->user_id;
            }else{
                $editBy = null;
                $createdBy = null;
                $lastUpdatedBy = null;
            }

            $watch_attribute = ['raw_material_num', 'description', 'actual_qty', 'actual_uom', 'actual_cost'];
            foreach($line->getOriginal() as $attribute_name => $attribute_value) {
                if($line->wasChanged($attribute_name) && in_array($attribute_name, $watch_attribute)) {
                    $edit_no = 1;
                    // $max_edit_no = $line->header->history()->where('edit_field', $attribute_name)->max('edit_no');
                    // $max_edit_no = $line->header->history()->max('edit_no');
                    $max_edit_no = $line->header->history()
                            ->where('edit_field', '!=', 'actual_cost')
                            ->max('edit_no');
                    if($max_edit_no > 0) {
                        $edit_no = $max_edit_no + 1;
                    }
                    $line->header->history()->create([
                        'edit_no' => $edit_no,
                        'edit_by' => $editBy,
                        'edit_date' => Carbon::now(),
                        'edit_field' => $attribute_name,
                        'old_data' => $attribute_value,
                        'new_data' => $line->$attribute_name,
                        'created_by' => $createdBy,
                        'last_updated_by' => $lastUpdatedBy,
                        'item_code'     => $line->raw_material_num
                    ]);
                }
            }
        });
    }
}
