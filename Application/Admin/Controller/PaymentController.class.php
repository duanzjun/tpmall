<?php
namespace Admin\Controller;
class PaymentController extends AdminController
{
    public function index()
    {
        //读取已安装的支付方式
        $payment_mod=D('Payment');
        $payments=$payment_mod->get_builtin();
        $white_list=$payment_mod->get_white_list();
        foreach ($payments as $key => $value)
        {
            $payments[$key]['system_enabled'] = in_array($key, $white_list);
        }
        $this->assign('payments',$payments);
        $this->display();
    }

    /**
     * 启用
    */
    public function enable()
    {
        $code=I('get.code','','trim');
        if(!$code){
            $this->error('没有指定支付方式');
        }
        $payment_mod=D('Payment');
        if(!$payment_mod->enable_builtin($code))
        {
            $this->error($payment_mod->getError());
        }
        $this->success('启用支付方式成功。');
    }

    /**
     * 禁用
    */
    public function disable()
    {
        $code=I('get.code','','trim');
        if (!$code)
            $this->error('没有指定支付方式');

        $payment_mod=D('Payment');
        if (!$payment_mod->disable_builtin($code))
            $this->error($payment_mod->getError());

        $this->success('禁用支付方式成功。');
    }
}