<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvLine extends Model
{
    use HasFactory;

    protected $table = "ptir_product_inv_lines";
    public $primaryKey = 'line_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'header_id', 'category_code', 'zone_code', 'program_code', 'created_at', 'updated_at',
                            'created_by_id', 'updated_by_id', 'created_by', 'last_updated_by', 'creation_date',
                            'last_update_date'];
}
