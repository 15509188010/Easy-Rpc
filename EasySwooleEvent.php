<?php

namespace EasySwoole\EasySwoole;

use App\Pool\RedisPool;
use App\Utility\EventNotify;
use EasySwoole\EasySwoole\Swoole\EventRegister;
use EasySwoole\EasySwoole\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Pool\Manager;
use EasySwoole\Redis\Config\RedisConfig;
use EasySwoole\HotReload\HotReloadOptions;
use EasySwoole\HotReload\HotReload;
use EasySwoole\ORM\DbManager;
use EasySwoole\ORM\Db\Connection;
use EasySwoole\ORM\Db\Config;


class EasySwooleEvent implements Event
{

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/27
     * Time: 6:01 下午
     * @throws \EasySwoole\Pool\Exception\Exception
     */
    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set('Asia/Shanghai');
        $config = new Config();
        $mysql = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL');
        $config->setDatabase($mysql['database']);
        $config->setUser($mysql['username']);
        $config->setPassword($mysql['password']);
        $config->setHost($mysql['host']);
        //连接池配置
        $config->setGetObjectTimeout(3.0); //设置获取连接池对象超时时间
        $config->setIntervalCheckTime(30*1000); //设置检测连接存活执行回收和创建的周期
        $config->setMaxIdleTime(15); //连接池对象最大闲置时间(秒)
        $config->setMaxObjectNum(20); //设置最大连接池存在连接对象数量
        $config->setMinObjectNum(5); //设置最小连接池存在连接对象数量
        $config->setAutoPing(5); //设置自动ping客户端链接的间隔
        DbManager::getInstance()->addConnection(new Connection($config));
    }

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/11
     * Time: 5:52 下午
     * @param EventRegister $register
     * @throws \EasySwoole\Pool\Exception\Exception
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

        //redis-Pool
        $config = new \EasySwoole\Pool\Config();
        $redisConfig1 = new RedisConfig(\EasySwoole\EasySwoole\Config::getInstance()->getConf('REDIS'));
        Manager::getInstance()->register(new RedisPool($config,$redisConfig1),'redis');//自定义

        //提前实例化异常通知器并注册回调
        EventNotify::getInstance();
        Trigger::getInstance()->onException()->set('notify',function (\Throwable $throwable){
            EventNotify::getInstance()->notifyException($throwable);
        });

        Trigger::getInstance()->onError()->set('notify',function ($msg){
            EventNotify::getInstance()->notify($msg);
        });
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