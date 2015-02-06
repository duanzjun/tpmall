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
        $goods_mod=M('Goods g');
        $lists=$goods_mod->field($field)->join($join)->where($map)->order($sort.' '.$order)->page(I('get.p',0,'intval').',10')->select();

        //分页
        $count=$goods_mod->join($join)->where($map)->count();
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

    public function edit()
    {
        if(!IS_POST){
            $categories=M('Gcategory')->where('store_id=0 AND if_show=1 AND parent_id=0')->order('sort_order')->select();
            $this->assign('categories',$categories);
            $this->display('goods_batch');
        }else{
            $id=I('get.id');
            if(!$id){
                $this->error('ID不能为空');
            }
            $ids=explode(',',$id);
            $data=array();
            $cid=I('post.cid');
            if(!empty($cid)){
                $cid=explode(',',$cid);
                foreach($cid as $_k=>$_c){
                    $data['cate_id_'.($_k+1)]=$_c;
                }
                $data['cate_id']=end($cid);
                $data['cate_name']=I('post.cate_name','','trim');
            }
            if(I('post.brand','','trim')) $data['brand']=I('post.brand','','trim');
            if(I('post.closed')>=0){
                $data['closed']=I('post.closed') ? 1 : 0;
                if(I('post.close_reason')){
                    $data['close_reason']=I('post.close_reason','','trim');
                }
            }
            if(empty($data)){
                $this->error('没有修改设置');
            }
            M('Goods')->where(array('goods_id'=>array('in',$ids)))->save($data);
            $page=I('get.ret_page',1,'intval')>1 ? '&p='.I('get.ret_page') : '';
            $this->success('批量编辑成功','index.php?m=admin&c=goods'.$page);
        }
    }

    public function recommend()
    {
        if(!IS_POST)
        {
            //取得推荐类型
            $recommends=M('Recommend')->where('store_id=0')->select();
            if(empty($recommends)){
                $this->error('没有推荐数据');
            }
            $this->assign('recommends',$recommends);
            $this->display('goods_batch');
        }else{
            $id=I('get.id');
            if(empty($id)){
                $this->error('ID不能为空');
            }
            $recom_id=I('post.recom_id') ? I('recom_id',0,'intval') : 0;
            if(!recom_id){
                $this->error('请选择推荐项');
            }
            $ids=explode(',',$id);
            $reco_mod=M('Recommended_goods');
            $reco_mod->where(array('goods_id'=>array('in',$ids)))->delete();
            $data=array();
            foreach($ids as $id){
                $data[]=array(
                    'recom_id'=>$recom_id,
                    'goods_id'=>$id
                );
            }
            $reco_mod->addAll($data);
            $this->success('推荐成功',U('goods/index',array('p'=>I('get.ret_page',1,'intval')>1 ? I('get.ret_page') : '')));
        }
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