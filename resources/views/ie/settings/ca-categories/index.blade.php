@extends('layouts.app')

@section('title', 'Cash Advance Categories')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/settings/ca-categories" /> Cash Advance Categories </div>
        <div><small>ประเภทของการเบิกเงินทดรอง</small></div>
    </h2>
    <ol class="breadcrumb hidden-xs hidden-sm">
        <li class="breadcrumb-item active">
            <strong>Cash Advance Categories</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        <a href="{{ route('ie.settings.ca-categories.create') }}"
            class="btn btn-success pull-right">
            <i class="fa fa-plus"></i> New Cash Advance Category
        </a>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="m-l-md m-r-md">
                    @foreach($ca_categories as $ca_category)
                        <div class="forum-item" style="margin: 7px 0; padding: 7px 0 10px;">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="forum-icon-policy">
                                        <i class="fa {{ $ca_category->icon }}"></i>
                                    </div>
                                    <div class="forum-item-policy-title">
                                        {{ $ca_category->name }}
                                    </div>
                                    <div class="forum-sub-title clearfix m-b-xs" style="margin-left: 70px;">
                                        {{ $ca_category->description }}
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ route('ie.settings.ca-sub-categories.index',[$ca_category->ca_category_id]) }}" class="btn btn-resize btn-default">
                                        <i class="fa fa-th-list m-r-xs"></i> Sub-Categories
                                    </a>
                                    <a href="{{ route('ie.settings.ca-categories.edit',[$ca_category->ca_category_id]) }}" class="btn btn-resize btn-warning">
                                        <i class="fa fa-edit m-r-xs"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection