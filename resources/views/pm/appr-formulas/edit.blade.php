@extends('layouts.app')

@section('title', 'PMS0033')

@section('page-title')
    <h2>สูตรการผลิต</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="#">สูตรการผลิต</a>
        </li>
    </ol>
@stop

@section('content')
    <div>
        <div class="ibox">
            
            {{-- <form action="{{ route('pm.appr-formulas.update', $ingredient->ingredient_id) }}" method="POST" class="disable-on-submit">
                @csrf
                @method('PUT')
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-3">
                            <h3 class="no-margins"> กำหนดสูตรผลิตภัณฑ์ </h3>
                        </div>
                        <div class="col-9 text-right">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="#" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </div>
                </div> --}}
                {{-- --------- --}}
                {{-- <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดสูตรผลิตภัณฑ์</h5>
                </div> --}}
                    {{-- <div class="row clearfix m-t-lg text-right">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="#" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </div> --}}
            {{-- </form> --}}
        </div>
    </div>
@endsection
