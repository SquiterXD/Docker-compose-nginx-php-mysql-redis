@extends('layouts.app')

@section('page-title-action')
    <a href="{{ route('om.settings.price-list.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Create
    </a>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนด Price List</h5>
                </div>
                <div class="ibox-content">
                    @include('om.settings.price-list._table')
                </div>
            </div>
        </div>
    </div>
@endsection
