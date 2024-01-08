@extends('layouts.blank')

@section('title', 'Login')

@section('content')


    <div class="loginColumns animated fadeInDown">
        <div class="row">

            {{-- {{ var_dump('zz', Session::all()) }} --}}
            @if (Session::has('err_login') && Session::get('err_login'))
            <div class="row">
                <div class="col-12">
                    <ul class="list-unstyled alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <li>{!! Session::get('err_login') !!}</li>
                    </ul>
                </div>
            </div>
            @endif

            <div class="col-md-12 text-center">
                <div class="widget red-bg p-lg text-center">
                    <div class="m-b-md">
                        <i class="fa fa-bell fa-4x"></i>
                        {{-- <h1 class="m-xs">47</h1> --}}
                        <h1 class="font-bold no-margins">
                            ข้อมูลผู้ใช้งาน มีการเปลี่ยนแปลงแผนก
                        </h1>
                        <h3>โปรดติดต่อเจ้าหน้าที่ดูแลระบบ โทร. 77</h3>

                    </div>
                </div>
                <a href="/logout" class="btn  btn-default mt-3 mb-3" >ออกจากระบบ</a>
            </div>

        </div>
    </div>
@endsection
