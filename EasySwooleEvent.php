<?php

namespace EasySwoole\EasySwoole;


use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Redis\Config\RedisConfig;
use EasySwoole\RedisPool\RedisPool;
use EasySwoole\Rpc\NodeManager\RedisManager;
use EasySwoole\Rpc\Rpc;
use EasySwoole\HotReload\HotReloadOptions;
use EasySwoole\HotReload\HotReload;


class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/11
     * Time: 5:52 下午
     * @param EventRegister $register
     */
    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        // 配置同上别忘了添加要检视的目录
        $hotReloadOptions = new HotReloadOptions;
        $hotReload = new HotReload($hotReloadOptions);
        $hotReloadOptions->setMonitorFolder([EASYSWOOLE_ROOT . '/App']);
        $server = ServerManager::getInstance()->getSwooleServer();
        $hotReload->attachToServer($server);
        /**
         * 定义节点Redis管理器
         */
        $redisPool = new RedisPool(new RedisConfig([
            'host' => '112.126.93.151',
            'auth' => 'Csm1143669542'
        ]));
        $manager = new RedisManager($redisPool);

        /**
         * 配置Rpc实例
         */
        $config = new \EasySwoole\Rpc\Config();
        //这边用于指定当前服务节点ip，如果不指定，则默认用UDP广播得到的地址
        $config->setServerIp('127.0.0.1');
        $config->setNodeManager($manager);

        /**
         * 配置初始化
         */
        Rpc::getInstance($config);
        Rpc::getInstance()->add(new \App\RpcService\Order());
        Rpc::getInstance()->attachToServer(ServerManager::getInstance()->getSwooleServer());
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}