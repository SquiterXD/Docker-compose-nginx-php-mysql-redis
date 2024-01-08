<?php

namespace App\Imports\OM\Saleorder\Domestic;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;

class MonthlyDistributeImport implements ToCollection
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

                        $mouth = monthToNumber($item_head);
                        if($mouth == 0){
                            $this->data =  ['status' => false,'message' => 'No header'];
                            return false;
                        }
                        $key_data[$mouth] = $key_head;

                    }elseif(empty($item_head) && $key_head > 1){
                        $this->data =  ['status' => false,'message' => 'No header'];
                        return false;
                    }
                }

                $i = 2;
                $sort = 1;
                foreach($key_data as $key_set => $head_set){
                    $head['last'][$key_set] = $head_set;
                    $head['first'][$key_set] = $i++;
                    $head['sort'][$key_set] = $sort++;
                }
            }

            if($key > 6){
                foreach($key_data as $key_index => $key_item){
                    $data['data'][$key][$key_index] = [
                        'item_description'  => $item[0],
                        'item_code'         => $item[1],
                        'quantity'          => $item[$head['first'][$key_index]],
                        'amount'            => $item[$head['last'][$key_index]],
                        'month'             => $key_index,
                        'sort'              => $head['sort'][$key_index]
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
