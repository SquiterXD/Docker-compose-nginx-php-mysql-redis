@if ($status == 'Draft')
    <span class="label"> {{ $status }} </span>
@elseif ($status == 'Release')
    <span class="label label-success"> {{ $status }} </span>
@elseif ($status == 'Wait Pay')
    <span class="label label-info"> {{ $status }} </span>
@elseif ($status == 'Confirm')
    <span class="label label-primary"> {{ $status }} </span>
@elseif ($status == 'Cancelled')
    <span class="label label-danger"> {{ $status }} </span>
@else
    <span class="label label-warning"> {{ $status }} </span>
@endif