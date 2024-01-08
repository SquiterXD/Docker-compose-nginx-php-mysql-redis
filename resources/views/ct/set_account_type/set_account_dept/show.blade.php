@extends('layouts.app')

@section('title', 'กำหนดหน่วยงาน')

@section('page-title')
    <h2>กำหนดหน่วยงาน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/ct/set_account_type">Set Account Type</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>Set Account Type Dept</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <set-account-dept-show-component 
                        acc_code="{{$acc_code}}"
                        sub_acc_code="{{$sub_acc_code}}"
                    ></set-account-dept-show-component>
                </div>
            </div>
        </div>
    </div>
@endsection
