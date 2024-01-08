@extends('layouts.app')

@section('title', 'Governor')

@section('page-title')
  <h2><x-get-program-code url='/ir/governors/governor'/> : การต่ออายุประกันภัย - ประกันผู้ว่า</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>Insurance</a>
    </li>
    <li class="breadcrumb-item">
        <a>การต่ออายุประกันภัย</a>
    </li>
    <li class="breadcrumb-item active">
      <strong><x-get-program-code url='/ir/governors/governor'/> : การต่ออายุประกันภัย - ประกันผู้ว่า</strong>
    </li>
  </ol>
@stop

@section('page-title-action')
  
@stop

@section('content')
  <div class="row">
      <div class="col-lg-12">
          <div class="ibox">
              <div class="ibox-title">
                  <h5>การต่ออายุประกันภัย - ประกันผู้ว่า</h5>
              </div>
              <div class="ibox-content">
                <governors/>
              </div>
          </div>
      </div>
  </div>
@endsection
