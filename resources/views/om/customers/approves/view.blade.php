@extends('layouts.app')
@section('custom_css')
<link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
<style>
    .dropdown-menu show{
        width: 400px;
    }
</style>
@stop

@section('title', 'หน้าจอ Customer Search และการส่งขออนุมัติการสร้างลูกค้า ระบบ E-Commerce สำหรับขายต่างประเทศ')

@section('page-title')
<h2><x-get-program-code url="/om/customers/approves" /> ขออนุมัติการสร้างลูกค้าใหม่</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ url('/') }}">หน้าหลัก</a>
    </li>
    <li class="breadcrumb-item active">
        <strong><x-get-program-code url="/om/customers/approves" /> ขออนุมัติการสร้างลูกค้าใหม่ - {{ $approves->customer_name }} Revise#{{ $approves->customer_id }}</strong>
    </li>
</ol>
@endsection

@section('content')

    <div class="ibox">
        <div class="ibox-title pr-2">
        <div class="d-flex align-items-center">
                <h3 class="m-0">{{ $approves->customer_name }} Revise#{{ $approves->approve_id }}</h3>
                @if ($approves->approves_as_status != 'Approved' && $approves->approves_as_status != 'Rejected' && $allowUser)
                <button class="btn btn-primary ml-auto" id="send_approve"><i class="fa fa-check"></i> Approve</button>
                <button class="btn btn-danger" id="send_reject"><i class="fa fa-warning"></i> Reject</button>
                <button class="btn btn-success" data-toggle="modal" data-target="#reassignModal" type="button"><i class="fa fa-retweet"></i> Reassign</button>
                @endif
                {{-- id="send_reassign" --}}
            </div>
        </div><!--ibox-title-->
        <div class="ibox-content">
            <form data-action="{{ url('/') }}/om/customers/approves/update/{{ $approves->approve_id }}" id="form_approve">
                {{ csrf_field() }}
                <input type="hidden" name="status" id="status" value="">

                <table class="table table-form-row" style="border: none;">
                    <tbody>
                        <tr>
                            <th style="width: 140px">From</th>
                            <td>{{ $from->ename }}</td>
                        </tr>

                        <tr>
                            <th>To</th>
                            <td>{{ $approves->employee_name }}</td>
                        </tr>

                        <tr>
                            <th>Sent</th>
                            <td>{{ date('d/m/Y H:i',strtotime($approves->date_sent)) }}</td>
                        </tr>

                        <tr>
                            <th>ID</th>
                            <td>{{ $approves->approve_id }}</td>
                        </tr>
                    </tbody>
                </table>

                <hr>

                <h3 class="black mt-4">ขออนุมัติการสร้างลูกค้าใหม่ ประเภทลูกค้า {{ $approves->custype_name }} ชื่อบริษัท {{ $approves->customer_name }} Revise รายละเอียดตามเอกสารแนบ</h3>

                <table class="table table-form-row">
                    <tbody>
                        <tr>
                            <th style="width: 160px">รหัสขอสร้างลูกค้า</th>
                            <td>{{ $approves->request_number }}</td>
                        </tr>

                        <tr>
                            <th>รหัสลูกค้า</th>
                            <td>{{ $approves->customer_number }}</td>
                        </tr>

                        <tr>
                            <th>สถานะ</th>
                            <td>{{ $approves->approves_as_status }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="black mt-4">ข้อมูลลูกค้า</h3>
                        <table class="table table-form-row">
                            <tbody>
                                <tr>
                                    <th style="width: 140px">ชื่อลูกค้า</th>
                                    <td>{{ $approves->customer_name }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 140px">ประเทศ</th>
                                    <td>{{ $approves->country_name }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 140px">ที่อยู่</th>
                                    <td>{{ $approves->address_line1 }} {{ $approves->address_line2 }} {{ $approves->address_line3 }}</td>
                                </tr>

                                @if(!is_null($approves->state))
                                <tr>
                                    <th style="width: 140px">รัฐ</th>
                                    <td>{{ $approves->state }}</td>
                                </tr>
                                @endif

                                @if(!is_null($approves->province_name))
                                <tr>
                                    <th style="width: 140px">จังหวัด</th>
                                    <td>{{ $approves->province_name }}</td>
                                </tr>
                                @endif

                                @if(!is_null($approves->city))
                                    @if($approves->country_code != 'TH')
                                    <tr>
                                        <th style="width: 140px">เมือง</th>
                                        <td>{{ $approves->city }}</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th style="width: 140px">เขต/อำเภอ/เมือง</th>
                                        <td>{{ $approves->city }}</td>
                                    </tr>
                                    @endif
                                @endif

                                @if(!is_null($approves->district))
                                <tr>
                                    <th style="width: 140px">แขวง/ตำบล</th>
                                    <td>{{ $approves->district }}</td>
                                </tr>
                                @endif

                                @if(!is_null($approves->postal_code))
                                <tr>
                                    <th style="width: 140px">รหัสไปรษณีย์</th>
                                    <td>{{ $approves->postal_code }}</td>
                                </tr>
                                @endif

                                <tr>
                                    <th style="width: 150px">เลขทะเบียนการค้า</th>
                                    <td>{{ $approves->tax_register_number }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 140px">สาขา</th>
                                    <td>
                                        @if ($approves->head_office_flag == 'Y')
                                            สำนักงานใหญ่
                                        @else
                                            {{ $approves->branch }}
                                        @endif

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3 class="black mt-4">ข้อมูลผู้ติดต่อ</h3>
                        <table class="table table-form-row">
                            <tbody>
                                <tr>
                                    <th style="width: 140px">คำนำหน้า</th>
                                    <td>{{ $approves->contact_prefix }}</td>
                                </tr>

                                <tr>
                                    <th>ชื่อผู้ติดต่อ</th>
                                    <td>{{ $approves->contact_first_name }}</td>
                                </tr>

                                <tr>
                                    <th>นามสกุล</th>
                                    <td>{{ $approves->contact_last_name }}</td>
                                </tr>
                                <tr>
                                    <th>อีเมล์</th>
                                    <td>{{ $approves->contact_email }}</td>
                                </tr>
                                <tr>
                                    <th>ตำแหน่ง</th>
                                    <td>{{ $approves->contact_position }}</td>
                                </tr>
                                <tr>
                                    <th>หมายเลขโทรศัพท์</th>
                                    <td>{{ $approves->contact_phone }}</td>
                                </tr>
                                <tr>
                                    <th>สกุลเงิน</th>
                                    <td>{{ $approves->currency }} ({{ $approves->currency_as_name }})</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <p>Attachment</p>

                @if (!empty($approves->attachment_dir_1))
                    <p><code><a href="{{ $basePath }}/{{ $approves->attachment_dir_1.$approves->attachment_file_1 }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $approves->attachment_file_1 }}</a></code></p>
                @endif
                @if (!empty($approves->attachment_dir_2))
                    <p><code><a href="{{ $basePath }}/{{ $approves->attachment_dir_2.$approves->attachment_file_2 }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $approves->attachment_file_2 }}</a></code></p>
                @endif
                @if (!empty($approves->attachment_dir_3))
                    <p><code><a href="{{ $basePath }}/{{ $approves->attachment_dir_3.$approves->attachment_file_3 }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $approves->attachment_file_3 }}</a></code></p>
                @endif
                @if (!empty($approves->attachment_dir_4))
                    <p><code><a href="{{ $basePath }}/{{ $approves->attachment_dir_4.$approves->attachment_file_4 }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $approves->attachment_file_4 }}</a></code></p>
                @endif
                @if (!empty($approves->attachment_dir_5))
                    <p><code><a href="{{ $basePath }}/{{ $approves->attachment_dir_5.$approves->attachment_file_5 }}" target="_blank"><i class="fa fa-file-pdf-o"></i> {{ $approves->attachment_file_5 }}</a></code></p>
                @endif

                <div class="form-group">
                    <label class="d-block">Approver Comment</label>
                    <textarea class="form-control" name="comment"></textarea>
                </div>

                @if (isset($approvesHistory))
                    <p>Approver</p>

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th style="width: 80px">No</th>
                                <th>From User</th>
                                <th>To User</th>
                                <th>Status</th>
                                <th>Approver Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvesHistory as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $fromHistory[$key]->ename }}</td>
                                <td>{{ $toHistory[$key]->ename }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->approver_comment }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </form>
        </div><!--ibox-content-->
    </div><!--ibox-->
    <div class="modal modal-600 fade" id="reassignModal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                <div class="modal-header">
                    <h3>Reassign</h3>
                </div>
                <form id="form_reassign" data-action="{{ url('/') }}/om/customers/approves/reassign/{{ $approves->approve_id }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="d-block">เลือกผู้อนุมัติใหม่</label>
                            <select class="custom-select" name="reassign_approval" id="reassign_approval" required>
                                <option value="">เลือกผู้อนุมัติใหม่</option>
                                @foreach ($customerApproval as $key => $item)
                                <option value="{{ $item->employee_number }}" data-position="{{ $item->position_name }}">{{ $item->employee_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="d-block">ตำแหน่ง</label>
                            <input type="text" class="form-control" disabled id="reassign_approval_postion" value=""/>
                        </div>
                    </div>
                    <div class="modal-footer center mt-4">
                        <button class="btn btn-gray" type="button"  data-dismiss="modal">
                            ปิด<small>Close</small>
                        </button>
                        <button class="btn btn-primary" type="submit">
                            ยืนยัน<small>Confirm</small>
                        </button>
                    </div>
                </form>

            </div><!--modal-content-->
        </div><!--modal-dialog-->
    </div><!--modal-->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $("#form_reassign").submit(async function(e) {
                e.preventDefault();
                let form_reassign = this // this
                let formData = new FormData(form_reassign);

                swal({
                    title: "Loading...",
                    text: "Please wait",
                    button: false,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                $.ajax({
                    type: 'post',
                    url: $(form_reassign).data('action'),
                    data: formData,
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if(result.status){
                            window.location.replace('/om/customers/approves/');
                        }else{
                            swal(result.message);
                        }
                    },
                    error: function (data) {
                    }
                });

            })

            $("#form_approve").submit(async function(e) {
                e.preventDefault();
                let form_approve = this // this
                let formData = new FormData(form_approve);

                $.ajax({
                    type: 'post',
                    url: $(form_approve).data('action'),
                    data: formData,
                    enctype: 'multipart/form-data',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {


                        if(result.status){
                            window.location.replace('/om/customers/approves/');
                        }else{
                            swal(result.message);
                        }

                    },
                    error: function (data) {
                        if(data.status == 419){
                            swal(data.responseJSON.message);
                            setTimeout(function(){ window.location.replace('/login'); }, 2000);

                        }

                    }
                });

            })

            $('#send_approve').on('click', function() {
                $('#status').val('Approved');
                swal({
                    title: "Are you sure approval?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },function(isConfirm) {
                    if (isConfirm) {
                        $("#form_approve").submit();
                    } else {
                        swal.close()
                    }
                });
            });

            $('#send_reject').on('click', function() {
                $('#status').val('Rejected');
                swal({
                    title: "Are you sure reject?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },function(isConfirm) {
                    if (isConfirm) {
                        $("#form_approve").submit();
                    } else {
                        swal.close()
                    }
                });
            });

            $('#send_reassign').on('click', function() {
                $('#status').val('Reassign');
                swal({
                    title: "Are you sure reassign?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No, cancel",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },function(isConfirm) {
                    if (isConfirm) {
                        $("#form_approve").submit();
                    } else {
                        swal.close()
                    }
                });
            });

            $('#reassign_approval').on('change', function() {
                var position = $(this).find(':selected').attr('data-position')
                $('#reassign_approval_postion').val(position)
            });

        });
    </script>
@endsection
