<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
define('APP_DEBUG',True);

require './FirePHPCore/fb.php';

//绑定访问Admin模块
define('BIND_MODULE','Admin');

// 定义应用目录
define('APP_PATH','./Application/');
define('RUNTIME_PATH','./Runtime/');
define('BUILD_DIR_SECURE',false); //目录安全写入（默认开启）

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';