@extends('layouts.app')

@section('title', 'คืนสินค้า (RMA) ในประเทศ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/toastr/toastr.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
@stop

@section('page-title')
    <h2>OMP0052 : บันทึกใบคืนสินค้า (RMA) สำหรับขายในประเทศ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>OMP0052 บันทึกใบคืนสินค้า (RMA) สำหรับขายในประเทศ</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <rma-domestic
                :numbers="{{ json_encode($numbers) }}"
                :invoices="{{ json_encode($invoices) }}"
                :customers="{{ json_encode($customers) }}"
                :url="{{ json_encode($url) }}"
                :uomlist="{{ json_encode($uomlist) }}"
            />
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('custom/js/toastr/toastr.min.js') !!}"></script>
    <script src="{!! asset('custom/js/sweetalert/sweetalert2.min.js') !!}"></script>
    <script src="{!! asset('custom/custom.js') !!}"></script>
    <script>
        $('.select2').select2();
    </script>
@endsection
