<?php
namespace Admin\Controller;
class PaymentController extends AdminController
{
    public function index()
    {
        $payment_mod=D('Payment');
        $payments=$payment_mod->get_builtin();
        $white_list=$payment_mod->get_white_list();
        foreach($payments as $key=>$value)
        {
            $payments[$key]['system_enabled']=in_array($key,$white_list);
        }
        $this->assign('payments',$payments);
        $this->display();
    }
}