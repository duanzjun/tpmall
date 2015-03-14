<?php
namespace Admin\Controller;
define('MAX_LAYER',4);
class GcategoryCOntroller extends AdminController
{
    public function index()
    {
        $gcate_mod=D('Gcategory');
        $lists=$gcate_mod->getAll(0,false,0);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function edit()
    {
        if(!IS_POST){
            $id=I('get.id',0,'intval');
            $cate_mod=D('Gcategory');
            $list=M('Gcategory')->where('cate_id='.$id)->find();
            $gcategories=$cate_mod->getAll(-1,false,0);
            $data=array();
            foreach($gcategories as $v){
                $data[$v['cate_id']]=array(
                    'id'=>$v['cate_id'],
                    'pid'=>$v['parent_id'],
                    'name'=>$v['cate_name']
                );
            }
            unset($gcategories);
            $html_tree=getTreeOption($data,$list['parent_id']);
            $this->assign('html_tree',$html_tree);
            $this->assign('list',$list);
            $this->display('form');
        }else{
            $cate_mod=M('Gcategory');
            if($cate_mod->create()){
                if($cate_mod->save()){
                    $this->success('编辑成功',U('gcategory/index'));
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
            $cate_mod=D('Gcategory');
            $gcategories=$cate_mod->getAll(-1,false,0);
            $data=array();
            foreach($gcategories as $v){
                $data[$v['cate_id']]=array(
                    'id'=>$v['cate_id'],
                    'pid'=>$v['parent_id'],
                    'name'=>$v['cate_name']
                );
            }
            unset($gcategories);
            $html_tree=getTreeOption($data,I('get.pid',0,'intval'));
            $this->assign('html_tree',$html_tree);
            $this->display('form');
        }else{
            $cate_mod=M('Gcategory');
            if($cate_mod->create()){
                if($cate_mod->add()){
                    $this->success('添加成功',U('gcategory/index'));
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
        $gcate_mod=D('Gcategory');
        $cate=$gcate_mod->getAll($id,false,0);
        foreach($cate as $key=>$val){
            $child=$gcate_mod->getAll($val['cate_id'],false,0);
            if($level+1>=MAX_LAYER){
                $cate[$key]['add_child']='';
            }else{
                $cate[$key]['add_child']='<a href="'.U('gcategory/add',array('id'=>$val['cate_id'])).'">新增子级</a>';
            }
            $spacer=str_repeat('&nbsp;',4*$level);
            if(!$child || empty($child)){
                $cate[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-minus"></i>';
            }else{
                $cate[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-plus" level="'.$level.'" status="open" ectype="flex" onclick="secajax($(this))"></i>';
            }
            $cate[$key]['if_show_html']='<span onclick="demo_toggle(this)" d-val="'.(1-$val['if_show']).'" '.
                                        'd-uri="'.U('gcategory/ajax_col',array('id'=>$lst['cate_id'],'col'=>'if_show')).'">'.
                                        '<i class="glyphicon glyphicon-'.($val['if_show']?'ok':'remove').'"></i></span>';
            $cate[$key]['edit']='<a href="'.U('gcategory/edit',array('id'=>$val['cate_id'])).'">编辑</a>';
            $cate[$key]['del']='<a href="#">删除</a>';

        }
        echo json_encode(array_values($cate));
    }
}