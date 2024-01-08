<link rel="stylesheet" href="{{ public_path('css\pdf.css') }}" media="all" />
<link rel="stylesheet" href="{{ public_path('css\app.css') }}" media="all" />
<style>
    
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
    }

    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
    }

    body {
        font-family: "THSarabunNew";
    }

</style>

<div style="min-height: 120px;">

    <h5 class="text-center tw-font-bold"> รายงานใบเบิกวัตถุดิบ </h5>

    <table border="0" width="100%" style="font-size: 14px;">
        <tr>
            <td width="60%" class="text-left"> 
                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> หน่วยงานที่เบิก </div> 
                    <div style="width: 55%;"class="tw-inline-block"> ฝ่ายการพิมพ์ กองพิมพ์ </div>
                </div>

                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> เบิกจากคลัง </div> 
                    <div style="width: 55%;"class="tw-inline-block"> - </div>
                </div>

                <div>
                    <div style="width: 35%;" class="tw-inline-block tw-font-bold"> คำสั่งผลิตเลขที่ </div> 
                    <div style="width: 55%;"class="tw-inline-block"> {{ $productMachineRequests[0]["request_number"] }} </div>
                </div>

            </td>
            <td width="40%" class="text-right"> 
                <div>
                    <div style="width: 35%;" class="text-left tw-inline-block tw-font-bold"> เลขที่ </div> 
                    <div style="width: 55%;" class="text-left tw-inline-block"> {{ $productMachineRequests[0]["request_number"] }} </div>
                </div>
                <div>
                    <div style="width: 35%;" class="text-left tw-inline-block tw-font-bold"> วันที่ </div> 
                    <div style="width: 55%;" class="text-left tw-inline-block"> {{ $productMachineRequests[0]["formatted_creation_date"] }} </div>
                </div>
            </td>
        </tr>
    </table>
    
</div>

<div style="min-height: 640px;">

    <table border="1" width="100%" style="font-size: 14px;">
        <thead>
            <tr>
                <th width="10%" class="text-center"> ลำดับที่ </th>
                <th width="20%" class="text-center"> รหัสสินค้า </th>
                <th width="40%" class="text-center"> รายการ </th>
                <th width="10%" class="text-center"> หน่วยนับ </th>
                <th width="20%" class="text-center"> จำนวนที่เบิก </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productMachineRequests as $index => $productMachineRequest)
            <tr>
                <td width="10%" class="tw-px-2 text-center"> {{ $index+1 }} </td>
                <td width="20%" class="tw-px-2 text-center"> {{ $productMachineRequest["inv_item_number"] }} </td>
                <td width="40%" class="tw-px-2 text-left"> {{ $productMachineRequest["inv_item_desc"] }} </td>
                <td width="10%" class="tw-px-2 text-center"> {{ $productMachineRequest["uom2"] }} </td>
                <td width="20%" class="tw-px-2 text-right"> {{ number_format($productMachineRequest["request_qty"], 2, '.', ',') }} </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div style="min-height: 140px;">

    <table border="0" width="100%" style="font-size: 14px;">
        <tr>
            <td width="33.33%" class="text-center"> 
                <p> ผู้เบิก .................................................... </p>
                <p> ( ......................................................... ) </p>
                <p> ตำแหน่ง .................................................. </p>
                <p> วันที่ ............... / .................. / ............... </p>
            </td>
            <td width="33.33%" class="text-center"> 
                <p> ผู้อนุมัติ .................................................... </p>
                <p> ( ......................................................... ) </p>
                <p> ตำแหน่ง .................................................. </p>
                <p> วันที่ ............... / .................. / ............... </p>
            </td>
            <td width="33.33%" class="text-center"> 
                <p> ผู้จ่าย .................................................... </p>
                <p> ( ......................................................... ) </p>
                <p> ตำแหน่ง .................................................. </p>
                <p> วันที่ ............... / .................. / ............... </p>
            </td>
        </tr>
    </table>

</div>