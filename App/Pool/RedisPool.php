<?php
namespace App\Pool;

use EasySwoole\Pool\Config;
use EasySwoole\Pool\AbstractPool;
use EasySwoole\Redis\Config\RedisConfig;
use EasySwoole\Redis\Redis;

/**
 * Description: redis连接池
 * Class RedisPool
 * @package App\Pool
 */
class RedisPool extends AbstractPool
{

    protected $redisConfig;

    /**
     * 重写构造函数,为了传入redis配置
     * RedisPool constructor.
     * @param Config $conf
     * @param RedisConfig $redisConfig
     * @throws \EasySwoole\Pool\Exception\Exception
     */
    public function __construct(Config $conf,RedisConfig $redisConfig)
    {
        parent::__construct($conf);
        $this->redisConfig = $redisConfig;
    }

    /**
     * Doc: (des="创建redis实例")
     * User: XMing
     * Date: 2020/9/22
     * Time: 2:59 下午
     * @return Redis
     */
    protected function createObject()
    {
        // TODO: Implement createObject() method.
        //根据传入的redis配置进行new 一个redis
        return new Redis($this->redisConfig);
    }
}