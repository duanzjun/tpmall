<?php
return array(
    'dashboard' => array(
        'text'      => L('dashboard'),
        'default'   => 'welcome',
        'children'  => array(
            'welcome'   => array(
                'text'  => L('welcome_page'),
                'url'   => U('index/welcome'),
            ),
            'base_setting'  => array(
                'parent'=> 'setting',
                'text'  => L('base_setting'),
                'url'   => U('setting/index'),
            ),
            'user_manage' => array(
                'text'  => L('user_manage'),
                'parent'=> 'user',
                'url'   => 'index.php?app=user',
            ),
            'store_manage'  => array(
                'text'  => L('store_manage'),
                'parent'=> 'store',
                'url'   => 'index.php?app=store',
            ),
            'goods_manage'  => array(
                'text'  => L('goods_manage'),
                'parent'=> 'goods',
                'url'   => U('goods/index'),
            ),
            'order_manage' => array(
                'text'  => L('order_manage'),
                'parent'=> 'trade',
                'url'   => 'index.php?app=order'
            ),
        ),
    ),
    // 设置
    'setting'   => array(
        'text'      => L('setting'),
        'default'   => 'base_setting',
        'children'  => array(
            'base_setting'  => array(
                'text'  => L('base_setting'),
                'url'   => U('setting/index'),
            ),
            'region' => array(
                'text'  => L('region'),
                'url'   => 'index.php?app=region',
            ),
            'payment' => array(
                'text'  => L('payment'),
                'url'   => 'index.php?app=payment',
            ),
            'theme' => array(
                'text'  => L('theme'),
                'url'   => 'index.php?app=theme',
            ),
            'template' => array(
                'text'  => L('template'),
                'url'   => 'index.php?app=template',
            ),
            'mailtemplate' => array(
                'text'  => L('noticetemplate'),
                'url'   => 'index.php?app=mailtemplate',
            ),
        ),
    ),
    // 商品
    'goods' => array(
        'text'      => L('goods'),
        'default'   => 'goods_manage',
        'children'  => array(
            'gcategory' => array(
                'text'  => L('gcategory'),
                'url'   => 'index.php?app=gcategory',
            ),
            'brand' => array(
                'text'  => L('brand'),
                'url'   => 'index.php?app=brand',
            ),
            'goods_manage' => array(
                'text'  => L('goods_manage'),
                'url'   => U('goods/index'),
            ),
            'recommend_type' => array(
                'text'  => L('recommend_type'),
                'url'   => U('recommend/index')
            ),
        ),
    ),
    // 店铺
    'store'     => array(
        'text'      => L('store'),
        'default'   => 'store_manage',
        'children'  => array(
            'sgrade' => array(
                'text'  => L('sgrade'),
                'url'   => 'index.php?app=sgrade',
            ),
            'scategory' => array(
                'text'  => L('scategory'),
                'url'   => 'index.php?app=scategory',
            ),
            'store_manage'  => array(
                'text'  => L('store_manage'),
                'url'   => 'index.php?app=store',
            ),
        ),
    ),
    // 会员
    'user' => array(
        'text'      => L('user'),
        'default'   => 'user_manage',
        'children'  => array(
            'user_manage' => array(
                'text'  => L('user_manage'),
                'url'   => 'index.php?app=user',
            ),
            'admin_manage' => array(
                'text' => L('admin_manage'),
                 'url'   => 'index.php?app=admin',
             ),
             'user_notice' => array(
                'text' => L('user_notice'),
                'url'  => 'index.php?app=notice',
             ),
        ),
    ),
    // 交易
    'trade' => array(
        'text'      => L('trade'),
        'default'   => 'order_manage',
        'children'  => array(
            'order_manage' => array(
                'text'  => L('order_manage'),
                'url'   => 'index.php?app=order'
            ),
        ),
    ),
    // 网站
    'website' => array(
        'text'      => L('website'),
        'default'   => 'acategory',
        'children'  => array(
            'acategory' => array(
                'text'  => L('acategory'),
                'url'   => 'index.php?app=acategory',
            ),
            'article' => array(
                'text'  => L('article'),
                'url'   => 'index.php?app=article',
            ),
            'partner' => array(
                'text'  => L('partner'),
                'url'   => 'index.php?app=partner',
            ),
            'navigation' => array(
                'text'  => L('navigation'),
                'url'   => 'index.php?app=navigation',
            ),
            'groupbuy' => array(
                'text' => L('groupbuy'),
                'url'  => 'index.php?app=groupbuy',
            ),
            'consulting' => array(
                'text'  => L('consulting'),
                'url'   => 'index.php?app=consulting',
            ),
            'share_link' => array(
                'text'  => L('share_link'),
                'url'   => 'index.php?app=share',
            ),
        ),
    ),
    // 扩展
    'extend' => array(
        'text'      => L('extend'),
        'default'   => 'plugin',
        'children'  => array(
            'plugin' => array(
                'text'  => L('plugin'),
                'url'   => 'index.php?app=plugin',
            ),
            'module' => array(
                'text'  => L('module'),
                'url'   => 'index.php?app=module&act=manage',
            ),
            'widget' => array(
                'text'  => L('widget'),
                'url'   => 'index.php?app=widget',
            ),
        ),
    ),
);