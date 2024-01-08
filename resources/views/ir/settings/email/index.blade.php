@extends('layouts.app')

@section('title', 'IRM0010')

@section('page-title')
    <h2>IRM0010: ข้อมูล Email สำหรับแจ้งเคลมประกัน</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>IR</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ir.settings.email.index') }}">IRM0010: ข้อมูล Email สำหรับแจ้งเคลมประกัน</a>
        </li>
    </ol>
@stop

@section('page-title-action')
    <a href="{{ route('ir.settings.email.create') }}" class="{{ trans('btn.create.class') }}">
        <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
    </a>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                       <form action="" method="GET" autocomplete="off">
                            <search-email :emails="{{ json_encode($emails) }}"
                                    :companies="{{ json_encode($companies) }}"
                                    :employees="{{ json_encode($employees) }}"
                                    :data-search="{{ json_encode($dataSearch) }}"
                                    :data-lists="{{ json_encode($dataLists) }}"
                                    :action-url="{{ json_encode(route('ir.settings.email.index')) }}">
                            </search-email>
                        </form>                    
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="m-t-lg">
                    <h1 class="tw-mt-0"></h1>
                    <div class="ibox-content">
                        {{-- <index-email inline-template>
                            <div v-loading="loading"> --}}
                                @include('ir.settings.email._table')
                            {{-- </div>
                        </index-email> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

