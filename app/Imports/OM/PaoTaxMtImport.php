<?php

namespace App\Imports\OM;

use App\Models\OM\PtomPaoTaxMt;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithColumnLimit;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PaoTaxMtImport implements ToCollection, WithStartRow, WithValidation, WithMultipleSheets, WithColumnLimit, WithCalculatedFormulas
{
    use Importable;

    /**
    * @return int
    */
    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function endColumn(): string
    {
        return 'H';
    }

    public function rules(): array
    {
        return [
            '0' => 'required|numeric',
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
            '6' => 'required',
            '7' => 'required',
        ];
    }

    public function collection(Collection $rows)
    {

        $taxRate = PtomAllTaxRateV::where('meaning', 'อัตราภาษีอบจ.')->first();
        $multiply = (float)$taxRate->tag/1000;
        $groupPV = $rows->groupBy(function ($item, $key) {
            return $item['4'];
        });

        $amountByPV = 0; 
        foreach ($groupPV as $groupName => $itemPvs) {
            foreach ($itemPvs as $index => $itemPv) {
                $amountByPV += $itemPv['7']; 
            }
        }

        foreach ($rows as $row) 
        {
            $year = self::composeYear($row[0]);
            $monthNo = self::composeMonthNo($row[1]);
            $customer = PtomCustomer::where('customer_number', $row[2])->first();
            $province = ThailandTerritoryModel::where('province_thai', $row[4])->first();
            $item = Itemv::where('item_code', $row[5])->first();

            if( $year ){
                PtomPaoTaxMt::create([
                    'year'                  => $year,
                    'month_no'              => $monthNo,
                    'file_name'             => 'TESTNAME',
                    'path_name'             => 'none',
                    'customer_id'           => $customer->customer_id,
                    'customer_number'       => $row[2],
                    'province_id'           => $province->province_id,
                    'province_name'         => $row[4],
                    'item_id'               => $item->inventory_item_id,
                    'item_code'             => $row[5],
                    'quantity_cg'           => $row[7],
                    'pao_amount_by_pv'      => (float)($amountByPV * $multiply),
                    'pao_amount'            => (float)($row[7] * $multiply),
                    'adjust_amount'         => (float)($row[7] * $multiply),
                    'dif_amount'            => 0,
                    'program_code'          => 'OMP0089',
                    'created_by'            => \Auth::user()->user_id,
                    'last_updated_by'       => \Auth::user()->user_id,
                    'created_by_id'         => \Auth::user()->user_id,
                    'updated_by_id'         => \Auth::user()->user_id,
                ]);
            }
        }
    }

    private static function getMonthNo()
    {
        $monthNo = 2;

        $monthLists = [
            '1' => 'มกราคม',
            '2' => 'กุมภาพันธ์',
            '3' => 'มีนาคม',
            '4' => 'เมษายน',
            '5' => 'พฤษภาคม',
            '6' => 'มิถุนายน',
            '7' => 'กรกฎาคม',
            '8' => 'สิงหาคม',
            '9' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        ];


        return $monthNo;
    }
}
