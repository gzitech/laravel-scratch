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
    <aside>
        <h3 class="nav-heading">
            Site
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('code', 'code/*') ?  ' active' : '' }}" href="/code/"><i
                        class="fa fa-terminal"></i>Code</a>
            </li>
            @right('user.list')
            <li class="nav-item">
                <a class="nav-link{{ Request::is('user', 'user/*') ?  ' active' : '' }}" href="/user/"><i
                        class="fa fa-user"></i>User</a>
            </li>
            @endright
            @right('role.list')
            <li class="nav-item">
                <a class="nav-link{{ Request::is('role', 'role/*') ?  ' active' : '' }}" href="/role/"><i
                        class="fa fa-rocket"></i>Role</a>
            </li>
            @endright
        </ul>
    </aside>
</div>