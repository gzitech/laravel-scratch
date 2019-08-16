# laravel-scratch

a start point for you support role-based access control, multi site, subscription.

## Access Control

role-based access control (RBAC)

### config right (config/rbac.php)

```php
'rights' => [
        'user' => [
            "list" => 1,
            "update" => 2,
        ],
        'role' => [
            "list" => 4,
            "update" => 8,
        ],
        'right' => [
            "list" => 16,
            "update" => 32,
        ],
    ],
```

### check right at controller

```php
    public function index()
    {
        $this->user->authorize('user.list');

        $data = [
            'users'=>$this->user->paginate(),
        ];

        return view("user", $data);
    }
```

### check right at view

```html
        <ul class="nav flex-column ">
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
```

## Multi Site (In development)


## Subscription (In development)


## Get Started

```bash
git pull
composer install
php artisan migrate --seed
yarn
yarn watch
```