<li>
    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">Reimbursement</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{ route('ie.reimbursements.index-pending') }}">My Pending Activity</a>
        </li>
        <li>
            <a href="{{ route('ie.reimbursements.index') }}">My Request</a>
        </li>
    </ul>

    <a href="#"><i class="fa fa-bolt"></i> <span class="nav-label">Cash Advance</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{ route('ie.cash-advances.index-pending') }}">My Pending Activity</a>
        </li>
        <li>
            <a href="{{ route('ie.cash-advances.index') }}">My Request</a>
        </li>
    </ul>
    <a href="{{ route('ie.report.index') }}"><i class="fa fa-file"></i> Reports</a>

    <a href="#"><i class="fa fa-sliders"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{ route('ie.settings.categories.index') }}">
                <i class="fa fa-th-large fa-fw"></i> Category
            </a>
        </li>
        {{-- <li>
            <a href="{{ route('ie.settings.ca-categories.index') }}">
                <i class="fa fa-th-large fa-fw"></i> CA Category
            </a>
        </li> --}}
        {{-- <li>
            <a href="{{ route('ie.settings.locations.index') }}">
                <i class="fa fa-globe fa-fw"></i> Location
            </a>
        </li> --}}
        <li>
            <a href="{{ route('ie.settings.preferences.index') }}">
                <i class="fa fa-cog fa-fw"></i> Preferences
            </a>
        </li>
        <li>
            <a href="{{ route('ie.settings.user-accounts.index') }}">
                <i class="fa fa-university fa-fw"></i> User Bank Accounts
            </a>
        </li>
    </ul>
</li>


{{-- [
    'href'  =>  route('settings.categories.index'),
    'text'  =>  '<i class="fa fa-th-large fa-fw"></i> REIM Category'
],
[
    'href'  =>  route('settings.ca_categories.index'),
    'text'  =>  '<i class="fa fa-th-large fa-fw"></i> CA Category'
],
[
    'href'  =>  route('settings.locations.index'),
    'text'  =>  '<i class="fa fa-globe fa-fw"></i> Location'
],
[
    'href'  =>  route('settings.users.index'),
    'text'  =>  '<i class="fa fa-users fa-fw"></i> User'
],
[
    'href'  =>  route('settings.preferences.index'),
    'text'  =>  '<i class="fa fa-cog fa-fw"></i> Preference'
] --}}