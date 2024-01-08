
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        @include('ir.reports._style')
        {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
    </head>
        <body>
            <div class="row">
                <div  style=" width:20%;"> <b> Program Code : {{$program->program_code}} </b> </div>
                <div style="width:60%;" align="center"> <b> การยาสูบแห่งประเทศไทย </b> </div>
                <div style="width:10%;" align="right"> <b> วันที่ : </b> </div>
                <div style="width:10%;" align="left"> <b> {{ ' '. parseToDateTh(now()) }} </b> </div>
            </div>
            <div class="row">
                <div  style=" width:20%;"> <b> </b> </div>
                <div style="width:60%;" align="center"> <b> ชุดที่:  {{ $policySetDes  ?? "xxxxxxx" }}</b> </div>
                <div style="width:10%;" align="right"> <b> เวลา : </b> </div>
                <div style="width:10%;" align="left"> <b> {{ date('H:i', strtotime(now())) }} </b> </div>
            </div>
        
            <div class="row">
                <div  style=" width:20%;"> <b> </b> </div>
                <div style="width:60%;" align="center"> <b> {{$program->description}}</b> </div>
                <div style="width:10%;" align="right"> <b> หน้า :  </b> </div>
                <div style="width:10%;" align="left">
                    <b>
                        <div style="content: counter(page);">
                        </div>
                    </b>
                </div>
            </div>
            {{-- <div class="row">
                <div  style=" width:20%;"> <b> </b> </div>
                <div style="width:60%;" align="center"> <b>
                    @foreach ($companies as $company)
                        @if ($loop->last)
                            {{ " และ "  }}
                        @endif
                        {{  $company->company_name  }}
                    @endforeach
                </b> </div>
                <div style="width:10%;" align="right"> </div>
                <div style="width:10%;" align="left">
                    <b>
                    </b>
                </div>
            </div> --}}
        
        {{-- <table class="table" width="100%">
            <tr>
                <td style="border: 1px solid black" align="center" width="5%">ลำดับ</td>
                <td style="border: 1px solid black" align="center" width="35%">รายการ</td>
                <td style="border: 1px solid black" align="center" width="15%">มูลค่าทุนประกัน</td>
                <td style="border: 1px solid black" align="center" width="15%">อัตราเบี้ยประกัน</td>
                <td style="border: 1px solid black" align="center" width="15%">ค่าเบี้ยประกัน 100% </td>
                <td style="border: 1px solid black" align="center" width="15%">คำนวณปิดบัญชี</td>
            </tr>
        </table> --}}
    </body>
</html>
    


