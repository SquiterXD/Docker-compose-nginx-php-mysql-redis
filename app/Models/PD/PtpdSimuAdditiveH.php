<?php

namespace App\Models\PD;

use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveHistory;
use App\Models\PD\PtpdSimuAdditiveL;
use App\Models\PD\PtpdMixProcess;
use App\Models\PD\PtpdInstruction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpdSimuAdditiveH extends Model
{
    use HasFactory;

    protected $table = 'oapd.ptpd_simu_additive_h';
    protected $primaryKey = 'simu_formula_id';

    protected $fillable = [
        'simu_formula_no', 'description', 'remark_formula', 'creation_date', 'created_by', 'last_update_date', 'last_updated_by', 'simu_type', 'program_code'
    ];

    // public function getCreatedByAttribute($value)
    // {
    //     $user = User::find($value);
    //     return $user? $user->name: $value;
    // }

    /**
     * Get the lines for the header.
     */
    public function lines()
    {
        return $this->hasMany(PtpdSimuAdditiveL::class, 'simu_formula_id', 'simu_formula_id');
    }

    /**
     * Get the mixs for the header.
     */
    public function mixs()
    {
        return $this->hasMany(PtpdMixProcess::class, 'simu_formula_id', 'simu_formula_id');
    }

    /**
     * Get the instructions for the header.
     */
    public function instructions()
    {
        return $this->hasMany(PtpdInstruction::class, 'simu_formula_id', 'simu_formula_id');
    }

    /**
     * Get the history for the header.
     */
    public function history()
    {
        return $this->hasMany(PtpdSimuAdditiveHistory::class, 'simu_formula_id', 'simu_formula_id');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::updated(function($header) {

            //$user = User::find($header->last_updated_by);
            if(User::where('user_id', $header->last_updated_by)->first() !== null){
                $editBy = User::where('user_id', $header->last_updated_by)->first()->name;
                $createdBy = User::where('user_id', $header->last_updated_by)->first()->user_id;
                $lastUpdatedBy = User::where('user_id', $header->last_updated_by)->first()->user_id;
            }else{
                $editBy = null;
                $createdBy = null;
                $lastUpdatedBy = null;
            }

            foreach($header->getOriginal() as $attribute_name => $attribute_value) {
                if($header->wasChanged($attribute_name) && ($attribute_name == 'description' || $attribute_name == 'remark_formula')) {
                    $edit_no = 1;
                    // $max_edit_no = $header->history()->where('edit_field', $attribute_name)->max('edit_no');
                    $max_edit_no = $header->history()->max('edit_no');
                    // if($header->history()->where('edit_field')){

                    // }

                    // edit_field = 'actual_cost'
                    if($max_edit_no > 0) {
                        $edit_no = $max_edit_no + 1;
                    }

                    $header->history()->create([
                        'edit_no' => $edit_no,
                        'edit_by' =>  $editBy,
                        'edit_date' => Carbon::now(),
                        'edit_field' => $attribute_name,
                        'old_data' => $attribute_value,
                        'new_data' => $header->$attribute_name,
                        'created_by' =>  $createdBy,
                        'last_updated_by' => $lastUpdatedBy,
                    ]);
                }
            }
        });
    }
}
