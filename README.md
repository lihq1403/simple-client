<h1 align="center"> simple-client </h1>

<p align="center"> 简易请求封装</p>

## Installing

```shell
$ composer require lihq1403/simple-client -vvv
```

## Usage

```php
$config = [
    'host' => 'https://restapi.amap.com',
    'sdk_name' => 'xxx',
    'sdk_version' => '1.0.1',
    'component' => [
        'logger' => null, // 日志组件
        'client' => null, // guzzle客户端
    ],
];
$app = new Application($config);

$simpleClient = new SimpleClient($app);
$actualResponse = $simpleClient->get('/v3/weather/weatherInfo', [
    'query' => [
        'key' => 'mock-key',
        'city' => '深圳',
        'output' => 'json',
        'extensions' => 'base',
    ],
]);
```

## License

MIT