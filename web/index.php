<?php
require __DIR__ . '/../vendor/autoload.php';

['path' => $path] = parse_url($_SERVER['REQUEST_URI']);

$args = explode('/', $path);
$route = $args[1] ?: 'list';
$blog = count($args) > 2 ? urldecode(implode('/', array_slice($args, 2))) : '';
$method = 'action' . ucfirst($route);

//展示文件列表
$app = new \base\Yi();

if (!method_exists($app, $method)) {
    die('page not found');
}

$app->$method($blog);

