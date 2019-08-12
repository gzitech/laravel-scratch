<div class="col-md-2 ssky-settings-tabs">
    <aside>
        <h3 class="nav-heading">
            Setting
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/profile', 'setting/profile/*') ?  ' active' : '' }}" href="/setting/profile/"><i
                        class="fa fa-user"></i>Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/security', 'setting/security/*') ?  ' active' : '' }}" href="/setting/security/"><i
                        class="fa fa-lock"></i>Security</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/api', 'setting/api/*') ?  ' active' : '' }}" href="/setting/api/"><i
                        class="fa fa-plug"></i>API</a>
            </li>
        </ul>
    </aside>
    <aside>
        <h3 class="nav-heading">
            Billing
        </h3>
        <ul class="nav flex-column ">
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/subscription', 'setting/subscription/*') ?  ' active' : '' }}" href="/setting/subscription/"><i
                        class="fa fa-refresh"></i>Subscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/payment/method', 'setting/payment/method/*') ?  ' active' : '' }}" href="/setting/payment/method/"><i
                        class="fa fa-credit-card"></i>Methods</a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ Request::is('setting/invoice', 'setting/invoice/*') ?  ' active' : '' }}" href="/setting/invoice/"><i
                        class="fa fa-shopping-cart"></i>Invoices</a>
            </li>
        </ul>
    </aside>
</div>