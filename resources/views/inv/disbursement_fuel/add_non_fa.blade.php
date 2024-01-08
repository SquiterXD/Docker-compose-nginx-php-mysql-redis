@extends('layouts.app')

@section('title', 'INV Fuel Gas')
    
@section('page-title')
    <h2>ข้อมูลกลุ่มเครื่องจักรเบ็ดเตล็ด</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>Fuel</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลกลุ่มเครื่องจักรเบ็ดเตล็ด</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="" method="post">
                        @csrf
                        <disbursement-fuel-add-non-fa-component></disbursement-fuel-add-non-fa-component> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
