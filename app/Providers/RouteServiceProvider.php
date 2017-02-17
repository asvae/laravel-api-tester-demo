<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            $router->get('/', function () {
                return redirect('/api-tester');
            });

            $router->get('api/redirect/{times}', [
                'as'   => 'redirect-test',
                'uses' => 'DemoController@redirect',
            ])->where('times', '[0-5]');
            $router->get('json', 'DemoController@json');
            $router->get('var_dump', 'DemoController@varDump');
            $router->get('request', 'DemoController@request');
            $router->get('status', 'DemoController@status');
            $router->get('json', 'DemoController@json');
            $router->get('string', 'DemoController@string');
            $router->get('i-am-very-very/very/very/very/very/very/very/long-route/for-no-apparent-reason', 'DemoController@string');
            $router->get('abort', 'DemoController@abort');
            $router->get('i-dont-have-controller', 'MissingController@action');
            $router->get('i-dont-have-action', 'DemoController@action');
        });
    }
}
