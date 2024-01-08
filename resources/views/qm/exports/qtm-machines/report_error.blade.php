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
<table class="table table-bordered">

    <thead>
        <tr>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;">
                โปรแกรม : {{ $programCode }}
            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;">
                การยาสูบแห่งประเทศไทย
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;">
                วันที่ {{ $reportDate }}
            </th>
        </tr>
        <tr>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;">

            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;">
                <p style="font-size: 16px; font-weight: bold;">  </p>
            </th>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;">
                เวลา {{ $reportTime }}
            </th>
        </tr>
        <tr>
            <th colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: left; padding-left: 10px;">
                {{-- หน่วยงาน : กองควบคุมคุณภาพผลิตภัณฑ์และวัตถุดิบ --}}
            </th>
            <th colspan="5" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: center;">
                <p class="tw-mb-0" style="font-size: 14px; font-weight: bold;"> ประจำวันที่ {{ $sampleDateFrom }} ถึงวันที่ {{ $sampleDateTo }} </p>
            </th>
            <th width="15" colspan="1" style="height: 30px; border: 1px solid #ffffff; font-weight: bold; vertical-align: middle; text-align: right; padding-right: 10px;">
            </th>

        </tr>

        <tr>
            <td style="font-size: 12px; font-weight: bold;" >date_time</td>
            <td style="font-size: 12px; font-weight: bold;" >brand</td>
            <td style="font-size: 12px; font-weight: bold;" >maker</td>
            <td style="font-size: 12px; font-weight: bold;" >file_name</td>
            <td style="font-size: 12px; font-weight: bold;" >interface_name</td>
            <td style="font-size: 12px; font-weight: bold;" >creation_date</td>
            <td style="font-size: 12px; font-weight: bold;" >interface_msg</td>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $line)
            <tr>
                <td>{{ $line->date_time }}</td>
                <td>{{ $line->brand }}</td>
                <td>{{ $line->maker }}</td>
                <td>{{ $line->file_name }}</td>
                <td>{{ $line->interface_name }}</td>
                <td>{{ $line->creation_date }}</td>
                <td>{{ $line->interface_msg }}</td>
            </tr>
        @endforeach
    </tbody>
</table>