<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceListHeader extends Model
{
    use HasFactory;

    protected $table = 'ptom_list_headers';
    protected $primaryKey = 'list_header_id';

    public function listLines()
    {
        return $this->hasMany(PriceListLine::class, 'list_header_id', 'list_header_id');
    }

    public function interface($batchno)
    {
        // dd($bathNo);
        $db = \DB::connection('oracle')->getPdo();
        $sql = " 
                    DECLARE
                        v_return_status     varchar2(1) := NULL;
                        v_message           varchar2(4000) := NULL;
                    BEGIN
                        dbms_output.put_line('------  S T A R T ------');

                        PTOM_PRICE_LIST_INT_PKG.UPLOAD (:batchno, :v_return_status, :v_message);

                        dbms_output.put_line('------  E N D ------');
                        COMMIT;
                    END;
                ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':batchno', $batchno);
        $stmt->bindParam(':v_return_status', $result['v_return_status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['v_message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);
        

        return $result;
    }
}
