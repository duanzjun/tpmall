<?php
namespace Admin\Model;
use Think\Model;
class SgradeModel extends Model
{
    function get_options()
    {

        $key='sgrade_options';
        $options=S($key);
        if($options === false)
        {
            $options = array();
            $sgrades = $this->select();
            foreach ($sgrades as $sgrade)
            {
                $options[$sgrade['grade_id']] = $sgrade['grade_name'];
            }
            S($key,$options);
        }
        return $options;
    }
}