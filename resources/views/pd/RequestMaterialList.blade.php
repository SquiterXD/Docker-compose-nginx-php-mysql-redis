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
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">

                    <table class="table">
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
                                <td>{{ $header->attribute1 }}</td>
                                <td>{{ $header->attribute2 }}</td>
                                <td>{{ $header->attribute3 }}</td>
                                <td>{{ $header->attribute4 }}</td>
                                <td>{{ $header->attribute5 }}</td>
                                <td>
                                    <a href="{{ route('pd.requestMaterial.main', ['id'=>$header->request_header_id]) }}">รายละเอียด</a>
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



