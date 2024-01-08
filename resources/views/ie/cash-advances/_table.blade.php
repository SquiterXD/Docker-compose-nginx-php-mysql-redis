<div class="table-responsive">
    <table class="table" id="tableCashAdvances">
        <thead>
            <tr>
                <th width="8%" class="text-center">
                    <div class="d-none d-sm-block">Status</div>
                    <div class="d-none d-sm-block">สถานะ</div>
                </th>
                @if (auth::user()->isShowAll())
                    <th width="3%" class="text-center">
                        <div class="d-none d-sm-block">OU</div>
                    </th>
                @endif
                <th width="10%">
                    <div class="d-none d-md-block">Document #</div>
                    <div class="d-none d-md-block">หมายเลขเอกสาร</div>
                    <div class="d-block d-md-none">Doc #</div>
                    <div class="d-block d-md-none">เอกสาร #</div>
                </th>
                <th width="10%">
                    <div class="d-none d-md-block">Invoice #</div>
                    <div class="d-none d-md-block">เลขที่ใบแจ้งหนี้</div>
                    <div class="d-block d-md-none">Invoice #</div>
                    <div class="d-block d-md-none">ใบแจ้งหนี้ #</div>
                </th>
                <th width="10%" title="Request Date" class="d-none d-md-table-cell">
                    <div>Req. Date</div>
                    <div>วันที่ยืม</div>
                </th>
                <th width="10%" class="d-none d-sm-table-cell">
                    <div>Preparer</div>
                    <div>ผู้จัดเตรียม</div>
                </th>
                <th width="10%" class="d-none d-sm-table-cell">
                    <div>Requester</div>
                    <div>ผู้ยืม</div>
                </th>
                <th width="10%" class="d-none d-md-table-cell">
                    <div>Pending User</div>
                    <div>ผู้ที่กำลังดำเนินการ</div>
                </th>
                <th width="5%" class="text-center d-none d-md-table-cell no-sort" style="padding-left: 0px;padding-right: 0px;">
                    <div>Paid</div>
                    <div>จ่ายเงิน</div>
                </th>
                <th width="5%" class="text-center d-none d-md-table-cell no-sort" style="padding-left: 0px;padding-right: 0px;">
                    <div>Cleared</div>
                    <div>เคลียร์</div>
                </th>
                <th width="10%" class="text-right">
                    <div>Amount</div>
                    <div>จำนวนเงิน</div>
                </th>
                <th width="3%" class="no-sort d-none d-md-table-cell" style="padding-left: 0px;padding-right: 0px;"></th>
                <th width="10%" class="text-right no-sort"></th>
            </tr>
        </thead>
        <tbody>
        @if(count($cashAdvances) > 0)
            @foreach($cashAdvances as $cashAdvance)
                @php
                    $statusClearCancel = $cashAdvance->statusClearCancel;
                @endphp
                <tr>
                    <td class="text-center">
                        {{-- {!! statusIconCA($cashAdvance->status) !!} --}}
                        <span class="d-none d-sm-block">
                            {!! statusIconCA($cashAdvance->status) !!}
                        </span>
                        <span class="d-block d-sm-none">
                            {!! statusMiniIconCA($cashAdvance->status) !!}
                        </span>
                    </td>
                    @if (auth::user()->isShowAll())
                        <td class="text-center">
                            {{ $mappings[$cashAdvance->org_id] }}
                        </td>
                    @endif
                    <td class="text-right">
                        <div>
                            <div class="pull-left d-none d-md-block" style="font-size: 0.8em;">cash advance</div>
                            <div>{{ $cashAdvance->document_no ?? '-' }}</div>
                        </div>
                        @if($cashAdvance->onClearing() || $statusClearCancel)
                            <hr class="m-t-xs m-b-xs">
                            <div>
                                <div class="pull-left d-none d-md-block" style="font-size: 0.8em;">clear</div>
                                <div>{{ $cashAdvance->clearing_document_no ?? '-' }}</div>
                            </div>
                        @endif
                    </td>
                    <td class="text-right">
                        <div>
                            <div class="pull-left d-none d-md-block" style="font-size: 0.8em;">
                                cash advance
                            </div>
                            @if ($cashAdvance->statusCancel)
                                <div class="pull-right d-none d-md-block text-danger" style="font-size: 0.8em;">cancel</div>
                            @endif
                            <div>{{ $cashAdvance->invoice_no ?? '-' }}</div>
                        </div>
                        {{-- @include('ie.cash-advances._cancel_apply', $item = $cashAdvance) --}}
                        @if($cashAdvance->onClearing() || $statusClearCancel)
                            <hr class="m-t-xs m-b-xs">
                            <div>
                                <div class="pull-left d-none d-md-block" style="font-size: 0.8em;">
                                    clear 
                                </div>
                                @if ($statusClearCancel)
                                    <div class="pull-right d-none d-md-block text-danger" style="font-size: 0.8em;">cancel</div>
                                @endif
                                <div>{{ $cashAdvance->clearing_invoice_no ?? '-' }}</div>
                            </div>
                        @endif
                    </td>
                    <td class="d-none d-md-table-cell">{{ dateFormatDisplay($cashAdvance->request_date) }}</td>
                    <td class="d-none d-sm-table-cell">{{ $cashAdvance->preparer ? $cashAdvance->preparer->name : '-' }}</td>
                    <td class="d-none d-sm-table-cell">{{ optional($cashAdvance->requester)->name ?? '-' }}</td>
                    <td class="d-none d-md-table-cell">{{ $cashAdvance->pending_user }}</td>
                    <td class="text-center d-none d-md-table-cell" style="padding-left: 0px;padding-right: 0px;">
                        @if($cashAdvance->isPaid())
                            <i class="fa fa-check-circle-o text-navy"></i>
                        @endif
                    </td>
                    <td class="text-center d-none d-md-table-cell" style="padding-left: 0px;padding-right: 0px;">
                        @if($cashAdvance->status == 'CLEARED')
                            <i class="fa fa-check-circle-o text-navy"></i>
                        @endif
                    </td>
                    <td class="text-right">
                        <div>
                            <span class="pull-left d-none d-md-block" style="font-size: 0.8em;">cash advance</span>
                            {{ numberFormatDisplay($cashAdvance->amount) }}
                        </div>
                        @if($cashAdvance->onClearing() || $statusClearCancel)
                            <hr class="m-t-xs m-b-xs">
                            <div>
                                <span class="pull-left d-none d-md-block" style="font-size: 0.8em;">clear</span>
                                {{ $cashAdvance->total_receipt_amount ? numberFormatDisplay($cashAdvance->total_receipt_amount) : '-' }}
                            </div>
                        @endif
                    </td>
                    <td class="d-none d-md-table-cell" style="padding-left: 0px;padding-right: 0px;">
                        <div>{{ $cashAdvance->currency_id }}</div>
                        @if($cashAdvance->onClearing() || $statusClearCancel)
                            <hr class="m-t-xs m-b-xs">
                            <div>{{ $cashAdvance->currency_id }}</div>
                        @endif
                    </td>
                    <td class="text-right" rowspan="{{ $statusClearCancel ? 3 : 2}}">
                        @if(( canEnter('/ie/cash-advances') || canView('/ie/cash-advances') ) && $cashAdvance->apply)
                            <a id="btn_select_apply_{{ $cashAdvance->cash_advance_id }}" 
                                data-toggle="modal" href="#modal-list-cancel-apply"
                                data-id="{{ $cashAdvance->cash_advance_id }}"
                                class="btn btn-xs btn-block btn-light btn-outline">
                                <i class="fa fa-history"></i> history
                            </a>
                        @endif
                        @if($cashAdvance->isRequester() && canEnter('/ie/cash-advances') && $cashAdvance->isReapplyable())
                            <a id="btn_re_apply_{{ $cashAdvance->cash_advance_id }}" 
                                data-id="{{ $cashAdvance->cash_advance_id }}"
                                class="btn btn-xs btn-block btn-warning btn-outline">
                                <i class="fa fa-repeat"></i> reapply
                            </a>
                        @endif
                        @if($cashAdvance->status == 'APPROVED' && $cashAdvance->isRequester() && canEnter('/ie/cash-advances') && $cashAdvance->isPaid() && !$cashAdvance->isReapplyable())
                            {{-- SET STATUS TO CLEAR REQUEST --}}
                            <a id="btn_clear_request_{{ $cashAdvance->cash_advance_id }}" 
                                class="btn btn-xs btn-block bg-success btn-outline"
                                href="{{ route('ie.cash-advances.clear-request', $cashAdvance->cash_advance_id) }}">
                                <i class="fa fa-check-square"></i> clear
                            </a>
                        @endif
                        @if($cashAdvance->onClearing() && ( canEnter('/ie/cash-advances') || canView('/ie/cash-advances') ) )
                            <a class="btn btn-xs btn-block bg-success btn-outline" href="{{ route('ie.cash-advances.clear', $cashAdvance->cash_advance_id) }}">
                                <i class="fa fa-check-square"></i> clear
                            </a>
                        @endif
                        <a class="btn btn-xs btn-block btn-default btn-outline" href="{{ route('ie.cash-advances.show', $cashAdvance->cash_advance_id) }}">
                            <i class="fa fa-file-text-o"></i> view CA
                        </a>
                        @if(($cashAdvance->isRequester() || \Auth::user()->isAccountantUser()) && canEnter('/ie/cash-advances'))
                            <a id="btn_duplicate_{{ $cashAdvance->cash_advance_id }}" 
                                data-id="{{ $cashAdvance->cash_advance_id }}"
                                class="btn btn-xs btn-block btn-info btn-outline">
                                <i class="fa fa-copy"></i> copy
                            </a>
                        @endif

                        @if( $cashAdvance->onClearing() && ( canEnter('/ie/cash-advances') || canView('/ie/cash-advances') ) )

                            <div class="row mx-0 m-t-xs">
                                <div class="col-sm-6 padding-btn-receipt-line">
                                    <a class="btn btn-xs btn-block btn-outline btn-default" title="CA PDF" target="_blank" 
                                    href="{{ route('ie.report.request', ['CASH-ADVANCE', $cashAdvance->cash_advance_id]) }}">
                                        <i class="fa fa-file-text"></i> CA
                                    </a>
                                </div>
                                <div class="col-sm-6 padding-btn-receipt-line">
                                    <a class="btn btn-xs btn-block btn-default btn-outline" title="CL PDF" target="_blank" 
                                    href="{{ route('ie.report.request', ['CLEARING', $cashAdvance->cash_advance_id]) }}">
                                        <i class="fa fa-file-text"></i> CL
                                    </a>
                                </div>
                            </div>
                        @else
                            <a class="btn btn-xs btn-block btn-outline btn-default" title="CA PDF" target="_blank" 
                            href="{{ route('ie.report.request', ['CASH-ADVANCE', $cashAdvance->cash_advance_id]) }}">
                                <i class="fa fa-file-text"></i> CA
                            </a>
                        @endif

                    </td>
                </tr>
                @if ($statusClearCancel)
                    <tr style="border: none !important; height: 1px;">
                        <td colspan="2" style="border: none !important; padding: 0px;"></td>
                        <td colspan="9" style="border: none !important; padding: 0px;">
                            <div class="d-none d-md-block text-danger" style="font-size: 0.68em;">{{ optional($statusClearCancel)->remittance_message1 }}</div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="10">
                        {{ $cashAdvance->reason }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="100">
                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>