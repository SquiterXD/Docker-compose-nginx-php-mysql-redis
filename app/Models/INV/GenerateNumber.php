<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateNumber extends Model
{
    protected $guarded = [];
    protected $table = 'ptw_generate_numbers';

    public function generateNumber($dept, $currentDate, $digit = 3)
    {
        $period = PtPeriodV::select('start_date', 'end_date', 'shot_year_thai')
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();

        $yearThai = $period->shot_year_thai;

        $documentNumber = $this->firstOrCreate(
            ['dept_code' => $dept, 'year' => $yearThai], 
            ['current_number' => 0])
        ;
        $documentNumber->increment('current_number');
        $paddingNumber = str_pad($documentNumber->current_number, $digit, '0', STR_PAD_LEFT);

        return "{$dept}{$yearThai}{$paddingNumber}";
    }
}
