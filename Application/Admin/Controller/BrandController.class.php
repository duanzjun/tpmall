<?php
namespace Admin\Controller;
class BrandController extends AdminController
{
    public function index()
    {
        I('get.brand_name','','trim') && $map['brand_name']=array('like','%'.I('get.brand_name','','trim').'%');
        I('get.tag','','trim') && $map['tag']=array('like','%'.I('get.tag','','trim').'%');
        $wait=I('get.wait_verify');
        if(is_numeric($wait)) $map['if_show']=0;

        $brand_mod=M('Brand');
        $lists=$brand_mod->where($map)->page(I('get.p',0,'intval').',10')->select();
        $count=$brand_mod->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();
        $this->assign('lists',$lists);
        $this->assign('page',$show);
        $this->assign('filter',empty($map)?0:1);
        $this->display();
    }

    public function add()
    {
        if(!IS_POST){
            $this->display('form');
        }else{
            $brand_mod=M('Brand');
            if($brand_mod->create()){
                if($brand_mod->add()){
                    $this->success('添加成功',U('brand/index'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($this->getError());
            }

        }
    }

    public function edit()
    {
        if(!IS_POST){
            $id=I('get.id',0,'intval');
            $list=M('Brand')->where('brand_id='.$id)->find();
            $this->assign('list',$list);
            $this->display('form');
        }else{
            $brand_mod=M('Brand');
            if($brand_mod->create()){
                if($brand_mod->save()){
                    $this->success('编辑成功',U('brand/index',array('p'=>I('ret_page',1,'intval'))));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($this->getError());
            }
        }
    }

    //修改列字段
    public function ajax_col()
    {
        $col=I('col','','trim');
        $val=I('val','','trim');
        $id=I('id',0,'intval');
        M('Brand')->where('brand_id='.$id)->setField($col,$val);
        $this->ajaxReturn(array('status'=>true,'rel'=>array('state'=>$val)));
    }

    public function ajaxupload()
    {
        parent::ajaxUpload(array(
            'upload_url'=>'data/files/mall/brand/',    //图片显示地址
            'upload_dir'=>'data/files/mall/brand/',    //图片存放路径
            'script_url'=>'index.php?m=admin&c=setting&a=ajaxupload',    //处理图片地址
            // 'rule'=>array('custom',trim($_GET['name']))
        ));
    }
}