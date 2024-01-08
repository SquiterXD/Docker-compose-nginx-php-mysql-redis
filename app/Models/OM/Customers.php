<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'ptom_customers';
    public $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    protected $appends = ['customer_name_format'];

    public static function byCustomerExport()
    {
        $result = self::whereRaw("lower(sales_classification_code) = 'export'")->whereRaw("lower(status) = 'active'")->get();
        return $result;
    }

    public static function byCustomerDomestic()
    {
        $result = self::whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number','ASC')->get();
        return $result;
    }

    public static function byCustomerId($id)
    {
        $result = self::where('customer_id',$id)->first();
        return $result;
    }

    public static function byCustomerNumber($number)
    {
        $result = self::where('customer_number',$number)->first();
        return $result;
    }

    public function scopeSearch($q, $type)
    {
        if ($type == 'domestic') {
            $q->where('customer_type_id', '!=', '80');
        }

        return $q;
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'Active');
    }

    public function scopeSearchForImproveFine($q, $search)
    {
        $text = strtoupper($search);
        // $q->where('UPPER(customer_number)', 'like', "%${text}%")
        //     ->orWhere('UPPER(customer_name)', 'like', "%${text}%")
        //     ->orWhere('customer_id', 'like', "%${text}%");
        $q->whereRaw("UPPER(customer_number) like '%".$text."%'")
            ->orWhereRaw("UPPER(customer_name) like '%".$text."%'")
            ->orWhereRaw("customer_id like '%".$text."%'");

        return $q;
    }
    
    public function getCustomerNameFormatAttribute()
    {
        if ($this->attribute2) {
            return  $this->customer_name . ' ('. $this->attribute2 . ')';
        }
        return  $this->customer_name;
    }
}
