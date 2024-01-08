<?php
namespace App\Models\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiweeklyV  extends Model
{
	use HasFactory;
    protected $table = "ptpp_biweekly_v";
    public $primaryKey = 'biweekly_id';
}
