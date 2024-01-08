<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmSampleProductMesV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_SAMPLE_PRODUCT_MES';
    public $timestamps = false;

    protected $fillable = [
    ];
}