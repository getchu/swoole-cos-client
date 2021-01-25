
对象存储（Cloud Object Storage，COS）是腾讯云提供的一种存储海量文件的分布式存储服务，具有高扩展性、低成本、可靠安全等优点。通过控制台、API、SDK 和工具等多样化方式，用户可简单、快速地接入 COS，进行多格式文件的上传、下载和管理，实现海量数据存储和管理。

> :star: 官方文档：https://cloud.tencent.com/document/product/436


## 安装

环境要求：

- PHP >= 7.1
- ext-swoole
- ext-libxml
- ext-simplexml
- ext-json
- ext-dom

```shell
$ composer require zhuangdebiao/swoole-cos-client -vvv
```

## 使用示例

配置前请了解官方名词解释：[文档中心 > 对象存储 > API 文档 > 简介：术语信息](https://cloud.tencent.com/document/product/436/7751#.E6.9C.AF.E8.AF.AD.E4.BF.A1.E6.81.AF)

```php

\Swoole\Coroutine\run(function () {

    $config = new \ZhuangDeBiao\SwooleCosClient\Config([
        // 必填，app_id、secret_id、secret_key 
        // 可在个人秘钥管理页查看：https://console.cloud.tencent.com/capi
        'appId' => '1251196541',
        'secretId' => '',
        'secretKey' => '',
        // 地域列表请查看 https://cloud.tencent.com/document/product/436/6224
        'region' => 'ap-guangzhou',
        'bucket' => 'test-1251196541',
    ]);
    
    $object = new \ZhuangDeBiao\SwooleCosClient\ObjectClient($config);

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

```

## License

MIT
