# laravel-scratch

a start point for you support role-based access control, multi site, subscription.

## Access Control

role-based access control (RBAC)

### config right (config/rbac.php)

```php
'rights' => [
        'user' => [
            "all" => 1,
            "edit" => 2,
        ],
        'role' => [
            "all" => 4,
            "edit" => 8,
        ],
        'right' => [
            "all" => 16,
            "edit" => 32,
        ],
        'site' => [
            "all" => 64,
            "self" => 128,
            "edit" => 256,
        ],
    ],
```

### check right at controller

```php
    public function index()
    {
        $this->user->authorize('user.all');

        $data = [
            'users'=>$this->user->paginate(),
        ];

        return view("user", $data);
    }
```

### check right at view

```html
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
                        class="fa fa-rocket"></i>Role</a>
            </li>
            @endright
        </ul>
```

## Multi Site

user can create sites base on right and subscription limit.

## Subscription (In development)


## Get Started

```bash
git pull
composer install
php artisan migrate --seed
yarn
yarn watch
```