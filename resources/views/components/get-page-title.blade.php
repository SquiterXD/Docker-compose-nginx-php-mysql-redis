
@php
    $child = optional($getMenu)->parent;
    $parent = optional($child)->parent;
@endphp

<h2>{{ optional($getMenu)->program_code }} : {{ optional($getMenu)->menu_title }}</h2>
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="/">Home</a>
    </li>
    @if ($parent)
        <li class="breadcrumb-item">
            {{ optional($parent)->menu_title }} 
        </li>
    @endif
    @if ($child)
        <li class="breadcrumb-item">
            {{ optional($child)->menu_title }}
        </li>
    @endif
    <li class="breadcrumb-item active">
        <a href="{{ optional($getMenu)->url }}"><strong> {{ optional($getMenu)->menu_title }} </strong></a>
    </li>
</ol>