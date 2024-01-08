<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpdInvMaterialItemV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpd_inv_material_item';
    public $timestamps = false;

    protected $fillable = [
    ];
}
