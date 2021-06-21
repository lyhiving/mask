<?php
include __DIR__ . '/../autoload.php';

use lyhiving\mask\mask;

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

