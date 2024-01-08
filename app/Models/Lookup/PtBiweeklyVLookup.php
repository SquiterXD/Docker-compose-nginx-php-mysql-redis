<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtBiweeklyVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.pt_biweekly_v';
    public $timestamps = false;

    protected $fillable = [
    ];
}
