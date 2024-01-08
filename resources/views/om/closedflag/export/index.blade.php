@extends('layouts.app')

@section('title', 'ปิดการขายประจำวัน')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2><x-get-program-code url="/om/close-flag/{{ $type }}" /> ปิดการขายประจำวัน สำหรับขายต่างประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/close-flag/{{ $type }}" /> ปิดการขายประจำวัน สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปิดการขายประจำวัน สำหรับขายต่างประเทศ</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">

                <div class="col-xl-6 m-auto mt-4">
                    <div class="form-group">
                        <label class="d-block">วันที่ปิดการขาย</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="date" placeholder="" onfocus="this.value=''" value="" list="date" onchange="this.blur(); resetButton(); clearNumber(); release(this.value);">
                            <i class="fa fa-calendar"></i>
                            <datalist id="date">
                                <option></option>
                                @foreach ($dataDates as $value)
                                    <option>{{ \Carbon\Carbon::parse($value)->format('d/m/Y') }}</option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">หมายเลขเอกสาร</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="number" onfocus="this.value=''" onchange="this.blur(); resetButton();" placeholder="" value="" list="number">
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
                        <button class="btn btn-md btn-secondary" id="btn_report" type="button" onclick="sendreport();"> ประมวลผล</button>
                        <button class="btn btn-md btn-secondary" id="btn_interface" type="button" onclick="sendinterface();" disabled><i class="fa fa-exchange"></i> ส่งรายการ Interface</button>
                    </div>
                </div>


            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script>
    let date_close = {!! json_encode($dataDates) !!};
    let reportGroupId = null;
    const token = "{{ csrf_token() }}";
    const type = "{{ $type }}";
    var check = {
        SO: {
            send: false,
            done: false,
            pass: true,
            msg: '',
        },
        RMA: {
            send: false,
            done: false,
            pass: true,
            msg: '',
        },
    };

    $(document).ready(function(){
        $('.date').datepicker();
        $('input[name="number"]').attr('readonly', true);
        try {
            $("input").each(function() {
            $(this).attr("autocomplete", "off");
            });
        }
        catch (e)
        {}
    });

    function clearNumber(){
        $('input[name="number"]').val('');
    }

    function resetButton(){
        $('#btn_report').prop('disabled', false);
        $('#btn_interface').prop('disabled', true);
    }

    function release(d) {
        if(d == ''){
            return false;
        } else {
            var date = d.split("/");
            var day = date[0];
            var month = date[1];
            var year = date[2];
            var newDate = year+"-"+month+"-"+day;
            if(date_close.indexOf(newDate) == -1){
                Swal.fire({
                    title: 'วันที่ดังกล่าวไม่มีให้เลือกใน LOV กรุณาดำเนินการใหม่',
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                $('input[name="date"]').val('');
                return false;
            // } else if(date_close.indexOf(newDate) != 0){
            //     Swal.fire({
            //         title: 'กรุณาดำเนินการปิดการขายวันที่ก่อนหน้า',
            //         icon: 'error'
            //     });
            //     $('input[name="date"]').val('');
            //     return false;
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
                        Swal.fire({
                            title: 'ระบบกำลังรวบรวมหมายเลขเอกสาร กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                    },
                    success: function(res) {
                        if(res.status == 'success'){
                            var datanumber2 = res.dataNumbers;
                            var htmlappend = '<option></option>';
                            $('#number').html(htmlappend);
                            $.each(datanumber2, function(key, v){
                                var data = '<option>' + v + '</option>';
                                htmlappend = htmlappend + data;
                            });
                            $('#number').html(htmlappend);
                            swal.close();
                            $('input[name="number"]').attr('readonly', false);
                        } else {
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาดระหว่างดำเนินการ',
                                icon: 'error',
                                showConfirmButton: true,
                                showCancelButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            });
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            text: error.responseText,
                            icon: 'error',
                            showConfirmButton: true,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                    }
                });
            }
        }
    }

    function sendreport() {
        $('#btn_report').prop('disabled', true);

        var date = $('input[name="date"]').val();
        var number = $('input[name="number"]').val();

        if(date == '' && number == ''){
            Swal.fire({
                text: 'กรุณาเลือกวันที่ปิดการขายประจำวัน',
                icon: 'error',
                showConfirmButton: true,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
            return false;
        } else {

            $.ajax({
                url: "{{ route('om.close-flag-report-export') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": "{{ $type }}",
                    "date": date,
                    "number": number
                },
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กรุณารอสักครู่ กำลังดำเนินการ',
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                },
                success: function(res) {
                    if(res.status == 'error'){
                        Swal.fire({
                            text: res.msg,
                            icon: 'error',
                            width: 800,
                            showConfirmButton: true,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                        $('#btn_report').prop('disabled', false);
                    } else {

                        let d_array = date.split("/");;
                        let fix_date = d_array[2]+'-'+d_array[1]+'-'+d_array[0];
                        Swal.fire({
                            title: 'ประมวลผลสำเร็จ Group ID : '+res.groupid,
                            icon: 'success',
                            showConfirmButton: true,
                            showCancelButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                        window.open("/ir/reports/get-param?group_id="+res.groupid+"&document_date="+fix_date+"&program_code=OMR0112&function_name=OMR0112&output=pdf", "_blank");
                        window.open("/ir/reports/get-param?group_id="+res.groupid+"&document_date="+fix_date+"&program_code=OMR0113&function_name=OMR0113&output=pdf", "_blank");

                        reportGroupId = res.groupid;
                        $('input[name="groupid"]').val(res.groupid);
                        $('#btn_interface').prop('disabled', false);
                    }
                },
                error: function(error) {
                    Swal.fire({
                        text: error.responseText,
                        icon: 'error',
                        showConfirmButton: true,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('#btn_report').prop('disabled', false);
                }
            });
        }

    }

    function sendinterface() {
        $('#btn_interface').prop('disabled', true);
        var date = $('input[name="date"]').val();
        var number = $('input[name="number"]').val();

        if(date == '' && number == ''){
            Swal.fire({
                text: 'กรุณาเลือกวันที่ปิดการขายประจำวัน',
                icon: 'error',
                showConfirmButton: true,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
            return false;
        } else {

            check.SO.send = true;
            check.RMA.send = true;

            Swal.fire({
                title: 'กรุณารอสักครู่ กำลังดำเนินการ',
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });

            $.ajax({
                url: "{{ route('om.close-flag-process-so-export') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "type": "{{ $type }}",
                    "date": date,
                    "number": number,
                    "group_id" : reportGroupId
                },
                cache: false,
                success: function(res) {
                    check.SO.done = true;
                    if(res.status == 'error'){
                        check.SO.msg = res.msg;
                        check.SO.pass = false;
                    }
                },
                error: function(error) {
                    check.SO.done = true;
                    check.SO.pass = false;
                    check.SO.msg = error.responseText;
                }
            }).then(()=>{
                if(check.SO.pass){
                    $.ajax({
                        url: "{{ route('om.close-flag-process-rma-export') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "type": "{{ $type }}",
                            "date": date,
                            "number": number,
                            "group_id" : reportGroupId
                        },
                        cache: false,
                        success: function(res) {
                            check.RMA.done = true;
                            if(res.status == 'error'){
                                check.RMA.msg = res.msg;
                                check.RMA.pass = false;
                            }
                        },
                        error: function(error) {
                            check.RMA.done = true;
                            check.RMA.pass = false;
                            check.RMA.msg = error.responseText;
                        }
                    }).then(()=>{
                        if(check.SO.pass && check.RMA.pass){
                            sendinvoice();
                        }else {
                            showSOError();
                            $('#btn_interface').prop('disabled', false);
                        }
                    });
                }else {
                    showSOError();
                    $('#btn_interface').prop('disabled', false);
                }
            });
        }
    }

    function sendinvoice()
    {
        var date = $('input[name="date"]').val();
        var number = $('input[name="number"]').val();

        $.ajax({
            url: "{{ route('om.close-flag-process-invoice-export') }}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "type": "{{ $type }}",
                "date": date,
                "number": number,
                "group_id" : reportGroupId
            },
            cache: false,
            success: function(res) {
                if(res.status == 'error'){
                    $('#btn_interface').prop('disabled', false);
                    Swal.fire({
                        title: res.msg,
                        icon: 'error',
                        width: 800,
                        showConfirmButton: true,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                } else {
                    Swal.fire({
                        title: 'ดำเนินการปิดการขายประจำวันเรียบร้อยแล้ว Group ID : '+res.groupid,
                        icon: 'success',
                        showConfirmButton: true,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('input[name="remark"]').val(res.msg);
                    $('input[name="groupid"]').val(res.groupid);
                    $('#btn_report').prop('disabled', false);
                }
            },
            error: function(error) {
                $('#btn_interface').prop('disabled', false);
                Swal.fire({
                    text: error.responseText,
                    icon: 'error',
                    showConfirmButton: true,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
            }
        }).then(()=>{
            resetCheck();
        });
    }

    function resetCheck()
    {
        check.SO.send = false;
        check.SO.done = false;
        check.SO.pass = true;
        check.SO.msg = '';
        check.RMA.send = false;
        check.RMA.done = false;
        check.RMA.pass = true;
        check.RMA.msg = '';
    }

    function showSOError()
    {
        let msg = '';
        if(!check.SO.pass){
            msg += 'SO Error : '+check.SO.msg+'<br>'
        }
        if(!check.RMA.pass){
            msg += 'RMA Error : '+check.RMA.msg;
        }
        Swal.fire({
            html: msg,
            icon: 'error',
            width: 800,
            showConfirmButton: true,
            showCancelButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result)=>{
            resetCheck();
        });
    }

</script>
@endsection
