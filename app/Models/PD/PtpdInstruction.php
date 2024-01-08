<?php

namespace App\Models\PD;

use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveH;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpdInstruction extends Model
{
    use HasFactory;

    protected $table = 'ptpd_instruction';
    public $primaryKey = 'instruction_id';

    protected $fillable = [
        'instruction_no',
        'instruction_desc',
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

    protected static function booted()
    {
        static::updated(function($instruction) {

            //$user = User::find($instruction->header->last_updated_by);

            if(User::where('user_id', $instruction->header->last_updated_by)->first() !== null){
                $editBy = User::where('user_id', $instruction->header->last_updated_by)->first()->name;
                $createdBy = User::where('user_id', $instruction->header->last_updated_by)->first()->user_id;
                $lastUpdatedBy = User::where('user_id', $instruction->header->last_updated_by)->first()->user_id;
            }else{
                $editBy = null;
                $createdBy = null;
                $lastUpdatedBy = null;
            }

            $watch_attribute = ['instruction_desc'];
            foreach($instruction->getOriginal() as $attribute_name => $attribute_value) {
                if($instruction->wasChanged($attribute_name) && in_array($attribute_name, $watch_attribute)) {
                    $edit_no = 1;
                    // $max_edit_no = $instruction->header->history()->where('edit_field', $attribute_name)->max('edit_no');
                    $max_edit_no = $instruction->header->history()->max('edit_no');
                    if($max_edit_no > 0) {
                        $edit_no = $max_edit_no + 1;
                    }
                    $instruction->header->history()->create([
                        'edit_no' => $edit_no,
                        'edit_by' => $editBy,
                        'edit_date' => Carbon::now(),
                        'edit_field' => $attribute_name,
                        'old_data' => $attribute_value,
                        'new_data' => $instruction->$attribute_name,
                        'created_by' => $createdBy,
                        'last_updated_by' => $lastUpdatedBy,
                    ]);
                }
            }
        });
    }
}
