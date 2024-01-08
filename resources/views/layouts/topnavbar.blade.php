@php
    $user = auth()->user();
    $role = [];
    $role = \Session::pull('roles', $role);
            \Session::pull('notification_flag', '');
            \Session::pull('balanceNumNotification', 0);
    foreach ($user->role_options ?? [] as $key => $roleId) {
        $role = \Cache::remember('role_user.'. auth()->user()->user_id.'.'. $roleId, 1500, function () use ($roleId) {
            return \App\Models\Role::find($roleId);
        });
        // $role = \App\Models\Role::find($roleId);
        $menu = new \App\Models\Menu;
        $menuList = $menu->treeRole($roleId);
        if ($role && $menuList) {
            $role->menu_list = $menuList;
            \Session::push('roles', $role);
        }
    }

    foreach (\Session::get('roles') as $key => $value) {
        if($value['notification_flag'] == '1'){
            \Session::put('notification_flag', true);
        }
    }

    if(session('db_name') != 'DEV3'){
        if(\Session::get('notification_flag' , true)){
            $balanceNumNotification = \App\Http\Controllers\EAM\NotificationController::calculateNumberNotification();
            \Session::put('balanceNumNotification' , $balanceNumNotification);
        }
    } 
    
@endphp
<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            {{-- <form role="search" class="navbar-form-custom" method="post" action="/">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search" />
                </div>
            </form> --}}
        </div>
        <ul class="nav navbar-top-links navbar-right">
            @if (session('db_name') != 'PROD')
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false" style="padding-left: 5px; padding-right: 5px;">
                        <div class="label label-danger" style="margin-top: 6px;">DB : {{ session('db_name') }}</div>
                    </a>
                </li>
            @endif
            <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false" style="padding-left: 5px; padding-right: 5px;">
                        <strong>
                            <span class="text-success">Dept. </span>
                            {{ optional(\Session::get('current_department'))->display }}
                        </strong>
                        @if ( count(($deptmentList = \Session::get('department_list', []))) > 1)
                            {{-- <i class="fa fa-exchange" style="margin-left: 0px; margin-right: 0px;"></i> --}}
                            {{-- <span class="small">(change)</span> --}}
                            {{-- <span class="small"> <i class="fa fa-caret-down fa-lg" aria-hidden="true"></i></span> --}}
                        @endif
                    </a>
                    @if ( isset($deptmentList) && count($deptmentList) > 1)
                    <ul class="dropdown-menu dropdown-alerts">
                        @foreach ($deptmentList as $dept)
                             <li class="{{ ($dept->department_code == optional(\Session::get('current_department'))->department_code) ? 'active' : '' }}">
                                <a href="{{ route('users.change-deparment', [auth()->user()->user_id, 'department_code' => $dept->department_code]) }}" class="dropdown-item">
                                    <div style="vertical-align: middle; display: flex">
                                        {{ $dept->display }}
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @if (\Session::get('organization_id' , false))
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false" style="padding-left: 5px; padding-right: 5px;">
                    <strong>
                        <span class="text-success">ORG </span>
                        {{ session()->get('organization_code') }}:
                        {{ session()->get('organization_name') }}
                    </strong>
                    @if ( count(($orgList = \Session::get('organization_list'))) > 1)
                        <span class="small">(change)</span>
                    @endif
                </a>

                @if (count($orgList) > 1)
                <ul class="dropdown-menu dropdown-alerts">
                    @foreach ($orgList as $org)
                         <li class="{{ ($org->organization_id == session()->get('organization_id')) ? 'active' : '' }}">
                            <a href="{{ route('users.change-org', [auth()->user()->user_id, 'organization_id' => $org->organization_id]) }}" class="dropdown-item">
                                <div style="vertical-align: middle; display: flex">
                                    {{ $org->organization_code }}: {{ $org->organization_name }}
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endif
            @if (\Session::get('notification_flag') && session('db_name') != 'DEV3')
                <li class="dropdown">                    
                    <a  class="dropdown-toggle count-info" 
                        href="{{ route('eam.notification.index') }}#maintenancePending">
                        <i class="fa fa-bell"></i>  
                        <span class="label label-danger">
                            {{ \Session::get('balanceNumNotification') }}
                        </span>
                    </a>
                </li>
            @endif
            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>
    </nav>
</div>
