<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|江苏师范大学</title>
    <link href="/xgxt/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/behavior.css" media="all">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/plugin.css" media="all">
	<!--<script type="text/javascript" src="/xgxt/Public/Admin/scripts/lib/jquery-2.1.1.min.js"></script>-->
	<!--<script type="text/javascript" src="/xgxt/Public/Admin/scripts/ajaxapi.js"></script>-->
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/xgxt/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    	<!-- Navbar -->
		<nav class="navbar navbar-default my-navbar" id="my-navbar" role="navigation">
			<!-- container-fluid -->
			<div class="container-fluid">	
				<!-- navbar-header -->
				<div class="navbar-header">
					<button class="navbar-toggle collapsed my-navbar-mobile-menu" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="glyphicon glyphicon-th my-navbar-mobile-menu-glyphicon"></span>
					</button>
					<a class="navbar-brand my-navbar-brand" href="#">
						<span class="my-navbar-brand-title">江苏师范大学</span>
					</a>
				</div>
				<!-- 主导航 -->
			       <div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
					<!-- my-navbar-btn的active是自己写的，切记 -->	
			            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><a class="btn btn-xs my-navbar-btn" href="<?php echo (u($menu["url"])); ?>">
								<span class="<?php echo ($menu["icon"]); ?>"></span> 
								<p class="text-center my-navbar-btn-title"><?php echo ($menu["title"]); ?></p>
							</a><?php endforeach; endif; else: echo "" ;endif; ?>
			        </ul>
				</div>
			</div>
			<!-- container-fluid End -->
		</nav>	
		<!-- Navbar End-->
    <!-- /头部 -->
    <div class="main-container" id="main-container">

    	<div class="my-sidebar" id="my-sidebar">
    	<div id="subnav" class="subnav">
    		<ul class="list-group" >
				<li class="list-group-item text-center hidden-xs my-sidebar-userinfo">
					<span class="my-sidebar-userinfo-title">当前用户：<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></span>
				</li>
				<!-- header Start-->
				<li class="list-group-item text-center my-sidebar-header">
						<span class="my-sidebar-header-title">办公系统</span>
				</li>
				<!-- header End-->
				<?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): ?><li class="list-group-item text-center my-sidebar-btn">
						   		<span class="<?php echo ($style); ?>"></span>
						   		<?php if(!empty($key)): ?><span class="<?php echo next(explode(',',$key));?>"><?php echo current(explode(',',$key));?></span><?php endif; ?>
						</li>
						<ul class="list-group my-sidebar-sub">
							<?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="list-group-item text-center my-sidebar-subbtn" data-index="1">
									<a href="<?php echo (u($menu["url"])); ?>">
										<span class="glyphicon glyphicon-plus-sign my-sidebar-subbtn-glyphicon"></span>
										<span class="my-sidebar-subbtn-title"><?php echo ($menu["title"]); ?></span>	
									</a>		
								</li><?php endforeach; endif; else: echo "" ;endif; ?>
						</ul><?php endif; endforeach; endif; else: echo "" ;endif; ?> 
            </ul>
            </div>
    	</div>
    	<div class="main-content" id="main-content">
    	
    	<div class="content" id="content">
	    	<div id="top-alert" class="fixed alert alert-error" style="display: none;">
	        	<button class="close fixed" style="margin-top: 4px;">&times;</button>
	        <div class="alert-content">这是内容</div>
    </div>
    		
	<!-- 标题栏 -->

	<div class="main-title">
		<h2>用户列表</h2>
	</div>

	<div class="cf">
		<div class="fl">
		<div class="btn-group" style="display:inline;">
			  <button type="button" class="btn btn-default"><a href="<?php echo U('add');?>">新 增</a></button>
			  <button type="button" class="btn btn-default ajax-post" url="<?php echo U('changeStatus?method=resumeUser');?>" target-form="ids">启 用</button>
			  <button type="button" class="btn btn-default ajax-post" url="<?php echo U('changeStatus?method=forbidUser');?>" target-form="ids">禁 用</button>
			  <button type="button" class="btn btn-default ajax-post confirm" url="<?php echo U('changeStatus?method=deleteUser');?>" target-form="ids">删 除</button>
		<div class="sleft search-type" style="display:inline; padding-left=20px;">
			<form class="form-inline">
				<div class="form-group has-success has-feedback">
				  <input type="text" value="<?php echo I('name');?>" name="name" class="form-control serach-input-type"  placeholder="请输入姓名或者校园卡号"><a class="sch-btn" href="javascript:;" id="xgxt-search-box" url="<?php echo U('index');?>"><span class="glyphicon glyphicon-search form-control-feedback"></span></a>
				</div>
			</form>
		</div>
		</div>
		

