@extends('layouts.app')

@section('title', 'ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>
        {{-- <x-get-program-code url="/om/tax-adjust" /> ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท --}}
        <x-get-page-title menu="" url="/om/tax-adjust" />
    </h2>
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/om/tax-adjust" /> ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท</strong>
        </li>
    </ol> --}}
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
<form action="" id="postsendinterface" method="POST">
    <div class="ibox">
        <div class="ibox-title">
            <h3>ปรับปรุงรายการภาษีขาย และผ่านข้อมูลให้บัญชีแยกประเภท</h3>
        </div>
        <div class="ibox-content"> 
            <div class="row space-50 justify-content-md-center flex-column mt-md-4">
                <div class="col-xl-12">
                    <div class="form-header-buttons"> 
                        <div class="buttons"> 
                            <button class="btn btn-md btn-white" type="button" id="searchbtn"><i class="fa fa-search"></i> ค้นหา</button>
                            <button class="btn btn-md btn-primary" type="button" onclick="savedata();" id="gslinterface"><i class="fa fa-save"></i> บันทึก</button>
                            <button class="btn btn-md btn-secondary" type="button" onclick="senddata();" id="glinterface"><i class="fa fa-exchange"></i> ส่งรายการ Interface GL</button> 
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                </div> 

                <div class="col-xl-10 m-auto">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label class="d-block">ปี พ.ศ.</label>
                                <select class="custom-select select2" name="input_year">
                                    <option value="" @if(!request()->input_year) selected @endif></option>
                                    @foreach($y as $y1)
                                        <option value="{{ $y1->budget_year + 543 }}" @if(request()->input_year == ($y1->budget_year + 543)) selected @else @if($y1->budget_year == date('Y')) selected @endif @endif>{{ $y1->budget_year + 543 }}</option>
                                    @endforeach
                                </select>
                            </div><!--form-group-->  
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label class="d-block">เดือน</label> 
                                @if(!$info)
                                <select class="custom-select select2" name="input_month">
                                    <option value="" @if(!request()->input_month) selected @endif></option>
                                    <option value="01" @if(date('m') == '01') selected @endif>มกราคม</option>
                                    <option value="02" @if(date('m') == '02') selected @endif>กุมภาพันธ์</option>
                                    <option value="03" @if(date('m') == '03') selected @endif>มีนาคม</option>
                                    <option value="04" @if(date('m') == '04') selected @endif>เมษายน</option>
                                    <option value="05" @if(date('m') == '05') selected @endif>พฤษภาคม</option>
                                    <option value="06" @if(date('m') == '06') selected @endif>มิถุนายน</option>
                                    <option value="07" @if(date('m') == '07') selected @endif>กรกฎาคม</option>
                                    <option value="08" @if(date('m') == '08') selected @endif>สิงหาคม</option>
                                    <option value="09" @if(date('m') == '09') selected @endif>กันยายน</option>
                                    <option value="10" @if(date('m') == '10') selected @endif>ตุลาคม</option>
                                    <option value="11" @if(date('m') == '11') selected @endif>พฤศจิกายน</option>
                                    <option value="12" @if(date('m') == '12') selected @endif>ธันวาคม</option>
                                    <!-- @foreach($m as $m1)
                                        <option value="{{ $m1->consignment_date }}" @if(request()->input_month == $m1->consignment_date) selected @endif>{{ FormatDate::dateFormatThaiString($m1->consignment_date) }}</option>
                                    @endforeach -->
                                </select>
                                @else
                                <select class="custom-select select2" name="input_month">
                                    <option value="" @if(!request()->input_month) selected @endif></option>
                                    <option value="01" @if(request()->input_month && request()->input_month == '01') selected @endif>มกราคม</option>
                                    <option value="02" @if(request()->input_month && request()->input_month == '02') selected @endif>กุมภาพันธ์</option>
                                    <option value="03" @if(request()->input_month && request()->input_month == '03') selected @endif>มีนาคม</option>
                                    <option value="04" @if(request()->input_month && request()->input_month == '04') selected @endif>เมษายน</option>
                                    <option value="05" @if(request()->input_month && request()->input_month == '05') selected @endif>พฤษภาคม</option>
                                    <option value="06" @if(request()->input_month && request()->input_month == '06') selected @endif>มิถุนายน</option>
                                    <option value="07" @if(request()->input_month && request()->input_month == '07') selected @endif>กรกฎาคม</option>
                                    <option value="08" @if(request()->input_month && request()->input_month == '08') selected @endif>สิงหาคม</option>
                                    <option value="09" @if(request()->input_month && request()->input_month == '09') selected @endif>กันยายน</option>
                                    <option value="10" @if(request()->input_month && request()->input_month == '10') selected @endif>ตุลาคม</option>
                                    <option value="11" @if(request()->input_month && request()->input_month == '11') selected @endif>พฤศจิกายน</option>
                                    <option value="12" @if(request()->input_month && request()->input_month == '12') selected @endif>ธันวาคม</option>
                                    <!-- @foreach($m as $m1)
                                        <option value="{{ $m1->consignment_date }}" @if(request()->input_month == $m1->consignment_date) selected @endif>{{ FormatDate::dateFormatThaiString($m1->consignment_date) }}</option>
                                    @endforeach -->
                                </select>
                                @endif
                            </div><!--form-group-->  
                        </div>

                        <div class="col-md-4">
                            <div class="form-group"> 
                                <label class="d-block">GL Batch Name</label> 
                                <input type="text" class="form-control" disabled="" name="input_groupid" placeholder="" value="{{ Request::old('input_groupid') }}">
                            </div><!--form-group-->  
                        </div>
                    </div><!--row--> 

                </div><!--col-xl-6-->

                <input type="hidden" name="id_old" value="">
                
                    @csrf
                    <div class="col-xl-12"> 
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center" id="datarevice">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>รหัสร้านค้า</th> 
                                        <th>ชื่อร้านค้า</th>
                                        <th>วันที่</th>     
                                        <th class="w-201">จำนวนเงินรวมภาษีมูลค่าเพิ่ม</th>
                                        <th class="w-201">ภาษีมูลค่าเพิ่ม</th> 
                                        <th class="w-201">ภาษีที่ Adjust</th>
                                        <th class="w-90">Post</th> 
                                    </tr>  
                                </thead>
                                <tbody> 
                                    @if($info)
                                        {!! $infos !!}
                                    @endif
                                </tbody>
                            </table>
                        </div><!--table-responsive--> 
                    </div><!--col-xl-12-->
                
            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->

    </form>
