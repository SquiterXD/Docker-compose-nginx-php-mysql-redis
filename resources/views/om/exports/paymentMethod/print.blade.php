@php
    $rounds = 0;
    $counts = count($pages);
@endphp
@foreach($pages as $page)
    @php
        $rounds++;
    @endphp
    {{ $page }}
    @if($rounds != $counts)
    <div style='page-break-after: always;'></div>
    @endif
@endforeach
