<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BGFundsXLAV extends Model
{
    use HasFactory;
    protected $table        = 'ptbg_inq_xla_v';
    protected $connection   = 'oracle';

    public function getEncumbranceXla($concatenated_segments)
    {
        return $xla = collect(\DB::select("
                select gcc.concatenated_segments
                    , xah.balance_type_code
                    , xah.period_name
                    , sum(nvl(entered_dr, 0) - nvl(entered_cr, 0)) encumbrance_amount
                from xla_ae_headers                      xah
                    , xla_ae_lines                       xal
                    , gl_code_combinations_kfv           gcc
                where 1=1
                and xah.ae_header_id            = xal.ae_header_id
                and xal.code_combination_id     = gcc.code_combination_id 
                and xah.gl_transfer_date is null
                and xah.balance_type_code       = 'E'
                and gcc.concatenated_segments   = '{$concatenated_segments}'
                group by gcc.concatenated_segments
                    , xah.balance_type_code
                    , xah.period_name
            "));
    }
}
