@extends('layouts.app')

@section('title', 'Cash Advance')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/cash-advances" /> Clearing Cash Advance</div>
        <div><small>ใบเคลียร์เงินยืมทดรองจ่าย</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.cash-advances.index') }}">Cash Advance</a>

        </li>
        <li class="breadcrumb-item active">
            <strong>Clearing : {{ $cashAdvance->clearing_document_no }}</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        @if($cashAdvance->isNotLock() && canEnter('/ie/cash-advances'))
            @if (\Auth::user()->isAccountantUser())
                <button class="btn btn-resize btn-warning btn-outline" data-toggle="modal" id="btn-edit-ca" href="#modal-edit-form-ca">
                    <i class="fa fa-edit"></i> Edit
                </button>
            @else
                <button class="btn btn-resize btn-warning btn-outline" data-toggle="modal" id="btn-edit-cl" href="#modal-edit-form-cl">
                    <i class="fa fa-edit"></i> Edit
                </button>
            @endif
        @endif
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox-content">
            {{-- @include('layouts._error_messages') --}}
            {{-- ERR MSG OVER BUDGET --}}
            <div class="row">
                <div class="col-md-12">
                    <div id="div_over_budget_err_msg_by_account" class="d-none"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 b-r">

                    {{-- COMPARE CA & CLEAR --}}
                    @include('ie.cash-advances.clear._compare_clearing_amount')

                    {{-- HEADER DETAIL (DOC# & AMOUNT) --}}
                    @include('ie.cash-advances.clear._header_detail')

                    {{-- MAIN DETAIL --}}
                    @include('ie.cash-advances.clear._main_detail')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 text-sm-right" style="padding-left: 0px;">
                                    <dt>
                                        <div>Checked By</div>
                                        <div><small>(ผู้ตรวจสอบ)</small></div>
                                    </dt>
                                </div>
                                <div class="col-md-8 text-sm-left">
                                    <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                                        {!! optional($cashAdvance->checkedBy)->name ?? '-' !!}
                                    </dd>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-5 text-sm-right" style="padding-left: 0px;">
                                    <dt>
                                        <div>Approved By </div>
                                        <div><small>(ผู้อนุมัติ)</small></div>
                                    </dt>
                                </div>
                                <div class="col-md-7 text-sm-left">
                                    <dd class="mini-scroll-bar" style="max-height: 200px;overflow: auto;">
                                        {!! optional($cashAdvance->approvedBy)->name ?? '-' !!}
                                    </dd>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="row" style="padding: 0px">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-info btn-resize" id="btn_open_dff_header" 
                                        data-request-type="CLEARING" data-request-id="{{$cashAdvance->cash_advance_id}}">
                                        [ ]
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-t-sm m-b-sm">

                    {{-- RECEIPT --}}
                    @include('ie.cash-advances.clear._receipts')

                    {{-- CA REQUEST TRANS BUTTON --}}
                    @include('ie.cash-advances.clear._button')

                    {{-- ACTIVITY LOG --}}
                    <div class="ibox-content activity-content mini-scroll-bar m-b-md"
                        style="max-height: 400px;overflow: auto;">
                        {{-- ACTIVITY LOG --}}
                        @include('ie.shared._activities')
                        {{-- @include('layouts._activities') --}}
                    </div>
                </div>

                <div class="col-md-3">

                    @include('ie.cash-advances.clear._other_detail')
                </div>
            </div>

            @include('ie.cash-advances.clear._modal_send_request')
            {{-- MODAL FOR EDIT --}}
            @include('ie.cash-advances.clear._modal_edit')
            {{-- MODAL FOR CLEARING REQUEST TRANS --}}
            @include('ie.cash-advances.clear._modal_approval')
            {{-- MODAL DFF HEADER --}}
            @include('ie.commons.dff._modal_dff_header')
            {{-- MODAL DFF LINE --}}
            @include('ie.commons.dff._modal_dff_line')
            {{-- MODAL FOR CA CHANGE APPROVE --}}
            @include('ie.cash-advances.show._modal_change_approver')
        </div>
    </div>
</div>
@stop

@section('scripts')

    {{-- SCRIPT CASH ADVANCE TRANSACTIONS --}}
    @include('ie.cash-advances._script')

    {{-- SCRIPT RECEIPT --}}
    @include('ie.commons.receipts._script')

    {{-- SCRIPT DFF --}}
    @include('ie.commons.dff._script')

@stop