@php
    $menu = new \App\Models\Menu;
    $menuList = $menu->tree(false, optional(auth()->user())->user_id);
@endphp
@foreach ($menuList as $menu)
    @if (count($menu->children) == 0)
        <li>
            <a href="{{ $menu->url }}"><i class="fa fa-diamond"></i> <span class="nav-label">{{ $menu->menu_title }}</span></a>
        </li>
    @else
        <li>
            <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">{{ $menu->menu_title }}</span> <span class="fa arrow"></span></a>
        </li>
    @endif

    @if (count($menu->children) > 0)
        <ul class="nav nav-second-level collapse">
        @foreach($menu->children as $secondMenu)
            @if (count($secondMenu->children) == 0)
                <li><a href="{{ $secondMenu->url }}">{{ $secondMenu->menu_title }}</a></li>
            @else
                <li>
                    <a href="#">{{ $secondMenu->menu_title }} <span class="fa arrow"></span></a>
                    <ul class="nav nav-third-level">
                        @foreach ($secondMenu->children as $thirdMenu)
                            @php
                                // if ($thirdMenu->url == '/lookup') {
                                //     $url = $thirdMenu->url.'?programCode='.$thirdMenu->program_code;
                                // } else {
                                //     $url = $thirdMenu->url;
                                // }
                                $url = $thirdMenu->url; 
                                    
                            @endphp
                            <li>
                                <a href="{{url($url)}}">{{ $thirdMenu->menu_title }}</a>
                                {{-- <a href="{{ $thirdMenu->url }}">{{ $thirdMenu->menu_title }}</a> --}}
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
        </ul>
    @endif
@endforeach