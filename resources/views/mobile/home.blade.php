@extends('mobile.layouts.app')

@section('content')
    @foreach ($menus as $menu)
        <a href="/mobiles{{ $menu->url }}"
            class="btn btn-lg btn-primary btn-block my-3 border-0"
            style="background: var(--{{ $menu->color }}); padding: 1rem 1rem;">
            <h3 class="no-margins"> {!! $menu->menu_title !!}</h3>
        </a>
    @endforeach
@endsection
