<?php


namespace App\Utility;

use EasySwoole\Component\Process\AbstractProcess;
use EasySwoole\Queue\Job;

class QueueProcess extends AbstractProcess
{

    protected function run($arg)
    {
        // TODO: Implement run() method.
        go(function (){
            MyQueue::getInstance()->consumer()->listen(function (Job $job){
                var_dump($job->getJobData());
            });
        });
    }
}