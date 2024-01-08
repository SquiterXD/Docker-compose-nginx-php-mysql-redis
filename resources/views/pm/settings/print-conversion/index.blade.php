@extends('layouts.app')

@section('title', 'บันทึกการแปลงหน่วยสิ่งพิมพ์')

@section('page-title')
    <h2>
        <x-get-program-code url="/pm/settings/print-conversion" />: บันทึกการแปลงหน่วยสิ่งพิมพ์
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong><x-get-program-code url="/pm/settings/print-conversion" />: บันทึกการแปลงหน่วยสิ่งพิมพ์</strong>
        </li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div>
                <print-conversion-search    :print-item-cat-list="{{ json_encode($printItemCatList) }}"
                                            :lookup-values="{{ json_encode($lookupValues) }}"
                                            :search = "{{ json_encode($search) }}"
                                            :default-print-item-cat = "{{ json_encode($defaultPrintItemCat) }}">
                
                </print-conversion-search>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>บันทึกการแปลงหน่วยสิ่งพิมพ์</h5>
                </div>
                {!! Form::open(['route' => ['pm.settings.print-conversion.createOrUpdate'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                <div class="ibox-content">
                    <print-conversion-table :list-conversion="{{ json_encode($listConversion) }}"
                                            :lookup-values="{{ json_encode($lookupValues) }}"
                                            :btn-trans="{{ json_encode($btnTrans) }}"
                                            :print-item-cat-list="{{ json_encode($printItemCatList) }}"
                                            :print-type-code="{{ json_encode($printTypeCode) }}"
                                            :search = "{{ json_encode($search) }}">
                    </print-conversion-table>
                </div>
                {!! Form::close() !!}                       
            </div>
        </div>
    </div>
@endsection

<style>
    .fixed {
        position: fixed;
    }

    .side {
        top: 0;
        left: 0;
        bottom: 0;
    }
</style>