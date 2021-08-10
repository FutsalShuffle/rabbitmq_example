<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ .'/Sender.php';

$r = new Sender('testQueue');
$r->send('Hello world!');