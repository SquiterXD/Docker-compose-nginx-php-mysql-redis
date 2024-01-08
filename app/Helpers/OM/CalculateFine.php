<?php

function calFineTest($list)
{
    $penaltyRate = App\Models\OM\PenaltyRateDomesticV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();
    
    if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
        if ($list->consignment_no) {

            if ($list->customer_type_id == 30) {
                
                $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();

                if ($list->payment_type_code == 10) {
                    $amount = $header->total_include_vat;
                } else {
                    $amount = $header->grand_total;
                }
            }else {
                $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();
                $amount = $header->total_include_vat;
            }

            $current_date   = date_create(date('Y-m-d'));
            $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
            $diffDate       = date_diff($current_date, $due_date);

            // dd($list->order_date, $list->due_date, explode('-', $list->due_date));

            $order_date = explode('-', $list->due_date);
            $startDate  = date_create($order_date[0] . "-12-31");
            $endDate    = date_create($order_date[0] + 1 . "-12-31");
            $diff       = date_diff($startDate, $endDate);

            $outstanding_debt = $list->outstanding_debt;
            $cal              = $outstanding_debt * $penaltyRate->description / 100;
            $sum              = $cal / $diff->days;

            
            if ($diffDate->format("%R%a") > 0) {
                return $total = 0;
            } else {
                $totalPayments = [];

                $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                            ->where('credit_group_code', $list->credit_group_code)
                                            ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                            ->get();

                $i = 1;                            
                if ($paymentMatchInvoices->isNotEmpty()) {

                    $oldPaymentDate = '';

                    foreach ($paymentMatchInvoices as $paymentMatch) {
                        $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                        $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                        $paymentDiffDate    = date_diff($payment_date, $due_date);
                        
                        if ($i == 1) {
                            $payment_amount = $amount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;
                            $total = $sum * $paymentDiffDate->days;


                            // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                        }
                        else {
                            
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);


                            $calAmount      =  $amount - $oldAmount;
                            $payment_amount = $calAmount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;

                            $total = $sum * $paymentDiffDate->days;
                        }

                        array_push($totalPayments, $total);

                        $oldAmount      = $paymentMatch->payment_amount;
                        $oldPaymentDate = $paymentMatch->creation_date;

                        $i += 1;
                    }

                    if ($outstanding_debt > 0) {

                        $payment_date       = date_create(date('Y-m-d'));
                        $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                        $paymentDiffDate    = date_diff($payment_date, $due_date);

                        $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                        $sum   = $payment_amount / $diff->days;

                        $total = $sum * $paymentDiffDate->days;

                        array_push($totalPayments, $total);
                        
                    }
                    
                    return array_sum($totalPayments);

                } else {
                    return $total = $sum * $diffDate->days;
                }
            }
        } else {
            $total = 0;
            
            return $total;
        }

    } else {
        if ($list->credit_group_code == 0) {
            return $total = 0;
        } else {
            $total = 0;
            

            if ($list->pick_release_no) {

                $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();                
                
                if ($header->payment_type_code == 10) {

                    $amount = $header->grand_total;

                } else {
                    $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
                                                            ->where('credit_group_code', $list->credit_group_code)
                                                            ->where('order_line_id', 0)
                                                            ->first();
                    
                    $amount = $orderCredit->amount;
                }
                

                $current_date   = date_create(date('Y-m-d'));
                $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                $diffDate       = date_diff($current_date, $due_date);

                $order_date = explode('-', $list->due_date);
                $startDate  = date_create($order_date[0] . "-12-31");
                $endDate    = date_create($order_date[0] + 1 . "-12-31");
                $diff       = date_diff($startDate, $endDate);

                $outstanding_debt = $list->outstanding_debt;
                $cal              = $outstanding_debt * $penaltyRate->description / 100;
                $sum              = $cal / $diff->days;
                
                if ($diffDate->format("%R%a") > 0) {
                    return $total = 0;
                } else {
                    
                    $totalPayments = [];

                    $oldAmount = '';
                    // credit_group_code
                    $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                                ->where('credit_group_code', $list->credit_group_code)
                                                // ->where('credit_group_code', 3)
                                                ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                ->orderBy('creation_date', 'asc')
                                                ->get();
                    // dd($paymentMatchInvoices);
                                                
                    $i = 1;
                    if ($paymentMatchInvoices->isNotEmpty()) {
                        $oldPaymentDate = '';

                        foreach ($paymentMatchInvoices as $paymentMatch) {
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);
                            
                            if ($i == 1) {
                                $payment_amount = $amount * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $total = $sum * $paymentDiffDate->days;
                                // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                            }
                            else {
                                
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                // dd($paymentMatch->creation_date);


                                $calAmount =  $amount - $oldAmount;
                                $payment_amount = $calAmount * $penaltyRate->description / 100;
                                // $payment_amount = $amount - $oldAmount * 15 / 100;

                                $sum   = $payment_amount / $diff->days;

                                $total = $sum * $paymentDiffDate->days;

                                // dd($i, $amount, $oldAmount, $amount - $oldAmount, $total);

                                // dd($t, $payment_amountx, $payment_amount);

                                // dd($i, $amount - $oldAmount, $payment_amount, $total);
                            }

                            array_push($totalPayments, $total);

                            $oldAmount      = $paymentMatch->payment_amount;
                            $oldPaymentDate = $paymentMatch->creation_date;

                            $i += 1;
                        }

                        // dd($totalPayments, $oldAmount);

                        if ($outstanding_debt > 0) {

                            $payment_date       = date_create(date('Y-m-d'));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);

                            $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;

                            $total = $sum * $paymentDiffDate->days;

                            array_push($totalPayments, $total);
                            
                        }
                        
                        return array_sum($totalPayments);

                    } else {
                        return $total = $sum * $diffDate->days;
                    }
                }
            } else {
                $total = 0;
                
                return $total;
            }
        }
    }

}

