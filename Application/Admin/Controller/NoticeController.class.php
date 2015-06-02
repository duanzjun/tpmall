<?php
namespace Admin\Controller;
/* 网站通知 */
// 发送通知的会员类型
define('SPEC', 1);
define('ALL', 2);
define('SGRADE', 3);
define('STORE', 4);
// 发送方式
define('MESSAGE', 1);
define('EMAIL', 2);
class NoticeController extends AdminController
{
    public function index()
    {
        if(!IS_POST){
            $sgrade_mod=M('Sgrade');
            $sgrades_tmp=$sgrade_mod->find();
            $sgrades=array();
            foreach($sgrades_tmp as $val){
                $sgrades[$val['grade_id']]=$val['grade_name'];
            }
            $this->display('form');
        }else{
            I('post.send_type');
            I('post.send_mode');
            I('post.content');
            I('post.send_mode');
            I('post.');
         if (empty($_POST['send_type']) && empty($_POST['send_mode']))
                {
                    $this->show_warning('type_mode_required');
                    exit;
                }
                if ((empty($_POST['content']) && trim($_POST['send_mode']) == 2) || (empty($_POST['content1']) && trim($_POST['send_mode'] == 1)))
                {
                    $this->show_warning('no_content');
                    exit;
                }
                if (trim($_POST['send_mode'] == 2) && empty($_POST['title']))
                {
                    $this->show_warning('title_empty');
                    exit;
                }
                $title = trim($_POST['send_mode']) == 2 ? trim($_POST['title']) : '';
                $content = trim($_POST['send_mode']) == 1 ? trim($_POST['content1']) : trim($_POST['content']);
                $result = array();
                $count = 0;
                switch (trim($_POST['send_type']))
                {
                    case SPEC :
                        if (!isset($_POST['user_name']) || empty($_POST['user_name']))
                        {
                            $this->show_warning("no_user");
                            exit;
                        }
                        $user_name = trim($_POST['user_name']);
                        $user_name = str_replace(array("\r","\r\n"), "\n", $user_name);
                        $user_name = explode("\n", $user_name);
                        $result = $this->_user_mod->find(array(
                            'fields' => 'user_id,email',
                            'conditions' => 'user_name ' . db_create_in($user_name),
                            'count' => true,));
                        $count = $this->_user_mod->getCount();
                        break;
                    case ALL :
                        $result = $this->_user_mod->find(array(
                            'fields' => 'user_id,email',
                            'count' => true,
                        ));
                        $count = $this->_user_mod->getCount();
                        break;
                    case SGRADE :
                        $sgrade_id = $_POST['sgrade'];
                        $store_mod =& m('store');
                        $result = $store_mod->find(array(
                            'fields' => 'member.user_id,member.email',
                            'join' => 'belongs_to_user',
                            'conditions' => 's.sgrade ' . db_create_in($sgrade_id),
                            'count' => true,
                        ));
                        $count = $store_mod->getCount();
                        break;
                    case STORE :
                        $store_mod =& m('store');
                        $result = $store_mod->find(array(
                            'fields' => 'member.user_id,member.email',
                            'join' => 'belongs_to_user',
                            'count' => true,
                            ));
                        $count = $store_mod->getCount();
                        break;
                }
                $users = array();
                foreach ($result as $val)
                {
                    $users[$val['user_id']] = $val['email'];
                }
                if (empty($users))
                {
                    $this->show_warning("no_users");
                    exit;
                }
                $admin_id = $this->visitor->get('user_id');
                if (isset($users[$admin_id]))
                {
                    unset($users[$admin_id]);
                    $count = $count - 1;
                }
                $amount = empty($_POST['amount']) ? 20 : intval(trim($_POST['amount']));
                $parts = ceil($count/$amount);
                $this->write_session(array('type' => trim($_POST['send_mode']), 'to_users' => $users, 'count' => $count, 'amount' => $amount, 'parts' => $parts,'title' => $title, 'content' => $content));
                $this->send();
            }
    }
}