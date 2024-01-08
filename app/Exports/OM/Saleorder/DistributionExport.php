<?php

namespace App\Exports\OM\Saleorder;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\OM\Customers\Export\ForeignCustomerModel;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;

class DistributionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $customer = ForeignCustomerModel::where('sales_classification_code','Domestic')
                                        ->where('status','Active')
                                        ->whereNotNull('customer_number')
                                        ->whereNotNull('delivery_date')
                                        ->orderBy('customer_number','asc')
                                        ->get();

        $product  = SequenceEcomsModel::where('product_type_code','10')
                                        ->where('sale_type_code','DOMESTIC')
                                        ->where('start_date','<=',date('Y-m-d'))
                                        ->where(function ($query) {
                                            $query->where('end_date','>=',date('Y-m-d'));
                                            $query->orWhereNull('end_date');
                                        })
                                        ->orderBy('screen_number','asc')
                                        ->get();

        $sumProduct = $product->count();

        $date = [
            'ทุกวัน' => '0',
            'จันทร์' => '1',
            'อังคาร' => '2',
            'พุธ' => '3',
            'พฤหัสบดี' => '4',
            'ศุกร์' => '5',
            'เสาร์' => '6',
            'อาทิตย์' => '7'
        ];

        foreach($customer as $keyCus => $cus_item){
            $customerData[$keyCus][0] = $cus_item->customer_number;
            $customerData[$keyCus][1] = $cus_item->province_name;
            $customerData[$keyCus][2] = $cus_item->customer_name;
            $cusIndex = 3;
            for($i = 1; $i <= $sumProduct ; $i++){
                $customerData[$keyCus][$cusIndex] = '0';
                $cusIndex += 1;
            }
        }      

        $dataDescription[0] = 'บุหรี่ หน่วย พันมวน , ยาเส้น หน่วย ซอง';
        $dataDescription[1] = '';
        $dataDescription[2] = '';
        $dataCode[0] = '      รหัสผลิตภัณฑ์
        รหัสร้านค้า';
        $dataCode[1] = 'จังหวัด';
        $dataCode[2] = 'ชื่อร้านค้า';
        $index = 3;
        foreach($product as $key => $pro_item){
            $dataDescription[$index] = $pro_item->item_description;
            $dataCode[$index] = $pro_item->item_code;
            $index += 1;
        }

        //row 1
        $export[] = $dataDescription;

        //row 2
        $export[] = $dataCode;

        $export[] = $customerData;

        return collect($export);
    }
}
