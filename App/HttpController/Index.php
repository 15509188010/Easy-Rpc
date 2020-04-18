<?php


namespace App\HttpController;


use EasySwoole\Http\AbstractInterface\Controller;
use EasySwoole\Rpc\Response;
use EasySwoole\Rpc\Rpc;

class Index extends Controller
{

    public function index()
    {
        /**$file = EASYSWOOLE_ROOT.'/vendor/easyswoole/easyswoole/src/Resource/Http/welcome.html';
         * if(!is_file($file)){
         * $file = EASYSWOOLE_ROOT.'/src/Resource/Http/welcome.html';
         * }
         * $this->response()->write(file_get_contents($file));*/
        $ret = [];
        $client = Rpc::getInstance()->client();
        /*
         * 调用订单列表
         */
        $client->addCall('order', 'list', ['page' => 1])
            ->setOnSuccess(function (Response $response) use (&$ret) {
                $ret['order'] = $response->toArray();
            })->setOnFail(function (Response $response) use (&$ret) {
                $ret['order'] = $response->toArray();
            });
        $client->exec(2.0);
        $this->writeJson(200, $ret);
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
}