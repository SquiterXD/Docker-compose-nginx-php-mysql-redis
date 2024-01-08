<?php
namespace App\Models\PM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MtlTransactionType extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'mtl_transaction_types';
    public $timestamps = false;
}
