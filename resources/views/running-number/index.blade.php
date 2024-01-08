@extends('layouts.app')

@section('title', 'Running number')

@section('page-title')
    <h2>Running Number</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item active">
            <a>Running Number</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('running-number.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> สร้าง
    </a>
@stop

{{-- @section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="mb-5">
                        <search-running  :headers = "{{ json_encode($headers) }}"
                                         :modules = "{{ json_encode($modules) }}">
                        </search-running>
                    </div>
                    @include('running-number._table')
                </div>
            </div>
        </div>
    </div>
@endsection --}}

{{-- @section('content') --}}
    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <search-running  :headers = "{{ json_encode($headers) }}"
                                     :modules = "{{ json_encode($modules) }}" 
                                     inline-template>
                        
                        <div class="mt-5">
                            @include('running-number._table')
                        </div>
                    </search-running>
                </div>
            </div>
        </div>
    </div> --}}
{{-- ------------------------------------------ --}}
    {{-- <search-running
        :headers = "{{ json_encode($headers) }}"
        :modules = "{{ json_encode($modules) }}"
        inline-template>
        <div>
            @include('running-number._search', ['actionUrl' => route('running-number.index')])
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    @include('running-number._table')
                </div>
            </div>
        </div>
    </search-running>

@endsection --}}

@section('content')
    <search-running
        :headers = "{{ json_encode($runningNumber) }}"
        :modules = "{{ json_encode($modules) }}"
        inline-template>
        <div>
           

            {{-- <div class="form-group mt-2">
                <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary" data-toggle="modal" 
                    :data-target="'#modal-flexfield'">
                        Add
                    </button>
                </div>
            </div> --}}

            {{-- @include('ir.settings.account-mapping._account_modal') --}}

            <div class="ibox float-e-margins">
             
                <div class="ibox-content">
                   @include('running-number._search', ['actionUrl' => route('running-number.index')])
                </div>
                <div class="ibox-content mt-3">
                    {{-- @include('running-number._test') --}}
                    @include('running-number._table')
                     {{-- <div class="m-t-sm text-right">
                        {!! $headers->render() !!}
                    </div> --}}
                </div>
            </div>
            {{-- -------------------------- ใช้ test page------------------------------- --}}
            {{-- <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Users</h5>
                        </div>
                        <div class="ibox-content">
                            @include('running-number._table')
        
                            <div class="m-t-sm text-right">
                                {!! $headers->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- --------------------------------------------------------- --}}
        
        </div>
       
    </search-running>
@endsection

