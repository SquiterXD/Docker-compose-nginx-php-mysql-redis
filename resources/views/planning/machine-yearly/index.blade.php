@extends('layouts.app')

@section('title', 'ประมาณการกำลังผลิตประจำปี')

@section('page-title')
    <h2> <x-get-program-code url="/planning/machine-yearly"/>: ประมาณกำลังการผลิตประจำปี</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปี</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณกำลังการผลิตประจำปี</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <button class="btn-lg tw-w-25 {{ trans('btn.create.class') }}" data-toggle="modal" data-target="#modal-create" data-backdrop="static" data-keyboard="false"> <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }} </button>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <search-machine-yearly-component :header="{{ json_encode($header) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :default-input="{{ json_encode($defaultInput) }}"
                        :search-input="{{ json_encode($searchInput) }}"
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :search="{{ json_encode($search) }}"
                        :p-url="{{ json_encode($url) }}"
                        :month-details="{{ json_encode($monthDetails) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        date-format="{{ trans('date.format-month-pp') }}"
                    >
                    </search-machine-yearly-component>
                    @include('planning.machine-yearly._create_machine_modal')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        // setTimeout( function() {
        //     var body = $('body');
        //     if (body.hasClass('fixed-sidebar')) {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     } else {
        //         if (!body.hasClass('body-small')) {
        //             body.addClass('mini-navbar');
        //         }
        //     }
        // },500)
    </script>
@stop