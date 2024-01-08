@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>กำหนดรายการราคาสินค้า</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['route' => ['om.settings.price-list.store'] , "method" => "post" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    
                    {{-- {{dd($hzGeographies)}} --}}
                    {{-- @include('om.setting.country._form') --}}
                    <price-list-form 
                            :default-value="{{ json_encode([])}}"
                            :currencies="{{json_encode($currencies)}}"
                            :items="{{json_encode($items)}}"
                            :uoms="{{json_encode($uoms)}}"
                            :url-save="{{ json_encode(route('om.settings.price-list.store')) }}"
                            :url-reset="{{ json_encode(route('om.settings.price-list.index')) }}">
                    </price-list-form>
                    {{-- <price-test
                        :default-value="{{ json_encode([])}}"
                            :currencies="{{json_encode($currencies)}}"
                            :items="{{json_encode($items)}}"
                            :uoms="{{json_encode($uoms)}}">

                    </price-test> --}}
   
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="row clearfix m-t-lg text-right">
                            <div class="col-sm-12">
                                <button class="btn btn-sm btn-primary" type="submit"> Save </button>
                                <a href="{{ route('om.settings.price-list.index') }}" type="button" class="btn btn-sm btn-white"> Cancel </a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection