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
                <a class="nav-link{{ Request::is('token', 'token/*') ?  ' active' : '' }}" href="/token/"><i
                        class="fa fa-gift"></i>Token</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('code', 'code/*') ?  ' active' : '' }}" href="/code/"><i
                        class="fa fa-code"></i>Code</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('user', 'user/*') ?  ' active' : '' }}" href="/user/"><i
                        class="fa fa-user"></i>User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('role', 'role/*') ?  ' active' : '' }}" href="/role/"><i
                        class="fa fa-users"></i>Role</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('right', 'right/*') ?  ' active' : '' }}" href="/right/"><i
                        class="fa fa-lock"></i>Right</a>
            </li>
        </ul>
    </aside>
</div>