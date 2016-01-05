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
    		
	<div class="main-title">
		<h2>系统设置</h2>
	</div>
	<div class="tab-wrap">
		<ul class="nav nav-tabs" role="tablist">
			<li <?php if(($id) == "1"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('?id=1');?>">学期配置</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('?id=2');?>">学校配置</a>
			</li>
		</ul>
		<div class="tab-content">
			<form action="<?php echo U('save');?>" method="post" class="form-horizontal form-inline">
				<br/>
				<?php if(($id) == "1"): ?><div class="form-item">
						<label><?php echo ($list[0]['title']); ?></label>
						<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-time"></span>
								<input type="text" class="form-control" name="config[<?php echo ($list[0]['name']); ?>]" value="<?php echo ($list[0]['value']); ?>">
						</div>
					</div>
					<br/>
					<div class="form-item">
						<div>					
							<label class="item-label"><?php echo ($list[1]['title']); ?></label>
							<div class="input-group">
									<span class="input-group-addon glyphicon glyphicon-time"></span>
									<select class="form-control" name="config[<?php echo ($list[1]['name']); ?>]">
										  <option value="春季学期" 
										  <?php if(($list[1]['value']) == "春季学期"): ?>selected<?php endif; ?>>春季学期
										  </option>

										  <option value="秋季学期" 
										  <?php if(($list[1]['value']) == "秋季学期"): ?>selected<?php endif; ?>>秋季学期
										  </option>
									</select>
							</div>
						</div>
					</div>
					<br/>
					<div class="form-item">
						<label class="item-label"><?php echo ($list[2]['title']); ?></label>
						<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-time"></span>
								<input type="date" class="form-control text input-large" name="config[<?php echo ($list[2]['name']); ?>]" value="<?php echo ($list[2]['value']); ?>">
						</div>
					</div>
					<br/>
					<div class="form-item">
						<label class="item-label"><?php echo ($list[3]['title']); ?></label>
						<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-time"></span>
								<input type="date" class="form-control text input-large" name="config[<?php echo ($list[3]['name']); ?>]" value="<?php echo ($list[3]['value']); ?>">
						</div>
					</div>
				    <br/>
					<div class="form-item">
						<div>					
							<label class="item-label"><?php echo ($list[4]['title']); ?></label>
							<div class="input-group">
									<span class="input-group-addon glyphicon glyphicon-off"></span>
									<select class="form-control" name="config[<?php echo ($list[4]['name']); ?>]">
										  <option value="1" <?php if(($list[4]['value']) == "1"): ?>selected<?php endif; ?>>开启
										  </option>
										  <option value="0" <?php if(($list[4]['value']) == "0"): ?>selected<?php endif; ?>>关闭
										  </option>
									</select>
							</div>
						</div>
					</div><?php endif; ?>
				<br/>
				<?php if(($id) == "2"): ?><div class="form-item">
						<label><?php echo ($list[0]['title']); ?></label>
						<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-user"></span>
								<input type="text" class="form-control" name="config[<?php echo ($list[0]['name']); ?>]" value="<?php echo ($list[0]['value']); ?>">
						</div>
					</div>
					<br/>
					<div class="form-item">
						<label><?php echo ($list[1]['title']); ?></label>
						<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-user"></span>
								<input type="text" class="form-control"  name="config[<?php echo ($list[1]['name']); ?>]" value="<?php echo ($list[1]['value']); ?>">
						</div>
					</div><?php endif; ?>

				<div class="form-item">
					<label class="item-label"></label>
					<div class="controls">
						<button type="submit" class="btn submit-btn ajax-post btn-default" target-form="form-horizontal">确认
						</button>
						<button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">重置
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

    	</div>	
    	</div>
    </div>

    
    
    
    
    <script src="/xgxt/Public/Admin/scripts/lib/require.js" data-main="/xgxt/Public/Admin/scripts/common"></script>
    


    
</body>
</html>