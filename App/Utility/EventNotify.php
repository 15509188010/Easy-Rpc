<?php
namespace App\Utility;

//use App\Model\EventNotifyModel;
//use App\Model\EventNotifyPhoneModel;
//use App\Utility\Sms\Sms;
use EasySwoole\Component\Singleton;
use EasySwoole\EasySwoole\Trigger;
use Swoole\Table;

/**
 * Description: 异常回调
 * Class EventNotify
 * @package App\Utility
 */
class EventNotify
{
    use Singleton;

    private $evenTable;

    function __construct()
    {
        $this->evenTable = new Table(2048);
        $this->evenTable->column('expire',Table::TYPE_INT,8);
        $this->evenTable->column('count',Table::TYPE_INT,8);
        $this->evenTable->create();
    }

    function notifyException(\Throwable $throwable)
    {
        $class = get_class($throwable);
        //根目录下的异常，以msg为key
        if($class == 'Exception'){
            $key = substr(md5($throwable->getMessage()),8,16);
        }else{
            $key = substr(md5($class),8,16);
        }
        $this->onNotify($key,$throwable->getMessage());
    }

    function notify(string $msg)
    {
        $key = md5($msg);
        $this->onNotify($key,$msg);
    }

    private function onNotify(string $key,string $msg)
    {
        $info = $this->evenTable->get($key);
        //同一种消息在十分钟内不再记录
        $this->evenTable->set($key,[
            "expire"=>time() + 10 * 60
        ]);
        if(!empty($info)){
            return;
        }
        try{
            //TODO 系统异常
            /*EventNotifyPhoneModel::create()->chunk(function (EventNotifyPhoneModel $model)use($msg){
                Sms::send($model->phone,$msg);
            });
            EventNotifyModel::create([
                'msg'=>$msg,
                'time'=>time()
            ])->save();*/
        }catch (\Throwable $throwable){
            //避免死循环
            Trigger::getInstance()->error($throwable->getMessage());
        }
    }
}