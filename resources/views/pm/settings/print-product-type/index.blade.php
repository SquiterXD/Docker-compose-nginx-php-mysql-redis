@extends('layouts.app')

@section('title', 'กำหนด Product ประเภทสิ่งพิมพ์')

@section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/print-product-type" />: กำหนด Product ประเภทสิ่งพิมพ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/pm/settings/print-product-type" />: กำหนด Product ประเภทสิ่งพิมพ์</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนด Product ประเภทสิ่งพิมพ์</h5>
                </div>
                {!! Form::open(['route' => ['pm.settings.print-product-type.update'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                <div class="ibox-content">
                    <product-type-table :products="{{ json_encode($products) }}"
                                        :list-products="{{ json_encode($listProducts) }}"
                                        :btn-trans="{{ json_encode($btnTrans) }}">
                    </product-type-table>
                </div>
                {!! Form::close() !!}                       
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2">
        {!! $products->links('shared._pagination') !!}
    </div>
@endsection