@extends('layouts.app')

@section('title', 'กำหนดแจ้งเตือนปริมาณใบยา')

{{-- @section('page-title')
    <h2>PDS0007 : กำหนดแจ้งเตือนปริมาณใบยา</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="/">PD</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <strong><a href="{{ route('pd.settings.ohhand-tobacco-forewarn.index') }}">กำหนดแจ้งแตือนปริมาณใบยา</a></strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/pd/settings/ohhand-tobacco-forewarn" />
@stop

@section('content')
    {{-- <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <ohhand-tobacco-forewarn-search :organizations = "{{ json_encode($organizations) }}"
                                    :org = "{{ json_encode($org) }}"
                                    :item-cat-seg1-list = "{{ json_encode($itemCatSeg1List) }}" >
    </ohhand-tobacco-forewarn-search>
@endsection