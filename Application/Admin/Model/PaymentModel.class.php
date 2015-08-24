<?php
namespace Admin\Model;
use Think\Model;
class PaymentModel extends Model
{

    /*---------对内置支付方式的操作---------*/

    /**
     *    获取内置支付方式
     *
     *    @author    Garbin
     *    @param     array $withe_list 白名单
     *    @return    array
     */
    public function get_builtin($white_list=null)
    {
        static $payments=null;
        if($payments===null)
        {
            //隐藏文件，当前目录，上一级，排除
            $payment_dir=APP_PATH.'Behavior/payments';
            $dir=dir($payment_dir);
            $paryments=array();
            while(false!==($entry=$dir->read()))
            {

                if($entry{0}=='.') continue;

                if(is_array($white_list) && !in_array($entry,$white_list)) continue;

                //获取支付方式信息
                $payments[$entry]=$this->get_builtin_info($entry);
            }
        }
        if(is_array($payments))
            uksort($payments,"cmp_payment");

        return $payments;
    }

    /**
     *    获取内置支付方式的配置信息
     *
     *    @author    Garbin
     *    @param     string $code
     *    @return    array
     */
    public function get_builtin_info($code)
    {
        // Lang::load(lang_file('payment/' . $code));
        $payment_path = APP_PATH.'/Behavior/payments/' . $code . '/payment.info.php';

        return include($payment_path);
    }

    /**
     *    获取支付方式白名单
     *
     *    @author    Garbin
     *    @return    array
     */
    function get_white_list()
    {
        $file = ROOT_PATH . '/data/payments.inc.php';
        if (!is_file($file))
        {
            return array();
        }

        return include($file);
    }

    /**
     *    启用内置支付方式
     *
     *    @param     string $code
     *    @return    bool
     */
    function enable_builtin($code)
    {
        $white_list = $this->get_white_list();
        $white_list[] = $code;
        $white_list = array_unique($white_list);
        return $this->save_white_list($white_list);
    }

    /**
     *    禁用内置支付方式
     *
     *    @param     string $code
     *    @return    void
     */
    function disable_builtin($code)
    {
        $white_list = $this->get_white_list();
        $index = array_search($code, $white_list);
        if (false !== $index)
        {
            unset($white_list[$index]);

            return $this->save_white_list($white_list);
        }

        return false;
    }

    /**
     *    保存白名单
     *
     *    @param     array $white_list
     *    @return    bool
     */
    function save_white_list($white_list)
    {
        $payments_inc_file = ROOT_PATH.'/data/payments.inc.php';
        $php_data = "<?php\n\nreturn " . var_export($white_list, true) . ";\n\n";

        return file_put_contents($payments_inc_file, $php_data, LOCK_EX);
    }

}
