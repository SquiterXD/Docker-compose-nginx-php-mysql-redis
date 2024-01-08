@foreach($G1s->sortBy('polycy_set')->groupBy('polycy_set') as $PolicySetH =>$G1_s)

    <div class="page-break"></div>
	<table class="table-tb">
	<thead>
	<tr>
          <td align="left" colspan="4"><b>โปรแกรม :</b>{{$program->program_code}}</td>
          <td align="center" colspan="22"><b>การยาสูบแห่งประเทศไทย</b></td>
          <td align="right" colspan="4"><b> วันที่ : </b> {{ date('d/m/Y', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"><b>สั่งพิมพ์ : </b>{{ \Auth::user()->name }}</td>
          <td align="center" colspan="22"><b>ชุดที่ {{$PolicySetH}}  : {{$G1_s[0]->polycy_desc_set}}</b></td>
          <td align="right" colspan="4"><b>เวลา : </b>{{ date('H:i', strtotime(now())) }}</td>
        </tr>
        <tr>
          <td align="left" colspan="4"></td>
          <td align="center" colspan="22"><b>{{$program->description}} {{$ParamMont}}</b></td>
          <td align="right" colspan="4"><b style="margin-right: 25px;">  หน้า : </b></td>
        </tr>
        @php
        $total = 0;
    @endphp
		<tr>
            <td align="left" colspan="30"><b><br> <u> Debit </u> </b></td>
        </tr>
        <tr>
        <td colspan="30"></td>
        </tr>
		<tr style="background-color: #d9d9d9;">
            <td class="td-border-full font-bold" align="center" colspan="1" width="1px"><b>ลำดับ</b></td>
            <td class="td-border-full font-bold" align="center" colspan="6"><b>รายการ</b></td>
            <td class="td-border-full font-bold" align="center" colspan="5"><b>รหัสบัญชี</b></td>
            <td class="td-border-full font-bold" align="center" colspan="12"><b>ชื่อบัญชี</b></td>
            <td class="td-border-full font-bold" align="center" colspan="3"><b>ค่าเบี้ยประกัน(บาท)</b></td>
			<td class="td-border-full font-bold" align="center" colspan="3"><b>ค่ายล่วงหน้า/ค้างจ่าย</b></td>
        </tr>
        </thead>
	@foreach($G1s as $G1h)
		@foreach($G1 as $G1l)
		<tr>
        <td class="td-border-lr" align="center" colspan="1">{{ $loop->iteration }}</td>
        <td class="td-border-lr" align="left" colspan="6">{{$G1l->stock_list_description}}</td>
        <td class="td-border-lr" align="center" colspan="5">{{$G1l->expense_account}}</td>
        <td class="td-border-lr" align="left" colspan="12">{{$G1l->expense_account_desc}}</td>
        <td class="td-border-lr" align="right" colspan="3">{{number_format($G1l->net_amount,2)}}</td>
		<td class="td-border-lr" align="center" colspan="3">{{$G1l->record_type}}</td>
    </tr>
		@endforeach
		<tr>
        <td class="td-border-lr" align="center" colspan="24"><b>รวมทั้งสิ้น</b></td>
        <td class="td-border-lr" align="right" colspan="3"><b>{{number_format($G1h->sum_debit,2)}}</b></td>
        <td class="td-border-lr" align="right" colspan="3"></td>
    </tr>
	@endforeach
	<tr>
        <td colspan="30"></td>
      </tr>
    <tr>
    <td align="left" colspan="30"><b><br> <u> Credit </u> </b></td>
    </tr>
    <tr>
        <td colspan="30"></td>
    </tr>
	<tr style="background-color: #d9d9d9;">
        <td class="td-border-full font-bold" align="center" colspan="7"><b>ประเภทค่าใช้จ่าย</b></td>
        <td class="td-border-full font-bold" align="center" colspan="5"><b>รหัสบัญชี</b></td>
        <td class="td-border-full font-bold" align="center" colspan="12"><b>ชื่อบัญชี</b></td>
        <td class="td-border-full font-bold" align="center" colspan="3"><b>ค่าเบี้ยประกัน(บาท)</b></td>
        <td class="td-border-full font-bold" align="center" colspan="3"><b>จ่ายล่วงหน้า/ค้างจ่าย</b></td>
    </tr>
	@foreach($G2s as $G2h)
		@foreach($G2 as $G2l)
		<tr>
        <td class="td-border-lr" align="center" colspan="7">{{$G2l->account_description}}</td>
        <td class="td-border-lr" align="center" colspan="5">{{$G2l->account_code_combine}}</td>
        <td class="td-border-lr" align="left" colspan="12">{{$G2l->account_combine_desc}}</td>
        <td class="td-border-lr" align="right" colspan="3">{{number_format($G2l->entered_cr,2)}}</td>
        <td class="td-border-lr" align="center" colspan="3">{{$G2l->record_type}}</td>
    </tr>
		@endforeach
		<tr>
        <td td class="td-border-lr" align="center" colspan="24"><b>รวมทั้งสิ้น</b></td>
        <td td class="td-border-lr" align="right" colspan="3"><b>{{number_format($G2h->sum_credit,2)}}</b></td>
        <td td class="td-border-lr" align="center" colspan="3"></td>
    </tr>
	@endforeach
	</table>

@endforeach