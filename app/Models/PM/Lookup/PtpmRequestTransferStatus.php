<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmRequestTransferStatus extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Request_Transfer_Status';
    public $timestamps = false;
}
