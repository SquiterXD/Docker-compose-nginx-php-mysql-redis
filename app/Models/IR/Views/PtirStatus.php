<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirStatus extends Model
{
    use HasFactory;
    protected $table = "ptir_status";
    public $timestamps = false;

    private $limit = 50;

    public function getStatusLov()
    {
        $collection = PtirStatus::select('lookup_code', 'meaning', 'description')
                                ->orderBy('lookup_code', 'asc') 
                                ->get();

        return $collection;
    }
}
