<?php
namespace Admin\Controller;
class GoodsController extends AdminController
{
    public function index()
    {
        //检索条件
        $map=array();
        I('goods_name','','trim') && $map['g.goods_name']=array('like','%'.I('goods_name','','trim').'%');
        I('store_name','','trim') && $map['g.store_name']=array('like','%'.I('store_name','','trim').'%');
        I('brand','','trim') && $map['g.brand']=I('brand','','trim');
        I('closed',0,'intval')==1 && $map['g.closed']=1;
        list($cid,$level)=explode('-',I('cid'));
        if($cid>0 && $level>0){
            $map['g.cate_id_'.$level]=$cid;
        }

        //更新排序
        if($sort=I('get.sort','','trim') && $order=I('get.order','','trim')){
            if(!in_array($order,array('asc','DESC'))){
                $sort='g.goods_id';
                $order='DESC';
            }
        }else{
            $sort='g.goods_id';
            $order='DESC';
        }

        //分类
        $categories=M('Gcategory')->where('store_id=0 AND if_show=1 AND parent_id=0')->order('sort_order')->select();
        $this->assign('categories',$categories);

        //查询关联
        $field=' g.goods_id,g.goods_name,g.store_id,g.brand,g.cate_name,g.if_show,g.closed,'.
               's.store_name,gs.views';
        $join=' LEFT JOIN '.__STORE__.' s ON g.store_id = s.store_id'.
              ' LEFT JOIN '.__GOODS_STATISTICS__.' gs ON g.goods_id = gs.goods_id';
        $model=M('Goods g');
        $lists=$model->field($field)->join($join)->where($map)->order($sort.' '.$order)->page(I('get.p',0,'intval').',10')->select();

        //分页
        $count=$model->join($join)->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();
        $this->assign('filter',empty($map)?0:1);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function get_cate()
    {
        $cid=I('cid',0,'intval');
        if($cid<1) return false;

        $lists=M('Gcategory')->where('store_id=0 AND if_show=1 AND parent_id='.$cid)->order('sort_order')->select();
        if(empty($lists)) return false;

        $str_html='<select><option value="">请选择...</option>';
        foreach($lists as $v){
            $str_html.='<option value="'.$v['cate_id'].'">'.$v['cate_name'].'</option>';
        }
        echo $str_html.'</select>';
    }

    //修改列字段
    public function ajax_col()
    {
        $col=I('col','','trim');
        $val=I('val','','trim');
        $id=I('id',0,'intval');
        M('Goods')->where('goods_id='.$id)->setField($col,$val);
        $this->ajaxReturn(array('status'=>true,'rel'=>array('state'=>$val)));
    }
}