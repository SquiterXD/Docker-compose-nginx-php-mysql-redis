@php
    $roles = session()->get('roles', []);
@endphp

@foreach ($roles as $role)
    @foreach ($role->menu_list as $firstParent => $menu)
        @if ($loop->first)
            <li class="special_link" >
                <a href="#" class="pt-1 pb-1"> <span class="nav-label">{{ $role->name }}</span></a>
            </li>
        @endif
        <li class="{{ isActiveRoute($menu->url) }} parentkey-{{ $menu->menu_id }}">
            @if (count($menu->children) == 0)
                <a href="{{ $menu->url }}"><i class="fa fa-diamond"></i> <span class="nav-label">
                    {{ $menu->program_code }}: {{ $menu->menu_title }}</span>
                </a>
            @else
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">{{ $menu->menu_title }}</span> <span class="fa arrow"></span></a>
            @endif

            @if (count($menu->children) > 0)
                <ul class="nav nav-second-level collapse">
                @foreach($menu->children->sortBy('program_code') as $secondParent => $secondMenu)
                    @if (count($secondMenu->children) == 0)
                        <li class="{{ isActiveRoute($secondMenu->url) }}" parentkey="{{ $menu->menu_id }}">
                            <a href="{{ $secondMenu->url }}">{{ $secondMenu->program_code }}: {{ $secondMenu->menu_title }}</a>
                        </li>
                    @else
                        <li class="parentkey-{{ $secondMenu->menu_id }}" parentkey="{{ $menu->menu_id }}">
                            <a href="#">{{ $secondMenu->menu_title }}<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                            @foreach ($secondMenu->children->sortBy('program_code') as $thirdParent => $thirdMenu)
                                <li class="{{ isActiveRoute($thirdMenu->url) }}" parentkey="{{ $secondMenu->menu_id }}">
                                    <a href="{{ $thirdMenu->url }}">{{ $thirdMenu->program_code }}: {{ $thirdMenu->menu_title }}</a>
                                </li>
                            @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
                </ul>
            @endif
        <li>
    @endforeach
@endforeach