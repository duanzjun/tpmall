<?php
namespace Admin\Controller;
class UserController extends AdminController
{
    public function index()
    {
        //检索条件
        $map=array();
        $field=I('get.field_name','','trim');
        $value=I('get.field_value','','trim');
        $sort=I('get.sort','','trim');
        $order=I('get.order','','trim');
        if($field && $value) $map[$field]=array('like','%'.$value.'%');

        //更新排序
        if($sort && $order){
            if(!in_array($order,array('asc','DESC'))){
                $sort='user_id';
                $order='DESC';
            }
        }else{
            if($sort && empty($order)){
                $order="";
            }else{
                $sort='user_id';
                $order='DESC';
            }
        }
        $member_mod=M('Member m');
        $field=' m.*,s.store_id,u.store_id as p_store_id,u.privs';
        $join=' LEFT JOIN '.__STORE__.' s ON m.user_id=s.store_id'.
              ' LEFT JOIN '.__USER_PRIV__.' u ON m.user_id=u.user_id';
        $lists=$member_mod->field($field)->join($join)->where($map)->order("$sort $order")->page(I('get.p',0,'intval').',10')->select();
        foreach($lists as $key=>$val){
            if($val['p_store_id']==0 && $val['privs']!=''){
                $lists[$key]['if_admin']=true;
            }
        }

        $count=$member_mod->join($join)->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();

        $query_fields=array(
            'user_name'=>'会员名',
            'email'=>'邮箱',
            'real_name'=>'真实姓名'
        );
        $sort_options=array(
            'reg_time DESC'=>'注册时间',
            'last_login DESC'=>'最后登录',
            'logins DESC'=>'登录次数'
        );

        $this->assign('lists',$lists);
        $this->assign('page',$show);
        $this->assign('query_fields',$query_fields);
        $this->assign('sort_options',$sort_options);
        $this->assign('filter',empty($map)?0:1);
        $this->display();
    }

    public function edit()
    {

    }
}