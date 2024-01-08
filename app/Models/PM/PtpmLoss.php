<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmLoss extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_loss';

}
