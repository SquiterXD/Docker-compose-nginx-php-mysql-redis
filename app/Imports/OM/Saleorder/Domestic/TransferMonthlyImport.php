<?php

namespace App\Imports\OM\Saleorder\Domestic;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TransferMonthlyImport implements ToCollection
{
    public $data;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $data = [];
        foreach($collection as $key => $item){
            if($key == 0){
                foreach($item as $key_head => $item_head){
                    if ($key_head > 2) {
                        if(empty($item_head)){
                            $this->data =  ['status' => false,'message' => 'No header'];
                            return false;
                        }
                        $data['name'][$key_head] = preg_replace('/\s+/', '', $item_head);
                    }
                }
            }

            if($key == 1){
                foreach ($item as $key_item => $item_code) {
                    if ($key_item > 2) {
                        if(empty($item_code)){
                            $this->data =  ['status' => false,'message' => 'No header'];
                            return false;
                        }
                        $data['code'][$key_item] = preg_replace('/\s+/', '', $item_code);
                        $data['code_item'][] = preg_replace('/\s+/', '', $item_code);
                    }
                }
            }

            if($key > 1){
                if(!empty($item[0])){
                    $data['shop'][] = $item[0];
                    foreach($item as $key_data => $item_data){
                        if($key_data > 2){
                            $data['shop_data'][$item[0]][] = [
                                'shop'          => preg_replace('/\s+/', '', $item[0]),
                                'product_name'  => preg_replace('/\s+/', '', $data['name'][$key_data]),
                                'product_code'  => preg_replace('/\s+/', '', $data['code'][$key_data]),
                                'total'         => !empty(preg_replace('/\s+/', '', $item_data))? preg_replace('/\s+/', '', $item_data) : 0
                            ];
                        }
                    }
                }
            }
        }
        $this->data = $data;
    }
}
