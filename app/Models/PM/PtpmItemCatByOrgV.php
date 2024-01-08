<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmItemCatByOrgV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_item_cat_by_org_v';
    public $timestamps = false;
}
