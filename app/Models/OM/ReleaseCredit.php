<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseCredit extends Model
{
    use HasFactory;
    protected $table = "OAOM.PTOM_RELEASE_CREDIT";
    public $primaryKey = 'release_credit_id';
    public $timestamps = false;
}
