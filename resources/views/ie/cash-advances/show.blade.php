@extends('layouts.app')

@section('title', 'Cash Advance')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/cash-advances" /> Cash Advance </div>
        <div><small>ใบยืมเงินทดรอง</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.cash-advances.index') }}">Cash Advance</a>

        </li>
        <li class="breadcrumb-item active">
            <strong>{{ $cashAdvance->document_no }}</strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    <div class="text-right m-t-lg">
        @if($cashAdvance->isNotLock() && canEnter('/ie/cash-advances'))
            {{-- BUTTON EDIT --}}
            @if (!$cashAdvance->onClearing())
                <button class="btn btn-resize btn-warning btn-outline" data-toggle="modal" id="btn-edit-ca" href="#modal-edit-form-ca">
                    <i class="fa fa-edit"></i> Edit
                </button>
            @endif
            @if( in_array($cashAdvance->status, ['NEW_REQUEST']) )
                {{-- BUTTON CANCEL --}}
                <div class="btn-resize">
                {!! Form::open(['route' => ['ie.cash-advances.set_status', $cashAdvance->cash_advance_id],
                            'method' => 'POST',
                            'id' => 'form-cancel-request']) !!}

                    {!! Form::hidden('type','CASH-ADVANCE') !!}
                    {!! Form::hidden('activity','CANCEL_REQUEST') !!}
                    <button type="submit" class="btn btn-resize btn-danger btn-outline" disabled="disabled">
                        <i class="fa fa-ban"></i> Cancel
                    </button>

                {!! Form::close() !!}
                </div>
            @endif
        @endif
        {{--  BUTTON ENTER DUE DATE  --}}
        {{-- @if($cashAdvance->status == 'FINANCE_PROCESS' && Auth::user()->isFinance() && canEnter('/ie/cash-advances'))
            <button class="btn btn-resize bg-success btn-outline" data-toggle="modal" href="#enter-due-date">
                <i class="fa fa-edit"></i>&nbsp; Enter Due Date & Payments
            </button>
        @endif --}}
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="ibox-content">
            {{-- @include('layouts._error_messages') --}}

            <div class="row">
                <div class="col-md-12">
                {{-- BLOCKED (UNCLEAR ALERT MESSAGE) --}}
                @if($cashAdvance->status == 'BLOCKED')
                    @include('ie.commons._unclear_alert_message')
                @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-9 b-r">
                    {{-- HEADER DETAIL (DOC# & AMOUNT) --}}
                    @include('ie.cash-advances.show._header_detail')

                    {{-- MAIN DETAIL --}}
                    @include('ie.cash-advances.show._main_detail')

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
                                        data-request-type="CASH-ADVANCE" data-request-id="{{$cashAdvance->cash_advance_id}}">
                                        [ ]
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-t-sm m-b-sm">

                    {{-- RECEIPT --}}
                    @include('ie.cash-advances.show._receipts')

                    {{-- CA REQUEST TRANS BUTTON --}}
                    @include('ie.cash-advances.show._button')

                    {{-- ACTIVITY LOG --}}
                    <div class="ibox-content activity-content mini-scroll-bar m-b-md"
                        style="max-height: 400px;overflow: auto;">
                        {{-- ACTIVITY LOG --}}
                        @include('ie.shared._activities')
                        {{-- @include('layouts._activities') --}}
                    </div>
                </div>

                <div class="col-md-3">
                    {{-- HEADER AMOUNT --}}
                    @include('ie.cash-advances.show._header_amount')

                    {{-- OTHER DETAIL --}}
                    @include('ie.cash-advances.show._other_detail')

                    {{-- APPROVAL DETAIL --}}
                    @include('ie.cash-advances.show._approval_detail')
                </div>
            </div>

            @include('ie.cash-advances.show._modal_send_request')
            {{-- MODAL FOR EDIT --}}
            @include('ie.cash-advances._modal_edit')
            {{-- MODAL FOR CA REQUEST TRANS --}}
            @include('ie.cash-advances.show._modal_approval')
            {{-- MODAL FOR ENTER DUE DATE --}}
            @if($cashAdvance->status == 'FINANCE_PROCESS' && Auth::user()->isFinance())
                @include('ie.cash-advances.show._modal_due_date')
            @endif
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