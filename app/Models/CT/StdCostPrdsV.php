<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCostPrdsV extends Model
{
    use HasFactory;

    protected $table = 'ptct_std_cost_prds_v';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
      'enable_flag', 'last_update_date', 'creation_date'
  ];
}
