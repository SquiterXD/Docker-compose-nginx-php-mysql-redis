
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        @php 
        $page=0;
        @endphp
        @foreach ($dataLists->groupBy('policy_set') as $dataListByPolicyS=>$dataListByPolicy)
        @foreach($dataListByPolicy->groupBy('company_name') as $dataListByComS=>$dataListByCom)
        @foreach($dataListByCom->groupBy('user_policy_number') as $dataListByUserPoS=>$dataListByUserPo)
        @foreach($dataListByUserPo->groupBy('status') as $dataListByStatusS => $dataListByStatus)
        @php 
        $page=$page+1;
        @endphp
        <table  width="100%">
            <tr>
                    <td > <b> โปรแกรม : IRR7010 </b></td>
                    <td colspan="8" align="center"><b>การยาสูบแห่งประเทศไทย</b></td>
                    <td ><b>วันที่ :  </b> {{ date('d/m/Y', strtotime(now())) }}</td>
            </tr>
            <tr >
                    <td ><b>สั่งพิมพ์ : </b> {{$user}}</td>
                    <td  colspan="8" align="center"><b> {{$dataListByPolicyS??''}}</b></td>
                    <td  ><b>เวลา :  </b> {{ date('H:i', strtotime(now()))}}</td>
                    
            </tr>
            <tr >
                <td  ></td>
                <td colspan="8" align="center"><b>รายละเอียดมูลค่าทุนประกันภัยทรัพย์สิน (เพิ่ม / ลด) และการคำนวณค่าเบี้ยประกันภัยโดยการประกันแบบ Replacement Value</b></td>
                <td ><b>หน้า :  </b> {{$page.'/'.$toPage}}</td>
            </tr>
            
            <tr >
                <td ></td>
                <td colspan="8" align="center"><b> {{ $dataListByComS}}</b></td>
                <td></td>
            </tr>
            @php
                if(is_null($startDate)){
                    
                    $start ='';
                    $END ='';
                }else{
                    $start ='ตั้งแต่วันที่ ';
                    $END =' ถึงวันที่ ';
                    
                }
                @endphp
            <tr >
                <td ></td>
                <td colspan="8" align="center"><b> {{$start}}</b>{{$startDate}}<b> {{$END}}</b>{{$endDate}}</td>
                <td></td>
                <td></td>
            </tr>
            <tr></tr>
            <tr >
                <td  colspan="3"><b>เลขที่กรมธรรม์ : </b>
                {{$dataListByUserPoS??''}}</td>
                <td colspan="4"></td>
                <td colspan="3" align="right"><b>เลขที่สลักหลัง :</b> {{$dataListByUserPo[0]->comments}}</td>
            </tr>
            <tr>
                <td><b>สถานะ : </b> {{$dataListByStatusS}}</td>
                
            </tr>
            <tr></tr>
            <tr></tr>
            @include('ir.reports.irr7010.excel._table')
        </table>
        @endforeach
        @endforeach
        @endforeach
        @endforeach
        <tr></tr>
    </body>
</html>
