<div class="col-md-2 ssky-settings-tabs">
    <aside>
        <h3 class="nav-heading">
            Dashboard
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('home', 'home/*') ?  ' active' : '' }}" href="/home/"><i
                        class="fa fa-home"></i> Home</a>
            </li>
        </ul>
    </aside>
    @right('user.all|role.all')
    <aside>
        <h3 class="nav-heading">
            Rbac
        </h3>
        <ul class="nav flex-column ">
            @right('user.all')
            <li class="nav-item">
                <a class="nav-link{{ Request::is('user', 'user/*') ?  ' active' : '' }}" href="/user/"><i
                        class="fa fa-user"></i>User</a>
            </li>
            @endright
            @right('role.all')
            <li class="nav-item">
                <a class="nav-link{{ Request::is('role', 'role/*') ?  ' active' : '' }}" href="/role/"><i
                        class="fa fa-users"></i>Role</a>
            </li>
            @endright
        </ul>
    </aside>
    @endright
</div>