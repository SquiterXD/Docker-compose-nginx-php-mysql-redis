<?php

namespace App\Imports\OM\SaleOrder\Domestic;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;


class YearDistributeImport implements ToCollection
{
    public $data;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $data = [
            'data' => [],
            'noData' => []
        ];
        foreach($collection as $key => $item){
            if($key == 6){
                foreach($item as $key_head => $item_head){
                    if(!empty($item_head) && $key_head > 1){
                        $head_ex = explode(' ',$item_head);
                        $year = $head_ex[1];
                        $key_data[$year] = $key_head;

                    }elseif(empty($item_head) && $key_head > 1){
                        $this->data =  ['status' => false,'message' => 'No header'];
                        return false;
                    }
                }

                $i = 2;
                foreach($key_data as $key_set => $head_set){
                    $head['last'][$key_set] = $head_set;
                    $head['first'][$key_set] = $i++;
                }
            }
            if($key == 7){
                foreach($item as $key_year => $item_year){
                    if(!empty($item_year) && $key_year > 1){
                            $head['year'][$key_year] = $item_year;

                    }elseif(empty($item_year) && $key_year > 1){
                        $this->data =  ['status' => false,'message' => 'No header'];
                        return false;
                    }
                }
            }
            if($key > 7){
                foreach($key_data as $key_index => $key_item){
                    $data['data'][$key][$key_index] = [
                        'item_description'  => $item[0],
                        'item_code'         => $item[1],
                        'quantity'          => $item[$head['first'][$key_index]],
                        'amount'            => $item[$head['last'][$key_index]],
                        'year_no'           => $key_index,
                        'year'              => $head['year'][$head['first'][$key_index]]
                    ];

                    $itemcode       = SequenceEcomsModel::where('item_code',trim($item[1]))->first();
                    if(empty($itemcode)){
                        $data['noData'][$item[1]] = $item[1].'/'.$item[0];
                    }
                }
            }
        }

        if(count($data['noData']) > 0){
            $data = implode(',',$data['noData']);
            throw new \Exception('ItemEmpty_'.$data);
        }

        $data['status'] = true;
        $this->data = $data;
    }
}
