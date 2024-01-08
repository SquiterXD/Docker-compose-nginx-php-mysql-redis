 {{-- <div class="table-responsive"> --}}
    <table class="table table-hover">
        <tbody>
        @if(count($accountantUsers)>0)
	        @foreach($accountantUsers as $index => $userId)
	        	<?php $user = \App\Models\User::find($userId); ?>
				<tr>
					<td class="text-center" width="5%">
						{{ $index+1 }}
					</td>
		            <td width="30%">
						{{ $user->name }}
		            </td>
		            <td width="45%" class="hidden-sm hidden-xs">
		            	<i style="color:#bbb" class="fa fa-envelope"></i> &nbsp;
		            	{{-- {{ $user->employee->email_address }} --}}
						{{ $user->email }}
		            </td>
		            <td width="5%">
		            	<a href="#" id="btn_remove_accountant_{{ $user->user_id }}" data-value="{{ $user->user_id }}" class="btn btn-outline btn-danger btn-xs">
                            <i class="fa fa-times"></i> 
                        </a>
		            </td>
		        </tr>
	        @endforeach
	    @else
			<tr>
				<td colspan="5">
					<h3 class="text-center m-t-md m-b-md" style="color:#bbb">
						Not found accountant user.
					</h3>
				</td>
			</tr>
	    @endif
        </tbody>
    </table>
{{-- </div> --}}