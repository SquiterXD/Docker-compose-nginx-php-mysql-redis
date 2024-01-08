
{{-- <div class="table-responsive"> --}}
    <table class="table table-hover">
		<thead>
			<tr>
				<th width="5%" class="text-center">
					#
				</th>
				<th>
					วัตถุประสงค์
				</th>
				<th width="5%" class="text-center">
					Seq
				</th>
			</tr>
		</thead>
        <tbody>
        @if(count($purpose)>0)
	        @foreach($purpose as $item)
				<tr>
					<td class="text-center">
						{{ $loop->iteration }}
					</td>
					<td>
						{{ $item->purpose }}
						{{-- {!! Form::checkbox('unblock_users[]',$user->user_id,in_array($user->user_id, $unblockers)) !!} --}}
					</td>
					<td class="text-center">
						{{ $item->seq }}
					</td>
		        </tr>
	        @endforeach
	    @else
			<tr>
				<td colspan="5">
					<h3 class="text-center m-t-md m-b-md" style="color:#bbb">
						Not found purpose.
					</h3>
				</td>
			</tr>
	    @endif
        </tbody>
    </table>
{{-- </div> --}}
