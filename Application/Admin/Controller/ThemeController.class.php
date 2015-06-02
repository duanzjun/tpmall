<?php
namespace Admin\Controller;
class ThemeController extends AdminController
{
    public function index()
    {

        $this->assign('pages');
        $this->display();
    }
}