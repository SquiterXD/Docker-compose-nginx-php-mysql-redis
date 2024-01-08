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
    <h2>
        <x-get-program-code url="/om/release-credit" /> คืนวงเงินเชื่อ สำหรับขายในประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/release-credit" /> คืนวงเงินเชื่อ สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')

<div class="ibox">
    <div class="ibox-title">
        <h3>OMP0004 คืนวงเงินเชื่อ สำหรับขายในประเทศ</h3>
    </div><!--ibox-title-->
    <div class="ibox-content">


        <div class="row space-50 justify-content-md-center mw-xl-1000 mt-md-4">
            <div class="col-xl-10">
                <form method="get">
                    <div class="form-header-buttons">
                        <div class="d-md-flex align-items-center">
                            <label class="nowrap pr-3">รหัสร้านค้า <span style="color:red;">*</span></label>

                            <div class="input-icon mr-md-2 mr-0">
                                <input type="text" class="form-control" name="customer_number" id="customer_number" autocomplete="off" placeholder="" value="{{ (request()) ? request()->customer_number : '' }}" list="customer-list" required onchange="custchange(this.value);">
                                <i class="fa fa-search"></i>
                                <datalist id="customer-list">
                                    @foreach ($customers as $item)
                                        @if ($item['customer_number'] != '')
                                        <option value="{{ $item['customer_number'] }}">{{ $item['customer_name'] }}</option>
                                        @endif
                                    @endforeach
                                </datalist>
                            </div>
                            <input type="text" id="customer_name" name="customer_name" class="form-control w-250 w-xl-auto mt-md-0 mt-2" value="{{ (request()) ? request()->customer_name : '' }}" readonly>
                        </div>
                        <div class="buttons d-flex mt-2 mt-md-0">
                            <button class="btn btn-md btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-primary" type="button" id="save_data"><i class="fa fa-save"></i> บันทึก</button>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                </form>
            </div>

            <div class="col-xl-10">
                <div class="table-responsive-md">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width: 150px">กลุ่มเงินเชื่อ</th>
                                <th>Invoice No.</th>
                                <th>Due Date</th>
                                <th>จำนวนเงิน</th>
                                <th>ค่าปรับ</th>
                                <th style="width: 150px">ต้องการชำระเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Outstanding as $item)
                                @if($item['credit_group_code'] != 0)
                                <tr>
                                    <td>
                                        @if($item['credit_group_code'] == 0)
                                            เงินสด
                                        @else
                                            {{ $item['credit_group_code'] }}
                                        @endif
                                    </td>
                                    <td>{{ $item['pick_release_no'] }}</td>
                                    <td>{{ $item['due_date'] }}</td>
                                    <td>{{ number_format($item['amount'],2) }}</td>
                                    <td>{{ number_format($item['penalty_total'],2) }}</td>
                                    <td>
                                        @if($item['flag'] == 'Y')
                                        <input type="checkbox" disabled value="{{ $item['no'] }}" {{ ($item['flag'] == 'Y') ? 'checked' : '' }}>
                                        @else
                                        <input type="checkbox" name="release_credit_checked[]" {{ ($item['flag'] == 'Y') ? 'checked' : '' }} data-charge="{{ $item['penalty_total'] }}" value="{{ $item['no'] }}">
                                        @endif

                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--row-->
    </div><!--ibox-content-->
</div><!--ibox-->

@endsection

@section('scripts')
<!-- Page-Level Scripts -->
<script>

    let customerlists = {!! json_encode($customers) !!};

    function custchange(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name']);
            }
        }else{
            $('#customer_name').val('');
        }
    }

    $("#save_data").click(async function(e){
        let formData = new FormData();

        formData.append('_token', "{{ csrf_token() }}");

        var list = await $("input[name='release_credit_checked[]']:checked").map(function () {
            return this.value;
        }).get();
        formData.append('release_credit', list);

        var charge = await $("input[name='release_credit_checked[]']:checked").map(function () {
            return $(this).data('charge');
        }).get();
        formData.append('charge_amount', charge);

        if(list.length > 0){
            swal({
                title: "คุณต้องการบันทึกข้อมูล?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: false
            },function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'post',
                        url: "{{ url('/')}}/om/release-credit/update",
                        data: formData,
                        enctype: 'multipart/form-data',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            location.reload();
                        },
                        error: function (data) {
                        }
                    });
                } else {
                    swal.close()
                }
            });
        }else{
            swal("Warning!", "Please select release credit", "error");
        }


    });
</script>
@stop
