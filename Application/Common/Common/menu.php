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
                'url'   => U('user/index'),
            ),
            'store_manage'  => array(
                'text'  => L('store_manage'),
                'parent'=> 'store',
                'url'   => U('store/index'),
            ),
            'goods_manage'  => array(
                'text'  => L('goods_manage'),
                'parent'=> 'goods',
                'url'   => U('goods/index'),
            ),
            'order_manage' => array(
                'text'  => L('order_manage'),
                'parent'=> 'trade',
                'url'   => U('order/index')
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
                'url'   => U('region/index'),
            ),
            'payment' => array(
                'text'  => L('payment'),
                'url'   => U('payment/index'),
            ),
            'theme' => array(
                'text'  => L('theme'),
                'url'   => U('theme/index'),
            ),
            'template' => array(
                'text'  => L('template'),
                'url'   => U('template/index'),
            ),
            'mailtemplate' => array(
                'text'  => L('noticetemplate'),
                'url'   => U('mailtemplate/index'),
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
                'url'   => U('gcategory/index'),
            ),
            'brand' => array(
                'text'  => L('brand'),
                'url'   => U('brand/index'),
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
                'url'   => U('sgrade/index'),
            ),
            'scategory' => array(
                'text'  => L('scategory'),
                'url'   => U('scategory/index'),
            ),
            'store_manage'  => array(
                'text'  => L('store_manage'),
                'url'   => U('store/index'),
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
                'url'   => U('user/index'),
            ),
            'admin_manage' => array(
                'text' => L('admin_manage'),
                 'url'   => U('admin/index'),
             ),
             'user_notice' => array(
                'text' => L('user_notice'),
                'url'  => U('notice/index'),
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
                'url'   => U('order/index')
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
                'url'   => U('acategory/index'),
            ),
            'article' => array(
                'text'  => L('article'),
                'url'   => U('article/index'),
            ),
            'partner' => array(
                'text'  => L('partner'),
                'url'   => U('partner/index'),
            ),
            'navigation' => array(
                'text'  => L('navigation'),
                'url'   => U('navigation/index'),
            ),
            'groupbuy' => array(
                'text' => L('groupbuy'),
                'url'  => U('groupbuy/index'),
            ),
            'consulting' => array(
                'text'  => L('consulting'),
                'url'   => U('consulting/index'),
            ),
            'share_link' => array(
                'text'  => L('share_link'),
                'url'   => U('share/index'),
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
                'url'   => U('plugin/index'),
            ),
            'module' => array(
                'text'  => L('module'),
                'url'   => U('module/manage'),
            ),
            'widget' => array(
                'text'  => L('widget'),
                'url'   => U('widget/index'),
            ),
        ),
    ),
);