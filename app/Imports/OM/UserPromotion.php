<?php

namespace App\Imports\OM;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserPromotion implements ToCollection, UserPromotionInterface
{
    protected $result;
    public function __construct($result)
    {
        $this->result = $result;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $note = '';
        $customer_number = [];
        foreach ($collection as $key => $value) {
            if($key == 1) {
                $note = $value[0];
            }elseif($key > 2) {
                $customer_number[] = $value[0];
            }
        }
        $this->result = ['note' => $note, 'customer_number' => collect($customer_number)->unique()];
        // return ['note' => $note, 'customer_number' => $customer_number];
    }

    public function resultData() {
        return $this->result;
    }
}
