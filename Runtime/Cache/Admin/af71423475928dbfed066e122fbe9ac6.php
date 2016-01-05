<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/xgxt/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/xgxt/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/xgxt/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/xgxt/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/xgxt/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
<script type="text/javascript" src="/xgxt/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <div class="main-title cf">
        <h2>编辑 [<?php echo ($model['title']); ?>]</h2>
    </div>
    <!-- 标签页导航 -->
<div class="tab-wrap">
    <ul class="tab-nav nav">
			<?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($key); ?>" <?php if(($key) == "1"): ?>class="current"<?php endif; ?>><a href="javascript:void(0);"><?php echo ($group); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="tab-content">
    <!-- 表单 -->
    <form id="form" action="<?php echo U('edit?model='.$model['id']);?>" method="post" class="form-horizontal">
        <!-- 基础文档模型 -->
		<?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><div id="tab<?php echo ($key); ?>" class="tab-pane <?php if(($key) == "1"): ?>in<?php endif; ?> tab<?php echo ($key); ?>">
            <?php if(is_array($fields[$key])): $i = 0; $__LIST__ = $fields[$key];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i; if($field['is_show'] == 1 || $field['is_show'] == 3): ?><div class="form-item cf">
                    <label class="item-label"><?php echo ($field['title']); ?><span class="check-tips"><?php if(!empty($field['remark'])): ?>（<?php echo ($field['remark']); ?>）<?php endif; ?></span></label>
                    <div class="controls">
                        <?php switch($field["type"]): case "num": ?><input type="text" class="text input-mid" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                            <?php case "string": ?><input type="text" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php break;?>
                            <?php case "textarea": ?><label class="textarea input-large">
                                <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($data[$field['name']]); ?></textarea>
                                </label><?php break;?>
                            <?php case "date": ?><input type="text" name="<?php echo ($field["name"]); ?>" class="text input-mid date" value="<?php echo (date('Y-m-d',$data[$field['name']])); ?>" placeholder="请选择日期" /><?php break;?>
                            <?php case "datetime": ?><input type="text" name="<?php echo ($field["name"]); ?>" class="text input-mid time" value="<?php echo (date('Y-m-d H:i',$data[$field['name']])); ?>" placeholder="请选择时间" /><?php break;?>
                            <?php case "bool": ?><select name="<?php echo ($field["name"]); ?>">
                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($data[$field['name']]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select><?php break;?>
                            <?php case "select": ?><select name="<?php echo ($field["name"]); ?>">
                                    <?php $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if(($data[$field['name']]) == $key): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select><?php break;?>
                            <?php case "radio": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="radio">
                                    <input type="radio" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>" <?php if(($data[$field['name']]) == $key): ?>checked="checked"<?php endif; ?>><?php echo ($vo); ?>
                                	</label><?php endforeach; endif; else: echo "" ;endif; break;?>
                            <?php case "checkbox": $_result=parse_field_attr($field['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label class="checkbox">
                                    <input type="checkbox" value="<?php echo ($key); ?>" name="<?php echo ($field["name"]); ?>[]" <?php if(in_array(($key), is_array($data[$field['name']])?$data[$field['name']]:explode(',',$data[$field['name']]))): ?>checked="checked"<?php endif; ?>><?php echo ($vo); ?>
                                	</label><?php endforeach; endif; else: echo "" ;endif; break;?>
                            <?php case "editor": ?><label class="textarea">
                                <textarea name="<?php echo ($field["name"]); ?>"><?php echo ($data[$field['name']]); ?></textarea>
                                <?php echo hook('adminArticleEdit', array('name'=>$field['name'],'value'=>$data[$field['name']]));?>
                                </label><?php break;?>
                            <?php case "picture": ?><div class="controls">
									<input type="file" id="upload_picture_<?php echo ($field["name"]); ?>">
									<input type="hidden" name="<?php echo ($field["name"]); ?>" id="cover_id_<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
									<div class="upload-img-box">
									<?php if(!empty($data[$field['name']])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($data[$field['name']],'path')); ?>"/></div><?php endif; ?>
									</div>
								</div>
								<script type="text/javascript">
								//上传图片
							    /* 初始化上传插件 */
								$("#upload_picture_<?php echo ($field["name"]); ?>").uploadify({
							        "height"          : 30,
							        "swf"             : "/xgxt/Public/static/uploadify/uploadify.swf",
							        "fileObjName"     : "download",
							        "buttonText"      : "上传图片",
							        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
							        "width"           : 120,
							        'removeTimeout'	  : 1,
							        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
							        "onUploadSuccess" : uploadPicture<?php echo ($field["name"]); ?>,
                                    'onFallback' : function() {
                                        alert('未检测到兼容版本的Flash.');
                                    }
							    });
								function uploadPicture<?php echo ($field["name"]); ?>(file, data){
							    	var data = $.parseJSON(data);
							    	var src = '';
							        if(data.status){
							        	$("#cover_id_<?php echo ($field["name"]); ?>").val(data.id);
							        	src = data.url || '/xgxt' + data.path;
							        	$("#cover_id_<?php echo ($field["name"]); ?>").parent().find('.upload-img-box').html(
							        		'<div class="upload-pre-item"><img src="' + src + '"/></div>'
							        	);
							        } else {
							        	updateAlert(data.info);
							        	setTimeout(function(){
							                $('#top-alert').find('button').click();
							                $(that).removeClass('disabled').prop('disabled',false);
							            },1500);
							        }
							    }
								</script><?php break;?>
                            <?php case "file": ?><div class="controls">
									<input type="file" id="upload_file_<?php echo ($field["name"]); ?>">
									<input type="hidden" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"/>
									<div class="upload-img-box">
										<?php if(isset($data[$field['name']])): ?><div class="upload-pre-file"><span class="upload_icon_all"></span><?php echo (get_table_field($data[$field['name']],'id','name','File')); ?></div><?php endif; ?>
									</div>
								</div>
								<script type="text/javascript">
								//上传图片
							    /* 初始化上传插件 */
								$("#upload_file_<?php echo ($field["name"]); ?>").uploadify({
							        "height"          : 30,
							        "swf"             : "/xgxt/Public/static/uploadify/uploadify.swf",
							        "fileObjName"     : "download",
							        "buttonText"      : "上传附件",
							        "uploader"        : "<?php echo U('File/upload',array('session_id'=>session_id()));?>",
							        "width"           : 120,
							        'removeTimeout'	  : 1,
							        "onUploadSuccess" : uploadFile<?php echo ($field["name"]); ?>,
                                    'onFallback' : function() {
                                        alert('未检测到兼容版本的Flash.');
                                    }
							    });
								function uploadFile<?php echo ($field["name"]); ?>(file, data){
									var data = $.parseJSON(data);
							        if(data.status){
							        	var name = "<?php echo ($field["name"]); ?>";
							        	$("input[name="+name+"]").val(data.data);
							        	$("input[name="+name+"]").parent().find('.upload-img-box').html(
							        		"<div class=\"upload-pre-file\"><span class=\"upload_icon_all\"></span>" + data.info + "</div>"
							        	);
							        } else {
							        	updateAlert(data.info);
							        	setTimeout(function(){
							                $('#top-alert').find('button').click();
							                $(that).removeClass('disabled').prop('disabled',false);
							            },1500);
							        }
							    }
								</script><?php break;?>
                            <?php default: ?>
                            <input type="text" class="text input-large" name="<?php echo ($field["name"]); ?>" value="<?php echo ($data[$field['name']]); ?>"><?php endswitch;?>
                    </div>
                </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>


        <div class="form-item cf">
            <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
            <button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
            <a class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</a>
        </div>
    </form>
    </div>
</div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "/xgxt", //当前网站地址
            "APP"    : "/xgxt/admin.php?s=", //当前项目地址
            "PUBLIC" : "/xgxt/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/xgxt/Public/static/think.js"></script>
    <script type="text/javascript" src="/xgxt/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
<link href="/xgxt/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<?php if(C('COLOR_STYLE')=='blue_color') echo '<link href="/xgxt/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">'; ?>
<link href="/xgxt/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/xgxt/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/xgxt/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
$('#submit').click(function(){
    $('#form').submit();
});

$(function(){
	$('.time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    $('.date').datetimepicker({
        format: 'yyyy-mm-dd',
        language:"zh-CN",
        minView:2,
        autoclose:true
    });
    showTab();
});
</script>

</body>
</html>