<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateDocumentNumber extends Model
{
    protected $guarded = [];
    protected $table = 'ptw_generate_document_numbers';
    protected $fillable = [
        'year',
        'month',
        'day',
        'current_number',
    ];
    

    public function generateDocumentNumber($digit = 2)
    {
        $currentYear = \Carbon\Carbon::now()->format('Y');
        $currentMonth = \Carbon\Carbon::now()->format('m');
        $currentDay = \Carbon\Carbon::now()->format('d');

        $documentNumber = $this->firstOrCreate(
            [   
                'year' => $currentYear, 
                'month' => $currentMonth, 
                'day' => $currentDay
            ],
            [   
                'current_number' => 0
            ]
        );

        $documentNumber->increment('current_number');
        $paddingNumber = str_pad($documentNumber->current_number, $digit, '0', STR_PAD_LEFT);

        return "{$currentYear}{$currentMonth}{$currentDay}{$paddingNumber}";
    }
}
