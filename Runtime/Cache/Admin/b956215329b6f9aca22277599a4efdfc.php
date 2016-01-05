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
        <h2><?php if(isset($data)): ?>[ <?php echo ($data["title"]); ?> ] 子<?php endif; ?>菜单管理 </h2>
    </div>

    <div class="cf">
	    <div class="btn-group">
		    <button type="button" class="btn btn-default" >
			    <a href="<?php echo U('add',array('pid'=>I('get.pid',0)));?>">
			    	新增
			    </a>
		    </button>
		     <button class="btn btn-default ajax-get confirm"  url="<?php echo U('del');?>" target-form="ids">删 除</button>
		</div>
		<div class="sleft search-type">
			<div class="form-group has-success has-feedback">
			  <input type="text" value="<?php echo I('name');?>" name="name" class="form-control serach-input-type"  placeholder="请输入菜单名称">
			  <a class="sch-btn" href="javascript:;" id="xgxt-search-box" url="<?php echo U('',array('pid'=>I('get.pid',0)));?>"><span class="glyphicon glyphicon-search form-control-feedback"></span></a>
			</div>
		</div>

        <!--  高级搜索 
        <div class="search-form fr cf">
        
            <div class="sleft">
                <input type="text" name="title" class="search-input" value="<?php echo I('title');?>" placeholder="请输入菜单名称">
                <a class="sch-btn" href="javascript:;" id="search" url="/xgxt/admin.php?s=/Menu/index/pid/0.html&name=1"><i class="btn-search"></i></a>
            </div>
        

        </div> -->
    </div>





    <br/>
    <div class="table-responsive my-notice-table">
					  <table class="table table-bordered table-hover">
					    <thead>
						    <tr class="info">
						        <th class="row-selected"><input class="checkbox check-all" type="checkbox"></td>
		                        <td>ID</td>
		                        <td>图标</td>
		                        <td>名称</td>
		                        <td>上级菜单</td>
		                        <td>分组</td>
		                        <td>URL</td>
		                        <td>排序</td>
		                        <td>仅开发者模式显示</td>
		                        <td>隐藏</td>
		                        <td>操作</td>
						    </tr>
					    </thead>
					    <tbody>
					    <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
							    <td>
							   <input class="ids row-selected" type="checkbox" name="id[]"  value="<?php echo ($menu['id']); ?>">
							    </td>
							    <td>
							    	<?php echo ($menu["id"]); ?>
							    </td>
							    <td>
							    	<span class="$menu.icon"></span>
							    </td>
							    <td>
							    	<a href="<?php echo U('index?pid='.$menu['id']);?>"><?php echo ($menu["title"]); ?></a>
							    </td>
							    <td>
							    	<?php echo ((isset($menu["up_title"]) && ($menu["up_title"] !== ""))?($menu["up_title"]):'无'); ?>
							    </td>
					    		<td>
					    			<?php echo ($menu["group"]); ?>
					    		</td>
					    		<td>
					    			<?php echo ($menu["url"]); ?>
					    		</td>
					    		<td>
					    			<?php echo ($menu["sort"]); ?>
					    		</td>
					    		<td>
					    			<a href="<?php echo U('toogleDev',array('id'=>$menu['id'],'value'=>abs($menu['is_dev']-1)));?>" class="ajax-get">
                            			<?php echo ($menu["is_dev_text"]); ?>
                            		</a>
					    		</td>
					    		<td>
					    			<a href="<?php echo U('toogleHide',array('id'=>$menu['id'],'value'=>abs($menu['hide']-1)));?>" class="ajax-get">
                            			<?php echo ($menu["hide_text"]); ?>
                            		</a>
					    		</td>
					    		<td>
					    			<a title="编辑" href="<?php echo U('edit?id='.$menu['id']);?>">
					    				编辑
					    			</a>
                            		<a class="confirm ajax-get" title="删除" href="<?php echo U('del?id='.$menu['id']);?>">
                            			删除
                            		</a>
								</td>					    
							  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
							<?php else: ?>
							<td colspan="10" class="text-center"> aOh! 暂时还没有内容! </td><?php endif; ?>
					    </tbody>
					  </table>
					  <div class="page">

        			  </div>
					</div>
    </div>

    	</div>	
    	</div>
    </div>

    
    
    
    
    <script src="/xgxt/Public/Admin/scripts/lib/require.js" data-main="/xgxt/Public/Admin/scripts/common"></script>
    
    <script type="text/javascript">
        $(function() {
            //搜索功能
            $("#search").click(function() {
                var url = $(this).attr('url');
                var query = $('.search-form').find('input').serialize();
                query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g, '');
                query = query.replace(/^&/g, '');
                if (url.indexOf('?') > 0) {
                    url += '&' + query;
                } else {
                    url += '?' + query;
                }
                window.location.href = url;
            });
            //回车搜索
            $(".search-input").keyup(function(e) {
                if (e.keyCode === 13) {
                    $("#search").click();
                    return false;
                }
            });
            //导航高亮
            highlight_subnav('<?php echo U('index');?>');
            //点击排序
        	$('.list_sort').click(function(){
        		var url = $(this).attr('url');
        		var ids = $('.ids:checked');
        		var param = '';
        		if(ids.length > 0){
        			var str = new Array();
        			ids.each(function(){
        				str.push($(this).val());
        			});
        			param = str.join(',');
        		}

        		if(url != undefined && url != ''){
        			window.location.href = url + '/ids/' + param;
        		}
        	});
        });
    </script>

    
</body>
</html>