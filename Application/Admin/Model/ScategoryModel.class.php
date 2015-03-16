<?php
namespace Admin\Model;
use Think\Model;
class ScategoryModel extends Model
{
    /**
     * 取分类列表
     * @param int $parent_id 大于等于0表示取某分类的下级分类，小于0表示取所有分类
     * @param bool $shown 只取要显示的分类
     * @param int $store_id 取店铺分类
    */
    public function getAll($parent_id=-1)
    {
        $map=array();
        $parent_id >= 0 && $map['parent_id']=$parent_id;

        return $this->where($map)->order('sort_order,cate_id')->select();
    }

    /**
     * 取得某分类的层级(从1开始算起)
     * @param int $id 分类id
     * @param bool $cached 是否缓存（缓存数据不包括不显示的分类，一般用于前台，非缓存数据包括不显示的分类，一般用于后台）
     * @return int 层级 当分类不存在或不显示时返回false
    */
    public function get_layer($id,$cached=false)
    {
        $ancestor=$this->get_ancestor($id,$cached);
        if(empty($ancestor))
        {
            return false;
        }else{
            return count($ancestor);
        }
    }

    /**
     * 取得某分类的祖先分类（包括自身，按层级排序）
     *
     * @param   int     $id     分类id
     * @param   bool    $cached 是否缓存（缓存数据不包括不显示的分类，一般用于前台；非缓存数据包括不显示的分类，一般用于后台）
     * @return  array(
     *              array('cate_id' => 1, 'cate_name' => '数码产品'),
     *              array('cate_id' => 2, 'cate_name' => '手机'),
     *              ...
     *          )
     */
    public function get_ancestor($id,$cached)
    {
        $res=array();
        if($cached)
        {
            $data=$this->_get_structured_data();
            if($id>0 && isset($data[$id])){
                while($id>0){
                    $res[]=array('cate_id'=>$id,'cate_name'=>$data[$id]['name']);
                    $id=$data[$id]['pid'];
                }
            }
        }else{
            while($id>0){
                $map['id']=$id;
                $map['store_id']=$store_id;
                $row=$this->field('cate_id,cate_name,parent_id')->where($map)->find();
                if($row){
                    $res[]=array('cate_id'=>$row['id'],'cate_name'=>$row['name']);
                    $id=$row['parent_id'];
                }
            }
        }
        return array_reverse($res);
    }

    /**
     * 取得结构化的分类数据（不包括不显示的分类，数据会缓存）
     *
     * @return array(
     *      0 => array(                             'cids' => array(1, 2, 3))
     *      1 => array('name' => 'abc', 'pid' => 0, 'cids' => array(2, 3, 4)),
     *      2 => array('name) => 'xyz', 'pid' => 1, 'cids' => array()
     * )
     *    分类id        分类名称             父分类id     子分类ids
    */
    function _get_structured_data()
    {
        $data = array(0 => array('cids' => array()));

        $cate_list = $this->getAll(-1, true);
        foreach ($cate_list as $id => $cate)
        {
            $data[$id] = array(
                'name' => $cate['cate_name'],
                'pid'  => $cate['parent_id'],
                'cids' => array()
            );
        }

        foreach ($cate_list as $id => $cate)
        {
            $pid = $cate['parent_id'];
            isset($data[$pid]) && $data[$pid]['cids'][] = $id;
        }
        return $data;
    }
}