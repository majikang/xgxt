<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Admin\Model\AuthGroupModel;
use Think\Page;

/**
 * 后台学生控制器
 * @author huajie <banhuajie@163.com>
 */
class StudentController extends AdminController {

    /* 保存允许访问的公共方法 */
    static protected $allow = array( 'draftbox','mydocument');

    private $cate_id        =   null; //文档分类id

    // /**
    //  * 检测需要动态判断的文档类目有关的权限
    //  *
    //  * @return boolean|null
    //  *      返回true则表示当前访问有权限
    //  *      返回false则表示当前访问无权限
    //  *      返回null，则会进入checkRule根据节点授权判断权限
    //  *
    //  * @author 朱亚杰  <xcoolcc@gmail.com>
    //  */
    // protected function checkDynamic(){
    //     $cates = AuthGroupModel::getAuthCategories(UID);
    //     //var_dump($cates);die;
    //     switch(strtolower(ACTION_NAME)){
    //         case 'index':   //文档列表
    //         case 'add':   // 新增
    //             $cate_id =  I('cate_id');
    //             break;
    //         case 'edit':    //编辑
    //         case 'update':  //更新
    //             $doc_id  =  I('id');
    //             $cate_id =  M('Stu')->where(array('id'=>$doc_id))->getField('category_id');
    //             break;
    //         case 'setstatus': //更改状态
    //         case 'permit':    //回收站
    //             $doc_id  =  (array)I('ids');
    //             $cate_id =  M('Stu')->where(array('id'=>array('in',$doc_id)))->getField('category_id',true);
    //             $cate_id =  array_unique($cate_id);
    //             break;
    //     }
    //     // if(!$cate_id){
    //     //     return null;//不明
    //     // }elseif( !is_array($cate_id) && in_array($cate_id,$cates) ) {
    //     //     return true;//有权限
    //     // }elseif( is_array($cate_id) && $cate_id==array_intersect($cate_id,$cates) ){
    //     //     return true;//有权限
    //     // }else{
    //     //     return false;//无权限
    //     // }
    // }

    // /**
    //  * 显示左边菜单，进行权限控制
    //  * @author huajie <banhuajie@163.com>
    //  */
    // protected function getMenu(){
    //     //获取动态分类
    //     $cate_auth  =   AuthGroupModel::getAuthCategories(UID); //获取当前用户所有的内容权限节点   
    //     $cate_auth  =   $cate_auth == null ? array() : $cate_auth;
    //     $cate       =   M('Class')->where(array('status'=>1))->field('id,title,pid,allow_publish')->order('pid,sort')->select();
    //     //var_dump($cate);die;
    //     //没有权限的分类则不显示
    //     if(!IS_ROOT){
    //         foreach ($cate as $key=>$value){
    //             if(!in_array($value['id'], $cate_auth)){
    //                 unset($cate[$key]);
    //             }
    //         }
    //     }

    //     $cate           =   list_to_tree($cate);    //生成分类树

    //     //获取分类id
    //     $cate_id        =   I('param.cate_id');
    //     $this->cate_id  =   $cate_id;

    //     //是否展开分类
    //     $hide_cate = false;
    //     if(ACTION_NAME != 'recycle' && ACTION_NAME != 'draftbox' && ACTION_NAME != 'mydocument'){
    //         $hide_cate  =   true;
    //     }

    //     //生成每个分类的url
    //     foreach ($cate as $key=>&$value){
    //         $value['url']   =   'Student/index?cate_id='.$value['id'];
    //         if($cate_id == $value['id'] && $hide_cate){
    //             $value['current'] = true;
    //         }else{
    //             $value['current'] = false;
    //         }
    //         if(!empty($value['_child'])){
    //             $is_child = false;
    //             foreach ($value['_child'] as $ka=>&$va){
    //                 $va['url']      =   'Student/index?cate_id='.$va['id'];
    //                 if(!empty($va['_child'])){
    //                     foreach ($va['_child'] as $k=>&$v){
    //                         $v['url']   =   'Student/index?cate_id='.$v['id'];
    //                         $v['pid']   =   $va['id'];
    //                         $is_child = $v['id'] == $cate_id ? true : false;
    //                     }
    //                 }
    //                 //展开子分类的父分类
    //                 if($va['id'] == $cate_id || $is_child){
    //                     $is_child = false;
    //                     if($hide_cate){
    //                         $value['current']   =   true;
    //                         $va['current']      =   true;
    //                     }else{
    //                         $value['current']   =   false;
    //                         $va['current']      =   false;
    //                     }
    //                 }else{
    //                     $va['current']      =   false;
    //                 }
    //             }
    //         }
    //     }
    //     $this->assign('nodes',      $cate);
    //     $this->assign('cate_id',    $this->cate_id);
    //     //p($cate);die;
    //     //获取面包屑信息
    //     $nav = get_parent_category($cate_id);
    //     $this->assign('rightNav',   $nav);

