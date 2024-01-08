@extends('mobile.layouts.app')

@section('content')
    @foreach ($orgList as $org)
        <a href="{{ route('mobiles.change-org', [auth()->user()->user_id, 'organization_id' => $org->organization_id]) }}"
            class="btn btn-lg btn-primary btn-block my-3 border-0"
            style=" padding: 1rem 1rem;">
            <h3 class="no-margins"> {{ $org->organization_code }}: {{ $org->organization_name }}</h3>
        </a>
    @endforeach
@endsection
