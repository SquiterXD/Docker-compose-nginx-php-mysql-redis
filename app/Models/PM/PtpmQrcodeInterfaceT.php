<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmQrcodeInterfaceT extends Model
{
    use HasFactory;
    protected $table = 'oapm.ptpm_qrcode_interface_t';
    public $primaryKey = false;
    public $timestamps = false;
    public $incrementing = false;
}
