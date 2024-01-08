<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmManufactureStepLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_manufacture_step';
    public $timestamps = false;

    protected $fillable = [
    ];
}
