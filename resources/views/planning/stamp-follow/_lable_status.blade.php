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
    @case('CANCELLED')
        <span class="label label-danger">Cancelled</span>
        @break
    @default
@endswitch
