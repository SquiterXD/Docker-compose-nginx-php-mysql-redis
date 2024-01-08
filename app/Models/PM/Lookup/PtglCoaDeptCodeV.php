<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtglCoaDeptCodeV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTGL_COA_DEPT_CODE_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}
