<nav class="navbar-default navbar-static-side" role="navigation">
{{-- <nav class="navbar-default navbar-static-side" role="navigation" style="width: 400px;"> --}}
    <div class="sidebar-collapse">
        {{-- <ul class="navbar-nav mr-auto">
            @php
                $menu = new \App\Models\Menu;
                $menuList = $menu->tree();
            @endphp
            @each('layouts.navigations._db', $menuList, 'menu', 'empty')
        </ul> --}}
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header pt-2">
                <div class="dropdown profile-element">
                    <div class="logo w-60" style="text-align: center;">
                        <img class="img-circlex "
                            style="
                                max-height: 90px;
                                position: relative;
                                padding: 6px 0;
                                line-height: 90px;
                                vertical-align: middle;"
                            src="{{ asset('img/logo-home2.png') }}" alt="">
                    </div>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ optional(auth()->user())->name }}</strong>
                                <div>
                                    <strong class="font-bold">username: {{ optional(auth()->user())->username }}</strong>
                                </div>
                            </span>
                            {{-- <span class="text-muted text-xs block">Example menu <b class="caret"></b></span> --}}
                        </span>
                    </a>
                    {{-- <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/logout">Logout</a></li>
                    </ul> --}}
                </div>
                <div class="logo-element">
                    TOAT
                </div>
            </li>
            {{-- <li class="{{ isActiveRoute('main') }}"> --}}
            {{-- <li class="">
                <a href="{{ url('/') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
            </li> --}}
            {{-- <li class="{{ isActiveRoute('minor') }}"> --}}
            {{-- <li class="">
                <a href="{{ url('/minor') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Minor view</span> </a>
            </li> --}}
            @include('layouts.navigations._role')
            {{-- @include('layouts.navigations._session') --}}
            {{-- @if (session('db_name', '') != 'DEV2' )
            <li class="special_link" >
                <a href="#" class="pt-1 pb-1"> <span class="nav-label">Ready for Test</span></a>
            </li>
            @endif --}}
            @include('layouts.navigations._db')
            {{-- @include('layouts.navigations._report') --}}
            {{-- @if (session('db_name', '') == 'DEV' && auth()->user()->name != 'PP')
                <li class="special_link" >
                    <a href="#" style="background: #f8ac59;" class="pt-1 pb-1"> <span class="nav-label">Develop</span></a>
                </li>
                @include('layouts.navigations._report')
                @include('layouts.navigations._example')
                @include('layouts.navigations._pm')
                @include('layouts.navigations._planning')
                @include('layouts.navigations._pm_plan')
                @include('layouts.navigations._pm_wip_issue')
                @include('layouts.navigations._pm_wip_confirm')
                @include('layouts.navigations._pd')
                @include('layouts.navigations._nuk')
                @include('layouts.navigations._eam')
                @include('layouts.navigations._om')
                @include('layouts.navigations._om-nuk')
                @include('layouts.navigations._ecom')
                @include('layouts.navigations._inv')
                @include('layouts.navigations._ie')
                @include('layouts.navigations._pm1')
                @include('layouts.navigations._ct')
                @include('layouts.navigations._ir')
            @endif --}}


        </ul>
    </div>
</nav>
    