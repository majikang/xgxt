<?php
/**
 * 代码与代码设置的视图
 */
namespace Admin\Model;

use Think\Model\ViewModel;

class CodeViewModel extends ViewModel {
     public $viewFields = array(
        'tab_code'=>array('id','lx','mc','bh'),
         'tab_code_set'=>array(
             'lxmc',
             '_on'=>'tab_code.lx=tab_code_set.dmlx'),
         ); 
}