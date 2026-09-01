<?php

use App\Providers\AppServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Category\Providers\CategoryServiceProvider;
use Modules\User\Providers\UserServiceProvider;

return [
    AppServiceProvider::class,
    AuthServiceProvider::class,
    UserServiceProvider::class,
    CategoryServiceProvider::class,
];

