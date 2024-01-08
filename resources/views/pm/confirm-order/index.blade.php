@extends('layouts.app')

@section('title', 'ยืนยันยอดผลิต, สูญเสีย')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
{{--    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">--}}
@stop

@section('page-title')
    <h2>
        <x-get-program-code url="/pm/confirm-order" />: บันทึกผลผลิตประจำวัน
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">UAT:PM</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Process</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>บันทึกผลผลิตประจำวัน</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    {{-- @if (canEnter('/users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Create
        </a>
    @endif --}}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
{{--            <confirm-order :headers="{{ json_encode($productHeader) }}" />--}}
            <confirm-order
                :now="{{ json_encode($now) }}"
                :url="{{ json_encode($url) }}"
                :trans-date="{{ json_encode(trans('date')) }}"
                :headers="{{ json_encode($productHeader) }}"
                :department="{{ json_encode($department) }}"
                :org-id="{{ json_encode($organization_id) }}"
                :organization-code="{{ json_encode($organization_code) }}"
                :product-period="{{ json_encode($product_period) }}"
            />
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
    <script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
@endsection
