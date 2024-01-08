<?php

namespace Database\Seeders\Planning;

use Illuminate\Database\Seeder;
use DB;

class MachineLinesVSeeder extends Seeder
{
    public function run()
    {
        $sql = "
            CREATE OR REPLACE VIEW ptpp_machine_yearly_lines_v AS
            SELECT
                h.budget_year
                , h.product_type_name
                , h.efficiency_machine
                , h.efficiency_product
                , h.product_type
                , l.res_plan_date
                , l.working_hour
                , l.holiday_flag
                , l.machine_name
                , l.machine_eam_status
                , l.eam_dt_flag
                , l.eam_pm_flag
                , mgrp.machine_description
                , l.machine_speed
                , l.machine_eamperformance
                , l.efficiency_machine_per_min
                , l.efficiency_product_per_min
                , l.efficiency_product_full
                , l.eam_dt_eff_product
                , l.eam_pm_eff_product
                , l.res_plan_date_display
                , h.period_name
                , mgrp.machine_group
                , machine_group_description
                , l.res_plan_h_id
                , l.res_plan_l_id
                from ptpp_machine_yearly_lines        l
                    , ptpp_machine_yearly_headers     h
                    , ptpp_machine_v                  mgrp
                where 1=1
                and l.res_plan_h_id = h.res_plan_h_id
                and l.machine_name  = mgrp.machine_name 
        ";

        DB::connection('oracle_oapp')->statement($sql);
    }
}
