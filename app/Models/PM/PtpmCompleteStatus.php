<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmCompleteStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_COMPLETE_STATUS';
    public $timestamps = false;

    public function scopeActive($q)
    {
        return $q->where("enabled_flag", "Y");
    }
}