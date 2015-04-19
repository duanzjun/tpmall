<?php
define('IMAGE_FILE_TYPE', 'gif|jpg|jpeg|png'); // 图片类型，上传图片时使用

define('SIZE_GOODS_IMAGE', '2097152');   // 商品大小限制2M
define('SIZE_STORE_LOGO', '20480');      // 店铺LOGO大小限制2OK
define('SIZE_STORE_BANNER', '1048576');  // 店铺BANNER大小限制1M
define('SIZE_STORE_CERT', '409600');     // 店铺证件执照大小限制400K
define('SIZE_STORE_PARTNER', '102400');  // 店铺合作伙伴图片大小限制100K
define('SIZE_CSV_TAOBAO', '2097152');     // 淘宝助理CSV大小限制2M

/* 店铺状态 */
define('STORE_APPLYING', 0); // 申请中
define('STORE_OPEN',     1); // 开启
define('STORE_CLOSED',   2); // 关闭

/* 订单状态 */
define('ORDER_SUBMITTED', 10);                 // 针对货到付款而言，他的下一个状态是卖家已发货
define('ORDER_PENDING', 11);                   // 等待买家付款
define('ORDER_ACCEPTED', 20);                  // 买家已付款，等待卖家发货
define('ORDER_SHIPPED', 30);                   // 卖家已发货
define('ORDER_FINISHED', 40);                  // 交易成功
define('ORDER_CANCELED', 0);                   // 交易已取消

/* 特殊文章分类ID */
define('STORE_NAV',    -1); // 店铺导航
define('ACATE_HELP',    1); // 商城帮助
define('ACATE_NOTICE',  2); // 商城快讯（公告）
define('ACATE_SYSTEM',  3); // 内置文章
');                 //acategory表中code字段为system时——内置文章类别
define('ACC_HELP', 'help');                     //acategory表中code字段为help时——商城帮助类别

/* 邮件的优先级 */
/* 系统文章分类code字段 */
define('ACC_NOTICE', 'notice');                 //acategory表中code字段为notice时——商城公告类别
define('ACC_SYSTEM', 'system
define('MAIL_PRIORITY_LOW',     1);
define('MAIL_PRIORITY_MID',     2);
define('MAIL_PRIORITY_HIGH',    3);

/* 发送邮件的协议类型 */
define('MAIL_PROTOCOL_LOCAL',       0, true);
define('MAIL_PROTOCOL_SMTP',        1, true);

/* 数据调用的类型 */
define('TYPE_GOODS', 1);

/* 上传文件归属 */
define('BELONG_ARTICLE',    1);
define('BELONG_GOODS',      2);
define('BELONG_STORE',      3);

/* 二级域名开关 */
!defined('ENABLED_SUBDOMAIN') && define('ENABLED_SUBDOMAIN', 0);

/* 环境 */
define('CHARSET', substr(LANG, 3));
define('IS_AJAX', isset($_REQUEST['ajax']));
/* 短消息的标志 */
define('MSG_SYSTEM' , 0); //系统消息

/* 团购活动状态 */
define('GROUP_PENDING',  0);            // 未发布
define('GROUP_ON',       1);            // 正在进行
define('GROUP_END',      2);            // 已结束
define('GROUP_FINISHED', 3);            // 已完成
define('GROUP_CANCELED', 4);            // 已取消

define('GROUP_CANCEL_INTERVAL', 5);     // 团购结束后自动取消的间隔天数

/* 通知类型 */
define('NOTICE_MAIL',   1); // 邮件通知
define('NOTICE_MSG',    2); // 站内短消息