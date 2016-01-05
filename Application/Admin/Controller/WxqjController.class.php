<?php
namespace Admin\Controller;

class WxqjController extends AdminController{


    /**
    主页--负责跳转
    *
    */
    public function index(){
    	   $uid=session('user_auth.sid');
    	    $list=M()->table('xgxt_auth_group_access this0,xgxt_auth_group this1')
    	    ->where("this0.uid='$uid' and this0.group_id=this1.id")
    	    ->field('this1.title title')->select();
    	    var_dump($list);
  	    switch ($list[0]['title']) {
    	    	case '学生':
    	    		$this->redirect('Wxqj/StuIndex');
    	    		break;
    	    	case '辅导员':
    	    		$this->redirect('Wxqj/TecList');
    	    		break;
    	    	case '学院副书记':
    	    		$this->redirect('Wxqj/TecList');
    	    		break;
    	    	case '学工处领导':
    	    		$this->redirect('Wxqj/List');
    	    		break;
    	    }
    }
/**
        学生用户     显示主页面
*/	
	public function StuIndex(){
      
	//$this->Time();//计算请假时间差
        var_dump(session('user_auth.uids'));
    	$this->display("Wxqj/htmls/StuIndex");//这里显示学生主页模板
    }

/**
        学生用户     显示主页面
*/  
    public function StuList(){
        //$this->CheckTodayQj();
		$Wxqj=M(wxqj);  
    	$condition['wxqj_cardno'] = session('user_auth.sid');//校园卡卡号
    	$condition['wxqj_state'] = 0 ;//未销假状态
    	$result = $Wxqj->where($condition)->order('wxqj_id desc')->limit(10)->select();
    	//var_dump($condition);
    	$this->assign('list',$result);
    	$this->display("Wxqj/htmls/StuList");//这里显示学生请假列表模板*/

    }
    public function StuForm(){
        if ($this->Checkjzdh()==null) {
            $error['dianhua'] ='家长电话未填写！';
        }else {
            $error['dianhua'] = null;
        }
        if ($this->CheckXiaojia()==false) {
            $error['xiaojia'] ='你还有假条未销假,不能请假！';
        }else {
            $error['xiaojia'] =null;
        }
        if ($this->CheckTodayQj()==false) {//判断当天是否还可以请假
            $error['doday'] ='老师拒绝后24小时不准请假！';
        }else {
            $error['today'] = null;
        }  
        $this->assign('error',$error);
        $this->display("Wxqj/htmls/StuForm"); 
    }
    /**
    请假表单处理页面
    */
    public function StuFormHandle(){
            date_default_timezone_set('prc');
            $data['wxqj_cardno'] = session('user_auth.sid');;//请假人卡号
            $data['wxqj_qjlb'] = I('wxqj_qjlb');//请假类别
            $data['wxqj_jjlxr'] = I("wxqj_jjlxr");//紧急联系人
            $data['wxqj_jjlxrdh'] = I("wxqj_jjlxrdh");//紧急联系人手机号
            $data['wxqj_jzyj'] = I("wxqj_jzyj");//家长是否知情
            $data['wxqj_kssj'] = I('wxqj_kssj');//请假开始时间
            $data['wxqj_jssj'] = I('wxqj_jssj');//请假结束时间
            $data['wxqj_qjsy'] =I('wxqj_qjsy');//请假理由
            $data['wxqj_state'] =0;//销假状态
            $data['wxqj_sqsj']=date('Y-m-d h:i:s');//申请时间
            $ip = get_client_ip();
            $data['wxqj_sqrip'] = $ip;//申请人ip
            $data['wxqj_shyj']='0';//审核意见，提交时为0未处理
            
            //判断时间
            $time=$this->TimeCel($data['wxqj_kssj'],$data['wxqj_jssj']);
            if ($time>71) {
                $data['wxqj_qjshr']=1;
                $data['wxqj_shrkh']=8;//这里后面需要数据库查询，并添加辅导员和书记卡号
            } else {
               $data['wxqj_qjshr']=0;
               $data['wxqj_shrkh']=7;
            }
            
            //提交数据   
            //$result = M('Wxqj')->add($data);
            if ($result) {
                echo "<script type='text/javascript'>alert(1111111);</script>";
                //$this->success("请假申请已提交，请等待回复...","Wxqj/StuList");
                $this->redirect('Wxqj/StuList');
            } else {
                echo "<script type='text/javascript'>alert(1111111);</script>";
                //$this->error("申请提交失败，请重新提交",addons_url("Wxqj://Wxqj/StuFormHandle"));
                $this->redirect('Wxqj/StuForm');
            }           
    }
/**
        验证家长电话是否存在
*/  
    public function Checkjzdh(){
        //通过session里面的校园卡号查询家长联系电话，存在返回true，不存在返回错误信息
        $jzhm=M(stu_jtcy);  
        $condition['stuid'] = 3020122579;//校园卡卡号
        $result = $jzhm->where($condition)->field('xbsjhm')->limit(1)->select();
        
        return $result['0']['xbsjhm'];//这里显示学生请假列表模板
    }
/**
        验证是否已经销假
*/ 
    public function CheckXiaojia(){
        $Wxqj=M(wxqj);  
        $condition['wxqj_cardno'] = 3020120278;
        $condition['wxqj_state'] = 0;//未销假状态
        $condition['wxqj_shyj'] = 2;//审核通过
        $result = $Wxqj->where($condition)->order('wxqj_sqsj desc')->select();
        if ($result) {
            return false;//存在未销假行为
        } else {
            return true;
        }   
    }
/**
        验证当天是否还可以再请假
*/ 
    public function CheckTodayQj(){
        $Wxqj=M(wxqj);  
        $condition['wxqj_cardno'] = 3020120278;
        $result = $Wxqj->where($condition)->field('wxqj_sqsj,wxqj_shsj')->select();
        $cel=$this->TimeCel($result[0]['wxqj_sqsj'],$result[0]['wxqj_shsj']);
        if ($cel>=24) {
           return ture;//
        } else {
           return false;
        }
    }


/**
    计算请假时间
    */
    public function Time($startdate,$enddate){

        //PHP计算两个时间差的方法 
        /*$startdate= date('Y-m-d H:i:s',time());
        $enddate="2014-12-12 11:45:09";*/
        $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
        $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
        $minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
        $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
        echo $date."天".$hour."小时".$minute."分钟";
        //echo $second."秒<br>";

    }
  /**
       计算时间差——————返回类型  float【72小时】
*/   
    public function TimeCel($cel1,$cel2){
            $cel1=strtotime($cel1);
            $cel2=strtotime($cel2);
            //$cel=$cel2-$cel1;
            $cel=floor(($cel2-$cel1)/3600);
            return $cel;
    }





/**
       副书记和辅导员     显示主页面
*/	
    public function TecIndex(){
        
        $this->TecCheck();	 
		$Wxqj=M(wxqj);  
    	$condition['wxqj_shrkh'] = $_SESSION['uid'];
        $condition['wxqj_shyj'] = 0;
    	$result = $Wxqj->where($condition)->order('wxqj_id desc')->select();
    	//print_r($result);
    	$this->assign('list',$result);
    	$this->display("./Addons/Wxqj/View/htmls/TecIndex.html");//这里显示老师审核列表
    }
/**
       副书记和辅导员     审批页面
*/  
    public function TecDetail(){  
        $this->TecCheck();  
        $wxqj_cardno=I('uid');
        $Wxqj=M(wxqj);  
        $condition['wxqj_id'] = $wxqj_cardno;
        $result = $Wxqj->where($condition)->select();
        
        $this->assign('list',$result);
        $this->display("./Addons/Wxqj/View/htmls/TecDetail.html");//这里显示老师审核列表
    }
/**
       副书记和辅导员     审批结果提交页面
*/  
    public function TecDetailForm(){  
        $this->TecCheck();
        $Wxqj=M(wxqj); 
        if ($_POST[submit1]) {
           $data['wxqj_shyj']=1;
           $condition['wxqj_id']=$_POST[submit1];
        } else if($_POST[submit2]){
           $data['wxqj_shyj']=2;
           $condition['wxqj_id']=$_POST[submit2];
        }

        $result = $Wxqj->where($condition)->save($data);
        //var_dump($result);
        if($result){
            $this->success("批假成功，正在跳转...",addons_url("Wxqj://Wxqj/TecIndex"));
        }else{
            $this->error("批假失败，请重新操作！",addons_url("Wxqj://Wxqj/TecIndex"));
        } 
    }
}































