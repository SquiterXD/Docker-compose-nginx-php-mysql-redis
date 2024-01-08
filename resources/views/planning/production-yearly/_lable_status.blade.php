@switch(strtoupper($status))
    @case('ACTIVE')
        <span class="label label-primary">Approved</span>
        @break
    @case('APPROVED')
        <span class="label label-primary">Approved</span>
        @break
    @case('INACTIVE')
        <span class="label label-default">Inactive</span>
        @break
    @case('CANCEL')
        <span class="label label-default">Cancel</span>
        @break

    @default
@endswitch
