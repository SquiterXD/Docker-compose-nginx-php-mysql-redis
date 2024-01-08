<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EamWorkingOrderV extends Model
{
    use HasFactory;
    protected $table = "pteam_work_order_h_v";

    public function checkPmWipEntity($date, $machine)
    {
        $data = collect(\DB::select("
            select * from pteam_work_order_h_v  h
            where h.wip_entity_id = (select max(wip_entity_id)
                                        from pteam_work_order_h_v 
                                        where asset_number = '{$machine}'
                                        and TO_DATE('{$date}', 'YYYY-mm-dd') BETWEEN trunc(scheduled_start_date)
                                                                            and trunc(scheduled_completion_date)
                                    )
        "));

        return $data? $data->first(): [];
    }
}
