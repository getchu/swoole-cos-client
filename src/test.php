<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ .'/SplBean.php';
include __DIR__ . '/Config.php';

include __DIR__ . '/XML.php';
include __DIR__ . '/Signature.php';

include __DIR__ . '/ObjectClient.php';



\Swoole\Coroutine\run(function () {

    $object = new \ZhuangDeBiao\SwooleCosClient\ObjectClient(new \ZhuangDeBiao\SwooleCosClient\Config([
        'appId' => '1251196541',
        'secretId' => '',
        'secretKey' => '',
        'region' => 'ap-guangzhou',
        'bucket' => 'test-1251196541',
    ]));

    $filename = __DIR__ . '/1.png';
    $rt = $object->putObject('你好/1.png', $filename);
    var_dump($rt);

    $rt = $object->headObject('你好/1.png');
    var_dump($rt);

    var_dump($object->getUrl('你好/1.png'));

//    $rt = $object->deleteObject('你好/1.png');
//    var_dump($rt);
//
//    $rt = $object->headObject('你好/1.png');
//    var_dump($rt);

});

