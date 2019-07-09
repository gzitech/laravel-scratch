<div class="col-md-2 ssky-settings-tabs">
    <aside>
        <h3 class="nav-heading">
            Dashboard
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('home', 'home/*') ?  ' active' : '' }}" href="/home/"><i class="fa fa-home"></i> Home</a>
            </li>
        </ul>
    </aside>
    <aside>
        <h3 class="nav-heading">
            Message
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('sms', 'sms/*') ?  ' active' : '' }}" href="/sms/"><i class="fa fa-comments"></i> SMS</a>
            </li>
        </ul>
    </aside>
    <aside>
        <h3 class="nav-heading">
            Site
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('user', 'user/*') ?  ' active' : '' }}" href="/user/"><i class="fa fa-users"></i> User</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting', 'setting/*') ?  ' active' : '' }}" href="/setting/"><i class="fa fa-gift"></i> Setting</a>
            </li>
        </ul>
    </aside>
</div>