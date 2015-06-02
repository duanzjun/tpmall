<?php
namespace Admin\Model;
use Think\Model;
class PaymentModel extends Model
{
    public function get_builtin($white_list=null)
    {
        static $payments=null;
        if($payments===null)
        {
            $payment_dir=ROOT_PATH
        }
    }
}