    //     //获取回收站权限
    //     //$this->assign('show_recycle', IS_ROOT || $this->checkRule('Admin/article/recycle'));
    //     //获取草稿箱权限
    //     //$this->assign('show_draftbox', C('OPEN_DRAFTBOX'));
    //     //获取审核列表权限
    //     //$this->assign('show_examine', IS_ROOT || $this->checkRule('Admin/article/examine'));
    // }

    /**
     * 分类文档列表页
     * @param integer $cate_id 分类id
     * @param integer $model_id 模型id
     */
    public function index($cate_id = null, $model_id = null){
        //获取左边菜单
        //  $this->getMenu();
        //获得当前班级id
        if($cate_id===null){
            $cate_id = $this->cate_id;
        }
        if(!empty($cate_id)){
            $pid = I('pid',0);
            // 获取列表绑定的模型
            if ($pid == 0) {    //班级列表，没有什么用
                $models     =   get_category($cate_id, 'model');
				// 获取分组定义
				$groups		=	get_category($cate_id, 'groups');
				if($groups){
					$groups	=	parse_field_attr($groups);
                    echo $group;
				}
            }else{ // 子班级列表(各班级的列表，里面是各班级的学生)
                $models     =   get_category($cate_id, 'model_sub');
            }
            if(is_null($model_id) && !is_numeric($models)){
                // 绑定多个模型 取基础模型的列表定义
                $model = M('Model')->getByName('stu');
            }else{
                $model_id   =   $model_id ? : $models;
                //获取模型信息
                $model = M('Model')->getById($model_id);
                if (empty($model['list_grid'])) {
                    $model['list_grid'] = M('Model')->getFieldByName('stu','list_grid');
                }                
            }
            //p($models);die;
            $this->assign('model', explode(',', $models));
        }else{
            // 获取基础模型信息
            $model = M('Model')->getByName('stu');
            $model_id   =   null;
            $cate_id    =   0;
            $this->assign('model', null);
        }

        //解析列表规则
        $fields =	array();

        //解析分组情况
        $grids  =	preg_split('/[;\r\n]+/s', trim($model['list_grid']));
        //p($grids);
        foreach ($grids as &$value) {
            // 字段:标题:链接
            $val      = explode(':', $value);
            // 支持多个字段显示
            $field   = explode(',', $val[0]);
            $value    = array('field' => $field, 'title' => $val[1]);
            if(isset($val[2])){
                // 链接信息
                $value['href']  =   $val[2];
                // 搜索链接信息中的字段信息
                preg_replace_callback('/\[([a-z_]+)\]/', function($match) use(&$fields){$fields[]=$match[1];}, $value['href']);
            }
            if(strpos($val[1],'|')){
                // 显示格式定义
                list($value['title'],$value['format'])    =   explode('|',$val[1]);
            }
            foreach($field as $val){
                $array  =   explode('|',$val);
                $fields[] = $array[0];
            }
        }

        // 文档模型列表始终要获取的数据字段 用于其他用途
        $fields[] = 'class_id';
        $fields[] = 'model_id';
        // 过滤重复字段信息
        $fields =   array_unique($fields);
        // 列表查询
        $list   =   $this->getStuList($cate_id,$model_id,$fields);
        // 列表显示处理
        //p($list);echo "</br></br>";
        //parseDocumentList 解析DocumentList 将时间格式，并将type，status分析

        //$list   =   $this->parseStuList($list,$model_id);

        //p($list);die;
        $this->assign('model_id',$model_id);
        $this->assign('groups', $groups);
        $this->assign('list',   $list);
        $this->assign('list_grids', $grids);
        $this->assign('model_list', $model);
        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    /**
     * 显示学生信息列表（只显示当前拥有的学生信息）
     * @param integer $cate_id 分类id
     * @param integer $model_id 模型id
     * @param mixed $field 字段列表
     */
    protected function getStuList($cate_id=0,$model_id=null,$field=true){
        /* 查询条件初始化 */
        /*设置相关的查询条件*/
        $map = array();
        //更改map就可以查询出能查看的学生的信息 根据拥有的班级查看权限
        if(!IS_ROOT){//超级管理员可以查看所有信息
            if(session('user_auth.type') == 1){
                $res = array();
                $stu = "uid = ".session('user_auth.uid');
                $result = M('AuthExtend')->where($stu)->field('extend_id')->select();
                foreach ($result as $list) { array_push($res, $list['extend_id']); }
                $map['class_id'] = array('in', $res);
                if($cate_id){
                    $result = explode(",",$cate_id);
                    $map['class_id'] = array('in', $result);
                }
            }elseif (session('user_auth.type') == 2) {
                $map['id'] = session('user_auth.sid');
            }
        }else{//超级管理员可以分班级查看信息
             if($cate_id){
                    $result = explode(",",$cate_id);
                    $map['class_id'] = array('in', $result);
                }
        }
        if(isset($_GET['name'])){
            if(is_numeric($_GET['name'])){
                $map['xh']=   array('like','%'.$_GET['name'].'%');
            }else{
                $map['name']    =   array('like', '%'.(string)$_GET['name'].'%');
            }
        }

        //$map['category_id']
        // 构建列表数据
        $Stu = M('Stu');

        $Stu->alias('STU');
        if(!is_null($model_id)){
            $map['model_id']    =   $model_id;
            //p($Document->getDbFields());die;
            //$field={id,title,update_time,status,view,category_id,model_id,pid}
            if(is_array($field) && array_diff($Stu->getDbFields(),$field)){
                $modelName  =   M('Model')->getFieldById($model_id,'name');
                //p($modelName);die;
                //__DOCUMENT_ == document_article
                //echo __DOCUMENT_;die;
                $Stu->join('__STU_'.strtoupper($modelName).'__ '.$modelName.' ON STU.id='.$modelName.'.id');
                $key = array_search('id',$field);
                if(false  !== $key){
                    unset($field[$key]);
                    $field[] = 'STU.id';
                    //去掉id，重新写入一个字段 DOCUMENT.id
                }
            }            
        }
        // p($Stu->where($map)->select());die;
        $list = $this->lists($Stu,$map,'STU.id DESC',$field);
        //p($list);die;
        /*$list(
            [title] => 0..0321
            [type] => 2
            [update_time] => 1415099185
            [status] => 1
            [view] => 1
            [category_id] => 39
            [model_id] => 2
            [pid] => 0
            [id] => 2
        )*/
        //检查该分类是否允许发布内容
        //将模型中需要使用的变量全部转换为相对应的提示值
        $i = 0;
        foreach ($list as $v) {
            $list[$i]['ystuh'] = get_student_code($v['ystuh']);
            $list[$i]['zyklm'] = get_student_code($v['zyklm'],'_bzkzy');
            $list[$i]['class_id'] = get_class_code($v['class_id']);
            $list[$i]['mzm'] = get_student_code($v['mzm'],'mz','TabCodeSys');
            $list[$i]['xbm'] = get_student_code($v['xbm'],'xb','TabCodeSys');
            $i++;
        }
        $allow_publish  =   get_category($cate_id, 'allow_publish');
        //p($list);die;
        //$this->assign('status', $status);
        $this->assign('allow',  $allow_publish);

        $this->meta_title = '文档列表';
        return $list;
    }

    /**
     * 设置一条或者多条数据的状态
     * @author huajie <banhuajie@163.com>
     */
    public function setStatus($model='Stu'){
        return parent::setStatus('Stu');
    }
//后面的Document还没有改成Stu
  //   /**
  //    * 文档新增页面初始化
  //    * @author huajie <banhuajie@163.com>
  //    */
  //   public function add(){
  //       //获取左边菜单
  //       $this->getMenu();

  //       $cate_id    =   I('get.cate_id',0);
  //       $model_id   =   I('get.model_id',0);
		// $id	=	I('get.group_id','');

  //       empty($cate_id) && $this->error('参数不能为空！');
  //       empty($model_id) && $this->error('该分类未绑定模型！');

  //       //检查该分类是否允许发布
  //       $allow_publish = check_category($cate_id);
  //       !$allow_publish && $this->error('该分类不允许发布内容！');

  //       // 获取当前的模型信息
  //       $model    =   get_document_model($model_id);

  //       //处理结果
  //       $info['pid']            =   $_GET['pid']?$_GET['pid']:0;
  //       $info['model_id']       =   $model_id;
  //       $info['category_id']    =   $cate_id;
		// $info['group_id']		=	$group_id;

  //       if($info['pid']){
  //           // 获取上级文档
  //           $article            =   M('Document')->field('id,title,type')->find($info['pid']);
  //           $this->assign('article',$article);
  //       }

  //       //获取表单字段排序
  //       $fields = get_model_attribute($model['id']);
  //       $this->assign('info',       $info);
  //       $this->assign('fields',     $fields);
  //       $this->assign('type_list',  get_type_bycate($cate_id));
  //       $this->assign('model',      $model);
  //       $this->meta_title = '新增'.$model['title'];
  //       $this->display();
  //   }

    /**
     * 学生详情页面
     * @author 陈强
     */
    public function info(){
        //获取左边菜单
        //$this->getMenu();
        //获取学业排名情况
        $id     =   I('get.id','');
        $uid     =   I('get.uid','');
        if(empty($id)){
            $this->error('参数不能为空！');
        }
        $this->check_is_info($id,$uid);//检查用户是否有权限查看该学生信息
        // 获取详细数据 
        $Stu = D('Stu');
        $data = $Stu->find($id);
        if(!$data){
            $this->error($Stu->getError());
        }

        // 获取当前的模型信息
        $model    =   get_document_model($data['model_id']);
        //p($model);
        $this->assign('list', $data);
        $this->assign('model_id', $data['model_id']);
        $this->assign('model',      $model);
        $this->assign('political',get_political());
        $this->assign('blood_type',get_blood_type());
        $this->assign('faith',get_faith());
        $this->assign('dormitory',get_dormitory());


	        if(empty($uid)){
	            $this->error('参数不能为空！');
	        }// 获取详细数据 
	        $map = "stuid = ".$uid;
	        $Stu = D('StuZxbxxy');
	        $data = $Stu->where($map)->select();
	        $this->assign('xy', $data);

	        //学生奖惩信息
	        $Stu = D('StuZxbxjc');
	        $data = $Stu->where($map)->select();
	        $this->assign('jc', $data);

	        //学生任职情况
	        $Stu = D('StuZxbxrz');
	        $data = $Stu->where($map)->select();
	        $this->assign('rz', $data);

	        //学生宿舍情况
	        $maps = "uid = ".$uid;
	        $Stu = D('StuSskh');
	        $data = $Stu->where($maps)->select();
	        $this->assign('ss', $data);
        //获取表单字段排序
        $fields = get_model_attribute($model['id']);
        $this->assign('fields',     $fields);


        //获取当前分类的文档类型
        $this->assign('type_list', get_type_bycate($data['class_id']));

        $this->meta_title   =   '学籍信息';
        if($this->isMobile()){
            $this->display('mobile_info');
        }else{
            $this->display();
        }
        
    }
    
     /**
     * 学生家庭成员信息页面
     * @author 陈强
     */
    public function stu_family_member(){
        //获取左边菜单
        //$this->getMenu();
        $id     =   I('get.id','');
        $uid     =   I('get.uid','');
        $this->check_is_info($id,$uid);//检查用户是否有权限查看该学生信息
        if(empty($uid)){
            $this->error('参数不能为空！');
        }
        // 获取详细数据 
        $map = "stuid = ".$uid;
        $Stu = D('StuJtcy');
        $data = $Stu->where($map)->select();
        $this->assign('list', $data);

        $this->meta_title   =   '家庭成员信息';
        $this->display();
    }
    /**
     * 修改并保存学生信息
     * @author 陈强
     */
    public function stu_save(){
        $id     =   $_GET['id'];
        if(IS_POST){
            $Stu = D('Stu');
            $data = $Stu->create();
            if($data){
                if($Stu->where(array('id'=>$id))->save()){
                    $this->success('修改成功');
                } else {
                    $this->error('修改失败');
                }
            } else {
                $this->error($Stu->getError());
            }
        } else {
            $this->error('请联系管理员：eroor X1001');
        }
    }

    
     /**
     * 判断当前用户是否有权限来获得点击学生的信息（包括浏览器地址栏传GET方法）
     * @param  integer  $id      所要查询的学生基本信息id
     * @param  integer  $uid      所要查询的学生基本信息校园卡号(和学业情况等有关)
     * @return integer           Y。1有权限，N。返回错误信息 没有权限
     * @author 陈强
     */
    protected function check_is_info($id,$uid){
        //首先判断要查询的id与uid是否对应
        $map = "id = ".$id." AND uid = ".$uid;
        if(!D('Stu')->where($map)->find()) $this->error('您没有权限！');
        if(IS_ROOT) return 1;
        unset($map);
        //其次判断是学生还是后台用户，如果是学生 只能查看自己的
        if(session('user_auth.type') == 1){
            $map = "uid = ".session('user_auth.uid');
            $stu = "id = ".$id;
            $result = M('AuthExtend')->where($map)->field('extend_id')->select();
            $student = D('Stu')->where($stu)->field('class_id')->find();
            foreach ($result as $list) {
               if($list['extend_id'] == $student['class_id'])
                    return 1;
            }
            if($results!=1)
                $this->error("您没有权限查看该学生信息！");
        }elseif (session('user_auth.type') == 2) {
            if($id != session('user_auth.sid'))
                $this->error('您无法查看该学生信息！');
            else
                return 1;
        }
    }
    /**
     * 获取班级树
     * @author 陈强
     */
    public function getTree(){//可以使用protected么？
        //获取动态分类
        $cate_auth  =   AuthGroupModel::getAuthCategories(UID); //获取当前用户所有的内容权限节点   
        $cate_auth  =   $cate_auth == null ? array() : $cate_auth;
        $cate       =   M('Class')->where(array('status'=>1))->field('id,title,pid,allow_publish,college')->order('pid,sort')->select();
        //var_dump($cate);die;
        //没有权限的分类则不显示
        if(!IS_ROOT){
            foreach ($cate as $key=>$value){
                if(!in_array($value['id'], $cate_auth)){
                    unset($cate[$key]);
                }
            }
        }

        $cate           =   list_to_tree($cate);    //生成分类树

        //获取分类id
        $cate_id        =   I('param.cate_id');
        $this->cate_id  =   $cate_id;

        //是否展开分类
        $hide_cate = false;
        if(ACTION_NAME != 'recycle' && ACTION_NAME != 'draftbox' && ACTION_NAME != 'mydocument'){
            $hide_cate  =   true;
        }

        //生成每个分类的url
        foreach ($cate as $key=>&$value){
            $value['url']   =   'Student/index?cate_id='.$value['id'];
            if($cate_id == $value['id'] && $hide_cate){
                $value['current'] = true;
            }else{
                $value['current'] = false;
            }
            if(!empty($value['_child'])){
                $is_child = false;
                foreach ($value['_child'] as $ka=>&$va){
                    $va['url']      =   'Student/index?cate_id='.$va['id'];
                    if(!empty($va['_child'])){
                        foreach ($va['_child'] as $k=>&$v){
                            $v['url']   =   'Student/index?cate_id='.$v['id'];
                            $v['pid']   =   $va['id'];
                            $is_child = $v['id'] == $cate_id ? true : false;
                        }
                    }
                    //展开子分类的父分类
                    if($va['id'] == $cate_id || $is_child){
                        $is_child = false;
                        if($hide_cate){
                            $value['current']   =   true;
                            $va['current']      =   true;
                        }else{
                            $value['current']   =   false;
                            $va['current']      =   false;
                        }
                    }else{
                        $va['current']      =   false;
                    }
                }
            }
        }
        $this->ajaxReturn($cate,'JSON');
        $this->assign('nodes',      $cate);
        $this->assign('cate_id',    $this->cate_id);
        //p($cate);die;
        //获取面包屑信息
        $nav = get_parent_category($cate_id);
        $this->assign('rightNav',   $nav);

        //获取回收站权限
        //$this->assign('show_recycle', IS_ROOT || $this->checkRule('Admin/article/recycle'));
        //获取草稿箱权限
        //$this->assign('show_draftbox', C('OPEN_DRAFTBOX'));
        //获取审核列表权限
        //$this->assign('show_examine', IS_ROOT || $this->checkRule('Admin/article/examine'));
    }
    /**
     * 是否是手机？
     * @author 陈强
     */
    private function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

}