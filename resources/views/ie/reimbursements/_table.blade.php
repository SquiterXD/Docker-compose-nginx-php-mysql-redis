<div class="table-responsive">
    <table class="table" id="tableReimbursements">
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
                    <div>Inv. Date</div>
                    <div>วันที่ใบแจ้งหนี้</div>
                </th>
                <th width="10%" class="d-none d-sm-table-cell">
                    <div>Preparer</div>
                    <div>ผู้จัดเตรียม</div>
                </th>
                <th width="10%" class="d-none d-sm-table-cell">
                    <div>Requester</div>
                    <div>ผู้ขอเบิก</div>
                </th>
                <th width="10%" class="d-none d-md-table-cell">
                    <div>Pending User</div>
                    <div>ผู้ที่กำลังดำเนินการ</div>
                </th>
                <th width="10%" class="text-right">
                    <div>Amount</div>
                    <div>จำนวนเงิน</div>
                </th>
                <th width="3%" class="no-sort hidden-sm hidden-xs" style="padding-left: 0px;padding-right: 0px;"></th>
                @if (canView('/ie/reimbursements') || canEnter('/ie/reimbursements'))
                    <th width="10%" class="no-sort"></th>
                @endif
            </tr>
        </thead>
        <tbody>
        @if(count($reims) > 0)
            @foreach($reims as $reim)
                <tr>
                    <td class="text-center no-sort">
                        <span class="d-none d-sm-block">
                            {!! statusIconREIM($reim->status) !!}
                        </span>
                        <span class="show-xs-only">
                            {!! statusMiniIconREIM($reim->status) !!}
                        </span>
                    </td>
                    @if (auth::user()->isShowAll())
                        <td class="text-center">
                            {{ $mappings[$reim->org_id] }}
                        </td>
                    @endif
                    <td>{{ $reim->document_no }}</td>
                    <td>
                        @if ($reim->statusCancel)
                            <div class="pull-right d-none d-md-block text-danger" style="font-size: 0.8em;">cancel</div>
                        @endif
                        <div>
                            {{ $reim->invoice_no }}
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">{{ dateFormatDisplay($reim->request_date) }}</td>
                    <td class="d-none d-sm-table-cell">{{ $reim->preparer ? $reim->preparer->name : '-' }}</td>
                    <td class="d-none d-sm-table-cell">{{ optional($reim->requester)->name ?? '-' }}</td>
                    <td class="d-none d-md-table-cell">{{ $reim->pending_user }}</td>
                    <td class="text-right">{{ $reim->total_receipt_amount ? numberFormatDisplay($reim->total_receipt_amount) : '-' }}</td>
                    <td class="d-none d-md-table-cell" style="padding-left: 0px;padding-right: 0px;">
                        {{ $reim->currency_id }}
                    </td>
                    <td class="text-right no-sort" rowspan="2">
                        @if (canView('/ie/reimbursements'))
                            <a class="btn btn-xs btn-block btn-default btn-outline" href="{{ route('ie.reimbursements.show', $reim->reimbursement_id) }}">
                                <i class="fa fa-file-text-o"></i> view
                            </a>
                        @endif
                        @if(($reim->isRequester() || \Auth::user()->isAccountantUser()) && canEnter('/ie/reimbursements'))
                            <a id="btn_duplicate_{{ $reim->reimbursement_id }}" 
                                data-id="{{ $reim->reimbursement_id }}"
                                class="btn btn-xs btn-block btn-info btn-outline">
                                <i class="fa fa-copy"></i> copy
                            </a>
                        @endif
                        {{-- <a class="btn btn-xs btn-block btn-default btn-outline" target="_blank"
                            href="{{ route('ie.report.request', ['REIMBURSEMENT', $reim->reimbursement_id]) }}">
                            PDF 
                        </a> --}}
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        {{ $reim->purpose }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="9">
                    <h2 style="color:#AAA;margin-top: 30px;margin-bottom: 30px;">Not Found.</h2>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
    