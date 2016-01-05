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
		<h2>权限管理</h2>
	</div>

    <div class="tools auth-botton">
    	<div class="btn-group">
		    <button type="button" class="btn btn-default">
		    	<a id="add-group" href="<?php echo U('createGroup');?>">新 增</a>
		    </button>
		    <button type="button" class="btn btn-default">
		    	<a url="<?php echo U('changestatus?method=resumeGroup');?>" class="ajax-post" target-form="ids" >启 用</a>
		    </button>
		    <button type="button" class="btn btn-default">
		    	 <a url="<?php echo U('changestatus?method=forbidGroup');?>" class="ajax-post" target-form="ids" >禁 用</a>
		    </button>
		    <button type="button" class="btn btn-default">
		    	<a url="<?php echo U('changestatus?method=deleteGroup');?>" class="ajax-post confirm" target-form="ids" >删 除</a>
		    </button>
		</div>
		
		<!--原来按钮
        <a id="add-group" class="btn" href="<?php echo U('createGroup');?>">新 增</a>
        <a url="<?php echo U('changestatus?method=resumeGroup');?>" class="btn ajax-post" target-form="ids" >启 用</a>
        <a url="<?php echo U('changestatus?method=forbidGroup');?>" class="btn ajax-post" target-form="ids" >禁 用</a>
        <a url="<?php echo U('changestatus?method=deleteGroup');?>" class="btn ajax-post confirm" target-form="ids" >删 除</a>
        -->
    </div>
    <br/>

	<!-- 数据列表 -->
	<div class="table-responsive my-notice-table">
	<table class="table table-bordered table-hover">
    <tdead>
        <tr class="info">
		<td class="row-selected row-selected"><input class="check-all" type="checkbox"/></td>
		<td class="">用户角色</td>
		<td class="">描述</td>
		<td class="">授权</td>
		<td class="">状态</td>
		<td class="">操作</td>
		</tr>
    </thead>
    <tbody>
		<?php if(!empty($_list)): if(is_array($_list)): $i = 0; $__LIST__ = $_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><input class="ids" type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>" /></td>
			<td><a href="<?php echo U('AuthManager/editgroup?id='.$vo['id']);?>"><?php echo ($vo["title"]); ?></a> </td>
			<td><span><?php echo mb_strimwidth($vo['description'],0,60,"...","utf-8");?></span></td>


			<td><a href="<?php echo U('AuthManager/access?group_name='.$vo['title'].'&group_id='.$vo['id']);?>" >访问授权</a>
			<a href="<?php echo U('AuthManager/user?group_name='.$vo['title'].'&group_id='.$vo['id']);?>" >成员授权</a>
			</td>
			<td><?php echo ($vo["status_text"]); ?></td>
			<td>
				<?php if(($vo["status"]) == "1"): ?><button class="btn btn-default"><a href="<?php echo U('AuthManager/changeStatus?method=forbidGroup&id='.$vo['id']);?>" class="ajax-get">禁用</a></button>
				<?php else: ?>
				<button class="btn btn-default"><a href="<?php echo U('AuthManager/changeStatus?method=resumeGroup&id='.$vo['id']);?>" class="ajax-get">启用</a></button><?php endif; ?>
				<button class="btn btn-default"><a href="<?php echo U('AuthManager/changeStatus?method=deleteGroup&id='.$vo['id']);?>" class="confirm ajax-get">删除</a></button>
            </td>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		<?php else: ?>
		<td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
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
    
<script type="text/javascript" charset="utf-8">
    //导航高亮
    highlight_subnav('<?php echo U('AuthManager/index');?>');
</script>

    
</body>
</html>