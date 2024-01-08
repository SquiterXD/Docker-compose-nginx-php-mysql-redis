<?php


namespace App\Models\PD\View;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmItemNumberV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Item_Number_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}