<!--原来搜索
		<div class="search-form fr cf" style="display:inline;">
			<div class="sleft">
				<input type="text" name="nickname" class="search-input" value="<?php echo I('nickname');?>" placeholder="请输入用户昵称或者ID">
				<a class="sch-btn" href="javascript:;" id="search" url="<?php echo U('index');?>"><i class="btn-search"></i></a>
			</div>
		</div>
-->

		<!--
            <a class="btn" href="<?php echo U('add');?>">新 增</a>
            <button class="btn ajax-post" url="<?php echo U('changeStatus?method=resumeUser');?>" target-form="ids">启 用
            </button>
            <button class="btn ajax-post" url="<?php echo U('changeStatus?method=forbidUser');?>" target-form="ids">禁 用
            </button>
            <button class="btn ajax-post confirm" url="<?php echo U('changeStatus?method=deleteUser');?>" target-form="ids">删 除
            </button>
        -->
    	</div>
        <!-- 高级搜索 -->
    </div>
    <!-- 数据列表 -->
    <br/>
    <div class="table-responsive my-notice-table">
	<table class="table table-bordered table-hover">
    <tdead>
        <tr class="info">
		<td class="row-selected row-selected"><input class="check-all" type="checkbox"/></td>
		<td class="">姓名</td>
		<td class="">姓名拼音</td>
		<td class="">校园卡号</td>
		<td class="">性别</td>
		<td class="">部门</td>
		<td class="">角色</td>
		<td class="">最后登录时间</td>
		<td class="">最后登录IP</td>
		<td class="">状态</td>
		<td class="">操作</td>
		</tr>
    </tdead>
    <tbody>
		<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["uid"]); ?>" /></td>
			<td><?php echo ($vo["name"]); ?></td>
			<td><?php echo ($vo["spell"]); ?></td>
			<td><?php echo ($vo["card"]); ?></td>
			<td><?php if(($vo['sex']) == "1"): ?>男<?php endif; if(($vo['sex']) == "2"): ?>女<?php endif; ?></td>
			<td><?php echo (get_in_department($vo["depart_id"])); ?></td>
			<td><?php echo (get_role($vo["uid"])); ?></td>
			<td><span><?php echo (time_format($vo["last_login_time"])); ?></span></td>
			<td><span><?php echo long2ip($vo['last_login_ip']);?></span></td>
			<td><?php echo ($vo["status_text"]); ?></td>
			<td><?php if(($vo["status"]) == "1"): ?><button type="button" class="btn btn-default"><a href="<?php echo U('User/changeStatus?method=forbidUser&id='.$vo['uid']);?>" class="ajax-get">禁用</a></button>
				<?php else: ?>
				<button type="button" class="btn btn-default"><a href="<?php echo U('User/changeStatus?method=resumeUser&id='.$vo['uid']);?>" class="ajax-get">启用</a></button><?php endif; ?>
				<button type="button" class="btn btn-default"><a href="<?php echo U('AuthManager/group?uid='.$vo['uid']);?>" class="authorize">授权</a></button>
				<button type="button" class="btn btn-default"><a href="<?php echo U('AuthManager/repassword?uid='.$vo['uid']);?>" class="confirm">重置密码</a></button>
				<button type="button" class="btn btn-default"><a href="<?php echo U('AuthManager/category?user_name='.$vo['name'].'&uid='.$vo['uid']);?>">班级授权</a></button>
                <button type="button" class="btn btn-default"><a href="<?php echo U('User/changeStatus?method=deleteUser&id='.$vo['uid']);?>" class="confirm ajax-get">删除</a></button>
                </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
		<td colspan="9" class="text-center">暂时还未填入数据! </td><?php endif; ?>
	</tbody>
    </table>
	</div>
    <div class="page">
        <?php echo ($_page); ?>
    </div>


    	</div>	
    	</div>
    </div>

    
    
    
    
    <script src="/xgxt/Public/Admin/scripts/lib/require.js" data-main="/xgxt/Public/Admin/scripts/common"></script>
    
	<!--<script src="/xgxt/Public/static/thinkbox/jquery.thinkbox.js"></script>

	<script type="text/javascript">
	//回车搜索
	$(".serach-input-type").keyup(function(e){
		if(e.keyCode === 13){
		var url = $("#xgxt-search-box").attr('url');
		 	var query  = $('.search-type').find('input').serialize();
	        query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
	        query = query.replace(/^&/g,'');
	        if( url.indexOf('?')>0 ){
	            url += '&' + query;
	        }else{
	            url += '?' + query;
	        }
			window.location.href = url;
			return false;
		}
	});
    //导航高亮
    highlight_subnav('<?php echo U('User/index');?>');
	</script>-->

    
</body>
</html>