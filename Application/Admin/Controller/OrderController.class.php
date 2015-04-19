<?php
namespace Admin\Controller;
class OrderController extends AdminController
{
    public function index()
    {
        //检索条件
        $map=array();
        $field_name=I('get.field_name','','trim');
        $field_value=I('get.field_value','','trim');
        if($field_name && $field_value) $map[$field_name]=array('like','%'.$field_value.'%');
        $status=I('get.status');
        if($status=='0' || intval($status)>0) $map['status']=$status;
        $time_from=I('get.add_time_from','','trim');
        $time_to=I('get.add_time_to','','trim');
        $time_from && $map['add_time']=array('egt',strtotime($time_from));
        $time_to && $map['add_time']=array('elt',strtotime($time_to));

        //更新排序
        $sort=I('get.sort','','trim');
        $order=I('get.order','','trim');
        if($sort && $order){
            if(!in_array($order,array('asc','DESC'))){
                $sort='order_id';
                $order='DESC';
            }
        }else{
            $sort='order_id';
            $order='DESC';
        }
        $order_mod=M('Order');
        $lists=$order_mod->where($map)->order("$sort $order")->page(I('get.p',0,'intval').',10')->select();
        $count=$order_mod->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();



        $this->assign('lists',$lists);
        $this->assign('page',$show);
        $this->assign('search_options',array(
            'seller_name'=>'店铺名称',
            'buyer_name'=>'买家名称',
            'payment_name'=>'支付方式',
            'order_sn'=>'订单号'
        ));
        $this->assign('order_status_list', array(
            C('ORDER_PENDING') => L('order_pending'),
            C('ORDER_SUBMITTED') => L('order_submitted'),
            C('ORDER_ACCEPTED') => L('order_accepted'),
            C('ORDER_SHIPPED') => L('order_shipped'),
            C('ORDER_FINISHED') => L('order_finished'),
            C('ORDER_CANCELED') => L('order_canceled'),
        ));
        $this->assign('filter',empty($map)?0:1);
        $this->display();
    }
}