/**
       session结构
*/  

/*array(4) { 
    	    	["onethink_admin"]=> array(4) { 
    	    		["user_auth"]=> array(4) { 
    	    			["uid"]=> int(2) 
    	    			["sid"]=> string(2) "19" 
    	    			["username"]=> string(6) "陈强" 
    	    			["type"]=> int(2) 
    	    		} 
    	    		["user_auth_sign"]=> string(40) "0d4ec1df67ec41d9ab2d313852068abd45e0a233" 
    	    		["ADMIN_MENU_LIST.Student"]=> array(2) { 
    	    			["main"]=> array(2) { 
    	    				[1]=> array(5) { 
    	    					["id"]=> string(1) "2" 
    	    					["title"]=> string(12) "学生管理" 
    	    					["url"]=> string(13) "Student/index" 
    	    					["icon"]=> string(48) "glyphicon glyphicon-book my-navbar-btn-glyphicon" 
    	    					["class"]=> string(7) "current" 
    	    				} 
    	    				[5]=> array(4) { 
    	    					["id"]=> string(3) "130" 
    	    					["title"]=> string(6) "退出" 
    	    					["url"]=> string(13) "Public/logout" 
    	    					["icon"]=> string(51) "glyphicon glyphicon-log-out my-navbar-btn-glyphicon" 
    	    				} 
    	    			} 
    	    			["child"]=> array(2) { 
    	    				["内容"]=> array(0) { } 
    	    				["微信请假"]=> array(1) { 
    	    					[0]=> array(5) { 
    	    						["id"]=> string(3) "161" 
    	    						["pid"]=> string(1) "2" 
    	    						["title"]=> string(12) "微信请假" 
    	    						["url"]=> string(10) "Wxqj/Index" 
    	    						["tip"]=> string(0) "" 
    	    					} 
    	    				} 
    	    			} 
    	    		} 
    	    		["ADMIN_MENU_LIST.Wxqj"]=> array(2) { 
    	    			["main"]=> array(2) { 
    	    				[1]=> array(5) { 
    	    					["id"]=> string(1) "2" 
    	    					["title"]=> string(12) "学生管理" 
    	    					["url"]=> string(13) "Student/index" 
    	    					["icon"]=> string(48) "glyphicon glyphicon-book my-navbar-btn-glyphicon" 
    	    					["class"]=> string(7) "current" 
    	    				} 
    	    				[5]=> array(4) { 
    	    					["id"]=> string(3) "130" 
    	    					["title"]=> string(6) "退出" 
    	    					["url"]=> string(13) "Public/logout" 
    	    					["icon"]=> string(51) "glyphicon glyphicon-log-out my-navbar-btn-glyphicon" 
    	    				} 
    	    			} 
    	    			["child"]=> array(2) { 
    	    				["内容"]=> array(0) { } 
    	    				["微信请假"]=> array(1) { 
    	    					[0]=> array(5) { 
    	    						["id"]=> string(3) "161" 
    	    						["pid"]=> string(1) "2" 
    	    						["title"]=> string(12) "微信请假" 
    	    						["url"]=> string(10) "Wxqj/Index" 
    	    						["tip"]=> string(0) "" 
    	    					} 
    	    				} 
    	    			} 
    	    		} 
    	    	} 
    	    	["_AUTH_LIST_2in,1,2"]=> array(9) { 
    	    		[0]=> string(25) "admin/user/updatepassword" 
    	    		[1]=> string(19) "admin/student/index" 
    	    		[2]=> string(19) "admin/student/index" 
    	    		[3]=> string(19) "admin/public/logout" 
    	    		[4]=> string(22) "admin/student/stu_save" 
    	    		[5]=> string(31) "admin/student/stu_family_member" 
    	    		[6]=> string(18) "admin/student/info" 
    	    		[7]=> string(16) "admin/wxqj/index" 
    	    		[8]=> string(14) "admin/stuindex" 
    	    	} 
    	    	["_AUTH_LIST_22"]=> array(2) { 
    	    		[0]=> string(19) "admin/student/index" 
    	    		[1]=> string(19) "admin/public/logout" 
    	    	} 
    	    	["_AUTH_LIST_21"]=> array(7) { 
    	    		[0]=> string(25) "admin/user/updatepassword"
    	    		 [1]=> string(19) "admin/student/index" 
    	    		 [2]=> string(22) "admin/student/stu_save" 
    	    		 [3]=> string(31) "admin/student/stu_family_member" 
    	    		 [4]=> string(18) "admin/student/info" 
    	    		 [5]=> string(16) "admin/wxqj/index" 
    	    		 [6]=> string(14) "admin/stuindex" 
    	    		} 
    	    	}*/
