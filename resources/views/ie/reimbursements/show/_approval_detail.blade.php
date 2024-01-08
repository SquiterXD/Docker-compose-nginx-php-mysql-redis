
@php
    if($reim->hierarchy_name_position_id){
        $current = \App\Models\IE\HierarchyNamePosition::find($reim->hierarchy_name_position_id);
        $position = optional($current)->position;
        $approvers = optional($position)->getUserList();
    }else {
        $approvers = [];
    }
@endphp
<div class="row">
    <div class="col-md-12">
        @if($reim->next_approver)
        {{-- NEXT APPROVER --}}
        <div><small class="font-bold"> Next Approver</small></div>
        <div><small class="font-bold"> ผู้อนุมัติคนถัดไป</small></div>
        <div class="text-right"> 
            {{ $reim->next_approver ? $reim->next_approver : '-' }} 
            @if(\Auth::user()->isChangeApprover() || !!collect($approvers)->where('user_id', \Auth::user()->user_id)->count())
                <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-change-approver">
                    <i class="fa fa-exchange"></i> Change
                </button>
            @endif
        </div>
        <hr class="m-t-sm m-b-sm">
        @endif
        <dl id="recipt-details" class="dl-horizontal dl-request-approval text-right" style="font-size: 12px;">
            @if($reim->approvals->where('process_type','REIMBURSEMENT')->where('approver_type','APPROVER')->count() > 0)
                @foreach($reim->approvals->where('process_type','REIMBURSEMENT')->where('approver_type','APPROVER')->sortBy('creation_date')->values()->all() as $key => $approval)

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

        </dl>
    </div>
</div>