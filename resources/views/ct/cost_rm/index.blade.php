@extends('layouts.app')

@section('title', 'กำหนด ORG วัตถุดิบ')

@section('page-title')
<div>
  <h2>กำหนด ORG วัตถุดิบ</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
          <a>CT</a>
      </li>
      <li class="breadcrumb-item active">
          <strong>กำหนด ORG วัตถุดิบ</strong>
      </li>
    </ol>
    
</div>
@stop

@section('page-title-action')
<a href="/ct/cost_center">
  <el-button class="btn-success mr-2 btn-p__tr" style="background-color: red; border:none;" id="add_cost_center" type="success">BACK</el-button>
</a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" style="background: rgb(243 243 244)">
                  <cost-rm-index-component/>
                </div>
            </div>
        </div>
    </div>
@endsection
