@php
    if($reim->hierarchy_name_position_id){
        $current = \App\Models\IE\HierarchyNamePosition::find($reim->hierarchy_name_position_id);
        $position = optional($current)->position;
        $approvers = optional($position)->getUserList();
    }else {
        $approvers = [];
    }
@endphp

@if ( (\Auth::user()->isChangeApprover() || !!collect($approvers)->where('user_id', \Auth::user()->user_id)->count()) && $reim->next_approver )

    <div class="modal fade" id="modal-change-approver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog pt-0 modal-md" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Change Approver</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                {!! Form::open(['route' => ['ie.reimbursements.change_approver', $reim->reimbursement_id], 
                    'method' => 'POST',
                    'id' => 'form-change-approver',
                    'class' => 'form-horizontal']) !!}

                    <div class="modal-body">
                        <div class="clearfix m-b-sm text-center">
                            <h4> Select User </h4>
                        </div>
                        <div class="clearfix">
                            <select name="select_approver" id="txt_select_approver" class="form-control select2">
                                @foreach ($approvers as $user)
                                    <option value="{{ $user->user_id }}" {{ $reim->next_approver_id == $user->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Change</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endif