</div>
@endsection

@section('scripts')
<script src="{!! asset('js/number.js') !!}"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>

<script>
    var idconsignment = [];
    var idconsignment2 = [];
        $(document).ready(function() {
            $(".select2").select2();
            $('#glinterface').prop('disabled', true);
            $('#gslinterface').prop('disabled', true);
            // $('select[name="input_month"]').on('change',function(){
            //     recivedata();
            // });
            // $('input[name="input_year"]').on('change',function(){
            //     recivedata();
            // });
            $('#searchbtn').on('click',function(){
                recivedata();
            });
            getvaluefromtable();
            getvaluefromtable2();
        });

        function getvaluefromtable() {
            $('#datarevice tbody tr td input[name="adjust_select[]"]').each(function(index, value){
                if (this.checked && !this.disabled) {
                    var splitStr = value.value.split(',');
                    if(splitStr[1] == 1){
                        var id = splitStr[0];
                        if(idconsignment.indexOf(parseInt(id)) == -1){
                            idconsignment.push(parseInt(id));
                        }
                    }
                }
            });
            if(idconsignment.length == 0){
                $('#glinterface').prop('disabled', true);
                $('#gslinterface').prop('disabled', true);
            } else {
                $('#glinterface').prop('disabled', false);
                $('#gslinterface').prop('disabled', false);
            }
        }

        function getvaluefromtable2() {
            $('#datarevice tbody tr td input[name="adjust_select[]"]').each(function(index, value){
                if (this.checked && !this.disabled) {
                    var splitStr = value.value.split(',');
                    if(splitStr[1] == 1){
                        var id = splitStr[0];
                        if(idconsignment.indexOf(parseInt(id)) == -1){
                            idconsignment.push(parseInt(id));
                        }
                    }
                }
            });

            idconsignment2 = idconsignment;
            console.log('idconsignment2', idconsignment2);
            $('input[name="id_old"]').val(idconsignment2);
        }

        function recivedata(){
            var month = $('select[name="input_month"] option').filter(':selected').val();
            var year = $('select[name="input_year"] option').filter(':selected').val();
            if(month == ''){
                $('select[name="input_month"]').focus();
                return false;
            }
            if(year == ''){
                $('input[name="input_year"]').focus();
                return false;
            }
            $.ajax({
                url: "{{ route('om.tax-adjust-recivedata') }}",
                type: "POST",
                data: {
                    "_token":  "{{ csrf_token() }}",
                    "month": month,
                    "year": year
                },
                cache: false,
                beforeSend:function(){
                    Swal.showLoading();
                },
                success: function(res){
                    console.log(res);
                    if(res.status != 200){
                        Swal.fire({
                            icon: 'error',
                            text: res.data,
                            showConfirmButton: true
                        });
                    } else {
                        swal.close();
                        $('#datarevice tbody').html('');
                        if(res.data == 'ไม่พบข้อมูล'){
                            $('#datarevice tbody').append('<tr class="align-middle"><td class="text-center text-danger" colspan="7">ไม่พบข้อมูล</td></tr>');
                        } else {
                            $('#datarevice tbody').html(res.data);
                        }
                        getvaluefromtable();
                    }
                },
                error: function(error){
                    console.log(error);
                    Swal.fire({
                            icon: 'error',
                            text: error.responseText,
                            showConfirmButton: true
                        });
                }
            });
        }

        function senddata(){
            if(idconsignment.length == 0){
                Swal.fire({
                            icon: 'error',
                            text: 'กรุณาเลือกรายการที่ต้องการดำเนินการ',
                            showConfirmButton: true
                        });
                return false;
            }
            Swal.fire({
                            text: 'ดำเนินการส่งรายการอินเตอร์เฟซ กรุณารอสักครู่',
                            showConfirmButton: false
                        });
            $('#postsendinterface').attr('action', '{{ route("om.tax-adjust-senddata") }}');
            $('#postsendinterface').submit();
        }

        function savedata(){
            if(idconsignment.length == 0){
                Swal.fire({
                            icon: 'error',
                            text: 'กรุณาเลือกรายการที่ต้องการดำเนินการ',
                            showConfirmButton: true
                        });
                return false;
            }
            Swal.showLoading();
            $('#postsendinterface').attr('action', '{{ route("om.tax-adjust-savedata") }}');
            $('#postsendinterface').submit();
        }


        function checkid(id){
            if(idconsignment.indexOf(id) == -1){
                idconsignment.push(id);
            } else {
                idconsignment.splice(idconsignment.indexOf(id), 1);
            }
            if(idconsignment.length == 0){
                $('#glinterface').prop('disabled', true);
                $('#gslinterface').prop('disabled', true);
            } else {
                $('#glinterface').prop('disabled', false);
                $('#gslinterface').prop('disabled', false);
            }

            console.log(idconsignment);
        }

    function numericonly(v, l) {
        var rowjQuery = $(v).closest("tr");
        var index = rowjQuery[0].rowIndex - 1;
        $('#datarevice tbody tr:eq(' + index + ')').find('input[name="payment_amount[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        }

        var currentVal = l;
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
            currentVal = currentVal.slice(0, -1);
        }
        $('#datarevice tbody tr:eq(' + index + ')').find('input[name="adjust_amount[]"]').val(replaceCommas(currentVal));
    }

    function testDecimals(currentVal) {
        var count;
        currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
        return count;
    }

    function replaceCommas(yourNumber) {
        var components = yourNumber.toString().split(".");
        if (components.length === 1)
            components[0] = yourNumber;
        components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if (components.length === 2)
            components[1] = components[1].replace(/\D/g, "");
        return components.join(".");
    }

        function tofixed2(k,v) {
            setTimeout(function() {
                var rowjQuery = $(k).closest("tr");
                var index = rowjQuery[0].rowIndex - 1;

                var r = $('#datarevice tbody tr:eq(' + index + ')').find('input[name="adjust_amount[]"]').val().replace(/,/g, '');
                

                $('#datarevice tbody tr:eq(' + index + ')').find('input[name="adjust_amount[]"]').val($.number(v,2));
            },1000);
        }
    @if(Request::old('input_groupid_status')) 
        Swal.fire({
            icon: 'error',
            text: 'โหลดเข้าระบบ GL ไม่สำเร็จ : {{ Request::old("input_groupid_err_msg") }} ',
            showConfirmButton: true
        });
    @endif
</script>
@endsection