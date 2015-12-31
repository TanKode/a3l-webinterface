<?php

namespace App\Providers;

use App\Event;
use App\Player;
use App\Role;
use App\User;
use App\Vehicle;
use Cmgmyr\Messenger\Models\Thread as ChatThread;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Riari\Forum\Models\Category as ForumCategory;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('chat_thread', ChatThread::class);

        $router->model('forum_category', ForumCategory::class);

        $router->model('event', Event::class);
        $router->model('user', User::class);
        $router->model('role', Role::class);

        $router->model('player', Player::class);
        $router->model('vehicle', Vehicle::class);
    }

    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
