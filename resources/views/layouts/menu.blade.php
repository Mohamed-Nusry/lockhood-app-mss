<li class="nav-item">
    <a href="{{ url('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item {{ request()->is('*user*') ||  request()->is('*department*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Users & Departments
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('department.index') }}" class="nav-link {{ request()->is('department') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Departments</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('user') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Users</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->is('*work*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
            Work Monitoring
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('kanban.index') }}" class="nav-link {{ request()->is('*work/kanban') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Kan Ban Card</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('assignedwork.index') }}" class="nav-link {{ request()->is('work/assignedwork') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Assigned Works</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->is('*inventory*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Inventory Automation
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('supplier.index') }}" class="nav-link {{ request()->is('*inventory/supplier') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Suppliers</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('material.index') }}" class="nav-link {{ request()->is('*inventory/material') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Purchase Materials</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item {{ request()->is('*report*') ? 'menu-opening menu-open' : '' }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        <p>
            Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('*report/work') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Work Report</p>
            </a>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->is('*report/income') ? 'sub-active' : '' }}">
                &nbsp;&nbsp;&nbsp;
                <p>Income Report</p>
            </a>
        </li>
    </ul>
</li>
