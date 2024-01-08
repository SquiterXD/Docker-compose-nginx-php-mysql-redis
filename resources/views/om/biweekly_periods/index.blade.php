@extends('layouts.app')

<style>
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

</style>

@section('title', 'กำหนดงวดการทำงานของการประมาณการจำหน่ายรายปักษ์')

@section('custom_css')
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0054 กำหนดงวดการทำงานของการประมาณการจำหน่ายรายปักษ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>กำหนดงวดการทำงานของการประมาณการจำหน่ายรายปักษ์</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <form id="formBiweeklyPeriods" autocomplete="off" enctype="multipart/form-data">
                    <div class="col-xl-12">
                        <div class="form-header-buttons">
                            <div class="buttons">
                                <button class="btn btn-md btn-white" type="button" onclick="resetBiweelyPeriods()"><i class="fa fa-repeat"></i></button>
                                <button class="btn btn-md btn-success" type="button" onclick="createBiweelyPeriods();"><i class="fa fa-plus"></i> สร้าง</button>
                                <button class="btn btn-md btn-white" type="button" onclick="searchBiweeklyPeriods();"><i class="fa fa-search"></i> ค้นหา</button>
                                {{-- <button class="btn btn-md btn-danger" type="button" onclick="clearBiweeklyPeriods();"><i class="fa fa-times"></i> ลบ</button> --}}
                                <button class="btn btn-md btn-primary" type="button" onclick="updateBiweeklyPeriods();"><i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="alert alert-warning alert-dismissible print-error-msg-shipping" id="close-btn-customers" style="display: none;">
                            <button type="button" class="close" onclick="$('#close-btn-customers').hide();">&times;</button>
                            <h5> Warning!</h5>
                            <ul></ul>
                        </div>
                    </div>
                    <div class="col-xl-6 m-auto">

                        <div class="form-group">
                            <label class="d-block">ปีงบประมาณ <span class="red">*</span></label>
                            <div class="input-icon">
                                <input  type="text" 
                                        class="form-control" 
                                        name="budget_year" 
                                        id="budget_year" 
                                        placeholder="" 
                                        value="" 
                                        maxlength="4" 
                                        onkeypress="return isNumber(event)" 
                                        autocomplete="none">
                                <i class="fa fa-search"></i>
                            </div>
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">วันที่เริ่มต้นงบประมาณ</label>
                            <div class="input-icon">
                                <input type="text" class="form-control date"  name="start_buget_year" id="start_buget_year" placeholder="" value="" data-date-format="dd/mm/yyyy" autocomplete="none" readonly>
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>

                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-white" type="button" id="buttonCalculate" onclick="calculateBiweekly();" disabled><i class="fa fa-calculator"></i> คำนวณงวดรายปักษ์</button>
                        </div>
                    </div><!--col-xl-6-->

                    <div class="col-md-12">

                        <hr class="lg">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <tbody>
                                    <tr class="align-middle text-center">
                                        <th>ปักษ์ที่</th>
                                        <th>วันที่เริ่มใช้</th>
                                        <th>ถึง วันที่</th>
                                        <th>จำนวนวันที่ขาย</th>
                                    </tr>
                                </tbody>
                                <tbody id="biweeklyList">
                                    {{-- Data Generate from function calculateBiweekly --}}
                                </tbody>
                            </table>
                        </div><!--table-responsive-->
                    </div><!--col-xl-12-->
                </form>
            </div><!--row-->

        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
    <script src="{!! asset('custom/custom.js') !!}"></script>
    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>

    <script>
        $(document).ready(function(){

        });
    </script>

    <script>

        var sequenceEcom = [];
        var budgetYear = '';
        var startBudgetYear = '';
        var checkSave = 0;
        var statusSearch = 0;

        $('#budget_year').change(function()
        {
            $('#buttonCalculate').attr('disabled', true);
            var year = $("#budget_year").val();

            if (year == '') {
                $('#start_buget_year').val('');
            }
            else if(year.length < 4 || year.length > 4){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณรูปแบบปี พ.ศ.!'
                });
                $('#start_buget_year').val('');
            }
            else if(year < 2400){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณรูปแบบปี พ.ศ.!'
                });
                $('#start_buget_year').val('');
            }
            else{
                statusSearch = 0;
                year = year - 1;
                $("#start_buget_year").val('01/10/'+year);

                // $("#start_buget_year").datepicker().datepicker("setDate", '01/10/'+year);
                // $("#start_buget_year").datepicker({minDate:-1,maxDate:-2}).attr('readonly','readonly');
            }
        });

        function createBiweelyPeriods()
        {
            var year = $("#budget_year").val();

            if (year == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณ!'
                });
            }else if(year.length < 4 || year.length > 4){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณรูปแบบปี พ.ศ.!'
                });
                $('#start_buget_year').val('');
            }else if(year < 2400){
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณรูปแบบปี พ.ศ.!'
                });
                $('#start_buget_year').val('');
            }else{

                checkBiweeklyPeriods();
                // $("#start_buget_year").datepicker().datepicker("setDate", '01/10/'+year);
                // $("#start_buget_year").datepicker({minDate:-1,maxDate:-2}).attr('readonly','readonly');
            }

            $('#biweeklyList').html('');
        }

        function calculateBiweekly()
        {
            checkSave = 1;
            budgetYear = $('#budget_year').val();
            startBudgetYear = $('#start_buget_year').val();

            if (budgetYear == '') {
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากรอกปีงบประมาณ!'
                });
                return false;
            }

            if (startBudgetYear == '' || statusSearch == 1) {
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากดปุ่มสร้างก่อนคำนวณงวดรายปักษ์!'
                });
                return false;
            }

            var lastDayOfMonth = new Array(0,31,28,31,30,31,30,31,31,30,31,30,31);
            var fromDate    =   new Array();
            var toDate      =   new Array();


            var dateArr = startBudgetYear.split('/');


            var selectDay       =   dateArr[0];
            var selectMonth     =   dateArr[1];
            var selectYear      =   dateArr[2];
            var selectMonthInt  =   parseInt(selectMonth);
            let biIndex     =   0;

            // เช็คว่าเป็น กพ ที่มี 29 วันหรือไม่
            // if(selectYear%4==0){
            //     lastDayOfMonth[2] = 29;
            // }

            var checkYear = 1;
            var checkMonth = selectMonth;
            var checkMonthInt = selectMonthInt;
            var checkYearInt = selectYear;
            while(checkYear < 12){

                if(checkMonthInt > 12){
                    checkMonth = 1;
                    checkMonthInt = 1;
                    checkYearInt = parseInt(checkYearInt) + 1;
                }

                // เช็คว่าเป็น กพ ที่มี 29 วันหรือไม่
                var formatYearToThai = checkYearInt - 543;
                if(formatYearToThai%4==0){
                    lastDayOfMonth[2] = 29;
                }else{
                    lastDayOfMonth[2] = 28;
                }

                checkMonthInt++;
                checkYear++;
            }


            // เช็คว่าเลือกปักษ์แรกไม่เกินวันที่ 15 ใช่หรือไม่
            if(selectDay<=15){

                fromDate[biIndex]   =   startBudgetYear;
                toDate[biIndex]     =   '15/'+selectMonth+'/'+selectYear;

                biIndex++;
                fromDate[biIndex]   =   '16/'+selectMonth+'/'+selectYear;
                toDate[biIndex]     =   lastDayOfMonth[selectMonthInt]+'/'+selectMonth+'/'+selectYear;

            }else{

                fromDate[biIndex]   =   startBudgetYear;
                toDate[biIndex]     =   lastDayOfMonth[selectMonth*1]+'/'+selectMonth+'/'+selectYear;

            }


            var biweeklyNum = 1;

            selectMonthInt++;

            while(biweeklyNum < 12){

                if(selectMonthInt > 12){
                    selectMonth = 1;
                    selectMonthInt = 1;
                    selectYear = parseInt(selectYear) + 1;
                }

                if(selectMonthInt<10){
                    selectMonth = '0'+selectMonthInt;
                }else{
                    selectMonth = selectMonthInt;
                }

                biIndex++;
                fromDate[biIndex]   =   '01/'+selectMonth+'/'+selectYear;
                toDate[biIndex]     =   '15/'+selectMonth+'/'+selectYear;

                biIndex++;
                fromDate[biIndex]   =   '16/'+selectMonth+'/'+selectYear;
                toDate[biIndex]     =   lastDayOfMonth[selectMonthInt]+'/'+selectMonth+'/'+selectYear;

                selectMonthInt++;
                biweeklyNum++;
            }

            var html = '';
            var number = 1;
            var startDate = '';
            var endDate = '';

            // GET HOLIDAY
            var dateStart   = $('#start_buget_year').val().split('/');
            var startYear   = dateStart[2];
            var newHoliday  = '';
            let holiData    = new Array();

            $.ajax({
                url : '{{ url("om/ajax/biweekly/get-holiday") }}/'+startYear,
                success : function(res){
                    var dataSA = res.data.data;
                    if (res.data.status == 'success') {
                        var dataHoliday = res.data.data;

                        $.each(dataHoliday, function(key,val)
                        {
                            var HoliArr = val.hol_date.split('/');
                            var HoliDay         =   HoliArr[0];
                            var HoliMonth       =   HoliArr[1];
                            var HoliYear        =   HoliArr[2];
                            var HoliDayInt      =   parseInt(HoliDay);

                            newHoliday = new Date(HoliMonth+'/'+HoliDayInt+'/'+HoliYear);

                            // console.log(newHoliday);
                            holiData.push(newHoliday);

                            // if (newHoliday == 'Tue Oct 13 2020 00:00:00 GMT+0700 (เวลาอินโดจีน)') {
                            //     console.log('Holiday : '+ newHoliday);
                            //     console.log(holiData);
                            //     console.log('Result : ' + holiData.includes('Tue Oct 13 2020 00:00:00 GMT+0700 (เวลาอินโดจีน)'));
                            // }

                        });

                    }else{

                    }

                    // console.log(holiData);

                    for(i=0; i<fromDate.length; i++)
                    {
                        number = i + 1;
                        var dayForSale = 0;
                        // console.log(fromDate[i]+'  => '+toDate[i]);

                        startDate   = fromDate[i];
                        endDate     = toDate[i];

                        // console.log(startDate);

                        var fromArr = startDate.split('/');
                        var fromDay         =   fromArr[0];
                        var fromMonth       =   fromArr[1];
                        var fromYear        =   fromArr[2] - 543;
                        var fromDayInt      =   parseInt(fromDay);
                        let fromDayIndex    =   0;

                        var toArr = endDate.split('/');
                        var toDay       =   toArr[0];
                        var toDayInt    =   parseInt(toDay);
                        let toDayIndex  =   0;

                        var isHoliday = 0;

                        var newfromYear = fromYear + 543;
                        var newStartDate = new Date(fromMonth+'/'+fromDayInt+'/'+newfromYear);

                        while (fromDayInt <= toDayInt) {
                            //if not Saturday or Sunday, +1
                            startDate = new Date(fromMonth+'/'+fromDayInt+'/'+fromYear);
                            checkDay = startDate.toString().substring(0,3);
                            isHoliday = 0;
                            // console.log(startDate + ' -- ' +checkDay);
                            if (checkDay != 'Sat' && checkDay != 'Sun') {

                                // ค้นหาวันหยุด
                                // holiData.forEach(element => {
                                //     if(element == newStartDate.toString()){
                                //         isHoliday = 1;
                                //         console.log(element);
                                //         console.log('true');
                                //     }

                                // });
                                dayForSale++;
                                // dayForSale = dayForSale - isHoliday;
                            }

                            // console.log(startDate);

                            fromDayInt++;
                        } //end date walk loop


                        html += '<tr class="align-middle">';
                        html += '    <td> '+number+' <input type="hidden" name="biweekly_no['+i+']" value="'+number+'"></td>';
                        html += '    <td>';
                        html += '        <div class="input-icon">';
                        html += '            <input type="text" class="form-control date" readonly name="start_date_period['+i+']" placeholder="" value="'+fromDate[i]+'" data-date-format="dd/mm/yyyy" autocomplete="none">';
                        html += '            <i class="fa fa-calendar"></i>';
                        html += '        </div>';
                        html += '    </td>';
                        html += '    <td>';
                        html += '        <div class="input-icon">';
                        html += '            <input type="text" class="form-control date" readonly name="end_date_period['+i+']" placeholder="" value="'+toDate[i]+'" data-date-format="dd/mm/yyyy" autocomplete="none">';
                        html += '            <i class="fa fa-calendar"></i>';
                        html += '        </div>';
                        html += '    </td>';
                        html += '    <td> '+dayForSale+' <input type="hidden" name="day_for_sale['+i+']" value="'+dayForSale+'" ></td>';
                        html += '</tr>';

                    }

                    $('#biweeklyList').html(html);
                    // $('.date').datepicker();
                }
            });

        }

        function updateBiweeklyPeriods()
        {
            if (checkSave == 0) {
                Swal.fire({
                    icon: 'warning',
                    text: 'กรุณากดคำนวณงวดรายปักษ์ก่อนบันทึก!'
                });
                return false;
            }

            if (statusSearch == 1) {
                Swal.fire({
                    icon: 'warning',
                    text: 'ข้อมูลนี้เป็นข้อมูลจากการค้นหา กรุณาสร้างข้อมูลใหม่!'
                });
                return false;
            }

            const formData = new FormData(document.getElementById("formBiweeklyPeriods"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/biweekly/update-periods") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    // var sequenceEcom = res.data.dataList;
                    if(res.data.status){
                        Swal.fire({
                            icon: 'success',
                            text: 'บันทึกข้อมูลเรียบร้อยแล้ว!'
                        });
                    }else{
                        if(data.type == 'validate'){

                        }else{
                            Swal.fire({
                                icon: 'error',
                                text: 'เกิดข้อผิดพลาด โปรดลองใหม่อีกครั้ง!'
                            });
                        }
                    }
                }
            });
        }

        function clearBiweeklyPeriods()
        {
            checkSave = 0;
            $('#biweeklyList').html('');
            Swal.fire({
                icon: 'success',
                text: 'ลบการคำนวณงวดรายปักษ์เรียบร้อยแล้ว!'
            });
        }

        function searchBiweeklyPeriods()
        {
            // $('#buttonCalculate').attr('disabled', true);
            // $('#buttonCalculate').removeAttr("disabled");
            var budgetYear = $('#budget_year').val();
            statusSearch = 1;

            budgetYear = (budgetYear != '') ? budgetYear : 0;

            swal.showLoading();

            $.ajax({
                url : '{{ url("om/ajax/biweekly/search-periods") }}/'+budgetYear,
                success : function(res){
                    swal.close();
                    if (res.data.status == 'success') {
                        var html = '';
                        var dataPeriods = res.data.data;

                        $.each(dataPeriods, function(key,val)
                        {
                            html += '<tr class="align-middle">';
                            html += '    <td> '+val.biweekly_no+' <input type="hidden" name="biweekly_no['+key+']" value="'+val.biweekly_no+'"></td>';
                            html += '    <td>';
                            html += '        <div class="input-icon">';
                            html += '            <input type="text" class="form-control date" readonly name="start_date_period['+key+']" placeholder="" value="'+val.start_date_period+'" data-date-format="dd/mm/yyyy" autocomplete="none">';
                            html += '            <i class="fa fa-calendar"></i>';
                            html += '        </div>';
                            html += '    </td>';
                            html += '    <td>';
                            html += '        <div class="input-icon">';
                            html += '            <input type="text" class="form-control date" readonly name="end_date_period['+key+']" placeholder="" value="'+val.end_date_period+'" data-date-format="dd/mm/yyyy" autocomplete="none">';
                            html += '            <i class="fa fa-calendar"></i>';
                            html += '        </div>';
                            html += '    </td>';
                            html += '    <td> '+val.day_for_sale+' <input type="hidden" name="day_for_sale['+key+']" value="'+val.day_for_sale+'" ></td>';
                            html += '</tr>';
                        });

                    }else{
                        Swal.fire({
                            icon: 'error',
                            text: 'ไม่พบข้อมูลที่ค้นหา!'
                        });
                    }

                    $('#biweeklyList').html(html);
                    // $('.date').datepicker();
                }
            });
        }

        function resetBiweelyPeriods()
        {
            $('#budget_year').val('');
            $('#start_buget_year').val('');
            $('#biweeklyList').html('');
        }

        function checkBiweeklyPeriods()
        {
            $('#buttonCalculate').attr('disabled', true);
            // $('#buttonCalculate').removeAttr("disabled");
            var year = $('#budget_year').val();

            year = (year != '') ? year : 0;

            swal.showLoading();

            $.ajax({
                url : '{{ url("om/ajax/biweekly/search-periods") }}/'+year,
                success : function(res){
                    swal.close();
                    // console.log($.trim(res.data.data));
                    if ($.trim(res.data.data) != '') {
                        Swal.fire({
                            icon: 'error',
                            text: 'ปีงบประมาณนี้มีอยู่ในระบบแล้ว!'
                        });
                    }else{
                        var yearPlus = parseInt($.trim(res.data.maxBudgetYear)) + 1;
                        if (year > yearPlus) {
                            Swal.fire({
                                icon: 'error',
                                text: 'ต้องสร้างข้อมูลปีงบประมาณ '+ yearPlus +' ก่อน!'
                            });
                        }else if ($.trim(res.data.minBudgetYear) && year <= $.trim(res.data.minBudgetYear)) {
                            Swal.fire({
                                icon: 'error',
                                text: 'ต้องระบุปีงบประมาณมากกว่าปี '+ res.data.maxBudgetYear +' !'
                            });
                        }else{
                            statusSearch = 0;
                            year = year - 1;
                            $("#start_buget_year").val('01/10/'+year);
                            $('#buttonCalculate').attr('disabled', false);
                        }
                    }
                }
            });


        }

        function isNumber(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>
@stop
