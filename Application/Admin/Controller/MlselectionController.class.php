<?php
namespace Admin\Controller;
class MlselectionController extends AdminController
{
    function index()
    {
        in_array(I('get.type'), array('region', 'gcategory')) or $this->json_error('invalid type');
        $pid = I('get.pid',0,'intval');
        switch (I('get.type'))
        {
            case 'region':
                $regions=D('region')->getAll($pid);
                if($regions){
                    foreach ($regions as $key => $region)
                    {
                        $regions[$key]['region_name'] = htmlspecialchars($region['region_name']);
                    }
                    $regions=array_values($regions);
                }
                echo json_encode(array('done'=>true,'retval'=>$regions));
                break;
            case 'gcategory':
                $cates=D('gcategory')->getAll($pid,true);
                if($cates){
                    foreach ($cates as $key => $cate)
                    {
                        $cates[$key]['cate_name'] = htmlspecialchars($cate['cate_name']);
                    }
                    $cates=array_values($cates);
                }
                echo json_encode(array('done'=>true,'retval'=>$cates));
                break;
        }
    }
}