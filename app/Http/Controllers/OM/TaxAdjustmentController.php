<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\OM\TaxAdjustModel;
use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\ConsignmentClub\ConsignmentLines;
use App\Models\OM\GLInterfaceModel;
use App\Models\OM\PTOM_GL_INTERFACES_REPORT;
use App\Repositories\OM\OracleCall;
use Carbon\Carbon;
use App\Models\OM\TaxAdjustmentsBKK;
use Faker\Core\Number;

class TaxAdjustmentController extends Controller
{
    public function index()
    {
        if (request()->all()) {
            $year = request()->input_year - 543;
            $month = request()->input_month;

            // $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
            $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS 
                WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID
                ORDER BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
            if (empty($consignments_customer_id1)) {
                $html = '';
                $info = false;
            } else {
                $html = '';
                $info = true;
                $setDataByLastDate = [];
                foreach ($consignments_customer_id1 as $key => $consignment1) {
                    $customer = Customer::where('customer_id', $consignment1->customer_id)->first();

                    if ($customer->customer_type_id == 30) {
                        $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    FROM PTOM_CONSIGNMENT_HEADERS 
                    WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                    AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                    AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                    AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                    GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE DESC 
                    FETCH FIRST 1 ROWS ONLY");
                    } else {
                        $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO  , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    FROM PTOM_CONSIGNMENT_HEADERS  
                    WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                    AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                    AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                    AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                    GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO ,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE DESC 
                    FETCH FIRST 1 ROWS ONLY");
                    }

                    foreach ($consignments_customer_id as $key_ => $consignment) {
                        if ($customer->customer_type_id == 30) {
                            $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                                ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                                ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                                ->first();
                        } else {
                            $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                                ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                                ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                                ->first();
                        }

                        $setDataByLastDate[$consignment->customer_id] = [
                            'date' => $last_date->consignment_date ? $last_date->consignment_date : null,
                            'customer_id' => $consignment->customer_id,
                            'customer_number' => $customer->customer_number,
                            'customer_name' => $customer->customer_name,
                            'customer_type_id' => $customer->customer_type_id,
                            'consignment_no' => $customer->customer_type_id != 30 ? $consignment->consignment_no : null,
                            'last_date' => $last_date
                        ];
                    }
                }
                sort($setDataByLastDate); //sort by date asc
                $key_index = 0;
                foreach ($setDataByLastDate as $consigeitem) {
                    if ($consigeitem['date'] != null) {
                        $d = explode('-', date_format(date_create($consigeitem['date']), 'Y-m-d'));
                        $day = $d[2];
                        $m = $d[1];
                        $y = $d[0] + 543;
                        $fulldate = $day . '/' . $m . '/' . $y;
                    } else {
                        $fulldate = '';
                    }

                    if ($consigeitem['customer_type_id'] == 30) {
                        dd(1);
                        $vat_ad = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.vat_amount');

                        $sum_vat = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                        $vat = $vat_ad;
                    } else {
                        //ptom_consignment_headers.vat_amount
                        $vatt = ConsignmentHeader::leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'DESC')->first();
                        //ptom_consignment_headers.total_include_vat
                        $sum_vatt = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                        $vat = $vatt->vat_amount ?? 0;
                        $vat_ad = $vat ?? 0;
                        $sum_vat = $sum_vatt ?? 0;
                    }
                    if ($consigeitem['customer_type_id'] == 30) {
                        $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                        $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                            $vatr = $tt->adjust_vat;
                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    } else {
                        $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                            if ($consigeitem['customer_type_id'] == 30) {
                                $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                            } else {
                                $vatr = $tt->adjust_vat;
                            }
                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vat_ad ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    }
                    $html .= "<tr class=\"align-middle\" id=\"" . $consigeitem['last_date']->consignment_header_id . "\"><td class=\"text-left\">" . $consigeitem['customer_number'] . "</td><td class=\"text-left\">" . $consigeitem['customer_name'] . "</td><td>" . $fulldate . "</td> <td class=\"text-right\">" . number_format($sum_vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"total_vat[]\" value=\"" . number_format($sum_vat ?? 0, 2) . "\"></td><td class=\"text-right\">" . number_format($vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"tax_amount[]\" value=\"" . number_format($vat ?? 0, 2) . "\"></td><td>" . $input1 . "</td><td>" . $input2 . "</td></tr>";
                    $key_index += 1;
                }
            }

            $infos = $html;
        } else {
            $info = false;
            $infos = '';
        }

        $m = DB::select("SELECT TO_CHAR(CONSIGNMENT_DATE, 'MM') CONSIGNMENT_DATE FROM PTOM_CONSIGNMENT_HEADERS GROUP BY TO_CHAR(CONSIGNMENT_DATE, 'MM') ORDER BY CONSIGNMENT_DATE ASC");
        $y = DB::select("SELECT BUDGET_YEAR FROM PTOM_PERIOD_V GROUP BY BUDGET_YEAR ORDER BY BUDGET_YEAR DESC");

        return view('om.tax-adjust.index', compact('info', 'infos', 'm', 'y'));
    }

    public function index_v2()
    {
        if (request()->all()) {
            $year = request()->input_year - 543;
            $month = request()->input_month;

            $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID 
            FROM PTOM_CONSIGNMENT_HEADERS 
            WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
            AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
            AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
            GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID
            ORDER BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
            if (empty($consignments_customer_id1)) {
                $html = '';
                $info = false;
            } else {
                $info = true;
                $html = '';
                $key_index = 0;
                $setDataByLastDate = [];
                foreach ($consignments_customer_id1 as $key => $consignment1) {
                    $customer = Customer::where('customer_id', $consignment1->customer_id)->first();

                    if ($customer->customer_type_id == 30) {
                        $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                        FROM PTOM_CONSIGNMENT_HEADERS 
                        WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                        AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                        AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                        AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                        GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                        ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE  DESC 
                        FETCH FIRST 1 ROWS ONLY");
                    } else {
                        $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO  , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                        FROM PTOM_CONSIGNMENT_HEADERS  
                        WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                        AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                        AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                        AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                        GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO ,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                        ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE DESC  
                        FETCH FIRST 1 ROWS ONLY");
                    }

                    foreach ($consignments_customer_id as $key_ => $consignment) {
                        if ($customer->customer_type_id == 30) {
                            $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                                ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                                ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                                ->first();
                        } else {
                            $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                                ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                                ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                                ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                                ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                                ->first();
                        }

                        $setDataByLastDate[$consignment->customer_id] = [
                            'date' => $last_date->consignment_date ? $last_date->consignment_date : null,
                            'customer_id' => $consignment->customer_id,
                            'customer_number' => $customer->customer_number,
                            'customer_name' => $customer->customer_name,
                            'customer_type_id' => $customer->customer_type_id,
                            'consignment_no' => $customer->customer_type_id != 30 ? $consignment->consignment_no : null,
                            'last_date' => $last_date
                        ];
                    }
                }

                sort($setDataByLastDate); //sort by date asc
                $key_index = 0;

                foreach ($setDataByLastDate as $consigeitem) {
                    if ($consigeitem['date'] != null) {
                        $d = explode('-', date_format(date_create($consigeitem['date']), 'Y-m-d'));
                        $day = $d[2];
                        $m = $d[1];
                        $y = $d[0] + 543;
                        $fulldate = $day . '/' . $m . '/' . $y;
                    } else {
                        $fulldate = '';
                    }

                    if ($consigeitem['customer_type_id'] == 30) {
                        $vat_ad = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.vat_amount');
                        $sum_vat = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                        $vat = $vat_ad;
                    } else {
                        //ptom_consignment_headers.vat_amount
                        $vatt = ConsignmentHeader::leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'DESC')->first();
                        //ptom_consignment_headers.total_include_vat
                        $sum_vatt = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                        $vat = $vatt->vat_amount ?? 0;
                        $vat_ad = $vat ?? 0;
                        $sum_vat = $sum_vatt ?? 0;
                    }
                    if ($consigeitem['customer_type_id'] == 30) {
                        $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                        $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                            $vatr = $tt->adjust_vat;
                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                if ($tt->attribute2 == 'Y') {
                                    $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                } else {
                                    $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                }
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    } else {
                        $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                            if ($consigeitem['customer_type_id'] == 30) {
                                $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                            } else {
                                $vatr = $tt->adjust_vat;
                            }
                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                                // $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                if ($tt->attribute2 == 'Y') {
                                    $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                } else {
                                    $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                }
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vat_ad ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    }
                    $html .= "<tr class=\"align-middle\" id=\"" . $consigeitem['last_date']->consignment_header_id . "\"><td class=\"text-left\">" . $consigeitem['customer_number'] . "</td><td class=\"text-left\">" . $consigeitem['customer_name'] . "</td><td>" . $fulldate . "</td> <td class=\"text-right\">" . number_format($sum_vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"total_vat[]\" value=\"" . number_format($sum_vat ?? 0, 2) . "\"></td><td class=\"text-right\">" . number_format($vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"tax_amount[]\" value=\"" . number_format($vat ?? 0, 2) . "\"></td><td>" . $input1 . "</td><td>" . $input2 . "</td></tr>";
                    $key_index += 1;
                }
            }

            $infos = $html;
        } else {
            $info = false;
            $infos = '';
        }

        $m = DB::select("SELECT TO_CHAR(CONSIGNMENT_DATE, 'MM') CONSIGNMENT_DATE FROM PTOM_CONSIGNMENT_HEADERS GROUP BY TO_CHAR(CONSIGNMENT_DATE, 'MM') ORDER BY CONSIGNMENT_DATE ASC");
        $y = DB::select("SELECT BUDGET_YEAR FROM PTOM_PERIOD_V GROUP BY BUDGET_YEAR ORDER BY BUDGET_YEAR DESC");

        return view('om.tax-adjust.index', compact('info', 'infos', 'm', 'y'));
    }

    public function recivedata(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required'
        ], [
            'month.required' => 'กรุณาระบุเดือน',
            'year.required' => 'กรุณาระบุปี พ.ศ.'
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => 100, 'data' => $validate->errors()->first()]);
        }

        $year = $request->year - 543;
        $month = $request->month;
        //GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID
        // $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
        $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID ORDER BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
        if (empty($consignments_customer_id1)) {
            return response()->json(['status' => 200, 'data' => 'ไม่พบข้อมูล']);
        } else {
            $html = '';
            $key_index = 0;
            foreach ($consignments_customer_id1 as $key => $consignment1) {
                $customer = Customer::where('customer_id', $consignment1->customer_id)->first();

                if ($customer->customer_type_id == 30) {
                    // $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
                    $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE  DESC FETCH FIRST 1 ROWS ONLY");
                } else {
                    // $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO FROM PTOM_CONSIGNMENT_HEADERS WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id'");
                    $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO  , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE FROM PTOM_CONSIGNMENT_HEADERS  WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO ,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE FETCH FIRST 1 ROWS ONLY");
                }

                foreach ($consignments_customer_id as $key_ => $consignment) {

                    if ($customer->customer_type_id == 30) {
                        $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->orderBy('ptom_consignment_headers.consignment_date', 'desc')->first();
                    } else {
                        $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consignment->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'desc')->first();
                    }

                    if ($last_date->consignment_date != null) {
                        $d = explode('-', date_format(date_create($last_date->consignment_date), 'Y-m-d'));
                        $day = $d[2];
                        $m = $d[1];
                        $y = $d[0] + 543;
                        $fulldate = $day . '/' . $m . '/' . $y;
                    } else {
                        $fulldate = '';
                    }


                    if ($customer->customer_type_id == 30) {
                        // $vat_ad = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                        $vat_ad = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->sum('ptom_tax_adjustments_bkk.vat_amount');

                        // $sum_vat = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.TOTAL_INCLUDE_VAT');
                        $sum_vat = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');

                        $vat = $vat_ad;
                    } else {
                        //ptom_consignment_headers.vat_amount
                        $vatt = ConsignmentHeader::leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_order_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consignment->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'DESC')->first();

                        //ptom_consignment_headers.total_include_vat
                        // $sum_vatt = ConsignmentHeader::leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_order_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consignment->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'DESC')->first();
                        $sum_vatt = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');

                        $vat = $vatt->vat_amount ?? 0;
                        $vat_ad = $vat ?? 0;
                        // $sum_vat = $sum_vatt->total_include_vat ?? 0;
                        $sum_vat = $sum_vatt ?? 0;
                    }

                    if ($customer->customer_type_id == 30) {
                        $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_consignment_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');


                        $t = TaxAdjustModel::where('document_number', $last_date->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $last_date->consignment_no)->first();
                            $vatr = $tt->adjust_vat;
                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                                $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",1," . $key_index . "\">";
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    } else {
                        $t = TaxAdjustModel::where('document_number', $last_date->consignment_no)->count();
                        if ($t > 0) {
                            $tt = TaxAdjustModel::where('document_number', $last_date->consignment_no)->first();

                            if ($customer->customer_type_id == 30) {
                                $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_order_headers.customer_id', $consignment->customer_id)->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                            } else {
                                $vatr = $tt->adjust_vat;
                            }

                            if ($tt->interface_flag == 'Y') {
                                $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                                $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",0," . $key_index . "\">";
                            } else {
                                $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                                // $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",1," . $key_index . "\">";
                                if ($tt->attribute2 == 'Y') {
                                    $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                } else {
                                    $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                                }
                            }
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vat_ad ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";

                            $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $last_date->consignment_header_id . ");\" value=\"" . $last_date->consignment_header_id . ",1," . $key_index . "\">";
                        }
                    }

                    $html .= "<tr class=\"align-middle\" id=\"" . $last_date->consignment_header_id . "\"><td class=\"text-left\">" . $customer->customer_number . "</td><td class=\"text-left\">" . $customer->customer_name . "</td><td>" . $fulldate . "</td> <td class=\"text-right\">" . number_format($sum_vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"total_vat[]\" value=\"" . number_format($sum_vat ?? 0, 2) . "\"></td><td class=\"text-right\">" . number_format($vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"tax_amount[]\" value=\"" . number_format($vat ?? 0, 2) . "\"></td><td>" . $input1 . "</td><td>" . $input2 . "</td></tr>";
                    $key_index += 1;
                }
            }
            return response()->json(['status' => 200, 'data' => json_decode(json_encode($html))]);
        }

        return response()->json(['status' => 400, 'data' => 'Something wrong!!']);
    }

    public function recivedata_v2(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'month' => 'required',
            'year' => 'required'
        ], [
            'month.required' => 'กรุณาระบุเดือน',
            'year.required' => 'กรุณาระบุปี พ.ศ.'
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => 100, 'data' => $validate->errors()->first()]);
        }

        $year = $request->year - 543;
        $month = $request->month;
        //GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID
        $consignments_customer_id1 = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID FROM PTOM_CONSIGNMENT_HEADERS 
        WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
        AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
        AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
        GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID
        ORDER BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID");
        if (empty($consignments_customer_id1)) {
            return response()->json(['status' => 200, 'data' => 'ไม่พบข้อมูล']);
        } else {
            $html = '';
            $setDataByLastDate = [];
            foreach ($consignments_customer_id1 as $key => $consignment1) {
                $customer = Customer::where('customer_id', $consignment1->customer_id)->first();

                if ($customer->customer_type_id == 30) {
                    $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    FROM PTOM_CONSIGNMENT_HEADERS 
                    WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                    AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                    AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                    AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                    GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE DESC 
                    FETCH FIRST 1 ROWS ONLY");
                } else {
                    $consignments_customer_id = DB::select("SELECT PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO  , PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    FROM PTOM_CONSIGNMENT_HEADERS  
                    WHERE UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM' 
                    AND EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year' 
                    AND EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month' 
                    AND PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID = '$consignment1->customer_id' 
                    GROUP BY PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID, PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO ,PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE 
                    ORDER BY PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE DESC 
                    FETCH FIRST 1 ROWS ONLY");
                }

                foreach ($consignments_customer_id as $key_ => $consignment) {
                    if ($customer->customer_type_id == 30) {
                        $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                            ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                            ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                            ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                            ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                            ->first();
                    } else {
                        $last_date = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consignment->customer_id)
                            ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                            ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                            ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                            ->orderBy('ptom_consignment_headers.consignment_date', 'desc')
                            ->first();
                    }

                    $setDataByLastDate[$consignment->customer_id] = [
                        'date' => $last_date->consignment_date ? $last_date->consignment_date : null,
                        'customer_id' => $consignment->customer_id,
                        'customer_number' => $customer->customer_number,
                        'customer_name' => $customer->customer_name,
                        'customer_type_id' => $customer->customer_type_id,
                        'consignment_no' => $customer->customer_type_id != 30 ? $consignment->consignment_no : null,
                        'last_date' => $last_date
                    ];
                }
            }
            sort($setDataByLastDate); //sort by date asc
            $key_index = 0;
            foreach ($setDataByLastDate as $consigeitem) {
                if ($consigeitem['date'] != null) {
                    $d = explode('-', date_format(date_create($consigeitem['date']), 'Y-m-d'));
                    $day = $d[2];
                    $m = $d[1];
                    $y = $d[0] + 543;
                    $fulldate = $day . '/' . $m . '/' . $y;
                } else {
                    $fulldate = '';
                }

                if ($consigeitem['customer_type_id'] == 30) {
                    $vat_ad = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                    $sum_vat = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.TOTAL_AMOUNT');
                    $vat = $vat_ad;
                } else {
                    //ptom_consignment_headers.vat_amount
                    $vatt = ConsignmentHeader::leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->orderBy('ptom_consignment_headers.consignment_date', 'DESC')->first();
                    //ptom_consignment_headers.total_include_vat
                    $sum_vatt = ConsignmentHeader::where('ptom_consignment_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->sum('PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT');
                    $vat = $vatt->vat_amount ?? 0;
                    $vat_ad = $vat ?? 0;
                    $sum_vat = $sum_vatt ?? 0;
                }
                if ($consigeitem['customer_type_id'] == 30) {
                    $vatr = ConsignmentHeader::leftJoin('PTOM_TAX_ADJUSTMENTS_BKK', 'PTOM_TAX_ADJUSTMENTS_BKK.TAX_ADJUSTMENT_NO', 'PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO')
                        ->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")
                        ->where('PTOM_CONSIGNMENT_HEADERS.CUSTOMER_ID', $consigeitem['customer_id'])
                        ->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")
                        ->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")
                        ->sum(DB::raw('nvl(PTOM_TAX_ADJUSTMENTS_BKK.TAX_ADJUST_AMOUNT, PTOM_CONSIGNMENT_HEADERS.VAT_AMOUNT)'));
                    $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                    if ($t > 0) {
                        $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                        // $vatr = $tt->adjust_vat;
                        if ($tt->interface_flag == 'Y') {
                            $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                        } else {
                            $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            if ($tt->attribute2 == 'Y') {
                                $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            } else {
                                $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            }
                        }
                    } else {
                        $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                        $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                    }
                } else {
                    $t = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->count();
                    if ($t > 0) {
                        $tt = TaxAdjustModel::where('document_number', $consigeitem['last_date']->consignment_no)->first();
                        if ($consigeitem['customer_type_id'] == 30) {
                            $vatr = TaxAdjustmentsBKK::join('ptom_consignment_headers', 'ptom_tax_adjustments_bkk.tax_adjustment_no', 'ptom_consignment_headers.consignment_no', 'left')->whereRaw("UPPER(PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS) = 'CONFIRM'")->where('ptom_order_headers.customer_id', $consigeitem['customer_id'])->whereRaw("EXTRACT(YEAR FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$year'")->whereRaw("EXTRACT(MONTH FROM PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE) = '$month'")->where('consignment_no', $consigeitem['last_date']->consignment_no)->sum('ptom_tax_adjustments_bkk.tax_adjust_amount');
                        } else {
                            $vatr = $tt->adjust_vat;
                        }
                        if ($tt->interface_flag == 'Y') {
                            $input1 = "<input type=\"text\" readonly class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            $input2 = "<input type=\"checkbox\" disabled checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",0," . $key_index . "\">";
                        } else {
                            $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vatr ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                            // $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            if ($tt->attribute2 == 'Y') {
                                $input2 = "<input type=\"checkbox\" checked name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            } else {
                                $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                            }
                        }
                    } else {
                        $input1 = "<input type=\"text\" class=\"form-control text-right\" name=\"adjust_amount[]\" value=\"" . number_format($vat_ad ?? 0, 2) . "\" onkeyup=\"numericonly(this,this.value);\" onchange=\"tofixed2(this,this.value);\" autocomplete=\"off\">";
                        $input2 = "<input type=\"checkbox\" name=\"adjust_select[]\" onclick=\"checkid(" . $consigeitem['last_date']->consignment_header_id . ");\" value=\"" . $consigeitem['last_date']->consignment_header_id . ",1," . $key_index . "\">";
                    }
                }
                $html .= "<tr class=\"align-middle\" id=\"" . $consigeitem['last_date']->consignment_header_id . "\"><td class=\"text-left\">" . $consigeitem['customer_number'] . "</td><td class=\"text-left\">" . $consigeitem['customer_name'] . "</td><td>" . $fulldate . "</td> <td class=\"text-right\">" . number_format($sum_vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"total_vat[]\" value=\"" . number_format($sum_vat ?? 0, 2) . "\"></td><td class=\"text-right\">" . number_format($vat ?? 0, 2) . "<input type=\"hidden\" class=\"form-control text-right\" name=\"tax_amount[]\" value=\"" . number_format($vat ?? 0, 2) . "\"></td><td>" . $input1 . "</td><td>" . $input2 . "</td></tr>";
                $key_index += 1;
            }
            return response()->json(['status' => 200, 'data' => json_decode(json_encode($html))]);
        }

        return response()->json(['status' => 400, 'data' => 'Something wrong!!']);
    }

    public function savedata(Request $request)
    {
        $user_id = getDefaultData('/users')->user_id;
        $validate = Validator::make($request->all(), [
            'adjust_amount.*' => 'required'
        ], [
            'adjust_amount.*.required' => 'กรุณาเลือกรายการที่ต้องการดำเนินการ'
        ]);
        if ($validate->fails()) {
            $requests = $request->all();
            $request->session()->flashInput($requests);
            return back()->withErrors($validate->errors()->first());
        }
        $formatgroup = draftGroupIDTaxAdjust();

        $id_old = explode(',', $request->id_old);

        foreach ($request->adjust_select as $key => $id) {
            $exp = explode(',', $id);
            $keys = $exp[2];
            if ($exp[1] == 1) {
                $index_arr = array_search($exp[0], $id_old);
                if ($index_arr !== false) {
                    unset($id_old[$index_arr]);
                }
                $taxAdjust = ConsignmentLines::leftJoin('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', 'ptom_consignment_headers.consignment_header_id')->leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')->leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')->where('ptom_consignment_headers.consignment_header_id', $exp[0])->groupBy(['ptom_consignment_headers.consignment_no', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.consignment_header_id', 'ptom_consignment_headers.consignment_date', 'ptom_order_headers.currency'])->get(['ptom_consignment_headers.consignment_no', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.consignment_header_id', 'ptom_consignment_headers.consignment_date', 'ptom_order_headers.currency']);

                if (!empty($taxAdjust) && count($taxAdjust) != 0) {
                    foreach ($taxAdjust as $value) {
                        $foud_info = TaxAdjustModel::where('document_number', $value->consignment_no)->first();
                        if (empty($foud_info)) {
                            $tax = TaxAdjustModel::create([
                                'interface_module' => 'GL',
                                'from_program_code' => 'OMP0043',
                                'document_number' => $value->consignment_no,
                                'customer_id' => $value->customer_id,
                                'customer_type_id' => $value->customer_type_id,
                                'group_id' => $formatgroup,
                                'remark' => 'บันทึกปรับภาษีขายที่สโมสร',
                                'order_header_id' => $value->consignment_header_id,
                                'tax_amount' => str_replace(',', '', $request->tax_amount[$keys]),
                                'consignment_date' => $value->consignment_date,
                                'interface_date' => $value->consignment_date,
                                'total_vat' => str_replace(',', '', $request->total_vat[$keys]),
                                'adjust_vat' => str_replace(',', '', number_format(abs(str_replace(',', '', $request->adjust_amount[$keys])), 2)),
                                'attribute1' => str_replace(',', '', number_format(str_replace(',', '', $request->adjust_amount[$keys]) - str_replace(',', '', $request->tax_amount[$keys]), 2)),
                                'attribute2' => 'Y',
                                'program_code' => 'OMP0043',
                                'created_by' => $user_id,
                                'last_updated_by' => $user_id
                            ]);
                        } else {
                            $foud_info->group_id = $formatgroup;
                            $foud_info->tax_amount = str_replace(',', '', $request->tax_amount[$keys]);
                            $foud_info->total_vat = str_replace(',', '', $request->total_vat[$keys]);
                            $foud_info->adjust_vat = str_replace(',', '', number_format(abs(str_replace(',', '', $request->adjust_amount[$keys])), 2));
                            $foud_info->attribute1 = str_replace(',', '', number_format(str_replace(',', '', $request->adjust_amount[$keys]) - str_replace(',', '', $request->tax_amount[$keys]), 2));
                            $foud_info->attribute2 = 'Y';
                            $foud_info->last_updated_by = $user_id;
                            $foud_info->save();
                        }
                    }
                }
            }
        }
        if (count($id_old) != 0) {
            foreach ($id_old as $id) {
                $foud_info = TaxAdjustModel::where('order_header_id', $id)->first();
                if (!empty($foud_info)) {
                    $foud_info->attribute2 = 'N';
                    $foud_info->last_updated_by = $user_id;
                    $foud_info->save();
                }
            }
        }

        $requestss = $request->all();
        // $requestss['input_groupid'] = $formatgroup;
        $request->session()->flashInput($requestss);

        return redirect()->to('/om/tax-adjust?input_month=' . $request->input_month . '&input_year=' . $request->input_year);
    }

    public function senddata(Request $request)
    {
        $user_id = getDefaultData('/users')->user_id;
        $validate = Validator::make($request->all(), [
            'adjust_amount.*' => 'required'
        ], [
            'adjust_amount.*.required' => 'กรุณาเลือกรายการที่ต้องการดำเนินการ'
        ]);
        if ($validate->fails()) {
            $requests = $request->all();
            $request->session()->flashInput($requests);
            return back()->withErrors($validate->errors()->first());
        }
        $formatgroup = draftGroupIDTaxAdjust();

        $tax_ids = collect();

        foreach ($request->adjust_select as $key => $id) {
            $exp = explode(',', $id);
            $keys = $exp[2];
            if ($exp[1] == 1) {
                $taxAdjust = ConsignmentLines::leftJoin('ptom_consignment_headers', 'ptom_consignment_lines.consignment_header_id', 'ptom_consignment_headers.consignment_header_id')
                    ->leftJoin('ptom_order_headers', 'ptom_consignment_headers.order_header_id', 'ptom_order_headers.order_header_id')
                    ->leftJoin('ptom_customers', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_id')
                    ->where('ptom_consignment_headers.consignment_header_id', $exp[0])
                    ->groupBy(['ptom_consignment_headers.consignment_no', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.consignment_header_id', 'ptom_consignment_headers.consignment_date', 'ptom_order_headers.currency'])
                    ->get(['ptom_consignment_headers.consignment_no', 'ptom_consignment_headers.customer_id', 'ptom_customers.customer_type_id', 'ptom_consignment_headers.consignment_header_id', 'ptom_consignment_headers.consignment_date', 'ptom_order_headers.currency']);

                $number_je_num = 0;
                if (!empty($taxAdjust) && count($taxAdjust) != 0) {
                    foreach ($taxAdjust as $keyTax => $value) {
                        $interface_date = Carbon::now()->timezone('Asia/Bangkok');
                        $foud_info = TaxAdjustModel::where('document_number', $value->consignment_no)->first();
                        if (empty($foud_info)) {
                            $tax = TaxAdjustModel::create([
                                'interface_module' => 'GL',
                                'from_program_code' => 'OMP0043',
                                'document_number' => $value->consignment_no,
                                'customer_id' => $value->customer_id,
                                'customer_type_id' => $value->customer_type_id,
                                'group_id' => $formatgroup,
                                'remark' => 'บันทึกปรับภาษีขายที่สโมสร',
                                'order_header_id' => $value->consignment_header_id,
                                'tax_amount' => str_replace(',', '', $request->tax_amount[$keys]),
                                'consignment_date' => $value->consignment_date,
                                'interface_date' => $value->consignment_date,
                                'total_vat' => str_replace(',', '', $request->total_vat[$keys]),
                                'adjust_vat' => str_replace(',', '', number_format(abs(str_replace(',', '', $request->adjust_amount[$keys])), 2)),
                                'attribute1' => str_replace(',', '', number_format(str_replace(',', '', $request->adjust_amount[$keys]) - str_replace(',', '', $request->tax_amount[$keys]), 2)),
                                'program_code' => 'OMP0043',
                                'created_by' => $user_id,
                                'last_updated_by' => $user_id
                            ]);
                        } else {
                            $tax = $foud_info;
                            $foud_info->group_id = $formatgroup;
                            $foud_info->tax_amount = str_replace(',', '', $request->tax_amount[$keys]);
                            $foud_info->total_vat = str_replace(',', '', $request->total_vat[$keys]);
                            $foud_info->adjust_vat = str_replace(',', '', number_format(abs(str_replace(',', '', $request->adjust_amount[$keys])), 2));
                            $foud_info->attribute1 = str_replace(',', '', number_format(str_replace(',', '', $request->adjust_amount[$keys]) - str_replace(',', '', $request->tax_amount[$keys]), 2));
                            $foud_info->last_updated_by = $user_id;
                            $foud_info->save();
                        }

                        $org_id = DB::select("SELECT ORGANIZATION_ID FROM OAOM.PTOM_OPERATING_UNITS_V WHERE SHORT_CODE = 'TOAT'");

                        if ($tax) {

                            if(in_array($tax->customer_type_id, ['30'])){

                                $date = CarBon::parse($tax->interface_date)->format('m-Y');
                                $query = TaxAdjustmentsBKK::whereRaw("
                                    trunc(tax_adjustment_date) between to_date('01-$date', 'dd-mm-yyyy') and last_day(to_date('$date', 'mm-yyyy'))
                                    and upper(post_flag) = 'Y'
                                ")
                                ->get();

                                foreach ($query as $key => $item) {

                                    $sum = round((float)$item->vat_amount - (float)$item->tax_adjust_amount, 2);
                                    $amount = round(abs((float)$item->vat_amount - (float)$item->tax_adjust_amount), 2);
                                    if($amount == 0) continue;

                                    if ($item->tax_adjustment_no == null) {
                                        $sum_base_vat = '0.00';
                                    } else {
                                        $base_vat = DB::select("
                                            SELECT 
                                                CONSIGNMENT_NO 
                                                ,SUM(PTOM_SO_OUTSTANDING_V.BASE_VAT) BASE_VAT 
                                            FROM PTOM_SO_OUTSTANDING_V 
                                            WHERE CONSIGNMENT_NO = '" . $item->tax_adjustment_no . "' 
                                            GROUP BY CONSIGNMENT_NO
                                        ");
                                        $sum_base_vat = round($base_vat[0]->base_vat, 2);
                                    }
                                    $number_je_num++;

                                    $period = strtoupper(Carbon::parse($item->tax_adjustment_date)->format('M-y'));
                                    $y543 = Carbon::parse($item->tax_adjustment_date)->format('Y') + 543;
                                    $dm543 = Carbon::parse($item->tax_adjustment_date)->format('d/m');

                                    $cr_segment9 = $this->segment($value->customer_id, 9, $sum, 'cr', $interface_date);

                                    //insert into PTOM_GL_INTERFACES
                                    $glInterfaceCredit = [
                                        'org_id' => $org_id[0]->organization_id ?? '',
                                        'group_id' => $formatgroup,
                                        'interface_module' => 'GL',
                                        'ledger_name' => 'การยาสูบแห่งประเทศไทย',
                                        // 'accounting_date' => $interface_date,
                                        'accounting_date' => $item->tax_adjustment_date,
                                        'period_name' => $period,
                                        // 'currency_code' => $value->currency,
                                        'currency_code' => 'THB',
                                        'actual_flag' => 'A',
                                        'user_je_category_name' => 'WEB OP Sales Invoice',
                                        'user_je_source_name' => 'WEB ระบบขาย',
                                        'batch_name' => 'รายการปรับภาษีขาย ' . $dm543 . '/' . $y543,
                                        // 'batch_description' => 'บันทึกรายการปรับภาษีขาย',
                                        'journal_name' => $tax->remark . ' ' . $dm543 . '/' . $y543,
                                        'journal_description_head' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . $dm543 . '/' . $y543,
                                        'journal_description_line' => 'Journal Import Created',
                                        'je_line_num' => $number_je_num,
                                        'entered_cr' => $amount,
                                        'accounted_cr' => $amount,
                                        'reference1' => 'รายการปรับภาษีขาย',
                                        'reference2' => 'บันทึกรายการปรับภาษีขาย',
                                        'reference4' => 'บันทึกปรับภาษีขายที่สโมสร',
                                        'reference5' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . date('d/m/Y'),
                                        'line_attribute1' => $cr_segment9 == '214001' ? '05' : '', // $sum_base_vat,
                                        'line_attribute2' => $cr_segment9 == '214001' ? $item->tax_adjustment_no : '', // $item->tax_adjustment_no,
                                        'line_attribute3' => $cr_segment9 == '214001' ? $sum : '', // $amount,
                                        'line_attribute4' => $cr_segment9 == '214001' ? '7' : '', // 'SVAT-G7',
                                        'line_attribute5' => $cr_segment9 == '214001' ? 'SVAT-G7' : '', // '7',
                                        'line_attribute6' => '', // $formatgroup,
                                        'program_code' => 'OMP0043',
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'web_batch_no' => $formatgroup,
                                        'segment1' => $this->segment($value->customer_id, 1, $sum, 'cr', $interface_date),
                                        'segment2' => $this->segment($value->customer_id, 2, $sum, 'cr', $interface_date),
                                        'segment3' => $this->segment($value->customer_id, 3, $sum, 'cr', $interface_date),
                                        'segment4' => $this->segment($value->customer_id, 4, $sum, 'cr', $interface_date),
                                        'segment5' => $this->segment($value->customer_id, 5, $sum, 'cr', $interface_date),
                                        'segment6' => $this->segment($value->customer_id, 6, $sum, 'cr', $interface_date),
                                        'segment7' => $this->segment($value->customer_id, 7, $sum, 'cr', $interface_date),
                                        'segment8' => $this->segment($value->customer_id, 8, $sum, 'cr', $interface_date),
                                        'segment9' => $cr_segment9,
                                        'segment10' => $this->segment($value->customer_id, 10, $sum, 'cr', $interface_date),
                                        'segment11' => $this->segment($value->customer_id, 11, $sum, 'cr', $interface_date),
                                        'segment12' => $this->segment($value->customer_id, 12, $sum, 'cr', $interface_date),
                                    ];
                                    GLInterfaceModel::create($glInterfaceCredit);
                                    PTOM_GL_INTERFACES_REPORT::create($glInterfaceCredit);

                                    $dr_segment9 = $this->segment($value->customer_id, 9, $sum, 'dr', $interface_date);

                                    $number_je_num++;
                                    $glInterfaceDebit = [
                                        'org_id' => $org_id[0]->organization_id ?? '',
                                        'group_id' => $formatgroup,
                                        'interface_module' => 'GL',
                                        'ledger_name' => 'การยาสูบแห่งประเทศไทย',
                                        // 'accounting_date' => $interface_date,
                                        'accounting_date' => $item->tax_adjustment_date,
                                        'period_name' => $period,
                                        // 'currency_code' => $value->currency,
                                        'currency_code' => 'THB',
                                        'actual_flag' => 'A',
                                        'user_je_category_name' => 'WEB OP Sales Invoice',
                                        'user_je_source_name' => 'WEB ระบบขาย',
                                        'batch_name' => 'รายการปรับภาษีขาย ' . $dm543 . '/' . $y543,
                                        // 'batch_description' => 'บันทึกรายการปรับภาษีขาย',
                                        'journal_name' => $tax->remark . ' ' . $dm543 . '/' . $y543,
                                        'journal_description_head' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . $dm543 . '/' . $y543,
                                        'journal_description_line' => 'Journal Import Created',
                                        'je_line_num' => $number_je_num,
                                        'entered_dr' => $amount,
                                        'accounted_dr' => $amount,
                                        'reference1' => 'รายการปรับภาษีขาย',
                                        'reference2' => 'บันทึกรายการปรับภาษีขาย',
                                        'reference4' => 'บันทึกปรับภาษีขายที่สโมสร',
                                        'reference5' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . date('d/m/Y'),
                                        'program_code' => 'OMP0043',
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'web_batch_no' => $formatgroup,
                                        'line_attribute1' => $dr_segment9 == '214001' ? '05' : '', // $sum_base_vat,
                                        'line_attribute2' => $dr_segment9 == '214001' ? $item->tax_adjustment_no : '', // $item->tax_adjustment_no,
                                        'line_attribute3' => $dr_segment9 == '214001' ? $sum : '', // $amount,
                                        'line_attribute4' => $dr_segment9 == '214001' ? '7' : '', // 'SVAT-G7',
                                        'line_attribute5' => $dr_segment9 == '214001' ? 'SVAT-G7' : '', // '7',
                                        'line_attribute6' => '', // $formatgroup,
                                        'segment1' => $this->segment($value->customer_id, 1, $sum, 'dr', $interface_date),
                                        'segment2' => $this->segment($value->customer_id, 2, $sum, 'dr', $interface_date),
                                        'segment3' => $this->segment($value->customer_id, 3, $sum, 'dr', $interface_date),
                                        'segment4' => $this->segment($value->customer_id, 4, $sum, 'dr', $interface_date),
                                        'segment5' => $this->segment($value->customer_id, 5, $sum, 'dr', $interface_date),
                                        'segment6' => $this->segment($value->customer_id, 6, $sum, 'dr', $interface_date),
                                        'segment7' => $this->segment($value->customer_id, 7, $sum, 'dr', $interface_date),
                                        'segment8' => $this->segment($value->customer_id, 8, $sum, 'dr', $interface_date),
                                        'segment9' => $dr_segment9,
                                        'segment10' => $this->segment($value->customer_id, 10, $sum, 'dr', $interface_date),
                                        'segment11' => $this->segment($value->customer_id, 11, $sum, 'dr', $interface_date),
                                        'segment12' => $this->segment($value->customer_id, 12, $sum, 'dr', $interface_date),
                                    ];
                                    GLInterfaceModel::create($glInterfaceDebit);
                                    PTOM_GL_INTERFACES_REPORT::create($glInterfaceDebit);
                                }

                            }else {

                                if ($tax->document_number == null) {
                                    $sum_base_vat = '0.00';
                                } else {
                                    $base_vat = DB::select("SELECT CONSIGNMENT_NO ,SUM(PTOM_SO_OUTSTANDING_V.BASE_VAT) BASE_VAT FROM PTOM_SO_OUTSTANDING_V WHERE CONSIGNMENT_NO = '" . $tax->document_number . "' GROUP BY CONSIGNMENT_NO");
                                    $sum_base_vat = str_replace(',', '', number_format($base_vat[0]->base_vat, 2));
                                }

                                if (str_replace(',', '', number_format(str_replace(',', '', $request->tax_amount[$keys]) - str_replace(',', '', $request->adjust_amount[$keys]), 2)) != 0) {
                                    $value_ad_tax = str_replace(',', '', number_format(str_replace(',', '', $request->tax_amount[$keys]) - str_replace(',', '', $request->adjust_amount[$keys]), 2));
                                    $number_je_num++;

                                    $amount = str_replace(',', '', number_format(abs($value_ad_tax), 2));

                                    $period = strtoupper(Carbon::parse($tax->interface_date)->format('M-y'));
                                    $y543 = Carbon::parse($tax->interface_date)->format('Y') + 543;
                                    $dm543 = Carbon::parse($tax->interface_date)->format('d/m');

                                    $cr_segment9 = $this->segment($value->customer_id, 9, $value_ad_tax, 'cr', $interface_date);
                                    //insert into PTOM_GL_INTERFACES
                                    $glInterfaceCredit = [
                                        'org_id' => $org_id[0]->organization_id ?? '',
                                        'group_id' => $formatgroup,
                                        'interface_module' => 'GL',
                                        'ledger_name' => 'การยาสูบแห่งประเทศไทย',
                                        // 'accounting_date' => $interface_date,
                                        'accounting_date' => $tax->interface_date,
                                        'period_name' => $period,
                                        // 'currency_code' => $value->currency,
                                        'currency_code' => 'THB',
                                        'actual_flag' => 'A',
                                        'user_je_category_name' => 'WEB OP Sales Invoice',
                                        'user_je_source_name' => 'WEB ระบบขาย',
                                        'batch_name' => 'รายการปรับภาษีขาย ' . $dm543 . '/' . $y543,
                                        // 'batch_description' => 'บันทึกรายการปรับภาษีขาย',
                                        'journal_name' => $tax->remark . ' ' . $dm543 . '/' . $y543,
                                        'journal_description_head' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . $dm543 . '/' . $y543,
                                        'journal_description_line' => 'Journal Import Created',
                                        'je_line_num' => $number_je_num,
                                        'entered_cr' => $amount,
                                        'accounted_cr' => $amount,
                                        'reference1' => 'รายการปรับภาษีขาย',
                                        'reference2' => 'บันทึกรายการปรับภาษีขาย',
                                        'reference4' => 'บันทึกปรับภาษีขายที่สโมสร',
                                        'reference5' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . date('d/m/Y'),
                                        'line_attribute1' => '', // $cr_segment9 == '214001' ? '05' : '',
                                        'line_attribute2' => '', // $cr_segment9 == '214001' ? $tax->document_number : '',
                                        'line_attribute3' => '', // $cr_segment9 == '214001' ? round(abs($tax->adjust_vat - $tax->tax_amount), 2) : '', // round(abs($tax->adjust_vat - $tax->tax_amount), 2),
                                        'line_attribute4' => '', // $cr_segment9 == '214001' ? '7' : '', // 'SVAT-G7',
                                        'line_attribute5' => '', // $cr_segment9 == '214001' ? 'SVAT-G7' : '', // '7',
                                        'line_attribute6' => '', // $formatgroup,
                                        'program_code' => 'OMP0043',
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'web_batch_no' => $formatgroup,
                                        'segment1' => $this->segment($value->customer_id, 1, $value_ad_tax, 'cr', $interface_date),
                                        'segment2' => $this->segment($value->customer_id, 2, $value_ad_tax, 'cr', $interface_date),
                                        'segment3' => $this->segment($value->customer_id, 3, $value_ad_tax, 'cr', $interface_date),
                                        'segment4' => $this->segment($value->customer_id, 4, $value_ad_tax, 'cr', $interface_date),
                                        'segment5' => $this->segment($value->customer_id, 5, $value_ad_tax, 'cr', $interface_date),
                                        'segment6' => $this->segment($value->customer_id, 6, $value_ad_tax, 'cr', $interface_date),
                                        'segment7' => $this->segment($value->customer_id, 7, $value_ad_tax, 'cr', $interface_date),
                                        'segment8' => $this->segment($value->customer_id, 8, $value_ad_tax, 'cr', $interface_date),
                                        'segment9' => $cr_segment9,
                                        'segment10' => $this->segment($value->customer_id, 10, $value_ad_tax, 'cr', $interface_date),
                                        'segment11' => $this->segment($value->customer_id, 11, $value_ad_tax, 'cr', $interface_date),
                                        'segment12' => $this->segment($value->customer_id, 12, $value_ad_tax, 'cr', $interface_date),
                                    ];
                                    GLInterfaceModel::create($glInterfaceCredit);
                                    PTOM_GL_INTERFACES_REPORT::create($glInterfaceCredit);

                                    $dr_segment9 = $this->segment($value->customer_id, 9, $value_ad_tax, 'dr', $interface_date);
                                    $number_je_num++;
                                    $glInterfaceDebit = [
                                        'org_id' => $org_id[0]->organization_id ?? '',
                                        'group_id' => $formatgroup,
                                        'interface_module' => 'GL',
                                        'ledger_name' => 'การยาสูบแห่งประเทศไทย',
                                        // 'accounting_date' => $interface_date,
                                        'accounting_date' => $tax->interface_date,
                                        'period_name' => $period,
                                        // 'currency_code' => $value->currency,
                                        'currency_code' => 'THB',
                                        'actual_flag' => 'A',
                                        'user_je_category_name' => 'WEB OP Sales Invoice',
                                        'user_je_source_name' => 'WEB ระบบขาย',
                                        'batch_name' => 'รายการปรับภาษีขาย ' . $dm543 . '/' . $y543,
                                        // 'batch_description' => 'บันทึกรายการปรับภาษีขาย',
                                        'journal_name' => $tax->remark . ' ' . $dm543 . '/' . $y543,
                                        'journal_description_head' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . $dm543 . '/' . $y543,
                                        'journal_description_line' => 'Journal Import Created',
                                        'je_line_num' => $number_je_num,
                                        'entered_dr' => $amount,
                                        'accounted_dr' => $amount,
                                        'reference1' => 'รายการปรับภาษีขาย',
                                        'reference2' => 'บันทึกรายการปรับภาษีขาย',
                                        'reference4' => 'บันทึกปรับภาษีขายที่สโมสร',
                                        'reference5' => 'บันทึกปรับยอดภาษีขายที่นำส่งของสโมสร สำหรับวันที่ ' . date('d/m/Y'),
                                        'program_code' => 'OMP0043',
                                        'created_by' => $user_id,
                                        'last_updated_by' => $user_id,
                                        'web_batch_no' => $formatgroup,
                                        'line_attribute1' => '', // $dr_segment9 == '214001' ? '05' : '', // $sum_base_vat,
                                        'line_attribute2' => '', // $dr_segment9 == '214001' ? $tax->document_number : '', // $tax->document_number,
                                        'line_attribute3' => '', // $dr_segment9 == '214001' ? round(abs($tax->adjust_vat - $tax->tax_amount), 2) : '', // round(abs($tax->adjust_vat - $tax->tax_amount), 2),
                                        'line_attribute4' => '', // $dr_segment9 == '214001' ? '7' : '', // 'SVAT-G7',
                                        'line_attribute5' => '', // $dr_segment9 == '214001' ? 'SVAT-G7' : '', // '7',
                                        'line_attribute6' => '', // $formatgroup,
                                        'segment1' => $this->segment($value->customer_id, 1, $value_ad_tax, 'dr', $interface_date),
                                        'segment2' => $this->segment($value->customer_id, 2, $value_ad_tax, 'dr', $interface_date),
                                        'segment3' => $this->segment($value->customer_id, 3, $value_ad_tax, 'dr', $interface_date),
                                        'segment4' => $this->segment($value->customer_id, 4, $value_ad_tax, 'dr', $interface_date),
                                        'segment5' => $this->segment($value->customer_id, 5, $value_ad_tax, 'dr', $interface_date),
                                        'segment6' => $this->segment($value->customer_id, 6, $value_ad_tax, 'dr', $interface_date),
                                        'segment7' => $this->segment($value->customer_id, 7, $value_ad_tax, 'dr', $interface_date),
                                        'segment8' => $this->segment($value->customer_id, 8, $value_ad_tax, 'dr', $interface_date),
                                        'segment9' => $dr_segment9,
                                        'segment10' => $this->segment($value->customer_id, 10, $value_ad_tax, 'dr', $interface_date),
                                        'segment11' => $this->segment($value->customer_id, 11, $value_ad_tax, 'dr', $interface_date),
                                        'segment12' => $this->segment($value->customer_id, 12, $value_ad_tax, 'dr', $interface_date),
                                    ];
                                    GLInterfaceModel::create($glInterfaceDebit);
                                    PTOM_GL_INTERFACES_REPORT::create($glInterfaceDebit);
                                }
                            }
                            // $value->consignment_date
                            // TaxAdjustModel::find($tax->interface_id)->update(['interface_flag' => 'Y', 'interface_date' => $interface_date]);
                            // TaxAdjustModel::find($tax->interface_id)->update(['interface_flag' => 'Y']);
                            $tax_ids->push($tax->interface_id);
                        } else {
                            return back()->withErrors('เกิดข้อผิดพลาดไม่สามารถดำเนินการบันทึกข้อมูลได้')->withInput($request->all());
                        }
                    }
                } else {
                    return back()->withErrors('เกิดข้อผิดพลาด ไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้ง')->withInput($request->all());
                }
            }
        }
        $requestss = $request->all();
        // $requestss['input_groupid'] = $formatgroup;
        // $request->session()->flashInput($requestss);

        OracleCall::callpakcagesOMP0043($formatgroup);

        $GLinter = GLInterfaceModel::where('program_code', 'OMP0043')->where('web_batch_no', $formatgroup)->get();
        $statusFalue = false;
        $statusTrue = false;
        $errorMSg = '';
        foreach ($GLinter as $Glitem) {
            if ($Glitem->interface_status == 'E') {
                $statusFalue = true;
                $errorMSg .= $Glitem->interfaced_msg . '<br>';
            }
            if ($Glitem->interface_status == 'C') {
                $statusTrue = true;
            }
        }

        if ($statusTrue && !$statusFalue) {
            TaxAdjustModel::whereIn('interface_id', $tax_ids)->update(['interface_flag' => 'Y']);
            $requestss['input_groupid'] = $formatgroup;
            $requestss['input_groupid_status'] = false;
            $requestss['input_groupid_err_msg'] = '';
        } else {
            $requestss['input_groupid'] = '';
            $requestss['input_groupid_status'] = true;
            $requestss['input_groupid_err_msg'] = $errorMSg . ' Group ID ' . $formatgroup;
        }

        $request->session()->flashInput($requestss);
        return redirect()->to('/om/tax-adjust?input_month=' . $request->input_month . '&input_year=' . $request->input_year);
    }

    private function segment($customer_id, $number, $sum, $type, $interface_date)
    {
        if ($sum > 0) {
            //ค่าบวก
            if ($type == 'cr') {
                $db = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-Sales Invoice-15'");
            } else {
                $db = DB::select("SELECT * FROM PTOM_CUSTOMER_AGENTS WHERE CUSTOMER_ID = '" . $customer_id . "'");
            }

            if ($number == 1) {
                return $db[0]->segment1 ?? '';
            } elseif ($number == 2) {
                return $db[0]->segment2 ?? '';
            } elseif ($number == 3) {
                return $db[0]->segment3 ?? '';
            } elseif ($number == 4) {
                return $db[0]->segment4 ?? '';
            } elseif ($number == 5) {
                if ($type == 'cr') {
                    $m = Carbon::parse($interface_date)->format('m');
                    $y = Carbon::parse($interface_date)->format('Y');
                    $yy = substr($y + 543, 2);
                    if ($m == 10 || $m == 11 || $m == 12) {
                        $yyy = $yy + 1;
                    } else {
                        $yyy = $yy;
                    }
                    return $yyy;
                } else {
                    return $db[0]->segment5 ?? '';
                }
            } elseif ($number == 6) {
                return $db[0]->segment6 ?? '';
            } elseif ($number == 7) {
                return $db[0]->segment7 ?? '';
            } elseif ($number == 8) {
                return $db[0]->segment8 ?? '';
            } elseif ($number == 9) {
                return $db[0]->segment9 ?? '';
            } elseif ($number == 10) {
                return $db[0]->segment10 ?? '';
            } elseif ($number == 11) {
                return $db[0]->segment11 ?? '';
            } elseif ($number == 12) {
                return $db[0]->segment12 ?? '';
            }
        } else {
            //ค่าลบ
            if ($type == 'cr') {
                $db = DB::select("SELECT * FROM PTOM_CUSTOMER_AGENTS WHERE CUSTOMER_ID = '" . $customer_id . "'");
            } else {
                $db = DB::select("SELECT * FROM PTOM_MAPPING_ACCOUNT_CODE_GL WHERE ACCOUNT_CODE = 'TRX-DOM-Sales Invoice-15'");
            }

            if ($number == 1) {
                return $db[0]->segment1 ?? '';
            } elseif ($number == 2) {
                return $db[0]->segment2 ?? '';
            } elseif ($number == 3) {
                return $db[0]->segment3 ?? '';
            } elseif ($number == 4) {
                return $db[0]->segment4 ?? '';
            } elseif ($number == 5) {
                if ($type == 'cr') {
                    return $db[0]->segment5 ?? '';
                } else {
                    $m = Carbon::parse($interface_date)->format('m');
                    $y = Carbon::parse($interface_date)->format('Y');
                    $yy = substr($y + 543, 2);
                    if ($m == 10 || $m == 11 || $m == 12) {
                        $yyy = $yy + 1;
                    } else {
                        $yyy = $yy;
                    }
                    return $yyy;
                }
            } elseif ($number == 6) {
                return $db[0]->segment6 ?? '';
            } elseif ($number == 7) {
                return $db[0]->segment7 ?? '';
            } elseif ($number == 8) {
                return $db[0]->segment8 ?? '';
            } elseif ($number == 9) {
                return $db[0]->segment9 ?? '';
            } elseif ($number == 10) {
                return $db[0]->segment10 ?? '';
            } elseif ($number == 11) {
                return $db[0]->segment11 ?? '';
            } elseif ($number == 12) {
                return $db[0]->segment12 ?? '';
            }
        }
    }
}
