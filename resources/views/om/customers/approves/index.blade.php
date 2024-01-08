@extends('layouts.app')
@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }
</style>
@stop
@section('title', 'Search Customer Domestic')

@section('page-title')

    <h2><x-get-program-code url="/om/customers/approves" /> ขออนุมัติการสร้างลูกค้าใหม่</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/customers/approves" /> ขออนุมัติการสร้างลูกค้าใหม่</strong>
        </li>
    </ol>
@stop

@section('content')

    <div class="ibox ">

        <div class="ibox-content">

            <div class="table-responsive border-0">
                <table class="table table-responsive table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">Request Number</th>
                            <th class="text-center">ชื่อลูกค้า</th>
                            <th class="text-center" style="width: 30%;">ที่อยู่</th>
                            <th class="text-center">ประเทศ</th>
                            <th class="text-center">วันที่ส่ง</th>
                            <th class="text-center">อนุมัติ</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (!$approves) --}}
                            @php
                            $run = 1
                            @endphp
                            @foreach ($approves as $key => $result)

                                @if (!in_array($result->customer_id,$inArr))
                                        <tr>
                                        <td class="text-center align-middle"> {{ $run }} </td>
                                        <td class="text-center align-middle"> {{ $result->request_number }} </td>
                                        <td class="text-center align-middle"> {{ $result->customer_name }} </td>
                                        <td class="text-left align-middle">
                                            {{ $result->address_line1 }} {{ $result->address_line2 }} {{ $result->address_line2 }}

                                            @if ($result->country_code != 'TH')
                                            {{ $result->city }} {{ $result->state }}
                                            @else
                                            {{ $result->district }} {{ $result->city }} {{ $result->province_name }} {{ $result->postal_code }}
                                            @endif

                                        </td>
                                        <td class="text-center align-middle">
                                            {{ $result->country_as_name }}
                                        </td>
                                        <td class="text-center align-middle"> {{ date('d/m/Y H:i',strtotime($result->date_sent)) }} </td>
                                        <td class="text-center align-middle">
                                            {{-- @if ($result->status != 'Reject' && $result->status != 'Approval') --}}
                                            <a class="btn btn-primary" href="{{ url('/') }}/om/customers/approves/view/{{ $result->customer_id }}">รายละเอียด</a>
                                            {{-- @else
                                            <button class="btn btn-primary" href="javascript:void(0)" disabled>รายละเอียด</button> --}}
                                            {{-- @endif --}}
                                        </td>
                                        <td class="text-center align-middle"> {{ $result->approves_as_status }} </td>
                                    </tr>
                                    @php
                                    $run++
                                    @endphp
                                @endif
                                @php
                                if (!in_array($result->customer_id,$inArr)) {
                                    array_push($inArr,$result->customer_id);
                                }
                                @endphp

                            @endforeach
                        {{-- @else
                        <tr>
                            <td class="text-center" colspan="9"> ไม่พบข้อมูลลูกค้าสำหรับขายในประเทศ </td>
                        </tr>
                        @endif --}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
        });

    });

</script>
@stop
