<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmSampleProductV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_SAMPLE_PRODUCT';
    public $timestamps = false;

    protected $fillable = [
    ];
}
