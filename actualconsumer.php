<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ .'/Consumer.php';

$r = new Consumer('testQueue');
$r->listen();