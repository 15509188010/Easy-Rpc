<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;

/**
 * Description: 路由
 * Class Router
 * @package App\HttpController
 */
class Router extends AbstractRouter
{
    /**
     * Doc: (des="申明所有路由")
     * User: XMing
     * Date: 2020/9/19
     * Time: 4:35 下午
     * @param RouteCollector $routeCollector
     */
    function initialize(RouteCollector $routeCollector)
    {
        // TODO: Implement initialize() method.
        $routeCollector->post('/api/user/login','/UserController/login');
    }
}