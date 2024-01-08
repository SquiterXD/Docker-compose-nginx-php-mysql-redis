@extends('layouts.app')

@section('title', 'กำหนดรหัสภาษีใบยา')

@section('page-title')
    <h2>กำหนดรหัสภาษีใบยา</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>CT</a>
        </li>
        <li class="breadcrumb-item">
          กำหนดรหัสภาษีใบยา
        </li>
        <li class="breadcrumb-item active">
          <strong>สร้าง</strong>
      </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                  <tax-medicine-create-component :is-edit="{{json_encode($is_edit)}}"></tax-medicine-create-component>
                </div>
            </div>
        </div>
    </div>
@endsection
