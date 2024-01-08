<?php

namespace App\Models\PD\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OhhandTobaccoForewarn extends Model
{
    use HasFactory;

    protected $table  = 'ptpd_ohhand_tobacco_forewarn';
    protected $primaryKey = 'forewarn_id';
    // public $incrementing = false;
    // public $timestamps = false;

    protected $fillable = [ 'forewarn_id', 'category_tobacco', 'type_tobacco', 'inventory_item_id',
                            'warning_num','attribute1', 'attribute2', 'attribute3', 'attribute4', 
                            'attribute5', 'attribute6', 'attribute7', 'attribute8', 'attribute9', 
                            'attribute10', 'program_code', 'created_at', 'updated_at', 
                            'deleted_at', 'created_by_id', 'updated_by_id', 'deleted_by_id',
                            'created_by', 'last_updated_by', 'creation_date', 'last_update_date'];    

    public function tobaccoForewarnV() 
    {
        return $this->hasOne(TobaccoForewarnV::class, 'inventory_item_id' ,'inventory_item_id');
    }

    public function updateOhhandTobaccoForewarn($data) 
    {
        $db = OhhandTobaccoForewarn::find($data['inventory_item_id']);
        $db->last_updated_by            = $data['last_updated_by'];
        $db->warning_num                = $data['warning_num'];
        $db->save();
    }
}
