<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller
{
    //加载初始化
    public function _initialize()
    {

    }

    public function ajaxUpload($options=array())
    {
        $_options=array(
            'upload_url'=>'Public/uploads/'.date('Ymd').'/',    //图片显示地址
            'upload_dir'=>'Public/uploads/'.date('Ymd').'/',    //图片存放路径
            'script_url'=>'index.php?m=admin&c=admin&a=ajaxupload',    //处理图片地址
        );
        $_options=array_merge($_options,$options);
        $upload=new \Think\Upload($_options);
        $files=$upload->get_response();     //返回上传数据
        //删除图片
        if($_SERVER['REQUEST_METHOD']==='DELETE'){
            if($files[I('file')]==true){
                //删除表记录
                //M('attachment')->where('filename="'.I('file').'"')->delete();
            }
        }else{
            foreach($files['files'] as $k=>$v){
                $v=is_object($v) ? (array)$v : $v;
                $data=array(
                    'uid'=>$_SESSION['authId'],
                    'module'=>MODULE_NAME,
                    'filename'=>$v['name'],
                    'filepath'=>$v['url'],
                    'filesize'=>$v['size'],
                    'filetype'=>$v['type'],
                    'isimage'=>1,
                    'uploadtime'=>time()
                );
                // M('attachment')->add($data);
            }
        }
    }
}