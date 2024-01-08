<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriterionAllocate extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_CRITERION_ALLOCATES';
    public $primaryKey = 'criterion_allocate_id';
	public $timestamps = false;
	protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];	
}
