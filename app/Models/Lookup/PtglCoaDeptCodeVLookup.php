<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtglCoaDeptCodeVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptgl_Coa_Dept_Code_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}
