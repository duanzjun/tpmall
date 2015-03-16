<?php
namespace Admin\Controller;
class StoreController extends AdminController
{
    public function index()
    {
        //检索条件
        $map=array();
        if(I('owner_name','','trim')){
            $where['owner_name']=array('like','%'.I('owner_name','','trim').'%');
            $where['user_name']=array('like','%'.I('owner_name','','trim').'%');
            $where['_logic']='or';
            $map['_complex']=$where;
        }
        I('store_name','','trim') && $map['store_name']=array('like','%'.I('store_name','','trim').'%');
        I('sgrade',0,'intval') && $map['sgrade']=I('sgrade',0,'intval');

        //更新排序
        if($sort=I('get.sort','','trim') && $order=I('get.order','','trim')){
            if(!in_array($order,array('asc','DESC'))){
                $sort='store_id';
                $order='DESC';
            }
        }else{
            $sort='store_id';
            $order='DESC';
        }

        $field='s.*,m.user_name';
        $join=' LEFT JOIN '.__MEMBER__.' m ON s.store_id=m.user_id';
        $lists=M('Store s')->field($field)->join($join)->where($map)->order($sort.' '.$order)->select();

        $grades=D('Sgrade')->get_options();


        $states=array(
            C('STORE_APPLYING')  => '待审核',
            C('STORE_OPEN')  => '开启',
            C('STORE_CLOSED')  => '关闭'
        );

        $this->assign('lists',$lists);
        $this->assign('sgrades', $grades);
        $this->assign('states',$states);
        $this->assign('filter',empty($map)?0:1);
        $this->display();
    }

    public function edit()
    {
        if(!IS_POST){
            $id=I('get.id',0,'intval');
            if(!$id){
                $this->error('ID不能为空');
            }
            $list=M('Store')->where('store_id='.$id)->find();

            if ($list['certification']){
                $certs = explode(',', $list['certification']);
                foreach ($certs as $cert){
                    $list['cert_' . $cert] = 1;
                }
            }

            //店铺分类
            $scategories=D('Scategory')->getAll();
            $data=array();
            foreach($scategories as $v){
                $data[$v['cate_id']]=array(
                    'id'=>$v['cate_id'],
                    'name'=>$v['cate_name'],
                    'pid'=>$v['parent_id']
                );
            }
            unset($scategories);

            $scates=M('CategoryStore')->where('store_id='.$list['store_id'])->find();
            $html_tree=getTreeOption($data,$scates['cate_id']);

            //店铺认证
            $sgrade=D('Sgrade')->get_options();

            //获取地区
            $regions=D('Region')->get_options(0);
            $this->assign('regions',$regions);

            $this->assign('list',$list);
            $this->assign('html_tree',$html_tree);
            $this->assign('sgrade',$sgrade);
            $this->display();
        }else{
            $cate_id=I('post.cate_id',0,'intval');
            if($cate_id>0){
                $cate_store_mod=M('CategoryStore');
                $cate_store_mod->where('store_id='.I('post.store_id'))->delete();
                $cate_store_mod->add(array('store_id'=>I('post.store_id'),'cate_id'=>$cate_id));
            }

            $store_mod=M('Store');
            if($data=$store_mod->create()){
               $certs = array();
                I('post.autonym')==1 && $cert[]='autonym';
                I('post.material')==1 && $cert[]='material';
                $data['certification']=empty($cert)?'':implode(',',$cert);
                $data['end_time']=strtotime($data['end_time']);
                if(false!==$store_mod->save($data)){
                    $this->success('编辑成功',U('store/index'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($this->getError());
            }
        }
    }

    public function batch_edit()
    {

    }

    public function check_name()
    {
        $id=I('get.id',0,'intval');
        $store_name=I('get.store_name','','trim');
        $list=M('Store')->where('store_id<>'.$id.' AND store_name="'.$store_name.'"')->find();
        if(!empty($list)){
            echo json_encode(false);
        }else{
            echo json_encode(true);
        }
    }
}
