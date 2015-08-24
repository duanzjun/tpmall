<?php
/**
  * 分类列表框获取数型结构
  * @param $model 模型
  * @param $selected 当前分类ID
  * @param $is_active 是否显示激活
  * @param $field 字段列表
*/
function getTreeOption($data,$selected=0)
{
    // $lists=D($model)->getAll($is_active);
    // foreach($lists as $key=>$val){
    //     $field['name'] && $val['name']=$val[$field['name']];
    //     $array[$val['id']]=$val;
    // }
    // unset($lists);
    $tree=new \Org\Util\Tree;
    $tree->icon=array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
    $tree->nbsp='&nbsp;&nbsp;&nbsp;';
    $tree->init($data);
    $str="<option value='\$id' \$selected>\$spacer\$name</option>";
    return $tree->get_tree(0,$str,$selected);
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($hook,$params=array()){
    \Think\Hook::listen($hook,$params);
}

/* 比较函数，实现支付方式排序 */
function cmp_payment($a, $b)
{
    if ($b == 'alipay')
    {
        return 1;
    }
    elseif ($b == 'tenpay2' && $a != 'alipay')
    {
        return 1;
    }
    elseif ($b == 'tenpay' && $a != 'alipay' && $a != 'tenpay2')
    {
        return 1;
    }
    else
    {
        return -1;
    }
}