<!DOCTYPE html>
<html>
    <head></head>
    <body style="
        width: 100% !important;
        height: 100%;
        line-height: 1.6;">
        <table style="width: 100%;">
            <tr>
                <td>
                    <img class="img-circlex "
                        style="
                            max-height: 90px;
                            position: relative;
                            padding: 6px 0;
                            line-height: 90px;
                            vertical-align: middle;"
                        src="https://media.thaigov.go.th/uploads/thumbnail/news/2021/04/IMG_40708_20210405164426000000.jpg" alt="">
                </td>
                <td> <h2> การยาสูบแห่งประเทศไทย </h2> </td>
            </tr>
        </table>
        <br>
        <div>
            <span><strong> เรื่อง : {{ $subject }} </strong></span>
        </div>
        <div>
            <span><strong> เรียน : {{ $receiverNames }} </strong></span>
        </div>
        <br>
        <div>
            <span><strong> หัวข้อการเกิดเหตุ : </strong> {{ $header->claim_title }} </span>
        </div>
        <div>
            <span><strong> ผู้แจ้งเหตุ : </strong> {{ $header->requestor_name }} </span>
        </div>
        <div>
            <span><strong> สถานที่เกิดเหตุ : </strong> {{ $header->location_name }} </span>
        </div>
        <div>
            <span><strong> วันที่เกิดเหตุ : </strong> {{ convertToFormatMail(date('d-m-Y', strtotime($header->accident_date))) }} </span>
        </div>
        <div>
            <span><strong> เวลาเกิดเหตุ : </strong> {{ date('H:i', strtotime($header->accident_time)) }} น. </span>
        </div>
        <div>
            <span><strong> รายละเอียดเหตุการณ์ : </strong> {!! $header->remarks !!} </span>
        </div>
        <br>
        @foreach ($defaultDesc as $desc)
            <div class="row">
                <div class=""> {{ $desc->description }} </div>
            </div>
        @endforeach

    </body>


</html>