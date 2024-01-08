@extends('layouts.app')

@section('title', 'Ex: Vue')

@section('page-title')
    <h2>รายการเบิกเครื่องเขียน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Stationery</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Stationery Request</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('inv.requisition_stationery.create') }}" class="btn btn-primary">
        สร้างรายการ
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="">
                        <div class="card">
                            <div class="card-body">
                                 <div class="col-6">
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">เลขที่เบิก</label>
                                        <div class="col-md-10">
                                            <input type="text" name="issue_number" value="{{ request()->issue_number }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">สถานะ</label>
                                        <div class="col-md-10">
                                            <select name="issue_status" class="form-control">
                                                @if ($lookupValuesExists)
                                                    <option value="WAITING" {{ request()->issue_status  == "WAITING" ? 'selected' : ''}}>รอตัดจ่าย</option>
                                                    <option value="ALL" {{ request()->issue_status  == "ALL" ? 'selected' : ''}}></option>
                                                    <option value="APPROVED" {{ request()->issue_status  == "APPROVED" ? 'selected' : ''}}>ตัดจ่ายสำเร็จ</option>
                                                    <option value="CANCELLED" {{ request()->issue_status  == "CANCELLED" ? 'selected' : ''}}>ยกเลิก</option>
                                                    <option value="RETURN" {{ request()->issue_status  == "RETURN" ? 'selected' : ''}}>ยกเลิก(return)</option>
                                                    <option value="DRAFT" {{ request()->issue_status  == "DRAFT" ? 'selected' : ''}}>ร่างรายการเบิก</option>
                                                @endif
                                                @if (!$lookupValuesExists)
                                                    <option value="ALL" {{ request()->issue_status  == "ALL" ? 'selected' : ''}}></option>
                                                    <option value="WAITING" {{ request()->issue_status  == "WAITING" ? 'selected' : ''}}>รอตัดจ่าย</option>
                                                    <option value="APPROVED" {{ request()->issue_status  == "APPROVED" ? 'selected' : ''}}>ตัดจ่ายสำเร็จ</option>
                                                    <option value="CANCELLED" {{ request()->issue_status  == "CANCELLED" ? 'selected' : ''}}>ยกเลิก</option>
                                                    <option value="RETURN" {{ request()->issue_status  == "RETURN" ? 'selected' : ''}}>ยกเลิก(return)</option>
                                                    <option value="DRAFT" {{ request()->issue_status  == "DRAFT" ? 'selected' : ''}}>ร่างรายการเบิก</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">วันที่เริ่ม</label>
                                        <div class="col-md-10">
                                            <date-range-picker-component
                                                :start-date="{{ json_encode(request()->start_date)}}"
                                                :end-date="{{ json_encode(request()->end_date)}}"
                                            ></date-range-picker-component>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label">หน่วยงาน</label>
                                        <div class="col-md-10">
                                            <select name="department_code" class="form-control">
                                                <option value="" selected></option>
                                                @foreach ($coaDeptCodeVs as $deptCode)
                                                    <option value="{{$deptCode->department_code}}" {{ request()->department_code == $deptCode->meaning ? 'selected' : null}}>
                                                        {{$deptCode->meaning}} - {{ $deptCode->description}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-md-2 col-form-label"></label>
                                        <div class="col-10 offset-col-2">
                                            <button class="btn btn-primary">ค้นหา</button>
                                            <a href="/inv/requisition_stationery" class="btn btn-link">ล้างข้อมูล</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>เลขที่เบิก</th>
                                <th style="width: 20%;">รายละเอียดขอเบิก</th>
                                <th style="width: 20%;">หน่วยงาน/สถานที่</th>
                                <th>Subinventory</th>
                                <th class="text-center">สถานะเอกสาร</th>
                                <th>วันที่สร้างรายการ</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issueHeaders as $issueHeader)
                                <tr>
                                    <td>{{ $issueHeader->issue_number }}</td>
                                    <td>{{ $issueHeader->description }}</td>
                                    <td>{{ optional($issueHeader->coaDeptCode)->description }}</td>
                                    <td>{{ $issueHeader->subinventory_code }}</td>
                                    <td class="text-center">
                                        @if ($issueHeader->issue_status == "APPROVED")
                                            <div class="tw-text-green-500">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "WAITING")
                                            <div class="tw-text-blue-500">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "UPDATE")
                                            <div class="tw-text-blue-500">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "INPROCESS")
                                            <div class="text-danger">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "CANCELLED")
                                            <div class="text-danger">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "RETURN")
                                            <div class="text-danger">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status == "DRAFT")
                                            <div class="text-secondary">{{ $issueHeader->thai_status }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($issueHeader->issue_status == "RETURN")
                                            <div class="text-secondary">{{ parseToDateTh($issueHeader->cancel_date) }}</div>
                                        @endif
                                        @if ($issueHeader->issue_status != "RETURN")
                                            <div class="text-secondary">{{ parseToDateTh($issueHeader->creation_date) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('inv.requisition_stationery.copy', [$issueHeader->issue_header_id])}}" class="btn btn-xs btn-info">คัดลอก</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('inv.requisition_stationery.show', [$issueHeader->issue_header_id])}}" class="btn btn-xs btn-primary w-100">
                                            {{ $issueHeader->issue_status == 'APPROVED' ? 'รายละเอียด' : ''}}
                                            {{ $issueHeader->issue_status == 'WAITING' ? 'ตรวจสอบ' : ''}}
                                            {{ $issueHeader->issue_status == 'UPDATE' ? 'ตรวจสอบ' : ''}}
                                            {{ $issueHeader->issue_status == 'INPROCESS' ? 'INPROCESS' : ''}}
                                            {{ $issueHeader->issue_status == 'CANCELLED' ? 'รายละเอียด' : ''}}
                                            {{ $issueHeader->issue_status == 'RETURN' ? 'รายละเอียด' : ''}}
                                            {{ $issueHeader->issue_status == 'DRAFT' ? 'ตรวจสอบ' : ''}}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($issueHeader->issue_status == "WAITING" || $issueHeader->issue_status == "UPDATE" || $issueHeader->issue_status == "DRAFT")
                                            <a href="{{ route('inv.requisition_stationery.edit', [$issueHeader->issue_header_id])}}" class="btn btn-xs btn-warning">แก้ไข</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="tw-flex tw-justify-center tw-my-5">
                        {{ $issueHeaders->appends(Request::all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
