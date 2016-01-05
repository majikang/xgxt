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
    		
	<div class="main-title cf">
		<h2><?php if(ACTION_NAME == 'add'): ?>新增<?php else: ?>编辑<?php endif; ?>模型</h2>
	</div>

	<!-- 标签页导航 -->
	<div class="tab-wrap">
		<ul class="tab-nav nav">
			<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
			<li data-tab="tab2"><a href="javascript:void(0);">设 计</a></li>
			<li data-tab="tab3"><a href="javascript:void(0);">高 级</a></li>
		</ul>
		<div class="tab-content">
			<!-- 表单 -->
			<form id="form" action="<?php echo U('update');?>" method="post" class="form-horizontal doc-modal-form">
				<!-- 基础 -->
				<div id="tab1" class="tab-pane in tab1">
					<div class="form-item cf">
						<label class="item-label">模型标识<span class="check-tips">（请输入文档模型标识）</span></label>
						<div class="controls">
							<input type="text" class="text " name="name" value="<?php echo ($info["name"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">模型名称<span class="check-tips">（请输入模型的名称）</span></label>
						<div class="controls">
							<input type="text" class="text " name="title" value="<?php echo ($info["title"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">模型类型<span class="check-tips">（目前只支持独立模型和文档模型）</span></label>
						<div class="controls">
							<select name="extend">
								<option value="0">独立模型</option>
								<option value="1">文档模型</option>
							</select>
						</div>
					</div>
				</div>

				<div id="tab2" class="tab-pane tab2">
					<div class="form-item cf">
						<label class="item-label">字段管理<span class="check-tips">（只有新增了字段，该表才会真正建立）</span></label>

						<div class="controls">
						<div class="form-item cf edit_sort edit_sort_l form_field_sort">
							<span>字段列表 		[ <a href="<?php echo U('Attribute/add?model_id='.$info['id']);?>" target="_balnk">新增</a>
							<a href="<?php echo U('Attribute/index?model_id='.$info['id']);?>" target="_balnk">管理</a> ] </span>
							<ul class="dragsort">
								<?php if(is_array($fields)): foreach($fields as $k=>$field): ?><li >
											<em ><input class="ids" type="checkbox" name="attribute_list[]" value="<?php echo ($field['id']); ?>" <?php if(in_array($field['id'],$info['attribute_list'])): ?>checked="checked"<?php endif; ?> /> <?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
										</li><?php endforeach; endif; ?>
							</ul>
						</div>

						</div>
					</div>
                    <div class="form-item cf">
                        <label class="item-label">字段别名定义<span class="check-tips">（用于表单显示的名称）</span></label>
                        <div class="controls">
                            <label class="textarea input-large">
                                <textarea name="attribute_alias"><?php echo ($info["attribute_alias"]); ?></textarea>
                            </label>
                        </div>
                    </div>
					<div class="form-item cf">
						<label class="item-label">表单显示分组<span class="check-tips">（用于表单显示的分组，以及设置该模型表单排序的显示）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="field_group" value="<?php echo ($info["field_group"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
					<label class="item-label">表单显示排序<span class="check-tips">（直接拖动进行排序）</span></label>
					<?php $_result=parse_field_attr($info['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-item cf edit_sort edit_sort_l form_field_sort">
							<span><?php echo ($vo); ?></span>
							<ul class="dragsort needdragsort" data-group="<?php echo ($key); ?>">
								<?php if(is_array($fields)): foreach($fields as $k=>$field): if((($field['group'] == $key) or($i == 1 and !isset($field['group']))) and ($field['is_show'] == 1)): ?><li class="getSort">
											<em data="<?php echo ($field['id']); ?>"><?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
											<input type="hidden" name="field_sort[<?php echo ($key); ?>][]" value="<?php echo ($field['id']); ?>"/>
										</li><?php endif; endforeach; endif; ?>
							</ul>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>

					<div class="form-item cf">
						<label class="item-label">列表定义<span class="check-tips">（默认列表模板的展示规则）</span></label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="list_grid"><?php echo ($info["list_grid"]); ?></textarea>
							</label>
						</div>
					</div>

					<div class="form-item cf">
						<label class="item-label">默认搜索字段<span class="check-tips">（默认列表模板的默认搜索项）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="search_key" value="<?php echo ($info["search_key"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">高级搜索字段<span class="check-tips">（默认列表模板的高级搜索项）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="search_list" value="<?php echo ($info["search_list"]); ?>">
						</div>
					</div>
				</div>

				<!-- 高级 -->
				<div id="tab3" class="tab-pane tab3">
					<div class="form-item cf">
						<label class="item-label">列表模板<span class="check-tips">（自定义的列表模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_list" value="<?php echo ($info["template_list"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">新增模板<span class="check-tips">（自定义的新增模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_add" value="<?php echo ($info["template_add"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">编辑模板<span class="check-tips">（自定义的编辑模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_edit" value="<?php echo ($info["template_edit"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">列表数据大小<span class="check-tips">（默认列表模板的分页属性）</span></label>
						<div class="controls">
							<input type="text" class="text input-small" name="list_row" value="<?php echo ($info["list_row"]); ?>">
						</div>
					</div>
				</div>

				<!-- 按钮 -->
				<div class="form-item cf">
					<label class="item-label"></label>
					<div class="controls edit_sort_btn">
						<input type="hidden" name="id" value="<?php echo ($info['id']); ?>"/>
						<button class="btn submit-btn ajax-post no-refresh" type="submit" target-form="form-horizontal">确 定</button>
						<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
					</div>
				</div>
			</form>
		</div>
	</div>

    	</div>	
    	</div>
    </div>

    
    
    
    
    <script src="/xgxt/Public/Admin/scripts/lib/require.js" data-main="/xgxt/Public/Admin/scripts/common"></script>
    
<script type="text/javascript" src="/xgxt/Public/static/jquery.dragsort-0.5.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
Think.setValue("extend", <?php echo ((isset($info["extend"]) && ($info["extend"] !== ""))?($info["extend"]):0); ?>);

//导航高亮
highlight_subnav('<?php echo U('Model/index');?>');

$(function(){
	showTab();
})
//拖曳插件初始化
$(function(){
	$(".needdragsort").dragsort({
	     dragSelector:'li',
	     placeHolderTemplate: '<li class="draging-place">&nbsp;</li>',
	     dragBetween:true,	//允许拖动到任意地方
	     dragEnd:function(){
	    	 var self = $(this);
	    	 self.find('input').attr('name', 'field_sort[' + self.closest('ul').data('group') + '][]');
	     }
	 });
})
</script>

    
</body>
</html>