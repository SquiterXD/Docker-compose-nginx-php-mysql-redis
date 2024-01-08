<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmItemNumberVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_item_number_v';
    public $timestamps = false;

    protected $fillable = [
    ];
}
