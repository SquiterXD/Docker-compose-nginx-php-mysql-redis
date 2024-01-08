<?php
namespace App\Repositories\PM;

class PmPrintRepo
{
    public static function getPrintTypeCode()
    {
        $db = \DB::connection('oracle')->table('v$database')->first();
        if ($db->name == 'UAT') {
            $data['gravure'] = 52;
            $data['offset'] = 51;
            $data['contract_manuf'] = 45;
        } else {
            // PROD
            // 17  พิมพ์ Gravure
            // 16  พิมพ์ Offset
            // 45  รับจ้างผลิต
            $data['gravure'] = 17;
            $data['offset'] = 16;
            $data['contract_manuf'] = 45;
        }

        return (object) $data;
    }
}
