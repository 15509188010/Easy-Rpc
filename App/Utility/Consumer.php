<?php
namespace App\Utility;

use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\EasySwoole\Logger;
use EasySwoole\Pool\Manager;
use Swoole\Coroutine;

/**
 * Description:
 * Class Consumer
 * @package App\Utility
 */
class Consumer extends AbstractProcess {

    /**
     * Doc: (des="")
     * User: XMing
     * Date: 2020/9/22
     * Time: 4:53 下午
     * @param $arg
     */
    protected function run($arg)
    {
        go(function (){
            while (true) {
                //TODO:: 拿到redis
                /** @var $redis \EasySwoole\Redis\Redis*/
                $redis = Manager::getInstance()->get('redis')->defer();
                //TODO:: 从有序集合中拿到三秒(模拟30分钟)以前的订单
                $orderIds = $redis->zRangeByScore('delay_queue_test1', 0, time()-60, ['withscores' => TRUE]);
                if (empty($orderIds)) {
                    Coroutine::sleep(1);
                    continue;
                }
                //TODO::拿出后立马删除
                $redis->zRem('delay_queue_test1', ...$orderIds);
                foreach ($orderIds as $orderId)
                {
                    Logger::getInstance()->console('消费订单：'.$orderId);
                    //TODO::判断此订单30分钟后，是否仍未完成，做相应处理
                }
            }
        });
    }

}