function calFineFixDateTest($list, $totalFineDue)
{
    $penaltyRate = App\Models\OM\PenaltyRateDomesticV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();

    if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
        if ($list->consignment_no) {
            $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();

            $amount = $header->total_include_vat;

            $current_date   = date_create(date('Y-m-d'));
            $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
            $fine_due_date  = date_create(date('Y-m-d', strtotime($totalFineDue)));
            $diffDate       = date_diff($fine_due_date, $due_date);

            $order_date = explode('-', $list->due_date);
            $startDate  = date_create($order_date[0] . "-12-31");
            $endDate    = date_create($order_date[0] + 1 . "-12-31");
            $diff       = date_diff($startDate, $endDate);

            $outstanding_debt = $list->outstanding_debt;
            $cal              = $outstanding_debt * $penaltyRate->description / 100;
            $sum              = $cal / $diff->days;

            
            if ($diffDate->format("%R%a") > 0) {
                return $total = 0;
            } else {
                $totalPayments = [];
                $oldAmount = '';

                $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                            ->where('credit_group_code', $list->credit_group_code)
                                            ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                            ->get();

                $i = 1;                            
                if ($paymentMatchInvoices->isNotEmpty()) {

                    $oldPaymentDate = '';

                    foreach ($paymentMatchInvoices as $paymentMatch) {
                        $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                        $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                        $paymentDiffDate    = date_diff($payment_date, $due_date);
                        
                        if ($i == 1) {
                            $payment_amount = $amount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;
                            $total = $sum * $paymentDiffDate->days;


                            // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                        }
                        else {
                            
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);


                            // $payment_amount = $amount - $oldAmount * 15 / 100;
                            $calAmount      =  $amount - $oldAmount;
                            $payment_amount = $calAmount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;

                            $total = $sum * $paymentDiffDate->days;
                        }

                        array_push($totalPayments, $total);

                        $oldAmount      = $paymentMatch->payment_amount;
                        $oldPaymentDate = $paymentMatch->creation_date;

                        $i += 1;
                    }

                    if ($outstanding_debt > 0) {

                        $payment_date       = date_create(date('Y-m-d'));
                        $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                        $fine_due_date      = date_create(date('Y-m-d', strtotime($totalFineDue)));
                        $paymentDiffDate    = date_diff($fine_due_date, $due_date);

                        $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                        $sum   = $payment_amount / $diff->days;

                        $total = $sum * $paymentDiffDate->days;

                        array_push($totalPayments, $total);
                        
                    }
                    
                    return array_sum($totalPayments);

                } else {
                    return $total = $sum * $diffDate->days;
                }
            }
        } else {
            $total = 0;
            
            return $total;
        }

    } else {
        if ($list->credit_group_code == 0) {
            return $total = 0;
        } else {
            $total = 0;

            if ($list->pick_release_no) {

                $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();                
                
                if ($header->payment_type_code == 10) {

                    $amount = $header->grand_total;

                } else {
                    $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
                                                            ->where('credit_group_code', $list->credit_group_code)
                                                            ->where('order_line_id', 0)
                                                            ->first();
                    
                    $amount = $orderCredit->amount;
                }
                

                $current_date   = date_create(date('Y-m-d'));
                $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                $fine_due_date  = date_create(date('Y-m-d', strtotime($totalFineDue)));
                $diffDate       = date_diff($fine_due_date, $due_date);

                $order_date = explode('-', $list->due_date);
                $startDate  = date_create($order_date[0] . "-12-31");
                $endDate    = date_create($order_date[0] + 1 . "-12-31");
                $diff       = date_diff($startDate, $endDate);

                $outstanding_debt = $list->outstanding_debt;
                $cal              = $outstanding_debt * $penaltyRate->description / 100;
                $sum              = $cal / $diff->days;
                
                if ($diffDate->format("%R%a") > 0) {
                    return $total = 0;
                } else {
                    
                    $totalPayments = [];

                    $oldAmount = '';

                    $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                                ->where('credit_group_code', $list->credit_group_code)
                                                ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                ->get();

                    $i = 1;
                    if ($paymentMatchInvoices->isNotEmpty()) {
                        $oldPaymentDate = '';

                        foreach ($paymentMatchInvoices as $paymentMatch) {
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);
                            
                            if ($i == 1) {
                                $payment_amount = $amount * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $total = $sum * $paymentDiffDate->days;


                                // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                            }
                            else {
                                
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);


                                // $payment_amount = $amount - $oldAmount * 15 / 100;
                                $calAmount      = $amount - $oldAmount;
                                $payment_amount = $calAmount * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;

                                $total = $sum * $paymentDiffDate->days;
                            }

                            array_push($totalPayments, $total);

                            $oldAmount      = $paymentMatch->payment_amount;
                            $oldPaymentDate = $paymentMatch->creation_date;

                            $i += 1;
                        }

                        if ($outstanding_debt > 0) {

                            $payment_date       = date_create(date('Y-m-d'));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $fine_due_date      = date_create(date('Y-m-d', strtotime($totalFineDue)));
                            $paymentDiffDate    = date_diff($fine_due_date, $due_date);

                            $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;

                            $total = $sum * $paymentDiffDate->days;

                            array_push($totalPayments, $total);
                            
                        }
                        
                        return array_sum($totalPayments);

                    } else {
                        return $total = $sum * $diffDate->days;
                    }
                }
            } else {
                $total = 0;
                
                return $total;
            }
        }
    }
}

