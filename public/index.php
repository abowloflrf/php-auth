<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

//服务端 Session 有效时间10天
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 10);
//客户端 Cookie 登陆状态有效时间10天
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 10);
//将session储存地址设置为本地storage文件夹
ini_set('session.save_path', __DIR__ . "/../storage/sessions/");
//开始session会话
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
