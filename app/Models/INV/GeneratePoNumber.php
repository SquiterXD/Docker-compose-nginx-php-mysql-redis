<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratePoNumber extends Model
{
    use HasFactory;
    protected $table = 'ptw_generate_po_numbers';
    protected $fillable = [
        'month',
        'current_number',
    ];

    public function generatePoNumber($month, $digit = 3)
    {
        $documentNumber = $this->firstOrCreate(
            ['month' => $month], 
            ['current_number' => 0])
        ;
        $documentNumber->increment('current_number');
        $paddingNumber = str_pad($documentNumber->current_number, $digit, '0', STR_PAD_LEFT);

        return "{$month}/{$paddingNumber}";
    }
}
