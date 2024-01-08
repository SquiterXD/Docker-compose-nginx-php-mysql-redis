<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PRPOStampV extends Model
{
    use HasFactory;
    protected $table = "OAPP.PTPP_PR_PO_STAMP_V";

    public static function numberToTextConverter($amount)
    {
        $amount_number = number_format($amount, 2, ".", "");
        $pt = strpos($amount_number, ".");
        $number = $fraction = "";

        if ($pt === false) {
            $number = $amount_number;
        } else {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        $ret = "";
        $baht = static::readNumber($number);
        if ($baht != "") {
            $ret .= $baht . "บาท";
        }

        $satang = static::readNumber($fraction);
        if ($satang != "") {
            $ret .=  $satang . "สตางค์";
        } else {
            $ret .= "ถ้วน";
        }
        return $ret;
    }

    public static function readNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";

        if ($number == 0) {
            return $ret;
        }
        if ($number > 1000000) {
            $ret .= static::readNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while ($number > 0) {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
              ((($divider == 10) && ($d == 1)) ? "" :
              ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }

    public function callGetAmoumt($prNumber, $ccid, $periodName, $ledgetId)
    {
        $db = \DB::connection('oracle')->getPdo();
        $sql = "declare
                    output1  varchar2(100) := null;
                    output2  varchar2(100) := null;
                    v_budget        number := 0;
                    v_encumbrance   number := 0;
                    v_actual        number := 0;
                begin
                    ptpp_gl_budget_pkg.main(i_code_combination_id       => '{$ccid}'
                                            , i_period                  => '{$periodName}'
                                            , i_ledger_id               => '{$ledgetId}'
                                            , i_pr_number               => '{$prNumber}'
                                            , errbuf                    => :output1
                                            , retcode                   => :output2
                                        );
                end;
            ";

        $stmt = $db->prepare($sql);
        logger($sql);
        $result = [];
        $stmt->bindParam(':output1', $result['output1'], \PDO::PARAM_STR, 1000);
        $stmt->bindParam(':output2', $result['output2'], \PDO::PARAM_STR, 1000);
        $stmt->execute();

        return $result;
    }
}
