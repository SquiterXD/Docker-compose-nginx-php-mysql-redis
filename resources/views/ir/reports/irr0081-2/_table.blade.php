@foreach($dataDebit as $location => $datas)
  <div class="page-break"></div>
	<table class="table-tb">
    <thead>
      <tr>
        <td align="left" colspan="4"><b>โปรแกรม :</b>{{$programCode}}</td>
        <td align="center" colspan="22"><b>การยาสูบแห่งประเทศไทย</b></td>
        <td align="right" colspan="4"><b> วันที่ : </b> {{ parseToDateTh(date('d/m/Y')) }}</td>
      </tr>
      <tr>
        <td align="left" colspan="4"><b>สั่งพิมพ์ : </b>{{ \Auth::user()->name }}</td>
        <td align="center" colspan="22"><b>ชุดที่ {{$location}} {{getPolicyName($location)}} </b></td>
        <td align="right" colspan="4"><b>เวลา : </b>{{ date('H:i') }}</td>
      </tr>
      <tr>
        <td align="left" colspan="4"></td>
        <td align="center" colspan="22"><b>{{ $program->description }} {{ $thaimonths[date('m', strtotime($month))]}}  {{ date('Y', strtotime($month))+543 }}</b></td>
        <td align="right" colspan="4"><b style="margin-right: 25px;">  หน้า : </b></td>
      </tr>
    </thead>
	</table>

  <div style="margin-top: 10px;"> <strong> Debit </strong> </div>
  <div>
    <table class="table" style="width: 100%">
      <thead>
          <tr style="background-color: #dcdfdb; border: 0.5px solid #000;">
            <th style="border: 0.5px solid #000; width: 20px;">ลำดับ</th>
            <th style="border: 0.5px solid #000;">รายการ</th>
            <th style="border: 0.5px solid #000; width: 120px;">รหัสบัญชี</th>
            <th style="border: 0.5px solid #000;">ชื่อบัญชี</th>
            <th style="border: 0.5px solid #000; width: 110px;">ค่าเบี้ยประกันภัย (บาท)</th>
            <th style="border: 0.5px solid #000; width: 95px;">จ่ายล่วงหน้า/ค้างจ่าย</th>
          </tr>
      </thead>
      <tbody>
        @foreach ($datas as $list)
          @php
            $endingText = '';
            
              if ($list->ending_amount >= 0) {
                $endingText = 'จ่ายล่วงหน้า';
              }else {
                $endingText = 'ค้างจ่าย';
              }
          @endphp
            <tr>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> {{ $loop->iteration }} </td>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $list->department_name }} </td>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $list->expense_account }} </td>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $list->prepaid_account_desc }} </td>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: right;"> {{ number_format($list->net_amount, 2) }} </td>
              <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> {{ $endingText }} </td>
            </tr>
        @endforeach
        <tr style="background-color: #dcdfdb;">
          @php
            $totalDebit = $datas->sum('net_amount');
          @endphp
          <th style="text-align: center; border: 0.5px solid #000;" colspan="4">
            <strong>รวมทั้งสิ้น</strong>
          </th>
          <th style="text-align: right; border: 0.5px solid #000;"> 
            <strong>{{ number_format($totalDebit, 2) }}</strong>
          </th>
          <th style="text-align: right; border: 0.5px solid #000;"> 
          </th>
        </tr>
      </tbody>
    </table>
  </div>

  <div style="margin-top: 10px;"> <strong> Credit </strong> </div>
  <div>
    <table class="table" style="width: 100%">
      <thead>
          <tr style="background-color: #dcdfdb; border: 0.5px solid #000;">
            <th style="border: 0.5px solid #000; width: 180px;">ประเภทค่าใช้จ่าย</th>
            <th style="border: 0.5px solid #000; width: 120px;">รหัสบัญชี</th>
            <th style="border: 0.5px solid #000;">ชื่อบัญชี</th>
            <th style="border: 0.5px solid #000; width: 110px;">ค่าเบี้ยประกันภัย (บาท)</th>
            <th style="border: 0.5px solid #000; width: 95px;">จ่ายล่วงหน้า/ค้างจ่าย</th>
          </tr>
      </thead>
      <tbody>
        @php
          $totalCredit = 0;
          $dataCreditPrepaid  = $datas->where('ending_amount', '>=', 0);
          $dataCreditAccrued  = $datas->where('ending_amount', '<', 0);
          $dataCredit         = $datas->first();

          $netAmountPrepaid = $dataCreditPrepaid ? $dataCreditPrepaid->sum('net_amount') : 0;
          $netAmountAccrued = $dataCreditAccrued ? $dataCreditAccrued->sum('net_amount') : 0;

        @endphp
        <tr>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> ค่าประกันภัยจ่ายล่วงหน้า </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $dataCredit ? $dataCredit->prepaid_account : '' }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $dataCredit ? $dataCredit->prepaid_account_desc : '' }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: right;"> {{ $dataCreditPrepaid ? number_format($netAmountPrepaid, 2) : 0 }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> จ่ายล่วงหน้า </td>
        </tr>
        <tr>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> ค่าประกันภัยค้างจ่าย </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $accrued ? $accrued->description : '' }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $accrued ? $accrued->attribute1 : '' }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: right;"> {{ $dataCreditAccrued ? number_format($netAmountAccrued, 2) : 0 }} </td>
          <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> ค้างจ่าย </td>
        </tr>
        <tr style="background-color: #dcdfdb;">
          <th style="text-align: center; border: 0.5px solid #000;" colspan="3">
            <strong>รวมทั้งสิ้น</strong>
          </th>
          <th style="text-align: right; border: 0.5px solid #000;"> 
            <strong>{{ number_format($netAmountPrepaid + $netAmountAccrued, 2) }}</strong>
          </th>
          <th style="text-align: right; border: 0.5px solid #000;"> 
          </th>
        </tr>
      </tbody>
    </table>
  </div>

