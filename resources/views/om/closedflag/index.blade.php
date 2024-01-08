@extends('layouts.app')

@section('title', 'ปิดการขายประจำวัน')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        {{-- <x-get-program-code url="/om/close-flag/{{ $type }}" /> ปิดการขายประจำวัน --}}
        <x-get-page-title menu="" url="/om/close-flag/{{ $type }}" />
    </h2>
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/close-flag/{{ $type }}" /> ปิดการขายประจำวัน</strong>
        </li>
    </ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปิดการขายประจำวัน</h3>
        </div>
        {{-- <form action="{{ route('om.close-flag-process') }}" method="POST">
            @csrf --}}
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-6 m-auto mt-4">
                    <div class="form-group">
                        <label class="d-block">วันที่ปิดการขาย</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="date" placeholder="" value="" list="date" onchange="release(this.value);">
                            <i class="fa fa-calendar"></i>
                            <datalist id="date">
                                <option></option>
                                @foreach ($dataDate as $value)
                                    <option>{{ date_format(date_create($value->pick_release_approve_date),'Y-m-d') }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">หมายเลขเอกสาร</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="number" placeholder="" value="" list="number">
                            <i class="fa fa-search"></i>
                            <datalist id="number">
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Group ID</label>
                        <input type="text" class="form-control" disabled="" name="groupid" placeholder="" value="">
                    </div>

                    <div class="form-group">
                        <label class="d-block">หมายเหตุ</label>
                        <input type="text" class="form-control" disabled="" name="remark" placeholder="" value="">
                    </div>
                </div><!--col-xl-6-->

                <div class="col-12">
                    <div class="form-buttons">
                        <button class="btn btn-lg btn-secondary" type="button" onclick="sendinterface();"><i class="fa fa-exchange"></i> ส่งรายการ Interface</button>
                        {{-- <button class="btn btn-lg btn-secondary" type="submit"><i class="fa fa-exchange"></i> ส่งรายการ Interface</button> --}}
                    </div>
                </div>


            </div><!--row-->
        </div><!--ibox-content-->
    {{-- </form> --}}
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        release('');
        $('.date').datepicker();
        try {
            $("input").each(function() {
            $(this).attr("autocomplete", "off");
            });
        }
        catch (e)
        {}
    });

    function release(d) {
        if(d == ''){
            $('#number').html('');
            var html = '<option></option>@foreach ($dataNumber as $value)<option>{{ $value->pick_release_no }}</option>@endforeach';
            $('#number').html(html);
            return false;
        } else {
            $.ajax({
                url: "{{ route('om.close-flag-release') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "date": d
                },
                cache: false,
                beforeSend: function() {
                    swal({
                        title: 'ระบบกำลังรวบรวมหมายเลขเอกสาร กรุณารอสักครู่',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function(res) {
                    if(res.status == 'success'){
                        var datanumber2 = res.dataNumbers;
                        var htmlappend = '<option></option>';
                        $('#number').html(htmlappend);
                        $.each(datanumber2, function(key, v){
                            var data = '<option>' + v.pick_release_no + '</option>';
                            htmlappend = htmlappend + data;
                        });
                        $('#number').html(htmlappend);
                        swal.close();
                    } else {
                        swal({
                            title: 'เกิดข้อผิดพลาดระหว่างดำเนินการ',
                            type: 'error'
                        });
                    }
                },
                error: function(error) {
                    swal({
                        title: error.responseText,
                        type: 'error'
                    });
                }
            });
        }
    }

    function sendinterface() {
        var date = $('input[name="date"]').val();
        var number = $('input[name="number"]').val();

        if(date == '' && number == ''){
            swal({
                title: 'กรุณาระบุข้อมูลปิดการขายเพื่อดำเนินการต่อ',
                type: 'error'
            });
            return false;
        } else {
            $.ajax({
                        url: "{{ route('om.close-flag-process') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "{{ $type }}",
                            "date": date,
                            "number": number
                        },
                        cache: false,
                        beforeSend: function() {
                            swal({
                                title: 'กรุณารอสักครู่ กำลังดำเนินการ',
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        },
                        success: function(res) {
                            if(res.status == 'error'){
                                console.log(2);
                                swal({
                                    title: res.data,
                                    type: 'error'
                                });
                            } else {
                                swal({
                                    title: res.data,
                                    type: 'success'
                                });
                                $('input[name="groupid"]').val(res.groupid);
                            }
                        },
                        error: function(error) {
                            console.log(1);
                            swal({
                                title: error.responseText,
                                type: 'error'
                            });
                        }
                    });
        }
    }
</script>
@endsection
