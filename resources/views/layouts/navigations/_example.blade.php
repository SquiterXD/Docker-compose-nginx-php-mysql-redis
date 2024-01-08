<li>
    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Example </span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="{{ route('example.vue') }}">Vue</a></li>
        <li><a href="{{ route('example.date') }}">Date</a></li>
        <li><a href="{{ route('example.users.index') }}">User</a></li>
    </ul>
</li>

{{-- PROGRAM --}}
<li>
    <a href="{{ route('program.type.index') }}">
        <i class="fa fa-th-list"></i> <span class="nav-label"> Program Type </span>
    </a>
</li>
<li>
    <a href="{{ route('program.info.index') }}">
        <i class="fa fa-cog"></i> <span class="nav-label"> Program Info </span>
    </a>
</li>
<li>
    <a href="{{ route('funds.index') }}"><i class="fa fa-sitemap"></i> <span class="nav-label">Inquiry Funds</span></a>
</li>
