<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<title>PACKING LIST</title>

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

<body class="font10">
    @php
        $line_number = 1;
    @endphp

    @foreach ($dataPiLotData as $keyCount => $itemPage)
    <div style="page-break-after: always"> </div>
    <div class="page-a4 cordiaUPC">
        <div class="subpage smallgap">
            <div class="border">
                <div class="report-content">
                <div class="report-header center angsanaUPC">
                    <div class="logo">
                        <img class="w-100" src="{!! asset('custom/img/logo-black.png') !!}" alt="">
                        {{-- <img class="w-100" src="img/logo-black.png" alt=""> --}}
                    </div>
                    <div class="info pl-4 pr-4">
                        <h3>{{ !empty($toatAddress) ? $toatAddress->company_name_eng : '' }}</h3>
                        <div class="row">
                            <div class="col-12">
                                <table class="w-100">
                                    <tr>
                                        <td class="pr-2 text-left" style="width: 5%">
                                            FAX.<br>
                                            PHONE.
                                        </td>

                                        <td class="pr-2 text-left" style="width: 27%">
                                            {{ !empty($toatAddress) ? $toatAddress->fax_number : '' }} <br>
                                            {{ !empty($toatAddress) ? $toatAddress->phone_number : '' }}
                                        </td>

                                        <td class="text-left" style="vertical-align: top; width: 15%">TAX ID NO. {{ !empty($toatAddress) ? $toatAddress->tax_payer_id : '' }}</td>

                                        <td class="text-center" style="width: 25%">
                                            {{ !empty($toatAddress) ? $toatAddress->address1_eng : '' }}<br>
                                            {{ !empty($toatAddress) ? $toatAddress->address2_eng : '' }}<br>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            {{-- <div class="col-4">
                                <h5>TAX ID NO.0994000164769</h5>
                            </div>
                            <div class="col-4">
                                P.O. BOX B<br>
                                184 RAMA IV ROAD<br>
                                BANGKOK, 10110, THAILAND
                            </div> --}}
                        </div>
                    </div>

                </div>

                <h3 class="report-title pb-2 pt-2"><span style="text-decoration: underline; font-weight:bold;">PACKING LIST</span></h3>

                <table class="table-report-foreign text-black f12 no-border w-100">
                    <tr>
                        <td style="width:70%;">
                            @if ( request()->ref == 72 )
                            <strong>IN NO. {{ !empty($proformaData) ? $proformaData->attribute1 : '' }}</strong>
                            @else
                            <strong>INV NO. {{ !empty($proformaData) ? $proformaData->pick_release_no : '' }}</strong>
                            @endif
                        </td>
                        <td class="text-center pr-5">
                            {{-- <strong>{{ !empty($toatAddress) ? $toatAddress->address2_eng : '' }}</strong> --}}

                            <strong>{{ !empty($proformaData) ? $proformaData->pi_date_text : '' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            CONSIGNED TO ORDER  OF : <strong> {{ !empty($proformaData) ? $proformaData->ship_to_site_name : '' }} </strong>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="pt-2">
                            FROM : <strong>{{ !empty($proformaData) ? $proformaData->port_of_loading : '' }}</strong>
                            {{-- FROM : <strong>{{ !empty($toatAddress) ? $toatAddress->address2_eng : '' }}</strong>
                            TO : <strong>{{ !empty($proformaData) ? $proformaData->state : '' }}, {{ !empty($proformaData) ? $proformaData->country_name : '' }}</strong> --}}
                        </td>
                    </tr>
                </table>

                <table class="table-report-foreign has-border f12">
                    <tr class="text-center align-middle has-bg">
                        <th rowspan="2" style="width: 57%"><strong>DESCRIPTION OF {{ $proformaData->product_type_code != 10 ? 'GOODS' : 'CIGARETTES' }}</strong></th>
                        <th colspan="2"><strong>WEIGHT/KG(S)</strong></th>
                        <th rowspan="2"><strong>MEASUREMENTS MMS. PER<br> CARDBOAD BOX</strong></th>
                    </tr>
                    <tr class="text-center align-middle has-bg">
                        <!--WEIGHT/KG(S)-->
                        <th style="width: 9%"><strong>NET</strong></th>
                        <th style="width: 9%"><strong>GROSS</strong></th>
                    </tr>

                    @if (!empty($dataPiLotData[$keyCount]))
                    @foreach ($dataPiLotData[$keyCount] as $item)

                    <tr>
                        <td class="text-left">
                            {{ $item->quantity_cbb }} CARDBOAD BOXES {{ $item->report_item_display }}
                            {{-- {{ $item->approve_quantity }} {{ $item->name_for_report_exp }} {{ $item->report_item_display }} --}}
                        </td>
                        <td class="text-right"> {{ $item->total_weight_unit_net }} </td>
                        <td class="text-right"> {{ $item->total_weight_unit_gross }} </td>
                        <td class="text-center"> {{ $item->mms_per_box }} </td>
                    </tr>
                    @endforeach
                    @endif

                    @if ($keyCount == count($dataPiLotData))

                    <tr>
                        <td class="text-center" style="height: 100px">
                            {!! !empty($proformaData) ? nl2br($proformaData->shipping_marks) : '' !!}
                        </td>
                        <td class="text-right"></td>
                        <td class="text-right"></td>
                        <td>
                            <h5>PACKING {{ $proformaData->product_type_code == 10 ? '(10,000/20) ' : '' }} :</h5>
                            <p>
                                {!! !empty($proformaData) ? nl2br($proformaData->remark) : '' !!}
                            </p>
                            {{-- @if (!empty($packingData))

                                @foreach ($packingData as $keyPack => $itemPacking)
                                    @if ($proformaData->product_type_code == 10)
                                        @if ($itemPacking->tag == 10)
                                        {{ $itemPacking->meaning }} <br>
                                        @endif
                                    @else
                                        @if ($itemPacking->tag != 10)
                                        {{ $totalApprovePack }} {{ $itemPacking->meaning }} <br>
                                        @endif
                                    @endif
                                @endforeach
                            @endif --}}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <div class="d-flex justify-content-between pl-4 pr-4">
                                <span>
                                    <span class="d-inline-block pl-3"><span>{{ !empty($totalQuantity) ? $totalQuantity : 0 }}</span> CARDBOAD BOXES </span>
                                    {{-- <span class="d-inline-block pl-3"><span>{{ !empty($totalQuantity) ? $totalQuantity : '' }}</span> {{ !empty($orderLinesData[1][0]->name_for_report_exp) ? $orderLinesData[1][0]->name_for_report_exp : '' }}</span> --}}
                                </span>
                                <span>TOTAL</span>
                            </div>
                        </td>
                        <td class="text-right">{{ !empty($totalNet) ? $totalNet : '' }}</td>
                        <td class="text-right">{{ !empty($totalGross) ? $totalGross : '' }}</td>
                        <td class="text-center">
                            E&OE
                        </td>
                    </tr>

                    @endif
                </table>

                @if ($keyCount == count($dataPiLotData))

                <table class="table-report-foreign text-black f12 no-border table-footer">
                    <tr>
                        <td>ORIGINATED IN THAILAND</td>
                        <td>
                            <div class="d-block" style="float: right; position: relative;">
                                <div class="signature"></div>
                                <p class="mb-0"><small> {{ !empty($approveData) ? $approveData->meaning : '' }} </small></p>
                                <p class="mb-0"><small> {{ !empty($approveData) ? $approveData->description : '' }} </small></p>
                            </div>
                        </td>
                    </tr>
                </table>

                @endif


            </div><!--border-->
        </div><!--subpage-->
    </div><!--page-a4-->

    <p class="mb-0 text-center f12" style="bottom:10px position:fixed;"> Page {{ $keyCount }} / {{ count($dataPiLotData) }} </p>

    @endforeach

<script type="text/javascript">

</script>
</body>
</html>
