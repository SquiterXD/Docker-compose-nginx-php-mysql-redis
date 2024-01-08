<div id="modal-edit-unblock-users" class="modal fade" aria-hidden="true">
        <div class="modal-dialog pt-0 modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="modal-body-edit-unblock-users">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                	<h4>
                		<div>Select UnBlocking Responsible Users</div>
                		<div><small>เลือกผู้มีสิทธิ์ปลดบล็อค</small></div>
                	</h4>
					<div class="row">
						<div class="col-sm-12 mini-scroll-bar" style="max-height: 350px;overflow-x: hidden;overflow-y: auto; padding-right: 5px;">
							{{-- <div class="table-responsive">
								<table id="table-edit-unblock-users" class="table table-hover">
									<tbody>
									@if(count($users))
									@foreach($users as $user)
										<tr>
											<td width="5%">
												{!! Form::checkbox('unblock_users[]',$user->user_id,in_array($user->user_id, $unblockers)) !!}
											</td>
											<td width="40%">
												{{ $user->name }}
											</td>
											<td width="55%" class="text-left hidden-sm hidden-xs">
												<i style="color:#bbb" class="fa fa-envelope"></i> &nbsp;
											{{ $user->email }}
											</td>
										</tr>
									@endforeach
									@else
										<tr>
											<td colspan="5">
												<h3 class="text-center m-t-md m-b-md" style="color:#bbb">
													Not found user.
												</h3>
											</td>
										</tr>
									@endif
									</tbody>
								</table>
							</div> --}}
							{!! Form::select('unblock_users[]', $userLists, $unblockers, ["class" => 'form-control select2', "id" => 'txt_unblock_users', "autocomplete" => "off", "multiple" => "multiple"]) !!}
						</div>
					</div>
					<div class="text-right mt-2">
						<button id="btn_save_edit_unblock_users"
								class="btn btn-sm btn-primary" type="submit">
			                Save
			            </button>
			            <button type="button" class="btn btn-sm btn-white" data-dismiss="modal">Cancel</button>
					</div>
                </div>
            </div>
        </div>
</div>
