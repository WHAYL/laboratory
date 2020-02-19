<?php


// [ 应用入口文件 ]
namespace think;

header('content-type:application:json;charset=utf8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Authorization,user');
header("Access-Control-Allow-Methods: POST,GET");
header('Access-Control-Allow-Credentials:true');

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应


$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);

