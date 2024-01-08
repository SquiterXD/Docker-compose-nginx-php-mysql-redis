@extends('layouts.app')

@section('title', 'Reimbursements')

@section('page-title')
    <h2>
        <div><x-get-program-code url="/ie/reimbursements" /> Reimbursement</div>
        <div><small>ใบเบิกเงินสำรองจ่าย / PR - TO AP</small></div>
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('ie.reimbursements.index') }}">
                Reimbursements
            </a>
        </li>
        <li class="breadcrumb-item active">
            <strong>
                {{ $reim->document_no }}
            </strong>
        </li>
    </ol>
@stop

@section('page-title-action')
    @if( $reim->isNotLock() && canEnter('/ie/reimbursements') )
        <div class="text-right m-t-lg">
            {{-- BUTTON EDIT --}}
            <button class="btn btn-resize btn-warning btn-outline" data-toggle="modal" href="#modal-edit-form" id="btn-edit-reim">
                <i class="fa fa-edit"></i> Edit
            </button>
            @if ( in_array($reim->status, ['NEW_REQUEST']) )
                {{-- BUTTON CANCEL --}}
                <div class="btn-resize">
                    {!! Form::open(['route' => ['ie.reimbursements.set_status', $reim->reimbursement_id],
                                'method' => 'POST',
                                'id' => 'form-cancel-request']) !!}

                        {!! Form::hidden('activity','CANCEL_REQUEST') !!}
                        <button type="submit" class="btn btn-resize btn-danger btn-outline" disabled="disabled">
                            <i class="fa fa-ban"></i> Cancel
                        </button>

                    {!! Form::close() !!}
                </div>
            @endif
        </div>
    @endif
    {{-- @if($reim->status == 'APPROVER_DECISION' && Auth::user()->isFinance() && canEnter('/ie/reimbursements'))
        <button class="btn btn-resize bg-success btn-outline" data-toggle="modal" href="#enter-due-date">
            <i class="fa fa-edit"></i>&nbsp; Enter Due Date & Payments
        </button>
    @endif --}}
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                {{-- @include('layouts._error_messages') --}}

                <div class="row">
                    <div class="col-md-12">
                        {{-- ERR MSG OVER BUDGET --}}
                        <div id="div_over_budget_err_msg_by_account" class="d-none"></div>
                        {{-- BLOCKED (UNCLEAR ALERT MESSAGE) --}}
                        @if($reim->status == 'BLOCKED')
                            @include('ie.commons._unclear_alert_message')
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9 b-r">
                        {{-- HEADER DETAIL --}}
                        @include('ie.reimbursements.show._header_detail')

                        {{-- MAIN DETAIL --}}
                        @include('ie.reimbursements.show._main_detail')

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
                                            {!! optional($reim->checkedBy)->name ?? '-' !!}
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
                                            {!! optional($reim->approvedBy)->name ?? '-' !!}
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="row" style="padding: 0px">
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-info btn-resize" id="btn_open_dff_header" 
                                            data-request-type="REIMBURSEMENT" data-request-id="{{$reim->reimbursement_id}}">
                                            [ ]
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-t-sm m-b-sm">

                        {{-- TABLE RECEIPT --}}
                        @include('ie.reimbursements.show._receipts')

                        {{-- REIM REQUEST TRANS BUTTON --}}
                        @include('ie.reimbursements.show._button')

                        {{-- ACTIVITY LOG --}}

                        <div class="ibox-content activity-content mini-scroll-bar m-b-md"
                            style="max-height: 400px;overflow: auto;">
                            @include('ie.shared._activities')
                            {{-- @include('layouts._activities') --}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        {{-- HEADER AMOUNT --}}
                        @include('ie.reimbursements.show._header_amount')
                        
                        {{-- ATTACHMENT DETAIL --}}
                        @include('ie.reimbursements.show._attachment_detail')

                        {{-- APPROVAL DETAIL --}}
                        @include('ie.reimbursements.show._approval_detail')
                    </div>
                </div>

                {{-- MODAL FOR EDIT --}}
                @include('ie.reimbursements._modal_edit')
                {{-- MODAL FOR SEND REQUEST --}}
                @include('ie.reimbursements.show._modal_send_request')
                {{-- MODAL FOR REIM REQUEST TRANS --}}
                @include('ie.reimbursements.show._modal_approval')
                {{-- MODAL FOR ENTER DUE DATE --}}
                {{-- @if($reim->status == 'APPROVER_DECISION' && Auth::user()->isFinance())
                    @include('ie.reimbursements.show._modal_due_date')
                @endif --}}
                {{-- MODAL FOR REIM CHANGE APPROVE --}}
                @include('ie.reimbursements.show._modal_change_approver')
                {{-- MODAL DFF HEADER --}}
                @include('ie.commons.dff._modal_dff_header')
                {{-- MODAL DFF LINE --}}
                @include('ie.commons.dff._modal_dff_line')
            </div>
        </div>
    </div>
@stop

@section('scripts')

    {{-- SCRIPT REIMBURSEMENT TRANSACTIONS --}}
    @include('ie.reimbursements._script')

    {{-- SCRIPT RECEIPT --}}
    @include('ie.commons.receipts._script')

    {{-- SCRIPT DFF --}}
    @include('ie.commons.dff._script')

@stop