<?php
namespace Admin\Controller;
class RecommendController extends AdminController
{
    public function index()
    {
        $recom_name=I('get.recom_name','','trim');
        $map=array();
        if(!empty($recom_name)){
            $map['recom_name']=array('like','%'.$recom_name.'%');
        }
        $recom_mod=M('Recommend');
        $lists=$recom_mod->where($map)->page(I('get.p',0,'intval').',10')->select();
        $count_goods=$this->count_goods();

        //分页
        $count=$recom_mod->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();

        $this->assign('cnt',$count_goods);
        $this->assign('lists',$lists);
        $this->assign('page',$show);
        $this->assign('filter',empty($map)?0:1);
        $this->display();
    }

    //编辑推荐
    public function edit()
    {
        if(!IS_POST){
            $id=I('get.id',0,'intval');
            if(empty($id)){
                $this->error('ID不存在');
            }
            $list=M('Recommend')->where('recom_id='.$id)->find();
            $this->assign('list',$list);
            $this->display('form');
        }else{
            $recom_mod=M('Recommend');
            if($recom_mod->create()){
                if(false!==$recom_mod->save()){
                    $this->success('编辑推荐成功',U('recommend/index'));
                }else{
                    $this->error('编辑推荐失败');
                }
            }else{
                $this->error($recom_mod->getError());
            }
        }
    }

    //新增推荐
    public function add()
    {
        if(!IS_POST){
            $this->display('form');
        }else{
            $recom_mod=M('Recommend');
            if($recom_mod->create()){
                if(false!==$recom_mod->add()){
                    $this->success('新增推荐成功',U('recommend/index'));
                }else{
                    $this->error('新增推荐失败');
                }
            }else{
                $this->error($recom_mod->getError());
            }
        }
    }

    //查看推荐商品
    public function view_goods()
    {
        $id=I('get.id',0,'intval');
        if(empty($id)){
            $this->error('推荐ID不存在');
        }

        $recommend=M('RecommendedGoods')->where('recom_id='.$id)->field('goods_id')->select();
        if(empty($recommend)) goto END; //直接跳转输出

        foreach($recommend as $recom){
            $ids[]=$recom['goods_id'];
        }

        //查询关联
        $field='g.goods_id,g.goods_name,g.store_id,g.brand,g.cate_name,g.if_show,g.closed,'.
               's.store_name,gs.views';
        $join=' LEFT JOIN '.__GOODS__.' g ON rg.goods_id=g.goods_id'.
              ' LEFT JOIN '.__STORE__.' s ON g.store_id = s.store_id'.
              ' LEFT JOIN '.__GOODS_STATISTICS__.' gs ON g.goods_id = gs.goods_id';
        $model=M('RecommendedGoods rg');
        $map['g.goods_id']=array('in',$ids);
        $lists=$model->field($field)->join($join)->where($map)->order('g.goods_id DESC')->page(I('get.p',0,'intval').',10')->select();
        //分页
        $count=$model->join($join)->where($map)->count();
        $Page=new \Think\Page($count,10);
        $show=$Page->show();
        $this->assign('filter',empty($map)?0:1);
        $this->assign('page',$show);
        $this->assign('lists',$lists);

        END:
        $this->display();
    }

    //取消推荐
    public function drop_goods_from()
    {

    }

    //统计各推荐下商品数
    private function count_goods()
    {
        $count=array();
        $sql="SELECT rg.recom_id,COUNT(*) as goods_count ".
             "FROM __RECOMMENDED_GOODS__ as rg ".
             "LEFT JOIN __RECOMMEND__ as r ON rg.recom_id=r.recom_id ".
             "LEFT JOIN __GOODS__ as g ON rg.goods_id=g.goods_id ".
             "WHERE r.store_id=0 ".
             "AND g.goods_id IS NOT NULL ".
             "GROUP BY rg.recom_id";
        $recom_mod=M('Recommend');
        $result=$recom_mod->query($sql);
        $data=array();
        foreach($result as $v){
            $data[$v['recom_id']]=$v['goods_count'];
        }
        unset($result);
        return $data;
    }
}