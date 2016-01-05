<?php
namespace Admin\Widget;
use Think\Controller;
class AuthPowerWidget extends Controller {
	public function userpower(){
	    $auth_groups    =   D('AuthGroup')->getGroups();
        $this->assign('auth_groups',$auth_groups);
        $this->display('Widget/Power/userpower');
	}
    public function categorypower(){
        $group_list     =   D('Category')->getTree();
        $this->assign('group_list',     $group_list);
        //var_dump($group_list);
        $this->display('Widget/Power/categorypower');
    }
}
?>