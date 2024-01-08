<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCostProd extends Model
{
    use HasFactory;

    protected $table = 'OACT.ptct_std_cost_prds';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    public $primaryKey = null;

    protected $fillable = [
      'start_date',
      'end_date'
  ];
}
