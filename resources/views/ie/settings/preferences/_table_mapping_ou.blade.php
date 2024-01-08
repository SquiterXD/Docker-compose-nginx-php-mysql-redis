
{{-- <div class="table-responsive"> --}}
    <table class="table table-hover">
        <tbody>
        @if(count($ous)>0)
	        @foreach($ous as $ou)
				<tr>
					<td width="5%">
						{{ $loop->iteration }}
					</td>
					<td width="55%">
						{{ $ou->name }}
						{{-- {!! Form::checkbox('unblock_users[]',$user->user_id,in_array($user->user_id, $unblockers)) !!} --}}
					</td>
					<td width="40%">
						{!! $mappingOU ? $mappingOU[$ou->organization_id] : null !!}
					</td>
		        </tr>
	        @endforeach
	    @else
			<tr>
				<td colspan="5">
					<h3 class="text-center m-t-md m-b-md" style="color:#bbb">
						Not found operating units.
					</h3>
				</td>
			</tr>
	    @endif
        </tbody>
    </table>
{{-- </div> --}}
