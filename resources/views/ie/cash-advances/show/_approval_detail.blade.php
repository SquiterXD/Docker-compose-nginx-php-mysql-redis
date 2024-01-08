@php
    $lastApply = $cashAdvance->lastApply;
    if($cashAdvance->hierarchy_name_position_id){
        $current = \App\Models\IE\HierarchyNamePosition::find($cashAdvance->hierarchy_name_position_id);
        $position = optional($current)->position;
        $approvers = optional($position)->getUserList();
    }else {
        $approvers = [];
    }
@endphp

@if($cashAdvance->next_approver)

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

<hr class="m-t-sm m-b-sm">

@endif

<h5> Request Approval</h5>

<hr class="m-t-sm m-b-sm">

<dl id="recipt-details" class="dl-horizontal dl-request-approval text-right" style="font-size: 12px;">

    @php
        $caApproverApprovals = $cashAdvance->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','APPROVER');
    @endphp

    @if($caApproverApprovals->count() > 0)
        @foreach($caApproverApprovals->sortBy('creation_date')->values()->all() as $key => $approval)

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
    
    {{-- @php
        $caFinanceApprovals = $lastApply->approvals->where('process_type','CASH-ADVANCE')->where('approver_type','FINANCE');
    @endphp

    @if($caFinanceApprovals->count() > 0)
        @foreach($caFinanceApprovals->sortBy('creation_date')->values()->all() as $key => $approval)

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

    @php
        $clApproverApprovals = $cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','APPROVER');
    @endphp

    @if($clApproverApprovals->count() > 0)
        @foreach($clApproverApprovals->sortBy('creation_date')->values()->all() as $key => $approval)

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

    {{-- @php
        $clFinanceApprovals = $cashAdvance->approvals->where('process_type','CLEARING')->where('approver_type','FINANCE');
    @endphp
    
    @if($clFinanceApprovals->count() > 0)
        @foreach($clFinanceApprovals->sortBy('creation_date')->values()->all() as $key => $approval)

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