<?php
namespace Admin\Controller;
class IndexController extends AdminController
{
    public function index()
    {
        $menus=load_config(APP_PATH.'Common/Common/menu.php');
        $this->assign('menus',$menus);
        $this->assign('menus_json',json_encode($menus));
        $this->display();
    }

    public function welcome()
    {
        $sys_info=array(
            'os'=>PHP_OS,
            'server_software'=>strpos($_SERVER['SERVER_SOFTWARE'], 'PHP')===false ? $_SERVER['SERVER_SOFTWARE'].' PHP/'.phpversion() : $_SERVER['SERVER_SOFTWARE'],
            'upload_max_filesize'=>@ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown',
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
            'mysql_version' => $this->_mysql_version(),
            'mysql_size' => $this->_mysql_db_size(),
        );

        //一周动态
        $news_in_a_week=$this->_get_news_in_a_week();
        //统计信息
        $stats=$this->_get_stats();

        $this->assign('sys_info',$sys_info);
        $this->assign('news_in_a_week',$news_in_a_week);
        $this->assign('stats',$stats);
        $this->display();
    }

    //获取mysql当前版本
    private function _mysql_version()
    {
        $_model=new \Think\Model();
        $version=$_model->query("SELECT version() as ver");
        return $version[0]['ver'];
    }

    private function _mysql_db_size()
    {
        $_model=new \Think\Model();
        $sql = "SHOW TABLE STATUS FROM ".C('DB_NAME');
        $tblPrefix = C('DB_PREFIX');
        if($tblPrefix != null) {
            $sql .= " LIKE '{$tblPrefix}%'";
        }
        $row = $_model->query($sql);
        $size = 0;
        foreach($row as $value) {
            $size += $value["Data_length"] + $value["Index_length"];
        }
        return round(($size/1048576),2).'M';
    }

    //一周动态
    private function _get_news_in_a_week()
    {
        $a_week_ago=NOW_TIME-7*86400;
        return array(
            'new_user_qty'=>M('member')->where('reg_time>'.$a_week_ago)->count(),
            'new_store_qty'=>M('store')->where('add_time>'.$a_week_ago.' AND state=1')->count(),
            'new_apply_qty'=>M('store')->where('add_time>'.$a_week_ago.' AND state=0')->count(),
            'new_goods_qty'=>M('goods')->where('add_time>'.$a_week_ago.' AND if_show=1 AND closed=0')->count(),
            'new_order_qty'=>M('order')->where('finished_time>'.$a_week_ago.' AND status=40')->count()
        );
    }

    //统计信息
    private function _get_stats()
    {
        return array(
            'user_qty'=>M('member')->count(),
            'store_qty'=>M('store')->where('state=1')->count(),
            'apply_qty'=>M('store')->where('state=0')->count(),
            'goods_qty'=>M('goods')->where('if_show=1 AND closed=0')->count(),
            'order_qty'=>M('order')->where('status=40')->count(),
            'order_amount'=>M('order')->where('status=40')->sum('order_amount'),
            'admin_email'=>M('member')->where('user_id=1')->getField('email')
        );
    }
}