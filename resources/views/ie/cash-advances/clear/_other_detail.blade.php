<div class="clearfix">
    <small class="font-bold">Clearing Amount (จำนวนเงินที่เคลียร์)</small>
    <div class="text-right m-t-sm">
        <h2 style="font-size: 36px" class="no-margins">
            <span id="receipt_grand_total_amount">
                {{ numberFormatDisplay($cashAdvance->total_receipt_amount) }}
            </span>
            <small>{{ $cashAdvance->currency_id }}</small>
        </h2>
    </div>
</div>
<hr class="m-b-xs">
<div class="clearfix">
    <div class="clearfix m-b-xs">
        <small class="font-bold">Attachments (ไฟล์แนบ)</small>
        {{-- BUTTON ADD ATTACHMENT --}}
        @if($cashAdvance->isNotLock() && canEnter('/ie/cash-advances'))
            <div class="text-right" style="font-size: 10px">
                @include('ie.cash-advances.show._add_attachment')
            </div>
        @endif
    </div>
    <ul class="list-unstyled project-files text-right m-b-xs mini-scroll-bar" 
        style="max-height: 100px;overflow: auto;">
        {{-- ATTACHMENT LISTS --}}
        @if(count($cashAdvance->attachments) > 0)
            @foreach($cashAdvance->attachments as $attachment)
            <li style="width: 97%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">
                @if($cashAdvance->isNotLock() && canEnter('/ie/cash-advances'))
                {!! Form::open(['route' =>[ 'ie.attachments.remove', $attachment->attachment_id], 
                                'method' => 'delete',
                                'style' => 'display: inline-block;',
                                'id' => 'form-remove-attachment']) !!}
                    <button type="submit" title="Remove {{ $attachment->original_name }}" 
                            class="btn btn-xs"
                            style="font-size: 11px; margin-left: 5px; color: #ED5565;">
                        <i class="fa fa-times"></i>
                    </button>
                {!! Form::close() !!}
                @endif
                <a href="{!! route('ie.attachments.download', [$attachment->attachment_id]) !!}" 
                    style="margin-left: 0px;color: #337ab7;">
                @if($attachment->is_image)
                    <i class="fa fa-file-picture-o"></i> 
                @else
                    <i class="fa fa-file-text-o"></i> 
                @endif
                &nbsp;{{ $attachment->original_name }}
                </a>
            </li>
            @endforeach
        @else
            <li> - </li>
        @endif
    </ul>
</div>

<hr class="m-t-xs m-b-sm">
<dl id="recipt-details" class="dl-horizontal text-right m-b-xs" style="font-size: 12px;">

    <dt>
        <div><small>Need By Date</small></div>
        <div><small>วันที่ต้องการรับเงิน</small></div>
    </dt>
    <dd><small>
        {{ $cashAdvance->need_by_date }}
    </small></dd>
    <dt>
        <div><small>Due Date</small></div>
        <div><small>วันที่กำหนดจ่าย</small></div>
    </dt>
    <dd><small>
        {{-- {{ $cashAdvance->due_date ? $cashAdvance->due_date : '-' }} --}}
        {{ $cashAdvance->clearing_gl_date ? $cashAdvance->clearing_gl_date : '-' }}
    </small></dd>

</dl>

@php
    if($cashAdvance->hierarchy_name_position_id){
        $current = \App\Models\IE\HierarchyNamePosition::find($cashAdvance->hierarchy_name_position_id);
        $position = $current->position;
        $approvers = $position->getUserList();
    }else {
        $approvers = [];
    }
@endphp

@if($cashAdvance->next_approver)
<hr class="m-t-sm m-b-xs">
{{-- NEXT APPROVER --}}
<dl id="recipt-details" class="dl-horizontal text-right m-b-xs" style="font-size: 12px;">
    <dt>
        <div><small>Next Approver</small></div>
        <div><small>ผู้อนุมัติคนถัดไป</small></div>
    </dt>
    <dd>
        <small>{{ $cashAdvance->next_approver ? $cashAdvance->next_approver : '-' }}</small>
        @if(\Auth::user()->isChangeApprover() || !!collect($approvers)->where('user_id', \Auth::user()->user_id)->count())
            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-change-approver">
                <i class="fa fa-exchange"></i> Change
            </button>
        @endif
    </dd>
</dl>
@endif
<hr class="m-t-sm m-b-sm">

<h5> Request Approval</h5>

<hr class="m-t-sm m-b-sm">

<dl id="recipt-details" class="dl-horizontal dl-request-approval text-right" style="font-size: 12px;">

    @if($cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','APPROVER')->count() > 0)
        @foreach($cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','APPROVER')->sortBy('creation_date')->values()->all() as $key => $approval)

            <dt>
            @if($key == 0) 
                <div><small>Approved by </small></div> 
                <div><small>ผู้อนุมัติ </small></div> 
            @endif
            </dt>
            <dd>
                <div><small>{{ $approval->user->name }}</small></div>
                <div><small>{{ date(trans('date.time-format'),strtotime($approval->creation_date)) }}</small></div>
            </dd>

        @endforeach
    @else
        <dt>
            <div><small>Approved by </small></div> 
            <div><small>ผู้อนุมัติ </small></div> 
        </dt>
        <dd><small>-</small></dd>
        <dt><small></small></dt>
        <dd><small>-</small></dd>
    @endif

    {{-- @if($cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','FINANCE')->count() > 0)
        @foreach($cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','FINANCE')->sortBy('creation_date')->values()->all() as $key => $approval)

            <dt>
            @if($key == 0) 
                <div><small>Finance Approved by </small></div> 
                <div><small>เจ้าหน้าที่การเงินที่อนุมัติ </small></div> 
            @endif
            </dt>
            <dd>
                <div><small>{{ $approval->user->name }}</small></div>
                <div><small>{{ date(trans('date.time-format'),strtotime($approval->creation_date)) }}</small></div>
            </dd>

        @endforeach
    @else
        <dt>
            <div><small>Finance Approved by </small></div> 
            <div><small>เจ้าหน้าที่การเงินที่อนุมัติ </small></div> 
        </dt>
        <dd><small>-</small></dd>
        <dt><small></small></dt>
        <dd><small>-</small></dd>
    @endif --}}

</dl>

<hr class="m-t-sm m-b-sm">

<h5> Clearing Approval</h5>

<hr class="m-t-sm m-b-sm">

<dl id="recipt-details" class="dl-horizontal dl-request-approval text-right">

    @if($cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','APPROVER')->count() > 0)
        @foreach($cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','APPROVER')->sortBy('creation_date')->values()->all() as $key => $approval)

            <dt>
            @if($key == 0) 
                <div><small>Approved by </small></div> 
                <div><small>ผู้อนุมัติ </small></div> 
            @endif
            </dt>
            <dd>
                <div><small>{{ $approval->user->name }}</small></div>
                <div><small>{{ date(trans('date.time-format'),strtotime($approval->creation_date)) }}</small></div>
            </dd>

        @endforeach
    @else
        <dt>
            <div><small>Approved by </small></div> 
            <div><small>ผู้อนุมัติ </small></div> 
        </dt>
        <dd><small>-</small></dd>
        <dt><small></small></dt>
        <dd><small>-</small></dd>
    @endif
    
    {{-- @if($cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','FINANCE')->count() > 0)
        @foreach($cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','FINANCE')->sortBy('creation_date')->values()->all() as $key => $approval)

            <dt>
            @if($key == 0) 
                <div><small>Finance Approved by </small></div> 
                <div><small>เจ้าหน้าที่การเงินที่อนุมัติ </small></div> 
            @endif
            </dt>
            <dd>
                <div><small>{{ $approval->user->name }}</small></div>
                <div><small>{{ date(trans('date.time-format'),strtotime($approval->creation_date)) }}</small></div>
            </dd>

        @endforeach
    @else
        <dt>
            <div><small>Finance Approved by </small></div> 
            <div><small>เจ้าหน้าที่การเงินที่อนุมัติ </small></div> 
        </dt>
        <dd><small>-</small></dd>
        <dt><small></small></dt>
        <dd><small>-</small></dd>
    @endif --}}

</dl>
