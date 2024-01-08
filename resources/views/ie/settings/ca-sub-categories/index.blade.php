@extends('layouts.app')

@section('title', 'CA Sub-Categories')

@section('page-title')
    {{-- PC --}}
    <h2 class="hidden-xs hidden-sm"> 
        <x-get-program-code url="/ie/settings/ca-categories" /> {{ $ca_category->name }} : CA Sub-Categories <br>
        <small>ประเภทการเบิกเงินทดรองย่อย</small>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="active">
            <a href="{{ route('ie.settings.ca-categories.index') }}"> All CA Categories </a>
        </li>
        <li class="active">
            <strong>{{ $ca_category->name }} : CA Sub-Categories</strong>
        </li>
    </ol>
    {{-- MOBILE --}}
    <h3 class="m-t-md m-b-sm show-xs-only show-sm-only">
        {{ $ca_category->name }} : CA Sub-Categories <br>
        <small>ประเภทการเบิกเงินทดรองย่อย</small>
    </h3>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <a href="{{ route('ie.settings.ca-sub-categories.create',[$ca_category->ca_category_id]) }}" 
            class="btn btn-success pull-right">
            <i class="fa fa-plus"></i> New CA Sub-Category
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th width="8%" class="text-center"></th>
                                <th width="40%">
                                    <div>Name / Description</div>
                                    <div><small>ชื่อ / รายละเอียด</small></div>
                                </th>
                                {{-- <th> 
                                    <div>Description</div>
                                    <div><small>รายละเอียด</small></div>
                                </th> --}}
                                <th width="10%" class="text-center hidden-sm hidden-xs">
                                    <div>Required Attachment</div>
                                    <div><small>บังคับแนบเอกสาร</small></div>
                                </th>
                                <th width="10%" class="text-center hidden-sm hidden-xs">
                                    <div>Start Date</div>
                                    <div><small>วันที่เริ่มต้นใช้งาน</small></div>
                                </th>
                                <th width="12%" class="text-center hidden-sm hidden-xs">
                                    <div>End Date</div>
                                    <div><small>วันที่สิ้นสุดการใช้งาน</small></div>
                                </th>
                                <th width="15%" class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($ca_sub_categories) > 0)
                            @foreach ($ca_sub_categories as $index => $ca_sub_category)
                                <tr>
                                    <td class="text-center">
                                        <span class="hidden-xs">
                                            {!! activeIcon($ca_sub_category->active) !!}
                                        </span>
                                        <span class="show-xs-only">
                                            <span class="m-t-sm">
                                            {!! activeMiniIcon($ca_sub_category->active) !!}
                                            </span>
                                        </span>
                                    </td>
                                    <td style="white-space: normal;">
                                        <div>
                                            {{ $ca_sub_category->name }} <br/>
                                        <small style="color:#999;overflow-wrap: break-word;">{{ $ca_sub_category->description }}</small>
                                        </div>
                                    </td>
                                {{--  <td class="">
                                        {{ $ca_sub_category->description }}
                                    </td> --}}
                                    <td class="text-center hidden-sm hidden-xs">
                                    @if($ca_sub_category->required_attachment)
                                        <span><i class="fa fa-check-circle-o text-navy"></i></span>
                                    @endif
                                    </td>
                                    <td class="text-center hidden-sm hidden-xs">
                                        {{ dateFormatDisplay($ca_sub_category->start_date) }}
                                    </td>
                                    <td class="text-center hidden-sm hidden-xs">
                                        {{ dateFormatDisplay($ca_sub_category->end_date) }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('ie.settings.ca-sub-categories.infos.index',[$ca_category->ca_category_id,$ca_sub_category->ca_sub_category_id]) }}" class="btn btn-block btn-info btn-outline btn-xs"><i class="fa fa-folder"></i> Info. </a>
                                        <a href="{{ route('ie.settings.ca-sub-categories.edit', [$ca_category->ca_category_id,$ca_sub_category->ca_sub_category_id]) }}" class="btn btn-block btn-warning btn-outline btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="6">
                                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if(isset($ca_sub_categories))
                    <div class="text-right">
                        {!! $ca_sub_categories->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection