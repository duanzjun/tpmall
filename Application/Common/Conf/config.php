<?php
return array(
	'DB_TYPE'=>'mysqli',
    'DB_HOST'=>'localhost',
    'DB_NAME'=>'koopoo',
    'DB_USER'=>'root',
    'DB_PWD'=>'123456',
    'DB_PORT'=>3306,
    'DB_PREFIX'=>'kp_',

    'SITE_URL'=>'http://localhost/tpmall',
    'REAL_SITE_URL'=>'http://localhost/tpmall',

    'LANG_SWITCH_ON'=>  true, // 开启语言包功能
    'LANG_AUTO_DETECT'=> true, // 自动侦测语言 开启多语言功能后有效
    'LANG_LIST'=> 'zh-cn', // 允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'=> 'l', // 默认语言切换变量


    /*********自定义配置***********/
    'IMAGE_FILE_TYPE'=> 'gif|jpg|jpeg|png', // 图片类型，上传图片时使用

    'SIZE_GOODS_IMAGE'=> '2097152',   // 商品大小限制2M
    'SIZE_STORE_LOGO'=> '20480',      // 店铺LOGO大小限制2OK
    'SIZE_STORE_BANNER'=> '1048576',  // 店铺BANNER大小限制1M
    'SIZE_STORE_CERT'=> '409600',     // 店铺证件执照大小限制400K
    'SIZE_STORE_PARTNER'=> '102400',  // 店铺合作伙伴图片大小限制100K
    'SIZE_CSV_TAOBAO'=> '2097152',     // 淘宝助理CSV大小限制2M

    //店铺状态
    'STORE_APPLYING'=> 0, // 申请中
    'STORE_OPEN'=>     1, // 开启
    'STORE_CLOSED'=>   2, // 关闭

    //订单状态
    'ORDER_SUBMITTED'=> 10,                 // 针对货到付款而言，他的下一个状态是卖家已发货
    'ORDER_PENDING'=> 11,                   // 等待买家付款
    'ORDER_ACCEPTED'=> 20,                  // 买家已付款，等待卖家发货
    'ORDER_SHIPPED'=> 30,                   // 卖家已发货
    'ORDER_FINISHED'=> 40,                  // 交易成功
    'ORDER_CANCELED'=> 0,                   // 交易已取消

    //特殊文章分类ID
    'STORE_NAV'=>    -1, // 店铺导航
    'ACATE_HELP'=>    1, // 商城帮助
    'ACATE_NOTICE'=>  2, // 商城快讯（公告）
    'ACATE_SYSTEM'=>  3, // 内置文章

    //系统文章分类code字段
    'ACC_NOTICE'=> 'notice',                 //acategory表中code字段为notice时——商城公告类别
    'ACC_SYSTEM'=> 'system',                 //acategory表中code字段为system时——内置文章类别
    'ACC_HELP'=> 'help',

    //邮件的优先级
    'MAIL_PRIORITY_LOW'=>     1,
    'MAIL_PRIORITY_MID'=>     2,
    'MAIL_PRIORITY_HIGH'=>    3,

    //发送邮件的协议类型
    'MAIL_PROTOCOL_LOCAL'=>       0,
    'MAIL_PROTOCOL_SMTP'=>       1,

    //数据调用的类型
    'TYPE_GOODS'=> 1,

    /* 上传文件归属 */
    'BELONG_ARTICLE'=>    1,
    'BELONG_GOODS'=>      2,
    'BELONG_STORE'=>      3,

    //二级域名开关
    'ENABLED_SUBDOMAIN'=> 0,

    //短消息的标志
    'MSG_SYSTEM'=>  0, //系统消息

    //团购活动状态
    'GROUP_PENDING'=>  0,            // 未发布
    'GROUP_ON'=>       1,            // 正在进行
    'GROUP_END'=>      2,            // 已结束
    'GROUP_FINISHED'=> 3,            // 已完成
    'GROUP_CANCELED'=> 4,            // 已取消
    'GROUP_CANCEL_INTERVAL'=> 5,     // 团购结束后自动取消的间隔天数

    //通知类型
    'NOTICE_MAIL'=>   1, // 邮件通知
    'NOTICE_MSG'=>    2, // 站内短消息
);