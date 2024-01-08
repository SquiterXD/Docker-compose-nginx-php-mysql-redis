<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmItemcatRequestSeg2 extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPM_ITEMCAT_REQUEST_SEG2';
    public $timestamps = false;
}
