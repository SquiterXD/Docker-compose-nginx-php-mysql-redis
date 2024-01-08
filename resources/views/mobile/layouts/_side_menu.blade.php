<mb-side-menu inline-template>
    <div class="px-2 py-2 tw-bg-indigo-800" style="height: 45px;">
        <div>
            {{-- <a href="#" class="btn btn-light btn-sm tw-font-bold " @click="displayMenu = !displayMenu">Menu</a> --}}
            {{-- <span class="no-margins text-left tw-font-bold tw-text-gray-400 small" >
                <a href="{{ route('operating-unit.index', ['device' => 'mobile']) }}" class="pl-1 small">
                Company: {{ hrOperatingUnit() ?  hrOperatingUnit()->name : '' }},
                ORG: {{ session('organization_code') }},
                SubInv: {{ session('inventory_name') }},
                </a>
            </span> --}}
            @if (\Session::get('organization_id' , false))
                <button class="btn btn-light btn-sm tw-font-bold" disabled="">
                    <strong>
                        <span class="text-success">ORG </span>
                        {{ session()->get('organization_code') }}:
                        {{ session()->get('organization_name') }}
                    </strong>
                </button>
                @if ( count(($orgList = \Session::get('organization_list'))) > 1)
                    <a href="{{ route('mobiles.change') }}" class="btn btn-light btn-sm tw-font-bold " >
                        <i class="fa fa-edit "></i>
                    </a>
                @endif
            @endif
            <span class="pull-right">
                {{-- <span style="color: #f8f9fa" title="Department: {{ auth()->user()->department_code }}">
                    <strong><i class="fa fa-building"></i> {{ auth()->user()->department_code }} </strong>
                </span>&nbsp;&nbsp; --}}
                <a href="{{ route('mobiles.logout') }}" class="btn btn-light btn-sm tw-font-bold btn-sm tw-font-bold "> <i class="fa fa-sign-out "></i> ออกจากระบบ</a>
            </span>
        </div>
        <div id="mySidenav" class="sidenav" :class="{ 'sidenav-show': displayMenu}">
            <a href="javascript:void(0)" class="closebtn" @click="hideMenu">&times;</a>
            <a href="{{ route('mobiles.index') }}" style=""><strong> Home </strong></a>
        </div>
    </div>
</mb-side-menu>