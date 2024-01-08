<?php


namespace App\Models\PM\SprinkleTobaccos;

use App\Models\PM\Cast\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSprinkleTobaccoLine extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_sprinkle_tobacco_lines';
    protected $primaryKey = 'sprinkle_line_id';
    public $timestamps = false;

}
