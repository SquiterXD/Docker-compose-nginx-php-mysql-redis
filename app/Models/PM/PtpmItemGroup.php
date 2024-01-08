<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmItemGroup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_ITEM_GROUP';
    public $timestamps = false;
}
