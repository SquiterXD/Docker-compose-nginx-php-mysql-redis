<?php

namespace App\Imports\OM\Saleorder\Domestic;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use App\Models\OM\Saleorder\Domestic\SequenceEcomsModel;

class TransferBiWeeklyImportController implements ToCollection
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
            if($key == 5){
                foreach($item as $key_head_excel => $item_head){
                    if(!empty($item_head) && $key_head_excel > 1){
                        $fortnight = explode(' ',$item_head);

                        $key_excel[] = $key_head_excel;
                        $key_data[$fortnight[1]] = $key_head_excel;
                    }elseif(empty($item_head) && $key_head_excel > 1){
                        $this->data =  ['status' => false,'message' => 'No header'];
                        return false;
                    }
                }
                $fist_key = array_key_first($key_data);
                $last_key = array_key_last($key_data);
                $index_data = $key_data[$fist_key]-1;
                for($i=$index_data ;$i > 1; $i--){
                    $first_data[$last_key--] = $i;
                }
            }
            if($key > 6){
                foreach($key_data as $key_index => $key_item){
                    $data['data'][$key][$key_index]['item_description']     = $item[0];
                    $data['data'][$key][$key_index]['item_code']            = $item[1];
                    $data['data'][$key][$key_index]['quantity']             = !empty($item[$first_data[$key_index]])? $item[$first_data[$key_index]] : 0;
                    $data['data'][$key][$key_index]['amount']               = !empty($item[$key_data[$key_index]])? $item[$key_data[$key_index]] : 0;

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
