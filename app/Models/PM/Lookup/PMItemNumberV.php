<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PMItemNumberV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_ITEM_NUMBER_V';
    public $timestamps = false;

    protected $fillable = [
    ];
}