

    @foreach($G1_DATAH->sortBy('policy_set_header_id')->groupBy('policy_set_header_id') as $PolicySetH =>$G1_DATA)  
    <div class="page-break">
    <div class="page-break"></div>
    <table class="table-tb">
    <thead>
        <tr>
          <td align="left" colspan="4"><b>โปรแกรม :</b>{{$program->program_code}}</td>
          <td style="font-size: 18px" align="center" colspan="19"><b>การยาสูบแห่งประเทศไทย</b></td>
          <td align="right" colspan="4"><b> วันที่ : </b> {{ date('d/m/Y', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"><b>สั่งพิมพ์ :</b> {{ \Auth::user()->name }}</td>
          <td style="font-size: 18px" align="center" colspan="19"><b>ชุดที่ {{$PolicySetH}}  : {{$G1_DATA[0]->policy_set_description}}</b></td>
          <td align="right" colspan="4"><b>เวลา : </b>{{ date('H:i', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"></td>
          <td style="font-size: 18px" align="center" colspan="19"><b>{{$program->description}} {{$ParamMont}}</b></td>
          <td align="right" colspan="4"><b style="margin-right: 30px;">  หน้า : </b></td>
        </tr>
        <tr>
            <td align="left" colspan="30"><b><br> <u> Debit </u> </b></td>
        </tr>
        <tr style="background-color: #d9d9d9;">
            <td class="td-border-full font-bold" align="center" colspan="1" width="1px"><b>ลำดับ</b></td>
            <td class="td-border-full font-bold" align="center" colspan="6"><b>รายการ</b></td>
            <td class="td-border-full font-bold" align="center" colspan="5"><b>รหัสบัญชี</b></td>
            <td class="td-border-full font-bold" align="center" colspan="12"><b>ชื่อบัญชี</b></td>
            <td class="td-border-full font-bold" align="center" colspan="3"><b>ค่าเบี้ยประกัน(บาท)</b></td>
        </tr>
    </thead>
<tbody>
    @php
        $total = 0;
    @endphp
    @foreach($G1_DATA->sortBy('location_name')->groupBy('location_name') as $locationname => $G1Ds )

    
    <tr>
        <td class="td-border-lr" align="center" colspan="1"><b>{{ $loop->iteration }}</b></td>
        <td class="td-border-lr" align="left" colspan="6"><b>{{ $locationname}}</b></td>
        <td class="td-border-lr" align="center" colspan="5"><b></b></td>
        <td class="td-border-lr" align="center" colspan="12"><b></b></td>
        <td class="td-border-lr" align="center" colspan="3"> <b></b></td>
    </tr>

    @php
        $sumLocations = 0;
    @endphp

    @foreach ($G1Ds->sortBy('department_name')->groupBy('department_name') as $departmentName => $G1D)
    <tr>
        <td class="td-border-lr" align="center" colspan="1"><b> {{ $loop->parent->iteration}}.{{ $loop->iteration }}</b></td>
        <td class="td-border-lr" align="left" colspan="6"><b>{{ $departmentName }}</b></td>
        <td class="td-border-lr" align="center" colspan="5"><b></b></td>
        <td class="td-border-lr" align="center" colspan="12"><b></b></td>
        <td class="td-border-lr" align="center" colspan="3"><b></b></td>
    </tr>
    @php
        $sumCategory = 0;
    @endphp
    @foreach ($G1D->sortBy('category_desc')->groupBy('category_desc') as $catDesc => $G1DByCats )

    @php
        $sumCategory += $G1DByCats->sum('net_amt');
    @endphp
    <tr>
        <td class="td-border-lr" align="center" colspan="1"><b></b></td>
        <td class="td-border-lr" align="left" colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$catDesc}}</td>
        <td class="td-border-lr" align="center" colspan="5">{{ $G1DByCats[0]->expense_account }}</td>
        <td class="td-border-lr" align="left" colspan="12">{{ $G1DByCats[0]->expense_account_desc }}</td>
        <td class="td-border-lr" align="right" colspan="3"><b>{{ number_format($G1DByCats->sum('net_amt'), 2) }}</b></td>
    </tr>
    @if($loop->last)
    @php
        $sumLocations += $sumCategory;
    @endphp
    <tr>
        
        <td style="background-color: #d9d9d9;" class="td-border td-border-l" align="center" colspan="24"><b>รวม : {{$departmentName}}</b></td>
        
        <td style="background-color: #d9d9d9;" class="td-border td-border-l" align="right" colspan="3"><b>{{ number_format($sumCategory, 2)}}</b></td>
    </tr>
    @endif
    @endforeach
    @if($loop->last)
    @php
        $total += $sumLocations;
    @endphp
    <tr>
        
        <td style="background-color: #d9d9d9;" class="td-border2 td-border-l" align="center" colspan="24"><b>รวม : {{$locationname}}</b></td>
        
        <td style="background-color: #d9d9d9;" class="td-border2" align="right" colspan="3"><b>{{ number_format($sumLocations, 2)}}</b> </td>
    </tr>
    @endif
    @endforeach
    @if($loop->last)
    <tr>
        
        <td style="background-color: #d9d9d9;" class="td-border2 td-border-l" align="center" colspan="24"><b>รวมทั้งสิ้น</b></td>
        
        <td style="background-color: #d9d9d9;" class="td-border2" align="right" colspan="3"><b>{{ number_format($total, 2) }}</b></td>
    </tr>
    @endif
    @endforeach
</tbody>
</table>
</div>
<!-- <div class="page-break"></div> -->
<table class="table-tb" style="margin-top:-14px">
    <thead>
    <tr>
          <td align="left" colspan="4"><b><b>โปรแกรม :</b>{{$program->program_code}}</b></td>
          <td align="center" colspan="19"><b>การยาสูบแห่งประเทศไทย</b></td>
          <td align="right" colspan="4"><b> วันที่ : </b> {{ date('d/m/Y', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"><b>สั่งพิมพ์ :</b> {{ \Auth::user()->name }}</td>
          <td align="center" colspan="19"><b><b>ชุดที่ {{$PolicySetH}}  : {{$G1_DATA[0]->policy_set_description}}</b></td>
          <td align="right" colspan="4"><b>เวลา : </b>{{ date('H:i', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"></td>
          <td align="center" colspan="19"><b>{{$program->description}} {{$ParamMont}}</b></td>
          <td align="right" colspan="4"><b style="margin-right: 30px;">  หน้า : </b></td>
        </tr>
    <tr>
        <br>
        <td align="left" colspan="30" text-decoration="underline"><b><br><u>Credit</u></b></td>
    </tr>
    <tr style="background-color: #d9d9d9;">
    <!-- <td lass="td-border-none" align="center" colspan="1"><b>ลำดับ</b></td> -->
    <td class="td-border-full" align="center" colspan="6"><b>รายการ</b></td>
    <td class="td-border-full" align="center" colspan="5"><b>รหัสบัญชี</b></td>
    <td class="td-border-full" align="center" colspan="12"><b>ชื่อบัญชี</b></td>
    <td class="td-border-full" align="center" colspan="3"><b>ค่าเบี้ยประกัน(บาท)</b></td>
    </tr>
    </thead>

    <tbody>

    @foreach($G1_DATA->sortBy('prepaid_account')->groupBy('prepaid_account') as $locationname => $G1Ds )
    <tr>
        <!-- <td class="td-border-none" align="center" colspan="1"><b>{{ $loop->iteration }}</b></td> -->
        <td class="td-border-lr" align="center" colspan="6">{{$G1Ds[0]->credit_desc}}</td>
        <td class="td-border-lr" align="center" colspan="5">{{$G1Ds[0]->prepaid_account}}</td>
        <td class="td-border-lr" align="left" colspan="12">{{$G1Ds[0]->prepaid_account_desc}}</td>
        <td class="td-border-lr" align="right" colspan="3">{{ number_format($G1Ds->sum('net_amt'),2)}}</td>
    </tr>
    @endforeach
    <tr>

        <td style="background-color: #d9d9d9;" class="td-border3 td-border-l" align="center" colspan="6"><b>รวมทั้งสิ้น</b></td>
        <td style="background-color: #d9d9d9;" class="td-border3" align="center" colspan="5"><b></b></td>
        <td style="background-color: #d9d9d9;"class="td-border3" align="left" colspan="12"><b></b></td>
        <td style="background-color: #d9d9d9;" class="td-border3" align="right" colspan="3"><b>{{ number_format($G1_DATA->sum('net_amt'),2)}}</b></td>
    </tr>
    </tbody>
</table>
<!-- <div class="page-break"></div> -->
@endforeach




