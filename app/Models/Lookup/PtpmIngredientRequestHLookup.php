<?php


namespace App\Models\Lookup;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\Lookup\PtpmItemNumberV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class PtpmIngredientRequestHLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_INGREDIENT_REQUEST_H';
    public $timestamps = false;

    protected $fillable = [
    ];
}
