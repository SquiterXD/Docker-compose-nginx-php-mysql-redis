@extends('layouts.app')

@section('title', 'รายการกำหนดศูนย์ต้นทุน')

@section('page-title')
<div>
  <h2>กำหนดศูนย์ต้นทุน</h2>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
          <a>CT</a>
      </li>
      <li class="breadcrumb-item active">
          <strong>กำหนดศูนย์ต้นทุน</strong>
      </li>
    </ol>
    
</div>
@stop

@section('page-title-action')
<a href="/ct/cost_center/create">
  <el-button class="btn-success mr-2 btn-p__tr" style="background-color: #40c8b2; border:none;" id="add_cost_center" type="success">เพิ่มศูนย์ต้นทุน</el-button>
</a>
<a href="/ct/cost_rm">
  <el-button class="btn-success mr-2 btn-p__tr" style="background-color: red; border:none;" id="add_cost_center" type="success">ORG วัตถุดิบ</el-button>
</a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <cost-center-index-component></cost-center-index-component>
                </div>
            </div>
        </div>
    </div>
@endsection
