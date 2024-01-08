<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmDepartmentFromGl extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_DEPARTMENT_FROM_GL';
    public $timestamps = false;

    protected $fillable = [
    ];
}
