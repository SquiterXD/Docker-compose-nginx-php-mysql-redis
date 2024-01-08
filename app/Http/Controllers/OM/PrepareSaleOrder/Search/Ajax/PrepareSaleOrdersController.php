<?php

namespace App\Http\Controllers\OM\PrepareSaleOrder\Search\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\PeriodV;
use App\Models\OM\OrderType;
use App\Models\OM\Customers;
use App\Models\OM\OrderHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;

class PrepareSaleOrdersController extends Controller
{
    public function getSoLists(Request $request)
    {
        $type = $request->type;
        $setValue = $request->set_data;
        $customer = $request->depend_cust;
        $text  = $request->get('query');
        $result = [];
        $result = OrderHeaders::selectRaw('distinct customer_id flex_id, order_number flex_value')
            ->whereNotNull('order_number')
            // ->whereHas('customer', function ($query) use ($type) {
            //     return $query->whereRaw("lower(sales_classification_code) = '{$type}'")
            //         ->whereRaw("lower(status) = 'active'");
            // })
            // ->when($customer, function ($query, $customer) {
            //     return $query->where(function($r) use ($customer) {
            //         $r->where('customer_id', $customer);
            //     });
            // })
            ->whereHas('customer', function ($query) use ($type, $customer) {
                return $query->search($type)
                ->whereRaw("lower(sales_classification_code) = '{$type}'")
                ->whereRaw("lower(status) = 'active'")
                ->when($customer, function ($q, $customer) {
                    return $q->where('customer_id', $customer);
                });
            })
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('order_number', 'like', "%${text}%");
                });
            })
            ->orderBy('order_number', 'desc')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = OrderHeaders::selectRaw('distinct customer_id flex_id, order_number flex_value')
                ->where('order_number', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getPrepareSoLists(Request $request)
    {
        $type = $request->type;
        $setValue = $request->set_data;
        $customer = $request->depend_cust;
        $text  = $request->get('query');
        $result = [];
        $result = OrderHeaders::selectRaw('distinct prepare_order_number flex_value, creation_date')
            ->whereNotNull('prepare_order_number')
            // ->whereHas('customer', function ($query) use ($type) {
            //     return $query->whereRaw("lower(sales_classification_code) = '{$type}'")
            //         ->whereRaw("lower(status) = 'active'");
            // })
            ->whereHas('customer', function ($query) use ($type, $customer) {
                return $query->search($type)
                ->whereRaw("lower(sales_classification_code) = '{$type}'")
                ->whereRaw("lower(status) = 'active'")
                ->when($customer, function ($q, $customer) {
                    return $q->where('customer_id', $customer);
                });
            })
            // ->when($customer, function ($query, $customer) {
            //     return $query->where(function($r) use ($customer) {
            //         $r->where('customer_id', $customer);
            //     });
            // })
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('prepare_order_number', 'like', "%${text}%");
                });
            })
            ->orderBy('creation_date', 'desc')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = OrderHeaders::selectRaw('distinct prepare_order_number flex_value, creation_date')
                ->where('prepare_order_number', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getPeriodLists(Request $request)
    {
        $setValue = $request->set_data;
        $text  = str_replace('%2F', '/', $request->get('query'));
        $result = [];
        $result = PeriodV::selectRaw("period_line_id flex_id , budget_year+543||'/'||period_no as flex_value")
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->whereRaw("budget_year+543||'/'||period_no like '%{$text}%'");
                });
            })
            ->orderBy('period_line_id')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = PeriodV::selectRaw("period_line_id as flex_id, budget_year+543||'/'||period_no as flex_value")
                ->whereRaw("budget_year+543||'/'||period_no = '{$setValue}'")
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getPiLists(Request $request)
    {
        $setValue = $request->pi_no;
        $text  = $request->get('query');
        $result = [];
        $result = ProformaInvoiceHeaders::selectRaw('pi_header_id flex_id, pi_number flex_value, order_header_id, creation_date')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('pi_number', 'like', "%${text}%");
                });
            })
            ->orderBy('creation_date', 'desc')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = ProformaInvoiceHeaders::selectRaw('pi_header_id flex_id, pi_number flex_value, order_header_id, creation_date')
                ->where('pi_number', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getInvoiceLists(Request $request)
    {
        $setValue = $request->invoice_no;
        $text  = $request->get('query');
        $result = [];
        $result = ProformaInvoiceHeaders::selectRaw('pick_release_no flex_value, creation_date')
            ->whereNotNull('pick_release_no')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('pick_release_no', 'like', "%${text}%");
                });
            })
            ->orderBy('creation_date', 'desc')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = ProformaInvoiceHeaders::selectRaw('pick_release_no flex_value, creation_date')
                ->where('pick_release_no', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getCustomerLists(Request $request)
    {
        $type = $request->type;
        $setValue = $request->customer_id;
        $text  = $request->get('query');
        $result = [];
        $result = Customers::selectRaw('customer_id flex_id, customer_number flex_value, customer_name, customer_type_id')
            // ->search($type)
            ->whereNotNull('customer_number')
            ->whereRaw("lower(sales_classification_code) = '{$type}'")
            ->whereRaw("lower(status) = 'active'")
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('customer_number', 'like', "%${text}%")
                        ->orWhere('customer_name', 'like', "%${text}%");
                });
            })
            ->orderBy('customer_number')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = Customers::selectRaw('customer_id flex_id, customer_number flex_value, customer_name, customer_type_id')
                ->where('customer_number', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }

    public function getOrderTypeLists(Request $request)
    {
        $type = $request->type;
        $setValue = $request->order_type_id;
        $text  = $request->get('query');
        $result = [];
        $result = OrderType::selectRaw('order_type_id flex_id, sales_type, order_type_name flex_value, description')
            ->search($type)
            ->whereRaw("lower(sales_type) = '{$type}'")
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('order_type_name', 'like', "%${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('description')
            ->limit(50)
            ->get();

        if ($setValue) {
            $valDefault = OrderType::selectRaw('order_type_id flex_id, sales_type, order_type_name flex_value, description')
                ->where('order_type_name', $setValue)
                ->first();

            if ($valDefault) {
                $result = $result->push($valDefault)->unique('flex_value');
            }
        }

        return $result;
    }
}
