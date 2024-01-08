<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

 
class PtpmItemClassificationsVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.Ptpm_Item_Classifications_V';
    protected $primaryKey = 'item_classification_code';
    public $timestamps = false;

    protected $fillable = [
    ];

    protected $casts = [
        'item_classification_code' => 'string',
    ];
}