@endforeach

{{-- <div style="margin-top: 10px;"> <strong> Credit </strong> </div>
<div>
  <table class="table" style="width: 100%">
    <thead>
        <tr style="background-color: #dcdfdb; border: 0.5px solid #000;">
          <th style="border: 0.5px solid #000;">ประเภทค่าใช้จ่าย</th>
          <th style="border: 0.5px solid #000;">รหัสบัญชี</th>
          <th style="border: 0.5px solid #000;">ชื่อบัญชี</th>
          <th style="border: 0.5px solid #000;">ค่าเบี้ยประกันภัย (บาท)</th>
          <th style="border: 0.5px solid #000;">จ่ายล่วงหน้า/ค้างจ่าย</th>
        </tr>
    </thead>
    <tbody>
      @php
        $totalCredit = 0;
      @endphp
      @foreach ($dataCredit as $account => $lists)
        @php
          $list         = $lists->first();
          $net_amount   = $lists->sum('net_amount');
          $totalCredit += $net_amount;
          // dd($dataCredit, $account, $lists->first());
          $endingText = '';
          
            if ($list->ending_amount >= 0) {
              $endingText = 'จ่ายล่วงหน้า';
            }else {
              $endingText = 'ค้างจ่าย';
            }
        @endphp
          <tr>
            <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> {{ $list->prepaid_account }} </td>
            <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $list->prepaid_account }} </td>
            <td style="border-left:0.5px solid #000; border-right:0.5px solid #000;"> {{ $list->prepaid_account_desc }} </td>
            <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: right;"> {{ $net_amount }} </td>
            <td style="border-left:0.5px solid #000; border-right:0.5px solid #000; text-align: center;"> {{ $endingText }} </td>
          </tr>
      @endforeach
      <tr style="background-color: #dcdfdb;">
        <th style="text-align: center; border: 0.5px solid #000;" colspan="3">
          <strong>รวมทั้งสิ้น</strong>
        </th>
        <th style="text-align: right; border: 0.5px solid #000;"> 
          <strong>{{ number_format($totalCredit, 2) }}</strong>
        </th>
        <th style="text-align: right; border: 0.5px solid #000;"> 
        </th>
      </tr>
    </tbody>
  </table>
</div> --}}