<?php
namespace App\HttpController;

use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\EasySwoole\Logger;


class Index extends Controller
{

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
     * Doc: (des="投递任务")
     * User: XMing
     * Date: 2020/9/22
     * Time: 10:06 上午
     */
    public function task()
    {
        $params = parent::json();
        if(empty($params)) parent::writeJson(ResponseCode::$noParams,[],'参数为空');
        Logger::getInstance()->console(json_encode($params));



    }
}