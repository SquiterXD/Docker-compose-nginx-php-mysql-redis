<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class PtirCompanies extends Model
{
    use HasFactory;

    protected $table = "ptir_companies";
    public $primaryKey = 'company_id';
    public $timestamps = false;
    protected $dates = ['created_at', 'updated_at', 'creation_date', 'last_update_date'];

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_number',
        'company_name',
        'company_address',
        'company_telephone',
        'vendor_id',
        'vendor_site_id',
        'customer_id',
        'active_flag',
        'program_code',
        'created_at',
        'updated_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];

    /**
     * Get all Company
     */
    public function allCompany($id, $active_flag)
    {
        $collection = PtirCompanies::select('company_id', 
                                            'company_number', 
                                            'company_name', 
                                            'active_flag')
                                    ->whereRaw('company_id = nvl(?, company_id)
                                                and active_flag = nvl(?, active_flag)', 
                                              [$id, $active_flag])                
                                    ->orderBy('company_number', 'asc')
                                    ->get();

        return $collection;
    }

    /**
     * Get the specified company
     */
    public function getCompany($id)
    {
        $collection = DB::table('ptir_companies as a')->select('a.company_id', 
                                                               'a.company_number', 
                                                               'a.company_name',
                                                               'a.company_address', 
                                                               'a.company_telephone', 
                                                               'a.vendor_id',
                                                               'b.vendor_number',
                                                               'b.vendor_name',
                                                               'a.vendor_site_id', 
                                                               'c.vendor_site_code', 
                                                               'a.customer_id', 
                                                               'd.customer_number', 
                                                               'd.customer_name', 
                                                               'a.active_flag')
                                                    ->leftJoin('ptir_vendor_v as b', 'a.vendor_id', '=', 'b.vendor_id')
                                                    ->leftJoin('ptir_vendor_brach_v as c', 'a.vendor_site_id', '=', 'c.vendor_site_id')
                                                    ->leftJoin('ptir_customer_v as d', 'a.customer_id', '=', 'd.customer_id')
                                                    ->where('company_id', $id)        
                                                    ->first();
        
        return $collection;
    }
    
    /**
     * Get list companies
     */
    public function getCompaniesLov($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';

        $collection = PtirCompanies::select('company_id', 
                                            'company_number', 
                                            'company_name')
                                    ->whereRaw("company_id = nvl(?, company_id) 
                                                and (company_number like ? or company_name like ?)
                                                and active_flag = 'Y'", 
                                               [$id, $keyword, $keyword])       
                                    ->take($this->limit)
                                    ->orderBy('company_number', 'asc')
                                    ->get();

        return $collection;
    }

    public function updateActiveFlag($data) 
    {
        $db = PtirCompanies::find($data['company_id']);
        $db->active_flag      = $data['active_flag'];
        $db->updated_at       = $data['updated_at'];
        $db->last_updated_by  = $data['last_updated_by'];
        $db->last_update_date = $data['last_update_date'];
        $db->save();
    }

  

    public function updateCompany($data)
    {
        $db = PtirCompanies::find($data['company_id']);
        $db->company_number    = $data['company_number'];
        $db->company_name      = $data['company_name'];
        $db->company_address   = $data['company_address'];
        $db->company_telephone = $data['company_telephone'];
        $db->vendor_id         = $data['vendor_id'];
        $db->vendor_site_id    = $data['vendor_site_id'];
        $db->customer_id       = $data['customer_id'];
        $db->active_flag       = $data['active_flag'];
        $db->last_updated_by   = $data['last_updated_by'];
        $db->updated_at        = Carbon::now();
        $db->last_update_date  = Carbon::now();
        $db->save();
    }

    public function getObjectCompany($id) 
    {
        $data = $this->getCompany($id);
        $obj = new stdClass();
        $obj->company_id        = (isset($data->company_id)) ? $data->company_id : '';
        $obj->company_number    = (isset($data->company_number)) ? $data->company_number : '';
        $obj->company_name      = (isset($data->company_name)) ? $data->company_name : '';
        $obj->company_address   = (isset($data->company_address)) ? $data->company_address : '';
        $obj->company_telephone = (isset($data->company_telephone)) ? $data->company_telephone : '';
        $obj->vendor_id         = (isset($data->vendor_id)) ? $data->vendor_id : '';
        $obj->vendor_number     = (isset($data->vendor_number)) ? $data->vendor_number : '';
        $obj->vendor_name       = (isset($data->vendor_name)) ? $data->vendor_name : '';
        $obj->vendor_site_id    = (isset($data->vendor_site_id)) ? $data->vendor_site_id : '';
        $obj->vendor_site_code  = (isset($data->vendor_site_code)) ? $data->vendor_site_code : '';
        $obj->customer_id       = (isset($data->customer_id)) ? $data->customer_id : '';
        $obj->customer_number   = (isset($data->customer_number)) ? $data->customer_number : '';
        $obj->customer_name     = (isset($data->customer_name)) ? $data->customer_name : '';
        $obj->active_flag       = (isset($data->active_flag)) ? $data->active_flag : '';

        return $obj;
    }

    public static function duplicateCheck($companyNumber)
    {
        $collection = PtirCompanies::where('company_number', $companyNumber)->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function genCompanyNumber() {
        $collection = PtirCompanies::selectRaw("(CASE WHEN MAX(to_number(company_number)) <> 99 THEN
                                                           LPAD(MAX(to_number(company_number))+1, 2, 0)
                                                      ELSE
                                                           LPAD(MAX(to_number(company_number))+1, 3, 0)
                                                END)  as company_number")
                                    ->first();
        if  ($collection->company_number == null) {
            $collection->company_number = '01';
        }
        return $collection;
    }

    public function vendorBranch()
    {
        return $this->belongsTo('App\Models\IR\Views\PtirVendorBranchView', 'vendor_site_id', 'vendor_site_id');
    }

    public function scopeSearch($q, $search)
    {
        if ($search->company_id) {
            $q->where('company_id', $search->company_id);
        } else {
            $q;
        }

        if ($search->active_flag) {
            $q->where('active_flag', $search->active_flag);
        } else {
            $q;
        }

        return $q;
    }

}

