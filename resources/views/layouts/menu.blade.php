<li class="nav-item">
    <a href="{{ url('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item {{ request()->is('*user*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Users
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('*user') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Add User</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user/view') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>View Users</p>
            </a>
        </li>
    </ul>
</li>
