<?php
namespace Admin\Controller;
class RegionController extends AdminController
{
    public function index()
    {
        $region_mod=M('Region');
        $this->display();
    }
}