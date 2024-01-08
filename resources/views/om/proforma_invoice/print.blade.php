<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<title>PROFORMA INVOICE</title>

<link href="{!! asset('custom/css-report/bootstrap.min.css') !!}" rel="stylesheet">
<link href="{!! asset('custom/css-report/print-export.css') !!}" rel="stylesheet">
</head>

<style>
    .page-a4 {
        width: 100% !important;
        /* height: 29.7cm !important; */
        page-break-after: always;
        page-break-inside: avoid;
    }

    body {
        text-transform: uppercase !important;
    }
</style>

<body class="font10" style="background: white;">
    @php
        $line_number = 1;
    @endphp

    @foreach ($orderLinesData as $keyCount => $itemPage)
    <div style="page-break-after: always"> </div>
    <div class="page-a4 cordiaUPC">
        <div class="subpage smallgap">
            <div class="border">
                <div class="report-content">
                <div class="report-header angsanaUPC">
                    <div class="info" style="position: absolute;">
                        <div class="logo" style="width: 90px; float:left;">
                            <img class="w-100" src="{!! asset('custom/img/logo-black.png') !!}" alt="">
                        </div>

                        <div style="margin-left: 10px; float:left; width:160mm">
                            <h3>{{ !empty($toatAddress) ? $toatAddress->company_name_eng : '' }}</h3>
                            <p>{{ !empty($toatAddress) ? $toatAddress->address1_eng : '' }} <br>
                                {{ !empty($toatAddress) ? $toatAddress->address2_eng : '' }} <br>
                            PHONE: {{ !empty($toatAddress) ? $toatAddress->phone_number : '' }} FAX: {{ !empty($toatAddress) ? $toatAddress->fax_number : '' }}<br>
                            {{ !empty($toatAddress) ? $toatAddress->email : '' }}<br>
                            TAX ID NO. {{ !empty($toatAddress) ? $toatAddress->tax_payer_id : '' }}</p>
                        </div>
                    </div>
                </div>

                <div style="padding-top: 85px;">
                    <h2 class="report-title angsanaUPC">PROFORMA INVOICE</h2>
                </div>

                <table class="table-report-foreign text-xs table1">
                    <tr class="first">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" rowspan="3">
                            <p class="mb-1">Consignee</p>
                            {{-- <div class="d-block pl-2">
                                <p>
                                    {{ !empty($proformaData) ? $proformaData->ship_to_site_name : '' }}<br>
                                    {{ !empty($proformaData) ? $proformaData->ship_address_line_1 : '' }}{{ !empty($proformaData->ship_address_line_2) ? ', '.$proformaData->ship_address_line_2 : $proformaData->ship_address_line_2 }}<br>
                                    {{ !empty($proformaData) ? $proformaData->ship_address_line_3 : '' }}{{ !empty($proformaData->ship_state) ? ', '.$proformaData->ship_state : $proformaData->ship_state }} {{ !empty($proformaData) ? $proformaData->ship_postal_code : '' }}
                                    @if (!empty($proformaData->ship_city) && !empty($proformaData->ship_district) && !empty($proformaData->ship_province_name))
                                    <br>{{ !empty($proformaData) ? $proformaData->ship_city : '' }} {{ !empty($proformaData) ? $proformaData->ship_district : '' }} {{ !empty($proformaData) ? $proformaData->ship_province_name : '' }}
                                    @endif
                                    {{ !empty($proformaData) ? $proformaData->ship_country_name : '' }} {{ !empty($proformaData) ? $proformaData->ship_postal_code : '' }}<br>
                                    TAX ID NO. {{ !empty($proformaData) ? $proformaData->tax_register_number : '' }}</p>
                            </div> --}}
                            <div class="d-block pl-2">
                                <p>
                                    {{ !empty($proformaData) ? $proformaData->ship_to_site_name : '' }}<br>
                                    {{ !empty($proformaData->ship_address_line_1) ? $proformaData->ship_address_line_1.', ' : '' }}{{ !empty($proformaData->ship_address_line_2) ? $proformaData->ship_address_line_2.', ' : $proformaData->ship_address_line_2 }}
                                    @if (!empty($proformaData->ship_address_line_3) || !empty($proformaData->ship_state))
                                        <br>{{ !empty($proformaData->ship_address_line_3) ? $proformaData->ship_address_line_3.', ' : '' }}{{ !empty($proformaData->ship_state) ? $proformaData->ship_state.', ' : $proformaData->ship_state }}
                                        {{-- {{ !empty($proformaData) ? $proformaData->ship_postal_code : '' }} --}}
                                    @endif
                                    @if ((!empty($proformaData->ship_city) || !empty($proformaData->ship_district) || !empty($proformaData->ship_province_name)) && $proformaData->ship_country_code == 'TH')
                                    <br>{{ !empty($proformaData->ship_district) ? $proformaData->ship_district.', ' : '' }} {{ !empty($proformaData->ship_city) ? $proformaData->ship_city.', ' : '' }} {{ !empty($proformaData->ship_province_name) ? $proformaData->ship_province_name.', ' : '' }}
                                    @endif
                                    <br>{{ !empty($proformaData->ship_country_name) ? $proformaData->ship_country_name : '' }} {{ !empty($proformaData->ship_postal_code) ? ', '.$proformaData->ship_postal_code : '' }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="title">No.</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->pi_number : '' }}</p>
                            </div>

                            {{-- <p class="">Status.</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->order_status : '' }}</p>
                            </div> --}}
                        </td>
                        <td>
                            <p class="title">Date</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->pi_date : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="title">Exporter’s Reference No.</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->sale_confirm_document_no : '' }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="title">Date</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->sale_confirm_date : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="title">Buyer’s Order No./ Inquiry No.</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->cust_po_number : '' }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="title">Date</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->order_date : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <!--//-->

                    <tr>
                        <td colspan="2" rowspan="3">
                            <p class="mb-1">Buyer (if not stated above)</p>
                            {{-- <div class="d-block pl-2">
                                <p>
                                    {{ !empty($proformaData) ? $proformaData->customer_name : '' }}<br>
                                    {{ !empty($proformaData) ? $proformaData->ship_address_line_1 : '' }}{{ !empty($proformaData->ship_address_line_2) ? ', '.$proformaData->ship_address_line_2 : $proformaData->ship_address_line_2 }}<br>
                                    {{ !empty($proformaData) ? $proformaData->ship_address_line_3 : '' }}{{ !empty($proformaData->state) ? ', '.$proformaData->state : $proformaData->state }} {{ !empty($proformaData) ? $proformaData->postal_code : '' }}
                                    @if (!empty($proformaData->ship_city) && !empty($proformaData->ship_district) && !empty($proformaData->ship_province_name))
                                    <br>{{ !empty($proformaData) ? $proformaData->ship_city : '' }} {{ !empty($proformaData) ? $proformaData->ship_district : '' }} {{ !empty($proformaData) ? $proformaData->ship_province_name : '' }}
                                    @endif
                                    {{ !empty($proformaData) ? $proformaData->ship_country_name : '' }} {{ !empty($proformaData) ? $proformaData->ship_postal_code : '' }}<br>
                                    TAX ID NO. {{ !empty($proformaData) ? $proformaData->tax_register_number : '' }}</p>
                            </div> --}}
                            <div class="d-block pl-2">
                                <p>
                                    {{ !empty($proformaData->bill_to_site_name) ? $proformaData->bill_to_site_name : '' }}<br>
                                    {{ !empty($proformaData->address_line1) ? $proformaData->address_line1 . ', ' : '' }}{{ !empty($proformaData->address_line2) ? $proformaData->address_line2 . ', ' : '' }}
                                    @if (!empty($proformaData->address_line3) || !empty($proformaData->state))
                                        <br>{{ !empty($proformaData->address_line3) ? $proformaData->address_line3 . ', ' : '' }}{{ !empty($proformaData->state) ? $proformaData->state . ', ' : '' }}
                                        {{-- {{ !empty($proformaData) ? $proformaData->postal_code : '' }} --}}
                                    @endif
                                    @if (!empty($proformaData->city) || !empty($proformaData->district) || !empty($proformaData->province_name))
                                    <br>{{ !empty($proformaData->district) ? $proformaData->district . ', ' : '' }} {{ !empty($proformaData->city) ? $proformaData->city . ', ' : '' }} {{ !empty($proformaData->province_name) ? $proformaData->province_name . ', ' : '' }}
                                    @endif
                                    {{ !empty($proformaData->country_name) ? $proformaData->country_name : '' }} {{ !empty($proformaData->postal_code) ? ', ' . $proformaData->postal_code : '' }}<br>
                                    {{-- @if (!empty($proformaData->branch))
                                        BRANCH NO. {{ !empty($proformaData->branch) ? $proformaData->branch : '' }}<br>
                                    @endif --}}
                                    @if (!empty($proformaData->tax_register_number))
                                        TAX ID NO. {{ !empty($proformaData->tax_register_number) ? $proformaData->tax_register_number : '' }}</p>
                                    @endif
                            </div>
                        </td>
                        <td>
                            <p class="title">Country of origin of Goods</p>
                            <div class="d-block text-center">
                                {{-- <p>{{ !empty($proformaData) ? $proformaData->country_name : '' }}</p> --}}
                                <p> THAILAND </p>
                            </div>
                        </td>
                        <td>
                            <p class="title">Country of Final Destination</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->ship_country_name : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="title"> Sale Confirmation / Date </p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->sa_number : '' }} / {{ !empty($proformaData) ? $proformaData->sa_date : '' }} </p>
                            </div>
                        </td>
                        <td>
                            <p class="title">INCOTERMS</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->incoterm_desription : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="2" rowspan="2" style="vertical-align: middle;">
                            <p class="title">Currency of Settlement</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->currency : '' }}</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td  colspan="2">
                            <p class="title">Shipment</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->shipment_condition : '' }}</p>
                            </div>
                        </td>
                    </tr>
                    <!--//-->

                    <tr>
                        <td>
                            <p class="title">Vessel/Aircraft etc.,</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->shipment_meaning : '' }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="title">Port of Loading</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->port_of_loading : '' }}</p>
                            </div>
                        </td>
                        <td  colspan="2" rowspan="2">
                            <p class="title">Terms of Payment</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->term_description : '' }}</p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="title">Port of Discharge</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->port_of_discharge : '' }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="title">Place of Delivery by On Carrier</p>
                            <div class="d-block text-center">
                                <p>{{ !empty($proformaData) ? $proformaData->ship_country_name : '' }}</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <!--====================[End] Table 1 =============== -->

                <table class="table-report-foreign text-xs table2">
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-left">Description of Goods</th>
                        <th class="pr-4">Quantity</th>
                        <th class="text-left">UOM</th>
                        <th>Per Unit</th>
                        <th>Amount</th>
                    </tr>

                    @if (!empty($orderLinesData[$keyCount]))
                    @foreach ($orderLinesData[$keyCount] as $item)
                    @if ($item->unit_price > 0)
                    <tr>
                        <td class="text-center">{{ $line_number }}</td>
                        <td class="text-left">{{ $item->report_item_display }}</td>
                        <td class="pr-4">{{ $item->approve_quantity }}</td>
                        <td class="text-left">{{ $item->name_for_report_exp }}</td>
                        <td>{{ $item->unit_price }}</td>
                        <td class="text-right">{{ $item->amount }}</td>
                    </tr>
                    @php
                        $line_number++;
                    @endphp
                    @endif
                    @endforeach
                    @foreach ($orderLinesData[$keyCount] as $item)
                    @if ($item->unit_price <= 0)
                    <tr>
                        <td class="text-center">{{ $line_number }}</td>
                        <td class="text-left">{{ $item->report_item_display }}</td>
                        <td class="pr-4">{{ $item->approve_quantity }}</td>
                        <td class="text-left">{{ $item->name_for_report_exp }}</td>
                        <td>{{ $item->unit_price }}</td>
                        <td class="text-right">{{ $item->amount }}</td>
                    </tr>
                    @php
                        $line_number++;
                    @endphp
                    @endif
                    @endforeach
                    @endif

                    <tr>
                        <td colspan="6" style="padding-top:10px"></td>
                    </tr>

                    @if ($keyCount == count($orderLinesData))

                    <tr class="total">
                        <td colspan="5" class="text-right">
                            <strong>TOTAL COST</strong>
                        </td>
                        <td class="text-right">
                            {{ !empty($proformaData) ? $proformaData->sub_total : '0.00' }}
                        </td>
                    </tr>

                    <tr class="total">
                        <td colspan="5">
                            <strong>VAT {{ !empty($proformaData) ? $proformaData->percentage_rate : '' }}%</strong>
                        </td>
                        <td>
                            {{ !empty($proformaData) ? $proformaData->tax : '' }}
                        </td>
                    </tr>
                    <tr class="total">
                        <td colspan="5">
                            <strong>TOTAL {{ !empty($proformaData) ? $proformaData->incoterm_desription : '' }}</strong>
                        </td>
                        <td>
                            {{ !empty($proformaData) ? $proformaData->grand_total : '0.00' }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" style="padding-top:2px"></td>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-left">
                            AMOUNT {{ !empty($proformaData) ? $proformaData->currency : '' }} * {{ !empty($proformaData) ? $proformaData->grand_total_text : '' }} only * E&OE
                        </th>
                    </tr>

                    @endif
                </table>

                @if ($keyCount == count($orderLinesData))

                <!--====================[End] Table 2 =============== -->

                <table class="table-report-foreign text-xs table3">
                    <tr>
                        <td rowspan="2">
                            <p class="mb-1">PACKING:</p>
                            <div class="d-block pl-2">
                                <p>
                                    {!! !empty($proformaData) ? nl2br($proformaData->remark) : '' !!}
                                </p>
                                {{-- @if (!empty($packingData))
                                <p>
                                    @foreach ($packingData as $item)
                                    @if ($proformaData->product_type_code == 10)
                                    @if ($item->tag == 10)
                                    {{ $item->meaning }} <br>
                                    @endif
                                    @else
                                    @if ($item->tag != 10)
                                    {{ $totalApprovePack }} {{ $item->meaning }} <br>
                                    @endif
                                    @endif
                                    @endforeach
                                </p>
                                @endif --}}
                            </div>
                        </td>
                        <td colspan="2" class="text-center" style="height: 30px">
                            WEIGHT/KG
                        </td>
                        <td rowspan="2">
                            <p class="mb-1">SHIPPING MARKS:</p>
                            <div class="d-block text-center">
                                <p>
                                    {!! !empty($proformaData) ? nl2br($proformaData->shipping_marks) : '' !!}
                            </div>
                        </td>
                    </tr>

                    <tr  class="text-center" >
                        <td style="vertical-align: middle;">
                            <br>
                            <p class="title">NET</p>
                            <p>{{ !empty($totalNet) ? $totalNet : '0.00' }}</p>
                        </td>
                        <td style="vertical-align: middle;">
                            <p class="title">GROSS</p>
                            <br>
                            <p>{{ !empty($totalGross) ? $totalGross : '0.00' }}</p>
                        </td>
                    </tr>

                    <!--//-->

                    <tr>
                        <td colspan="2">
                            <p class="title">CONFIRMATION AND ACCEPTANED BY</p>
                            <div class="signature"></div>
                            <p><small>Place and date, Signature and Stamp of authorized signatory</small></p>
                        </td>
                        <td colspan="2">
                            <p class="title">ON BEHALF OF<br>TOBACCO AUTHORITY OF THAILAND</p>
                            <div class="signature"></div>
                            <p class="mb-0"><small> {{ !empty($approveData) ? $approveData->meaning : '' }} </small></p>
                            <p class="mb-0"><small> {{ !empty($approveData) ? $approveData->description : '' }} </small></p>
                        </td>
                    </tr>
                </table>

                <!--====================[End] Table 3 =============== -->

                <table class="table-report-foreign text-xs table4 table-footer">
                    <tr>
                        @if (!empty($incotermData))
                        <td>
                            <p class="title"> {{ $incotermData[0]->attribute1 }} </p>
                            <div class="d-block">
                                <p>
                                    @foreach ($incotermData as $item)
                                    {{ $item->meaning }} : {{ $item->description }} <br>
                                    @endforeach
                                </p>
                            </div>
                        </td>
                        @endif
                        @if (!empty($paymentData))
                        <td>
                            <p class="title">PAYMENTS :</p>
                            <div class="d-block bold">
                                @foreach ($paymentData as $item)
                                <p> {{ $item->meaning }} </p>
                                @endforeach
                            </div>
                        </td>
                        @endif

                        <td>
                            <table class="address" style="width: 100%">
                                <tr>
                                    <td>Account name address</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_acc_name_eng : '' }} <br> {{ !empty($bankAccData) ? $bankAccData->om_acc_address_eng : '' }} </td>
                                </tr>
                                <tr>
                                    <td>A/C NO.</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->bank_account_number : '' }} </td>
                                </tr>
                                <tr>
                                    <td>Bank</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_bank_name_eng : '' }} </td>
                                </tr>
                                <tr>
                                    <td>Branch</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_branch : '' }} </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_bank_address_eng : '' }} </td>
                                </tr>
                                <tr>
                                    <td>S.W.I.F.T</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_swift : '' }} </td>
                                </tr>
                                <tr>
                                    <td>Chips UID</td>
                                    <td> {{ !empty($bankAccData) ? $bankAccData->om_chips_uid : '' }} </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!--====================[End] Table 4 =============== -->

                <p class="mb-0 text-center">NOTE : ALL FOREIGN BANK CHARGES INCLUDING COSTS OF POSTAGE OR WIRING WILL BE BORNE BY APPLICANT </p>

                @endif

            </div><!--border-->
        </div><!--subpage-->
    </div><!--page-a4-->

    <p class="mb-0 text-center f12" style="bottom:10px position:fixed;"> Page {{ $keyCount }} / {{ count($orderLinesData) }} </p>

    @endforeach

<script type="text/javascript">

</script>
</body>
</html>
