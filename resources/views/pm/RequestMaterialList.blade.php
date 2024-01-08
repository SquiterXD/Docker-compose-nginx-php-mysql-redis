@extends('layouts.app')

@section('title', 'PD')

@section('page-title')
    <h2>PD</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Request Header</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>ค้นหา</h5>
                </div>
                <div class="ibox-content">
                    <form role="form" class="form">
                        <div class="form-group mr-2">
                            <label for="i1" class="">เลขที่เอกสาร</label>
                            <input type="text" id="i1" class="form-control">
                        </div>
                        <div class="form-group mr-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="i2" class="">วันที่ขอเบิก</label>
                                    <input type="date" id="i2" class="form-control">
                                </div>
                                <div class="col-lg-6">
                                    <label for="i3" class="">ถึง</label>
                                    <input type="date" id="i3" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mr-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="i4" class="">วันที่นำส่ง ยสต.</label>
                                    <input type="date" id="i4" class="form-control">
                                </div>
                                <div class="col-lg-6">
                                    <label for="i5" class="">ถึง</label>
                                    <input type="date" id="i5" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-white" type="submit">ค้นหา</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    <table class="table table-bordered">
                        <thead>
                        <tr class="">
                            <th class="">เลขที่เอกสาร</th>
                            <th class="">หน่วยงานที่ขอเบิก</th>
                            <th class="">วันที่ขอเบิก</th>
                            <th class="">วันที่นำส่งยสท.</th>
                            <th class="">สถานะการขอเบิก</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($headers as $header)
                            <tr>
                                <td>{{ $header->request_number }}</td>
                                <td>{{ $header->department_code }}</td>
                                <td>{{ $header->request_date }}</td>
                                <td>{{ $header->send_date }}</td>
                                <td>{{ $header->request_status }}</td>
                                <td>
                                    <a href="{{ route('pm.request-materials.index', ['id'=>$header->request_header_id]) }}">รายละเอียด</a>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