function checkCancel($list)
{
    // $id = $list->customer_type_id == 40 ? $list->consignment_header_id: $list->order_header_id;

    if ($list->customer_type_id == 30 || $list->customer_type_id == 40 && $list->product_type_code == 10) {
        $id = $list->consignment_header_id;
    } else {
        $id = $list->order_header_id;
    }
    

    $data =  App\Models\OM\ImproveFine::where('invoice_id', $id)->where('credit_group_code', $list->credit_group_code)->first();

    if ($data) {
        return true;
    } else {
        return false;
    }
    
}

function calFineExp($list)
{
    // dd($list);
    $penaltyRate = App\Models\OM\PenaltyRateExportV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();
    
    
    // if ($list->credit_group_code == 0) {
    //     return $total = 0;
    // } else {
        $total = 0;
        
        if (!$list->due_date) {
            return $total;
        } else {

            if ($list->pick_release_no) {

                $header =  App\Models\OM\ProformaInvoiceHeader::where('pick_release_no', $list->pick_release_no)->first();                
                
                
                // $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
                //                                         ->where('credit_group_code', $list->credit_group_code)
                //                                         ->where('order_line_id', 0)
                //                                         ->first();
                
                $amount = $header->grand_total;
                
                

                $current_date   = date_create(date('Y-m-d'));
                $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                $diffDate       = date_diff($current_date, $due_date);

                $order_date = explode('-', $list->due_date);
                $startDate  = date_create($order_date[0] . "-12-31");
                $endDate    = date_create($order_date[0] + 1 . "-12-31");
                $diff       = date_diff($startDate, $endDate);

                $outstanding_debt = $list->outstanding_debt;
                $cal              = $outstanding_debt * $penaltyRate->description / 100;
                $sum              = $cal / $diff->days;
                
                if ($diffDate->format("%R%a") > 0) {
                    return $total = 0;
                } else {
                    
                    $totalPayments = [];

                    $oldAmount = '';
                    // credit_group_code
                    $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('invoice_number', $list->pick_release_no)
                                                // ->where('credit_group_code', $list->credit_group_code)
                                                ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                ->orderBy('creation_date', 'asc')
                                                ->get();

                    // dd($paymentMatchInvoices);
                    // dd($paymentMatchInvoices, $paymentMatchInvoices->isNotEmpty());
                                                
                    $i = 1;
                    if ($paymentMatchInvoices->isNotEmpty()) {
                        $oldPaymentDate = '';
                        $oldpaymentApply = '';

                        foreach ($paymentMatchInvoices as $paymentMatch) {
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);

                            $paymentApplies =  App\Models\OM\PaymentApply::where('pick_release_no', $list->pick_release_no)
                                                ->where('creation_date', $paymentMatch->creation_date)
                                                ->orderBy('creation_date', 'asc')
                                                ->get();

                            // dd('invoice_amount', $paymentApplies->sum('invoice_amount'));
                            
                            if ($i == 1) {
                                $payment_amount = $amount * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $paymentDiff = $paymentDiffDate->days - 1;
                                $total = $sum * $paymentDiff;
                                array_push($totalPayments, $total);
                                // dd($total);

                            }
                            else {
                                
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);


                                $calAmount      = ($amount - $oldAmount) - $oldpaymentApply;
                                $payment_amount = $calAmount * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $total = $sum * $paymentDiffDate->days;

                                array_push($totalPayments, $total);
                            }

                            // array_push($totalPayments, $total);

                            $oldAmount       = $paymentMatch->payment_amount;
                            $oldpaymentApply = $paymentApplies->sum('invoice_amount');
                            $oldPaymentDate  = $paymentMatch->creation_date;

                            $i += 1;
                        }

                        // dd($totalPayments, $oldAmount);

                        if ($outstanding_debt > 0) {

                            $payment_date       = date_create(date('Y-m-d'));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);

                            $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;
                            $paymentDiff = $paymentDiffDate->days+1;
                            $total = $sum * $paymentDiff;

                            array_push($totalPayments, $total);
                            
                        }
                        // dd('if totalPayments', array_sum($totalPayments));
                        
                        return array_sum($totalPayments);

                    } else {
                        // dd('if total', $sum * $diffDate->days);
                        return $total = $sum * $diffDate->days;
                    }
                }
            } else {
                $total = 0;

                // dd('else', $total);
                
                return $total;
            }
        }
    // }
    

}

