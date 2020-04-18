<?php
/**
 * Created by PhpStorm.
 * User: XiaoMing
 * Date: 2020/4/18
 * Time: 10:12
 */

namespace App\RpcService;

use EasySwoole\Rpc\AbstractService;

class Order extends AbstractService
{
    public function serviceName(): string
    {
        return 'order';
    }


    public function list()
    {
        $this->response()->setResult([
            [
                'id'        => 1,
                'goodsId'   => '100001',
                'goodsName' => '商品1',
                'prices'    => 1124
            ],
            [
                'id'        => 2,
                'goodsId'   => '100002',
                'goodsName' => '商品2',
                'prices'    => 599
            ]
        ]);
        $this->response()->setMsg('get order list success');
    }
}