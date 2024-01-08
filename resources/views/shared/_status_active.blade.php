@if ($isActive)
    <i class="fa fa-check-circle text-success fa-{{ (isset($size) && $size) ? $size : 1 }}x"></i>
@else
    <i class="fa fa-circle text-muted fa-{{ (isset($size) && $size) ? $size : 1 }}x"></i>
@endif