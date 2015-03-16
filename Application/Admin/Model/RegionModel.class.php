<?php
namespace Admin\Model;
use Think\Model;
class RegionModel extends Model
{
    public function getAll($parent_id = -1)
    {
        if ($parent_id >= 0){
            return $this->where('parent_id='.$parent_id)->select();
        }else{
            return $this->select();
        }
    }

    /**
     * 取得options，用于下拉列表
     */
    public function get_options($parent_id = 0)
    {
        $res = array();
        $regions = $this->getAll($parent_id);
        foreach ($regions as $region)
        {
            $res[$region['region_id']] = $region['region_name'];
        }
        return $res;
    }
}