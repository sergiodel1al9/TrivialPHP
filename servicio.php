<?php

require_once('./include/DB.php');
$uri = 'http://localhost/TrivialPHP/index.php';

$server = new SoapServer(null, array('uri' => $uri));

$server->setClass('DB');

$server->handle();