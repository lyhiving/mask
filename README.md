敏感信息打码处理类
-----------

## 编辑 `composer.json`

```bash
composer require lyhiving/mask
```

```json
{
    "require": {
            "lyhiving/mask": "1.*"
    }
}
```

## 使用方法
```php
<?php

use lyhiving\mask;

//对于非自动加载，请打开下面的注释
/**
spl_autoload_register(function ($class) {
    include 'src/' . str_replace('\\', '/', $class) . '.php';
});
*/

$str = '44528119991005005X';

echo mask::formatIdCard($str) . PHP_EOL;

$str = '13800138000';

echo mask::formatPhone($str) . PHP_EOL;

$str = '6222003602101234080';

echo mask::formatBankCard($str) . PHP_EOL;

$str = '123456';

echo mask::formatPassword($str) . PHP_EOL;

$str = '12345678@abc.com';

echo mask::formatEmail($str) . PHP_EOL;

$data = [
    'id_card'     => '44528119991005005X',
    'idcard'      => '44528119991005005X',
    'identity_id' => '44528119991005005X',
    'idNumber'    => '44528119991005005X',
    'id_number'   => '44528119991005005X',
];

$data = mask::format($data);
var_dump($data);
```

本文件部分来自 [@amsterdan5](https://github.com/amsterdan5/mask) , 主要是开多一个分支来处理ERP中需要特别处理的字段，由于某种不可抗拒的原因，只能引用新建。