<?php
namespace Admin\Controller;
class RegionController extends AdminController
{
    public function index()
    {
        $region_mod = D('Region');
        $lists = $region_mod->getAll(0);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function ajax_cate()
    {
        $id=I('get.id',0,'intval');
        $level=I('get.level',1,'intval');
        if(empty($id)){

        }
        $region_mod=D('Region');
        $region=$region_mod->getAll($id,false,0);

        foreach($region as $key=>$val){
            $child=$region_mod->getAll($val['region_id'],false,0);
            if($level+1>=MAX_LAYER){
                $region[$key]['add_child']='';
            }else{
                $region[$key]['add_child']='<a href="'.U('region/add',array('id'=>$val['region_id'])).'">新增子级</a>';
            }
            $spacer=str_repeat('&nbsp;',4*$level);
            if(!$child || empty($child)){
                $region[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-minus"></i>';
            }else{
                $region[$key]['switchs_html']=$spacer.'<i class="glyphicon glyphicon-plus" level="'.$level.'" status="open" ectype="flex" onclick="secajax($(this))"></i>';
            }
            $region[$key]['edit']='<a href="'.U('region/edit',array('id'=>$val['region_id'])).'">编辑</a>';
            $region[$key]['del']='<a href="#">删除</a>';

        }
        echo json_encode(array_values($region));
    }
}