function calFineExpFixDate($list, $totalFineDue)
{
    // dd($totalFineDue);
    $penaltyRate = App\Models\OM\PenaltyRateExportV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();
  
    $total = 0;
    if (!$list->due_date) {
        return $total;
    } else {
        if ($list->pick_release_no) {

            $header =  App\Models\OM\ProformaInvoiceHeader::where('pick_release_no', $list->pick_release_no)->first();                     
            $amount = $header->grand_total;

            $current_date   = date_create(date('Y-m-d'));
            $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
            $fine_due_date  = date_create(date('Y-m-d', strtotime($totalFineDue)));
            $diffDate       = date_diff($fine_due_date, $due_date);


            $order_date = explode('-', $list->due_date);
            $startDate  = date_create($order_date[0] . "-12-31");
            $endDate    = date_create($order_date[0] + 1 . "-12-31");
            $diff       = date_diff($startDate, $endDate);

            $outstanding_debt = $list->outstanding_debt;
            $cal              = $outstanding_debt * $penaltyRate->description / 100;
            $sum              = $cal / $diff->days;
            
            if ($diffDate->format("%R%a") > 0) {
                return $total = 0;
            } else {
                
                $totalPayments = [];

                $oldAmount = '';

                $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('invoice_number', $list->pick_release_no)
                                            ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                            ->orderBy('creation_date', 'asc')
                                            ->get();

                $i = 1;
                if ($paymentMatchInvoices->isNotEmpty()) {
                    $oldPaymentDate = '';
                    $oldpaymentApply = '';

                    foreach ($paymentMatchInvoices as $paymentMatch) {
                        $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                        $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                        $paymentDiffDate    = date_diff($payment_date, $due_date);

                        $paymentApplies =  App\Models\OM\PaymentApply::where('pick_release_no', $list->pick_release_no)
                                                ->where('creation_date', $paymentMatch->creation_date)
                                                ->orderBy('creation_date', 'asc')
                                                ->get();
                        
                        if ($i == 1) {
                            $payment_amount = $amount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;
                            $paymentDiff = $paymentDiffDate->days-1;
                            $total = $sum * $paymentDiff;

                            array_push($totalPayments, $total);
                            // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                        }
                        else {
                            
                            $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                            $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                            $paymentDiffDate    = date_diff($payment_date, $due_date);


                            // $payment_amount = $amount - $oldAmount * 15 / 100;
                            $calAmount      = ($amount - $oldAmount) - $oldpaymentApply;
                            $payment_amount = $calAmount * $penaltyRate->description / 100;

                            $sum   = $payment_amount / $diff->days;

                            $total = $sum * $paymentDiffDate->days;

                            array_push($totalPayments, $total);
                        }

                        // array_push($totalPayments, $total);

                        $oldAmount       = $paymentMatch->payment_amount;
                        $oldpaymentApply = $paymentApplies->sum('invoice_amount');
                        $oldPaymentDate  = $paymentMatch->creation_date;

                        $i += 1;
                    }

                    if ($outstanding_debt > 0) {

                        $payment_date       = date_create(date('Y-m-d'));
                        $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                        $fine_due_date      = date_create(date('Y-m-d', strtotime($totalFineDue)));
                        $paymentDiffDate    = date_diff($fine_due_date, $due_date);

                        $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                        $sum   = $payment_amount / $diff->days;
                        $paymentDiff = $paymentDiffDate->days+1;
                        $total = $sum * $paymentDiff;

                        array_push($totalPayments, $total);
                        
                    }
                    
                    return array_sum($totalPayments);

                } else {
                    return $total = $sum * $diffDate->days;
                }
            }
        } else {
            $total = 0;
            
            return $total;
        }
    }
    
}

function checkCancelExp($list)
{
    $data =  App\Models\OM\ImproveFine::where('invoice_number', $list->pick_release_no)->first();

    if ($data) {
        return true;
    } else {
        return false;
    }
    
}

function checkCancelOutstanding($list)
{    
    $invoiceNumber = $list->customer_type_id == 30 || $list->customer_type_id == 40 ? $list->consignment_no : $list->pick_release_no;

    $data =  App\Models\OM\ImproveFine::where('invoice_number', $invoiceNumber)
                                    ->where('credit_group_code', $list->credit_group_code)
                                    ->where('cancel_flag', 'Y')
                                    ->first();

    if ($data) {
        return true;
    } else {
        return false;
    }
    
}

function calFine($list)
{
    // แก้คำนวณล่าสุด W. 07/07/22
    $penaltyRate = App\Models\OM\PenaltyRateDomesticV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();
    if (!$list->due_date) {
        $total = 0;
        return $total;
    } else {
        if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
            if ($list->consignment_no) {

                // if ($list->customer_type_id == 30) {
                    
                    // Start คำนวณ Customer 30
                    if ($list->consignment_no) {

                        $header =  App\Models\OM\ConsignmentHeaders::where('consignment_no', $list->consignment_no)->first();
                        $amount = $header->total_include_vat;
                    } else {
                        $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first(); 
                        $amount = $header->grand_total;
                    }

                    $current_date   = date_create(date('Y-m-d'));
                    $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                    $diffDate       = date_diff($current_date, $due_date);

                    // dd($list->order_date, $list->due_date, explode('-', $list->due_date));

                    $order_date = explode('-', $list->due_date);
                    $startDate  = date_create($order_date[0] . "-12-31");
                    $endDate    = date_create($order_date[0] + 1 . "-12-31");
                    $diff       = date_diff($startDate, $endDate);

                    $outstanding_debt = $list->outstanding_debt;
                    $cal              = $outstanding_debt * $penaltyRate->description / 100;
                    $sum              = $cal / $diff->days;

                    
                    if ($diffDate->format("%R%a") > 0) {
                        return $total = 0;
                    } else {
                        $totalPayments = [];

                        $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('invoice_number', $list->consignment_no)
                                                    ->where('match_flag', 'Y')
                                                    ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                    ->orderBy('creation_date', 'asc')
                                                    ->get();

                        // dd($paymentMatchInvoices);

                        $i = 1;                            
                        if ($paymentMatchInvoices->isNotEmpty()) {

                            $oldPaymentDate = '';
                            $oldAmount = '';

                            foreach ($paymentMatchInvoices as $paymentMatch) {
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                // dd($payment_date, $due_date);
                                
                                if ($i == 1) {
                                    if ($outstanding_debt == 0) {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days;
                                        $total = $sum * $paymentDiff;
                                        array_push($totalPayments, $total);
                                    } else {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days-1;
                                        $total = $sum * $paymentDiff;
                                        array_push($totalPayments, $total);
                                    }

                                    // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                                }
                                else {
                                    
                                    $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                    $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                    $paymentDiffDate    = date_diff($payment_date, $due_date);


                                    $calAmount      =  $amount - $oldAmount;
                                    $payment_amount = $calAmount * $penaltyRate->description / 100;

                                    $sum   = $payment_amount / $diff->days;

                                    $total = $sum * $paymentDiffDate->days;
                                    array_push($totalPayments, $total);
                                }

                                $oldAmount      = $paymentMatch->payment_amount;
                                $oldPaymentDate = $paymentMatch->creation_date;

                                $i += 1;
                            }

                            if ($outstanding_debt > 0) {

                                $payment_date       = date_create(date('Y-m-d'));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $paymentDiff = $paymentDiffDate->days + 1;
                                $total = $sum * $paymentDiff;

                                array_push($totalPayments, $total);
                            }
                            
                            return array_sum($totalPayments);

                        } else {
                            return $total = $sum * $diffDate->days;
                        }
                    }
                    // END
                // }else {
                //     $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();
                //     $amount = $header->total_include_vat;
                // }

            } else {
                $total = 0;
                
                return $total;
            }

        } else {
            if ($list->credit_group_code == 0) {
                return $total = 0;
            } else {
                $total = 0;
                

                if ($list->pick_release_no) {

                    $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();                
                    
                    if ($header->payment_type_code == 10) {

                        $amount = $header->grand_total;

                    } else {
                        $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
                                                                ->where('credit_group_code', $list->credit_group_code)
                                                                ->where('order_line_id', 0)
                                                                ->first();
                        
                        $amount = $orderCredit->amount;
                    }
                    

                    $current_date   = date_create(date('Y-m-d'));
                    $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                    $diffDate       = date_diff($current_date, $due_date);

                    $order_date = explode('-', $list->due_date);
                    $startDate  = date_create($order_date[0] . "-12-31");
                    $endDate    = date_create($order_date[0] + 1 . "-12-31");
                    $diff       = date_diff($startDate, $endDate);

                    $outstanding_debt = $list->outstanding_debt;
                    $cal              = $outstanding_debt * $penaltyRate->description / 100;
                    $sum              = $cal / $diff->days;
                    
                    if ($diffDate->format("%R%a") > 0) {
                        return $total = 0;
                    } else {
                        
                        $totalPayments = [];

                        $oldAmount = '';
                        // credit_group_code
                        $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                                    ->where('credit_group_code', $list->credit_group_code)
                                                    // ->where('credit_group_code', 3)
                                                    ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                    ->orderBy('creation_date', 'asc')
                                                    ->get();
                        // dd($paymentMatchInvoices);
                                                    
                        $i = 1;
                        if ($paymentMatchInvoices->isNotEmpty()) {
                            $oldPaymentDate = '';

                            foreach ($paymentMatchInvoices as $paymentMatch) {
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);
                                
                                if ($i == 1) {

                                    if ($outstanding_debt == 0) {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days;
                                        $total = $sum * $paymentDiff;
                                    } else {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days - 1;
                                        $total = $sum * $paymentDiff;
                                    }
                                    
                                    
                                    // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                                }
                                else {
                                    
                                    $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                    $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                    $paymentDiffDate    = date_diff($payment_date, $due_date);

                                    $calAmount =  $amount - $oldAmount;
                                    $payment_amount = $calAmount * $penaltyRate->description / 100;

                                    $sum   = $payment_amount / $diff->days;

                                    $total = $sum * $paymentDiffDate->days;
                                }

                                array_push($totalPayments, $total);

                                $oldAmount      = $paymentMatch->payment_amount;
                                $oldPaymentDate = $paymentMatch->creation_date;

                                $i += 1;
                            }

                            // dd($totalPayments, $oldAmount);

                            if ($outstanding_debt > 0) {

                                $payment_date       = date_create(date('Y-m-d'));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $paymentDiff = $paymentDiffDate->days + 1;
                                $total = $sum * $paymentDiff;

                                array_push($totalPayments, $total);
                                
                            }
                            
                            return array_sum($totalPayments);

                        } else {
                            return $total = $sum * $diffDate->days;
                        }
                    }
                } else {
                    $total = 0;
                    
                    return $total;
                }
            }
        }
    }

}

// function calFineFixDate($list, $totalFineDue)
// {
//     // แก้คำนวณล่าสุด W. 06/09/22
//     $penaltyRate = App\Models\OM\PenaltyRateDomesticV::where('start_date_active', '<=', date('Y-m-d'))
//                                         ->where('end_date_active', '>=', date('Y-m-d'))
//                                         ->orWhereNull('end_date_active')
//                                         ->first();

//     if (!$list->due_date) {
//         $total = 0;
//         return $total;
//     } else {
//         if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
//             if ($list->consignment_no) {
//                 if ($list->consignment_no) {

//                     $header =  App\Models\OM\ConsignmentHeaders::where('consignment_no', $list->consignment_no)->first();
//                     $amount = $header->total_include_vat;
//                 } else {
//                     $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first(); 
//                     $amount = $header->grand_total;
//                 }

//                 // $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();

//                 // $amount = $header->total_include_vat;

//                 $current_date   = date_create(date('Y-m-d'));
//                 $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
//                 $fine_due_date  = date_create(date('Y-m-d', strtotime($totalFineDue)));
//                 $diffDate       = date_diff($fine_due_date, $due_date);

//                 $order_date = explode('-', $list->due_date);
//                 $startDate  = date_create($order_date[0] . "-12-31");
//                 $endDate    = date_create($order_date[0] + 1 . "-12-31");
//                 $diff       = date_diff($startDate, $endDate);

//                 $outstanding_debt = $list->outstanding_debt;
//                 $cal              = $outstanding_debt * $penaltyRate->description / 100;
//                 $sum              = $cal / $diff->days;

                
//                 if ($diffDate->format("%R%a") > 0) {
//                     return $total = 0;
//                 } else {
//                     $totalPayments = [];

//                     $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
//                                                 ->where('credit_group_code', $list->credit_group_code)
//                                                 ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
//                                                 ->orderBy('creation_date', 'asc')
//                                                 ->get();

//                     $i = 1;                            
//                     if ($paymentMatchInvoices->isNotEmpty()) {

//                         $oldPaymentDate = '';
//                         $oldAmount = '';

//                         foreach ($paymentMatchInvoices as $paymentMatch) {
//                             $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
//                             $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
//                             $paymentDiffDate    = date_diff($payment_date, $due_date);
                            
//                             if ($i == 1) {
//                                 if ($outstanding_debt == 0) {

//                                     $payment_amount = $amount * $penaltyRate->description / 100;
//                                     $sum   = $payment_amount / $diff->days;
//                                     $paymentDiff = $paymentDiffDate->days;
//                                     $total = $sum * $paymentDiff;
//                                     array_push($totalPayments, $total);

//                                 }else {

//                                     $payment_amount = $amount * $penaltyRate->description / 100;
//                                     $sum   = $payment_amount / $diff->days;
//                                     $paymentDiff = $paymentDiffDate->days-1;
//                                     $total = $sum * $paymentDiff;
//                                     array_push($totalPayments, $total);

//                                 }
//                                 // $payment_amount = $amount * $penaltyRate->description / 100;

//                                 // // $sum   = $payment_amount / $diff->days;
//                                 // // $total = $sum * $paymentDiffDate->days;

//                                 // $sum   = $payment_amount / $diff->days;
//                                 // $paymentDiff = $paymentDiffDate->days-1;
//                                 // $total = $sum * $paymentDiff;
//                                 // array_push($totalPayments, $total);

//                                 // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

//                             }
//                             else {
                                
//                                 $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
//                                 $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
//                                 $paymentDiffDate    = date_diff($payment_date, $due_date);


//                                 // $payment_amount = $amount - $oldAmount * 15 / 100;
//                                 $calAmount      =  $amount - $oldAmount;
//                                 $payment_amount = $calAmount * $penaltyRate->description / 100;

//                                 $sum   = $payment_amount / $diff->days;

//                                 $total = $sum * $paymentDiffDate->days;

//                                 array_push($totalPayments, $total);
//                             }

//                             // array_push($totalPayments, $total);

//                             $oldAmount      = $paymentMatch->payment_amount;
//                             $oldPaymentDate = $paymentMatch->creation_date;

//                             $i += 1;
//                         }

//                         if ($outstanding_debt > 0) {

//                             $payment_date       = date_create(date('Y-m-d'));
//                             $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
//                             $fine_due_date      = date_create(date('Y-m-d', strtotime($totalFineDue)));
//                             $paymentDiffDate    = date_diff($fine_due_date, $due_date);

//                             $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

//                             $sum         = $payment_amount / $diff->days;
//                             $paymentDiff = $paymentDiffDate->days + 1;
//                             $total       = $sum * $paymentDiff;

//                             array_push($totalPayments, $total);
                            
//                         }
                        
//                         return array_sum($totalPayments);

//                     } else {
//                         return $total = $sum * $diffDate->days;
//                     }
//                 }
//             } else {
//                 $total = 0;
                
//                 return $total;
//             }

//         } else {
//             if ($list->credit_group_code == 0) {
//                 return $total = 0;
//             } else {
//                 $total = 0;

//                 if ($list->pick_release_no) {

//                     $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();                
                    
//                     if ($header->payment_type_code == 10) {

//                         $amount = $header->grand_total;

//                     } else {
//                         $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
//                                                                 ->where('credit_group_code', $list->credit_group_code)
//                                                                 ->where('order_line_id', 0)
//                                                                 ->first();
                        
//                         $amount = $orderCredit->amount;
//                     }
                    

//                     $current_date   = date_create(date('Y-m-d'));
//                     $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
//                     $fine_due_date  = date_create(date('Y-m-d', strtotime($totalFineDue)));
//                     $diffDate       = date_diff($fine_due_date, $due_date);

//                     $order_date = explode('-', $list->due_date);
//                     $startDate  = date_create($order_date[0] . "-12-31");
//                     $endDate    = date_create($order_date[0] + 1 . "-12-31");
//                     $diff       = date_diff($startDate, $endDate);

//                     $outstanding_debt = $list->outstanding_debt;
//                     $cal              = $outstanding_debt * $penaltyRate->description / 100;
//                     $sum              = $cal / $diff->days;
                    
//                     if ($diffDate->format("%R%a") > 0) {
//                         return $total = 0;
//                     } else {
                        
//                         $totalPayments = [];

//                         $oldAmount = '';

//                         $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
//                                                     ->where('credit_group_code', $list->credit_group_code)
//                                                     ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
//                                                     ->orderBy('creation_date', 'asc')
//                                                     ->get();

//                         $i = 1;
//                         if ($paymentMatchInvoices->isNotEmpty()) {
//                             $oldPaymentDate = '';

//                             foreach ($paymentMatchInvoices as $paymentMatch) {
//                                 $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
//                                 $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
//                                 $paymentDiffDate    = date_diff($payment_date, $due_date);
                                
//                                 if ($i == 1) {
//                                     if ($outstanding_debt == 0) {
//                                         $payment_amount = $amount * $penaltyRate->description / 100;

//                                         $sum   = $payment_amount / $diff->days;
//                                         $paymentDiff = $paymentDiffDate->days;
//                                         $total = $sum * $paymentDiff;
//                                         array_push($totalPayments, $total);
                                        
//                                     } else {
//                                         $payment_amount = $amount * $penaltyRate->description / 100;

//                                         $paymentDiff = $paymentDiffDate->days-1;
//                                         $total = $sum * $paymentDiff;
//                                         array_push($totalPayments, $total);
//                                     }

//                                 }
//                                 else {
                                    
//                                     $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
//                                     $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
//                                     $paymentDiffDate    = date_diff($payment_date, $due_date);


//                                     // $payment_amount = $amount - $oldAmount * 15 / 100;
//                                     $calAmount      = $amount - $oldAmount;
//                                     $payment_amount = $calAmount * $penaltyRate->description / 100;

//                                     $sum   = $payment_amount / $diff->days;

//                                     $total = $sum * $paymentDiffDate->days;
//                                     array_push($totalPayments, $total);
//                                 }

//                                 // array_push($totalPayments, $total);

//                                 $oldAmount      = $paymentMatch->payment_amount;
//                                 $oldPaymentDate = $paymentMatch->creation_date;

//                                 $i += 1;
//                             }

//                             if ($outstanding_debt > 0) {

//                                 $payment_date       = date_create(date('Y-m-d'));
//                                 $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
//                                 $fine_due_date      = date_create(date('Y-m-d', strtotime($totalFineDue)));
//                                 $paymentDiffDate    = date_diff($fine_due_date, $due_date);

//                                 $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

//                                 $sum   = $payment_amount / $diff->days;
//                                 $paymentDiff = $paymentDiffDate->days + 1;
//                                 $total       = $sum * $paymentDiff;
                                

//                                 array_push($totalPayments, $total);
                                
//                             }
                            
//                             return array_sum($totalPayments);

//                         } else {
//                             return $total = $sum * $diffDate->days;
//                         }
//                     }
//                 } else {
//                     $total = 0;
                    
//                     return $total;
//                 }
//             }
//         }
//     }
// }


function calFineFixDate($list, $totalFineDue)
{
    // แก้คำนวณล่าสุด W. 06/09/22
    $penaltyRate = App\Models\OM\PenaltyRateDomesticV::where('start_date_active', '<=', date('Y-m-d'))
                                        ->where('end_date_active', '>=', date('Y-m-d'))
                                        ->orWhereNull('end_date_active')
                                        ->first();
    if (!$list->due_date) {
        $total = 0;
        return $total;
    } else {
        if ($list->customer_type_id == 30 || $list->customer_type_id == 40) {
            if ($list->consignment_no) {

                // if ($list->customer_type_id == 30) {
                    
                    // Start คำนวณ Customer 30
                    if ($list->consignment_no) {

                        $header =  App\Models\OM\ConsignmentHeaders::where('consignment_no', $list->consignment_no)->first();
                        $amount = $header->total_include_vat;
                    } else {
                        $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first(); 
                        $amount = $header->grand_total;
                    }

                    $current_date   = date_create(date('Y-m-d', strtotime($totalFineDue)));
                    $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                    $diffDate       = date_diff($current_date, $due_date);

                    // dd($list->order_date, $list->due_date, explode('-', $list->due_date));

                    $order_date = explode('-', $list->due_date);
                    $startDate  = date_create($order_date[0] . "-12-31");
                    $endDate    = date_create($order_date[0] + 1 . "-12-31");
                    $diff       = date_diff($startDate, $endDate);

                    $outstanding_debt = $list->outstanding_debt;
                    $cal              = $outstanding_debt * $penaltyRate->description / 100;
                    $sum              = $cal / $diff->days;

                        
                    if ($diffDate->format("%R%a") > 0) {
                        return $total = 0;
                    } else {
                        $totalPayments = [];

                        $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('invoice_number', $list->consignment_no)
                                                    ->where('match_flag', 'Y')
                                                    // ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                    ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                    ->orderBy('creation_date', 'asc')
                                                    ->get();

                        // dd($paymentMatchInvoices);

                        $i = 1;                            
                        if ($paymentMatchInvoices->isNotEmpty()) {

                            $oldPaymentDate = '';
                            $oldAmount = '';

                            foreach ($paymentMatchInvoices as $paymentMatch) {
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                // dd($payment_date, $due_date);
                                
                                if ($i == 1) {
                                    if ($outstanding_debt == 0) {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days;
                                        // $total = $sum * $paymentDiff;
                                        // array_push($totalPayments, $total);

                                        if ($diffDate->days < $paymentDiffDate->days) {
                                            $total = $sum * $diffDate->days;
                                            array_push($totalPayments, $total);
                                        } else {
                                            $total = $sum * $paymentDiff;
                                            array_push($totalPayments, $total);
                                        }
                                    } else {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days-1;
                                        // $total = $sum * $paymentDiff;
                                        // array_push($totalPayments, $total);
                                        if ($diffDate->days < $paymentDiffDate->days) {
                                            $total = $sum * $diffDate->days;
                                            array_push($totalPayments, $total);
                                        } else {
                                            $total = $sum * $paymentDiff;
                                            array_push($totalPayments, $total);
                                        }
                                    }

                                    // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                                }
                                else {
                                    
                                    $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                    $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                    $paymentDiffDate    = date_diff($payment_date, $due_date);


                                    $calAmount      =  $amount - $oldAmount;
                                    $payment_amount = $calAmount * $penaltyRate->description / 100;

                                    $sum   = $payment_amount / $diff->days;

                                    // $total = $sum * $paymentDiffDate->days;
                                    // array_push($totalPayments, $total);

                                    if ($diffDate->days < $paymentDiffDate->days) {
                                        $total = $sum * $diffDate->days;
                                        array_push($totalPayments, $total);
                                    } else {
                                        $total = $sum * $paymentDiffDate->days;
                                        array_push($totalPayments, $total);
                                    }
                                }

                                $oldAmount      = $paymentMatch->payment_amount;
                                $oldPaymentDate = $paymentMatch->creation_date;

                                $i += 1;
                            }

                            if ($outstanding_debt > 0) {

                                $payment_date       = date_create(date('Y-m-d'));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $paymentDiff = $paymentDiffDate->days + 1;
                                // $total = $sum * $paymentDiff;

                                // array_push($totalPayments, $total);

                                if ($diffDate->days < $paymentDiffDate->days) {
                                    $total = $sum * $diffDate->days;
                                    array_push($totalPayments, $total);
                                } else {
                                    $total = $sum * $paymentDiff;
                                    array_push($totalPayments, $total);
                                }
                            }
                            
                            return array_sum($totalPayments);

                        } else {
                            return $total = $sum * $diffDate->days;
                        }
                    }
                    // END
                // }else {
                //     $header =  App\Models\OM\ConsignmentHeaders::where('order_header_id', $list->order_header_id)->first();
                //     $amount = $header->total_include_vat;
                // }

            } else {
                $total = 0;
                
                return $total;
            }

        } else {
            if ($list->credit_group_code == 0) {
                return $total = 0;
            } else {
                $total = 0;
                

                if ($list->pick_release_no) {

                    $header =  App\Models\OM\OrderHeaders::where('order_header_id', $list->order_header_id)->first();                
                    
                    if ($header->payment_type_code == 10) {

                        $amount = $header->grand_total;

                    } else {
                        $orderCredit = App\Models\OM\OrderCreditGroup::where('order_header_id', $list->order_header_id)
                                                                ->where('credit_group_code', $list->credit_group_code)
                                                                ->where('order_line_id', 0)
                                                                ->first();
                        
                        $amount = $orderCredit->amount;
                    }
                    

                    $current_date   = date_create(date('Y-m-d', strtotime($totalFineDue)));
                    $due_date       = date_create(date('Y-m-d', strtotime($list->due_date)));
                    $diffDate       = date_diff($current_date, $due_date);

                    $order_date = explode('-', $list->due_date);
                    $startDate  = date_create($order_date[0] . "-12-31");
                    $endDate    = date_create($order_date[0] + 1 . "-12-31");
                    $diff       = date_diff($startDate, $endDate);

                    $outstanding_debt = $list->outstanding_debt;
                    $cal              = $outstanding_debt * $penaltyRate->description / 100;
                    $sum              = $cal / $diff->days;
                    
                    if ($diffDate->format("%R%a") > 0) {
                        return $total = 0;
                    } else {
                        
                        $totalPayments = [];

                        $oldAmount = '';
                        // credit_group_code
                        $paymentMatchInvoices =  App\Models\OM\PaymentMatchInvoice::where('prepare_order_number', $list->prepare_order_number)
                                                    ->where('credit_group_code', $list->credit_group_code)
                                                    // ->where('credit_group_code', 3)
                                                    ->where('creation_date', '>=', date('Y-m-d', strtotime($list->due_date)))
                                                    ->orderBy('creation_date', 'asc')
                                                    ->get();
                        // dd($paymentMatchInvoices);
                                                    
                        $i = 1;
                        if ($paymentMatchInvoices->isNotEmpty()) {
                            $oldPaymentDate = '';

                            foreach ($paymentMatchInvoices as $paymentMatch) {
                                $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                $due_date           = date_create(date('Y-m-d', strtotime($list->due_date)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);
                                
                                if ($i == 1) {

                                    if ($outstanding_debt == 0) {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days;
                                        // $total = $sum * $paymentDiff;

                                        if ($diffDate->days < $paymentDiffDate->days) {
                                            $total = $sum * $diffDate->days;
                                        } else {
                                            $total = $sum * $paymentDiff;
                                        }
                                    } else {
                                        $payment_amount = $amount * $penaltyRate->description / 100;

                                        $sum   = $payment_amount / $diff->days;
                                        $paymentDiff = $paymentDiffDate->days - 1;
                                        // $total = $sum * $paymentDiff;

                                        if ($diffDate->days < $paymentDiffDate->days) {
                                            $total = $sum * $diffDate->days;
                                        } else {
                                            $total = $sum * $paymentDiff;
                                        }
                                    }
                                    
                                    
                                    // dd($payment_date, $due_date, $paymentDiffDate->days, $paymentDiffDate);

                                }
                                else {
                                    
                                    $payment_date       = date_create(date('Y-m-d', strtotime($paymentMatch->creation_date)));
                                    $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                    $paymentDiffDate    = date_diff($payment_date, $due_date);

                                    $calAmount =  $amount - $oldAmount;
                                    $payment_amount = $calAmount * $penaltyRate->description / 100;

                                    $sum   = $payment_amount / $diff->days;

                                    // $total = $sum * $paymentDiffDate->days;

                                    if ($diffDate->days < $paymentDiffDate->days) {
                                        $total = $sum * $diffDate->days;
                                    } else {
                                        $total = $sum * $paymentDiffDate->days;
                                    }
                                }

                                array_push($totalPayments, $total);

                                $oldAmount      = $paymentMatch->payment_amount;
                                $oldPaymentDate = $paymentMatch->creation_date;

                                $i += 1;
                            }

                            // dd($totalPayments, $oldAmount);

                            if ($outstanding_debt > 0) {

                                $payment_date       = date_create(date('Y-m-d'));
                                $due_date           = date_create(date('Y-m-d', strtotime($oldPaymentDate)));
                                $paymentDiffDate    = date_diff($payment_date, $due_date);

                                $payment_amount = $outstanding_debt * $penaltyRate->description / 100;

                                $sum   = $payment_amount / $diff->days;
                                $paymentDiff = $paymentDiffDate->days + 1;
                                // $total = $sum * $paymentDiff;

                                // array_push($totalPayments, $total);

                                if ($diffDate->days < $paymentDiffDate->days) {
                                    $total = $sum * $diffDate->days;
                                    array_push($totalPayments, $total);
                                } else {
                                    $total = $sum * $paymentDiff;
                                    array_push($totalPayments, $total);
                                }
                                
                            }
                            
                            return array_sum($totalPayments);

                        } else {
                            return $total = $sum * $diffDate->days;
                        }
                    }
                } else {
                    $total = 0;
                    
                    return $total;
                }
            }
        }
    }

}