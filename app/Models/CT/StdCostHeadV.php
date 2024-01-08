<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StdCostHeadV extends Model
{
  use HasFactory;

  protected $table = 'OACT.ptct_std_cost_heads_v';
  public $primaryKey = "PRDGRP_YEAR_ID";
}
