<?php


namespace App\Spider;


use EasySwoole\Spider\Hole\ConsumeAbstract;

class ConsumeTest extends ConsumeAbstract
{

    public function consume()
    {
        // TODO: Implement consume() method.
        // TODO: Implement consume() method.
        $data = $this->getJobData();
        $items = '';
        foreach ($data as $item) {
            $items .= implode("\t", $item)."\n";
        }
        file_put_contents('baidu.txt', $items, FILE_APPEND);
    }
}