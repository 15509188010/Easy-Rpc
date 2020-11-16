<?php
return [
    'SERVER_NAME' => "EasySwoole",
    'MAIN_SERVER' => [
        'LISTEN_ADDRESS' => '0.0.0.0',
        'PORT' => 9501,
        'SERVER_TYPE' => EASYSWOOLE_WEB_SERVER, //可选为 EASYSWOOLE_SERVER  EASYSWOOLE_WEB_SERVER EASYSWOOLE_WEB_SOCKET_SERVER,EASYSWOOLE_REDIS_SERVER
        'SOCK_TYPE' => SWOOLE_TCP,
        'RUN_MODEL' => SWOOLE_PROCESS,
        'SETTING' => [
            'worker_num' => 8,
            'reload_async' => true,
            'max_wait_time'=>3
        ],
        'TASK'=>[
            'workerNum'=>4,
            'maxRunningNum'=>128,
            'timeout'=>15
        ]
    ],
    /*################ REDIS CONFIG ##################*/
    'REDIS' => [
        'host'          => '192.168.199.153',
        'port'          => '6379',
        'auth'          => '',
        'serialize' => \EasySwoole\Redis\Config\RedisConfig::SERIALIZE_NONE
    ],
    'MYSQL' => [
        'host'          => '192.168.199.153',
        'port'          => '3306',
        'username'      => 'root',
        'database'      => 'mall',
        'password'      => 'root'
    ],
    'TEMP_DIR' => '/data/www/Log',
    'LOG_DIR' => '/data/www/Log'
];
