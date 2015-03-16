<?php
namespace Admin\Controller;
define('MAX_LAYER', 2);
class ScategoryController extends AdminController
{
    public function index()
    {
        $scate_mod=D('Scategory');
        $lists=$scate_mod->getAll(0,false);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function edit()
    {
        if(!IS_POST){
            $id=I('get.id',0,'intval');
            $cate_mod=D('Scategory');
            $list=M('Scategory')->where('cate_id='.$id)->find();
            $scategories=$cate_mod->getAll(-1,false,0);
            $data=array();
            foreach($scategories as $v){
                $data[$v['cate_id']]=array(
                    'id'=>$v['cate_id'],
                    'pid'=>$v['parent_id'],
                    'name'=>$v['cate_name']
                );
            }
            unset($scategories);
            $html_tree=getTreeOption($data,$list['parent_id']);
            $this->assign('html_tree',$html_tree);
            $this->assign('list',$list);
            $this->display('form');
        }else{
            $cate_mod=M('Scategory');
            if($cate_mod->create()){
                if($cate_mod->save()){
                    $this->success('编辑成功',U('scategory/index'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($this->getError());
            }
        }
    }

    public function add()
    {
        if(!IS_POST){
            $cate_mod=D('Scategory');
            $scategories=$cate_mod->getAll(-1,false,0);
            $data=array();
            foreach($scategories as $v){
                $data[$v['cate_id']]=array(
                    'id'=>$v['cate_id'],
                    'pid'=>$v['parent_id'],
                    'name'=>$v['cate_name']
                );
            }
            unset($scategories);
            $html_tree=getTreeOption($data,I('get.pid',0,'intval'));
            $this->assign('html_tree',$html_tree);
            $this->display('form');
        }else{
            $cate_mod=M('Scategory');
            if($cate_mod->create()){
                if($cate_mod->add()){
                    $this->success('添加成功',U('scategory/index'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($this->getError());
            }
        }
    }

    public function ajax_cate()
    {
        $id=I('get.id',0,'intval');
        $level=I('get.level',1,'intval');
        if(empty($id)){

        }
        $gcate_mod=D('Scategory');
        $cate=$gcate_mod->getAll($id,false);
        foreach($cate as $key=>$val){
            $child=$gcate_mod->getAll($val['cate_id'],false);
            if($level+1>=MAX_LAYER){
                $cate[$key]['add_child']='';
            }else{
                $cate[$key]['add_child']='<a href="'.U('scategory/add',array('id'=>$val['cate_id'])).'">新增子级</a>';
            }
            $spacer=str_repeat('&nbsp;',4*$level);
            if(!$child || empty($child)){
                $cate[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-minus"></i>';
            }else{
                $cate[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-plus" level="'.$level.'" status="open" ectype="flex" onclick="secajax($(this))"></i>';
            }
            $cate[$key]['edit']='<a href="'.U('scategory/edit',array('id'=>$val['cate_id'])).'">编辑</a>';
            $cate[$key]['del']='<a href="#">删除</a>';

        }
        echo json_encode(array_values($cate));
    }
}