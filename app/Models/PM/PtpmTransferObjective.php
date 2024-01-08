<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmTransferObjective extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_TRANSFER_OBJECTIVE';
    public $timestamps = false;


    public function scopeActive($q)
    {
        return $q->where("enabled_flag", "Y");
    }
}
