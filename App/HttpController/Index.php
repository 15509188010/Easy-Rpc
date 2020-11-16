<?php
namespace App\HttpController;

use App\Services\EwsUserService;
use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Pool\Manager;
use EasySwoole\Redis\Redis;

class Index extends Controller
{
    /**
     * @var Redis
     */
    private $objRedis;

    /**
     * @var EwsUserService
     */
    private $objEwsUserService;

    /**
     * Index constructor.
     * @throws \Throwable
     */
    public function __construct()
    {
        parent::__construct();
        $this->objRedis = Manager::getInstance()->get('redis')->getObj();
        $this->objEwsUserService = new EwsUserService();
    }

    public function index()
    {
        $file = EASYSWOOLE_ROOT . '/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
        if (!is_file($file)) {
            $file = EASYSWOOLE_ROOT . '/src/Resource/Http/welcome.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    protected function actionNotFound(?string $action)
    {
        $this->response()->withStatus(404);
        $file = EASYSWOOLE_ROOT . '/vendor/easyswoole/easyswoole/src/Resource/Http/404.html';
        if (!is_file($file)) {
            $file = EASYSWOOLE_ROOT . '/src/Resource/Http/404.html';
        }
        $this->response()->write(file_get_contents($file));
    }

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/28
     * Time: 10:30 上午
     */
    public function show()
    {
        print_r($this->objEwsUserService->getUserByUserName('15509188010'));
    }

}