@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        {{-- <table width="100%" style="height:100vh;" border="0" class="">
            <tr >
                <td class="align-top text-center " style="opacity: 0.4; filter: alpha(opacity=40);">
                    <img class="img-circlex "
                        style="
                            max-height: 300px;
                            position: relative;
                            line-height: 300px;
                            "
                        src="{{ asset('img/logo-home2.png') }}" alt="">
                    <div class="text-center logo-font" style="
                        font-size: 35px;
                    ">
                        <strong>การยาสูบแห่งประเทศไทย</strong>
                    </div>
                    <div class="text-center logo-font" style="
                        font-size: 28px;
                    ">
                        <strong>Tobacco Authority of Thailand</strong>
                    </div>
                </td>
            </tr>
        </table> --}}

        <div class="row">
            <div class="col-lg-12">
                {{-- <div class="text-center m-t-lg" "> --}}
                <div class="text-center" style="opacity: 0.4; filter: alpha(opacity=40);">
                    <img class="img-circlex "
                        style="
                            max-height: 300px;
                            position: relative;
                            line-height: 300px;
                            "
                        src="{{ asset('img/logo-home2.png') }}" alt="">
                    <div class="text-center logo-font" style="
                        font-size: 35px;
                    ">
                        <strong>การยาสูบแห่งประเทศไทย</strong>
                    </div>
                    <div class="text-center logo-font" style="
                        font-size: 28px;
                    ">
                        <strong>Tobacco Authority of Thailand</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
