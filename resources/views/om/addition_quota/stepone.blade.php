@extends('layouts.app')

@section('title', 'ส่งใบขออนุมัติเพิ่มเพดานการจำหน่าย')

@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    .has-error {
        border-color: #a94442;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    }
    .font-16 {font-size: 16px !important;}
    .swal2-container {
        z-index: 9999 !important;
    }
</style>
@stop

@section('page-title')
<h2><x-get-program-code url="/om/addition-quota/approve/step" /> ส่งใบขออนุมัติเพิ่มเพดานการจำหน่าย</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">หน้าแรก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong>ส่งใบขออนุมัติเพิ่มเพดานการจำหน่าย</strong>
    </li>
</ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-content">
            <div class="paper-content">
                <div class="paper-logo">
                    <img class="logo" src="img/logo.png" alt="">
                    <div class="infos">
                        <p>การยาสูบแห่งประเทศไทย</p>
                        <p>Tobacco Authority Of Thailand</p>
                    </div>
                </div><!--paper-logo-->
                <h2 class="paper-title">ขออนุมัติเพิ่มเพดานการจำหน่าย</h2>
                <form method="POST" action="{{ route('om.addition-quota-update') }}" id="stepone">
                    @csrf
                    <input type="hidden" id="quotaHeaderId" name="addition_id" value="{{ $addtion->quota_header_id }}" >
                <div class="row">

                    <div class="col-md-12">
                        <div class="paper-row p-0 font-16">
                            <strong>เรียน</strong> ผู้ว่าการ {{ $nameemptitle[0]->employee_name ?? '' }}<br>
                        </div>
                    </div><!--col-md-12-->

                     <div class="col-md-12">
                        <div class="paper-row pl-5 pt-3 pb-3">
                            <div class="item font-16">
                                ด้วย {{ $customer[0]->customer_name ?? '' }} 
                                ขออนุมัติเพิ่มเพดานการจำหน่าย ประจำงวด 
                                {{ FormatDate::DateThai($order_dates[0]->delivery_date) ?? '' }}
                            </div>
                        </div>
                    </div><!--col-md-12-->


                    <div class="col-xl-12 pt-2">
                        <div class="table-unit-label">หน่วย : หีบ</div>
                        <div class="table-responsive-xl">
                            <table class="table table-bordered text-center" id="table_approve">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>กลุ่ม</th>
                                        <th>เพดาน</th>
                                        <th>อนุมัติก่อนหน้า <br>(ในสัปดาห์)</th>
                                        <th>ขอเพิ่ม</th>
                                        <th>รวมทั้งหมด</th>
                                        <th>ยอดซื้องวดล่าสุด</th>
                                        <th>จำนวนอนุมัติ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($meaning as $key => $mean)
                                    <?php 
                                    if($orderB[$key] == '-') { 
                                        $rb = 0; 
                                    } else { 
                                        $rb = $orderB[$key]; 
                                    } ?>
                                    <input type="hidden" name="line_id[]" value="{{ $line_id[$key] }}">
                                    <tr class="align-middle">
                                        <td class="text-left">{{ $key +1 }}. {{ $mean }}</td>
                                        <td>{{ $received_quota[$key]/10 }}</td>
                                        <td>@if($orderB[$key] != '-') {{ $orderB[$key] }} @else - @endif</td>
                                        <td>{{ number_format($order_quantity[$key],2) }}</td>
                                        <td>{{ number_format((($received_quota[$key]/10) + $order_quantity[$key] + $rb),2) }}</td>
                                        <td>@if($before_quantity[$key] == 0) - @else {{ $before_quantity[$key]  }} @endif<input type="hidden" name="before_quantity[]" value="{{ $before_quantity[$key] }}"></td>
                                        <td><input type="text" onchange="replacenumbertoformat(this,this.value);" class="text-center form-control" name="approve_number[]" value="{{ number_format($order_approve[$key],2) }}" @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!--table-responsive-md-->

                        <div class="paper-row">
                            <div class="item mt-2 mb-2 font-16">จึงเรียนมาเพื่อโปรดพิจารณา</div>
                        </div>
                    </div><!--col-xl-12-->

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-5">
                                <div class="form-group">
                                    <select class="custom-select @error('division') has-error @enderror" 
                                            name="division" 
                                            @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif
                                            id="salesDivision">
                                        <option value=""></option>
                                        @foreach($employs as $employ)
                                            <option value="{{ $employ->authority_id }}" 
                                                @if($employ->authority_id == $emp_division[0]) selected @endif>
                                                {{ $employ->employee_name }}({{ $employ->position_name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <input  class="custom-input" 
                                            type="text" 
                                            name="sales_division_additional" 
                                            id="salesDivisionAdditional"
                                            value="{{ $addtion->sales_division_additional }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <select class="custom-select" 
                                            name="acting" 
                                            @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif>
                                        <option value=""></option>
                                        @foreach($actings as $acting)
                                            <option value="{{ $acting->lookup_code }}" @if($acting->lookup_code == $actingg[0]) selected @endif>{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-5">
                                <div class="form-group">
                                    <select class="custom-select @error('emp1') has-error @enderror" 
                                            name="emp1" 
                                            @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif
                                            id="authorityId1">
                                        <option option value=""></option>
                                        @foreach($employs as $employ)
                                        <option value="{{ $employ->authority_id }}" @if($employ->authority_id == $emp_approve1[0]) selected @endif>{{ $employ->employee_name }}({{ $employ->position_name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <input  class="custom-input" 
                                            type="text" 
                                            name="authority_id1_additional" 
                                            id="authorityId1Additional"
                                            value="{{ $addtion->authority_id1_additional }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <select class="custom-select" name="acting1" @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif>
                                        <option value=""></option>
                                        @foreach($actings as $acting)
                                        <option value="{{ $acting->lookup_code }}" @if($acting->lookup_code == $actingg1[0]) selected @endif>{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-5">
                                <div class="form-group">
                                    <select class="custom-select @error('emp2') has-error @enderror" 
                                            name="emp2" 
                                            @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif
                                            id="authorityId2">
                                        <option value=""></option>
                                        @foreach($employs as $employ)
                                        <option value="{{ $employ->authority_id }}" @if($employ->authority_id == $emp_approve2[0]) selected @endif>{{ $employ->employee_name }}({{ $employ->position_name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <input  class="custom-input" 
                                            type="text" 
                                            name="authority_id2_additional" 
                                            id="authorityId2Additional"
                                            value="{{ $addtion->authority_id2_additional }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <select class="custom-select" name="acting2" @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif>
                                        <option value=""></option>
                                        @foreach($actings as $acting)
                                        <option value="{{ $acting->lookup_code }}" @if($acting->lookup_code == $actingg2[0]) selected @endif>{{ $acting->meaning }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr class="lg">
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <h3>เนื่องจาก {{ $addtion->reason }}</h3>
                            <label class="d-block font-16">ผู้มีอำนาจอนุมัติ</label>
                        </div>                        
                    </div>   

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-5">
                                <select class="custom-select @error('emp3') has-error @enderror" 
                                        name="emp3" 
                                        @if($addtion->approve_status != 'ขออนุมัติ') disabled @endif
                                        id="authorityId3">
                                    <option value=""></option>
                                    @foreach($employs as $employ)
                                    <option value="{{ $employ->authority_id }}" 
                                            @if($employ->authority_id == $emp_approve3[0]) selected @endif>
                                            {{ $employ->employee_name }}({{ $employ->position_name }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <input  class="custom-input" 
                                            type="text" 
                                            name="authority_id3_additional"
                                            id="authorityId3Additional" 
                                            value="{{ $addtion->authority_id3_additional }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <select class="custom-select" name="acting3" 
                                            @if($addtion->approve_status != 'ขออนุมัติ') 
                                            disabled @endif
                                            id="actingPosition3">                                        
                                        <option value=""></option>
                                        @foreach($actings as $acting)
                                            <option value="{{ $acting->lookup_code }}" 
                                                    @if($acting->lookup_code == $actingg3[0]) selected @endif
                                                    @if (   $actingg3[0] == null && 
                                                            $addtion->authority_id3_additional == 'ผู้อำนวยการฝ่ายขาย')
                                                        @if ($acting->lookup_code == '10')
                                                            selected
                                                        @endif
                                                    @endif
                                                   >
                                                    {{ $acting->meaning }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>            
                    
                    <div class="col-md-12">
                        @if($addtion->approve_status != 'ขออนุมัติ')
                            @if($addtion->approve_status == 'อนุมัติ')
                                <font color="green" class="text-center">สถานะ : {{ $addtion->approve_status }}</font>
                            @else
                                <font color="red" class="text-center">สถานะ : {{ $addtion->approve_status }}</font>
                            @endif
                        @else
                            <div class="form-buttons mt-0">
                                <button class="btn btn-lg btn-primary" 
                                        type="submit" 
                                        name="status_approve" 
                                        value="รอการอนุมัติ" 
                                        id="status_approve1">
                                    <i class="fa fa-send"></i> ส่งขออนุมัติ
                                </button>
                                <button class="btn btn-lg btn-danger" 
                                        type="submit" 
                                        name="status_approve" 
                                        value="ไม่อนุมัติ" 
                                        id="status_approve2">
                                    <i class="fa fa-times"></i> ไม่อนุมัติ
                                </button>
                                <button class="btn btn-lg btn-success" 
                                        data-toggle="modal" 
                                        data-target="#UploadModalFile" 
                                        type="button">
                                    <i class="fa fa-upload"></i> แนบไฟล์
                                </button>
                            </div>
                            <div class="form-buttons mt-0">
                                <button class="btn btn-lg btn-info" 
                                        type="button" 
                                        id="printaction">
                                    <i class="fa fa-print"></i> พิมพ์ใบคำร้อง
                                </button>
                            </div>
                        @endif
                    </div>
                </div><!--row-->

                {{-- Jay 21082021 --}}
                <input type="hidden" name="files_uploadsId" id="files_uploadsId" value="">
                {{-- Jay 21082021 --}}

            </form>
            </div><!--paper-content-->
        </div><!--ibox-content-->
    </div><!--ibox-->

    <div class="modal modal-600 fade" id="UploadModalFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <div class="modal-header">
                    <h3>Upload File</h3>
                </div>
                <form id="form_attachment" data-action="{{ url('/') }}/om/addition-quota/upload/file">
                    {{ csrf_field() }}
                    <input type="hidden" name="addition_id" value="{{ $addtion->quota_header_id }}" >
                    <div class="modal-body pt-4 pb-0">
                        <div class="attachment-box">
                            <div class="form-group d-flex mb-1">
                                <div class="custom-file">
                                    <input id="attachment" type="file" class="custom-file-input" name="attachment" value="" accept=".jpeg, .jpg, .bmp, .png, .pdf, .doc, .docx, .xls, .xlsx, .rar, .zip, .csv">
                                    <label for="attachment" class="custom-file-label label-attachment">Choose file...</label>
                                </div>
                                <div class="button">
                                    <button class="btn btn-success" type="button" onclick="submitChooseFile()">Submit</button>
                                    <button class="btn btn-warning" type="button" id="btn_clear" onclick="clearInputFile();">Clear</button>
                                </div>
                            </div>
                            <p><small>Allow type : jpeg, jpg, bmp, png, pdf, doc, docx, xls, xlsx, rar, zip, csv and size < 2mb</small></p>
                            <ul class="nav files">
                            </ul>
                        </div>
                    </div>
                    <!--modal-body-->
                    <div class="modal-footer center mt-4">
                        <button class="btn btn-gray" type="button" data-dismiss="modal">
                            ปิด<small>Close</small>
                        </button>
                        <button class="btn btn-primary" type="submit">
                            ยืนยัน<small>Confirm</small>
                        </button>
                    </div>
                </form>
            </div>
        </div><!--modal-content-->
    </div><!--modal-dialog-->

</div>
@endsection

@section('scripts')
<script src="{!! asset('js/aksFileUpload.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
<script src="{!! asset('js/number.js') !!}"></script>
<script>

	$(document).ready(function() {
			$(".aks-file-upload-files").aksFileUpload({
					dragDrop: true,
					maxSize: "1 GB",
					multiple: true,
					maxFile: 50
			});

            $('#status_approve1').on('click', function() {
                Swal.fire({
                            title: 'กำลังดำเนินการ กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('#stepone').submit();
            });


            $('#status_approve2').on('click', function() {
                Swal.fire({
                            title: 'กำลังดำเนินการ กรุณารอสักครู่',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        $('#stepone').submit();
            });


        $('#printaction').on('click', function() {
                $.ajax({
                    url: "{{ route('om.addition-onprint') }}",
                    type: "POST",
                    data: {
                        "_token":                       "{{ csrf_token() }}",
                        "id":                           "{{ $addtion->quota_header_id }}",
                        "sale":                         $('select[name="division"] option:selected').val(),
                        "sale_acting":                  $('select[name="acting"] option:selected').val(),
                        "emp1":                         $('select[name="emp1"] option:selected').val(),
                        "emp1_acting":                  $('select[name="acting1"] option:selected').val(),
                        "emp2":                         $('select[name="emp2"] option:selected').val(),
                        "emp2_acting":                  $('select[name="acting2"] option:selected').val(),
                        "emp3":                         $('select[name="emp3"] option:selected').val(),
                        "emp3_acting":                  $('select[name="acting3"] option:selected').val(),
                        "sales_division_additional":    $("#salesDivisionAdditional").val(),
                        "authority_id1_additional":     $("#authorityId1Additional").val(),
                        "authority_id2_additional":     $("#authorityId2Additional").val(),
                        "authority_id3_additional":     $("#authorityId3Additional").val()
                    },
                    cache: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังดึงใบพิมพ์ใบคำร้อง',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        console.log(res);
                        if(res.status == 'error'){
                            Swal.fire({
                                title: res.msg,
                                type: 'error'
                            });
                        } else {
                            var win = window.open("{{ url('/') }}/om/addition-quota/approve/step/{{ $addtion->quota_header_id }}/6", "_blank");
                            if (win) {
                                console.log(1);
                                //Browser has allowed it to be opened
                                swal.close();
                                win.focus();
                            } else {
                                console.log(2);
                                //Browser has blocked it
                                Swal.fire({
                                    title: 'กรุณาอนุญาตการเปิดป๊อบอัพสำหรับเว็บไซต์นี้',
                                    icon: 'warning'
                                });
                            }
                        }
                    },
                    error: function(error) {
                        Swal.fire({
                            title: error.responseText,
                            type: 'error'
                        });
                    }
                });
            
        });
	});


	var fileChoose = [];
	var fileSecChoose = 1;
	var fileRunChoose = -1;
	$('#attachment').change(function(){
			var input = this;
			var reader = new FileReader();
			reader.readAsDataURL(input.files[0]);
			fileChoose.push(input.files[0]);
			fileRunChoose += 1;
	});
	function submitChooseFile(){
			let html = '<li id="file_choose_'+fileSecChoose+'_'+fileRunChoose+'">'+
							'<code><a href="#" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+fileChoose[fileRunChoose].name+'</code></a>'+
							'<button class="btn btn-remove" onclick="removeFileAttachment('+fileSecChoose+','+fileRunChoose+')" type="button"><i class="fa fa-times"></i></button>'+
					'</li>';
			$("ul.files").append(html);
			clearInputFile();
	}

    $("#form_attachment").submit(async function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('addition_id', $('input[name=addition_id]').val());
        await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
        });
        Swal.fire({
            title: 'กำลังอัปโหลด กรุณารอสักครู่',
            showCancelButton: false,
            showConfirmButton: false
        });
        $.ajax({
            type: 'post',
            url: $(this).data('action'),
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            dataType: "json",
            contentType: false,
            processData: false,
            success:function (result) {
                if(result.status == 200){
                    $("ul.files").empty();
                    fileChoose = [];
                    fileRunChoose = -1;
                    fileSecChoose += 1;
                    clearInputFile()
                    var html = '';
                    var files_uploadsId = [];
                    $.each(result.attachments,function(index, fileInfo) {
                        html += '<li id="file_choose_'+index+'_'+fileInfo.attachment_id+'">'+
                            '<code><a href="'+fileInfo.path_name+'/'+fileInfo.file_name+'" target="_blank"><i class="fa fa-file-pdf-o"></i>  '+fileInfo.file_name+'</code></a>'+
                            '<button class="btn btn-remove" onclick="removeFileAttachment('+index+','+fileInfo.attachment_id+',`db`)" type="button"><i class="fa fa-times"></i></button>'+
                        '</li>';
                        files_uploadsId.push(fileInfo.attachment_id);
                    });
                    $("ul.files").append(html);
                    $('#files_uploadsId').val(files_uploadsId)
                    $('#UploadModalFile').modal('hide')
                    Swal.fire({
                        title: result.message,
                        icon: 'success'
                    });
                }
                if(result.status == 422 || result.status == 403){
                    Swal.fire({
                        title: result.message,
                        icon: 'error'
                    });
                }
            },
            error: function (data) {
                console.log(data);
                $('#UploadModalFile').modal('hide')
            }
        });
    });

    function replacenumbertoformat(v,l){
        $('#matchpayment tbody tr:eq(' + index + ')').find('input[name="balancetotal[]"]').val(l.replace(/[^0-9\.|\,]/g, ''));
        if ((v.which != 46 || l.indexOf('.') != -1 || l.indexOf(',') != -1) && (v.which < 48 || v.which > 57 || v.whitch === 188 || v.which === 110)) {
            v.preventDefault();
        } else {
            var rowjQuery = $(v).closest("tr");
            var index = rowjQuery[0].rowIndex - 1;
            if(v == ''){
                console.log('2');
                $('#table_approve tbody tr:eq(' + index + ')').find('input[name="approve_number[]"]').val('0.00');
            } else {
                console.log('3');
                $('#table_approve tbody tr:eq(' + index + ')').find('input[name="approve_number[]"]').val($.number(l,2));
            }
        }
    }

    function clearInputFile(type=''){
        $('#attachment').replaceWith($('#attachment').val('').clone(true));
        $('#attachment').val('');
        $("#attachment").val(null);
        $('.label-attachment').html('Choose file...')
        if(type == 'clear'){
            delete fileChoose[fileRunChoose];
            fileRunChoose = -1;
        }
    }

    function removeFileAttachment(section,index,type='local'){
        if(type != 'local'){
            let formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('attachment_id', index);
            $.ajax({
                type: 'post',
                url: "{{ url('/') }}/om/domestic-matching/files/delete",
                cache: false,
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังลบไฟล์',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                success: function (result) {
                    Swal.fire({
                        title: result.data,
                        icon: 'success'
                    });
                    $('#file_choose_'+section+'_'+index).remove();
                },
                error: function (data) {
                    console.log("error : " + data);
                }
            });
        }else{
            delete fileChoose[index];
            $('#file_choose_'+section+'_'+index).remove()
        }
    }

    function uploadfilestart(){
        swal({
                title: 'กำลังอัปโหลดไฟล์',
                showCancelButton: false,
                showConfirmButton: false
            });
            $('#uploadfilestartform').submit();
    }

    function deletefile(id,index){
        swal({
            title: "ยืนยัน?",
            text: "ต้องการลบไฟล์ที่เลือกใช่หรือไม่?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ยืนยันการลบ",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: true,
            closeOnCancel: true
            },
            function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "{{ env('APP_URL') }}/om/addition-quota/delete/file",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "attachment_id": id,
                    },
                    cache: false,
                    beforeSend: function() {
                        swal({
                            title: 'กำลังลบไฟล์',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(res) {
                        swal.close();
                        swal({
                            title: res.data,
                            type: 'success'
                        });
                    },
                    error: function(error) {
                        swal.close();
                        swal({
                            title: error.responseText,
                            type: 'error'
                        });
                    }
                });
            }
        });
    }

    $('#salesDivision').change(function(){
        let formData    = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user_id', $("#salesDivision").val());
        formData.append('quota_header_id', $("#quotaHeaderId").val());
                
        $.ajax({
            type        : 'post',
            url         : "{{ url('/') }}/om/addition-quota/getDetailSalesDivision",
            cache       : false,
            data        : formData,
            dataType    : "json",
            contentType : false,
            processData : false,
            success: function (result) {
                $("#salesDivisionAdditional").val(result.data);
            },
            error: function (data) {
                console.log("error : " + data);
            }
        });
	});

    $('#authorityId1').change(function(){
        let formData    = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user_id', $("#authorityId1").val());
        formData.append('quota_header_id', $("#quotaHeaderId").val());
                
        $.ajax({
            type        : 'post',
            url         : "{{ url('/') }}/om/addition-quota/getDetailAuthorityId1",
            cache       : false,
            data        : formData,
            dataType    : "json",
            contentType : false,
            processData : false,
            success: function (result) {
                $("#authorityId1Additional").val(result.data);
            },
            error: function (data) {
                console.log("error : " + data);
            }
        });
	});

    $('#authorityId2').change(function(){
        let formData    = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user_id', $("#authorityId2").val());
        formData.append('quota_header_id', $("#quotaHeaderId").val());
                
        $.ajax({
            type        : 'post',
            url         : "{{ url('/') }}/om/addition-quota/getDetailAuthorityId2",
            cache       : false,
            data        : formData,
            dataType    : "json",
            contentType : false,
            processData : false,
            success: function (result) {
                $("#authorityId2Additional").val(result.data);
            },
            error: function (data) {
                console.log("error : " + data);
            }
        });
	});

    $('#authorityId3').change(function(){
        let formData    = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user_id', $("#authorityId3").val());
        formData.append('quota_header_id', $("#quotaHeaderId").val());
                
        $.ajax({
            type        : 'post',
            url         : "{{ url('/') }}/om/addition-quota/getDetailAuthorityId3",
            cache       : false,
            data        : formData,
            dataType    : "json",
            contentType : false,
            processData : false,
            success: function (result) {
                $("#authorityId3Additional").val(result.data);

                if($("#authorityId3Additional").val() == 'ผู้อำนวยการฝ่ายขาย'){
                    $('#actingPosition3').val(10).trigger('change');
                }else{
                    $('#actingPosition3').val('').trigger('change');
                }
            },
            error: function (data) {
                console.log("error : " + data);
            }
        });
	});
    
</script>
@endsection
