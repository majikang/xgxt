<?php
namespace Admin\Controller;
use Think\Controller\RestController;
Class TestController extends RestController {
    protected $allowMethod    = array('get','post','put');
    protected $allowType      = array('html','xml','json');
    Public function read_get_html(){
        // 输出id为1的Info的html页面
    }

    Public function read_get_xml(){
        // 输出id为1的Info的XML数据
    }
    Public function read_xml(){
        // 输出id为1的Info的XML数据
    }
    Public function read_json(){
        // 输出id为1的Info的json数据
        echo "34";
    }
    Public function rest() {
     switch ($this->_method){
      case 'get': // get请求处理代码
           if ($this->_type == 'html'){
           		echo "html";
           }elseif($this->_type == 'json'){
           		echo "json";
           }
           break;
      case 'put': // put请求处理代码
           break;
      case 'post': // post请求处理代码
           break;
     }
   }
}
