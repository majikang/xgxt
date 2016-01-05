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
    		
	<!--全部开始-->
	<div class="tab-wrap">
		<!-- 标签页头 -->
		<form action="<?php echo U('stu_save','id='.$list['id']);?>" method="post" class="form-inline form-horizontal" role="form">
		<div class="cf">
	<div class="fl">



<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#stu_acad" role="tab" data-toggle="tab">学籍信息</a></li>
  <li role="presentation"><a href="#stu_natu" role="tab" data-toggle="tab">自然信息</a></li>
  <li role="presentation"><a href="#stu_cont" role="tab" data-toggle="tab">联系信息</a></li>
  <li role="presentation"><a href="#stu_stud" role="tab" data-toggle="tab">学业排名信息</a></li>
  <li role="presentation"><a href="#stu_rewa" role="tab" data-toggle="tab">奖惩情况信息</a></li>
  <li role="presentation"><a href="#stu_work" role="tab" data-toggle="tab">任职情况信息</a></li>
  <li role="presentation"><a href="#stu_sskh" role="tab" data-toggle="tab">宿舍情况信息</a></li>
</ul>









<!--

		<ul class="nav nav-tabs" role="tablist">
			<li <?php if(($id) == "1"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('edit','id='.$list['id']);?>">学籍信息</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('stu_nature_information','id='.$list['id']);?>">自然信息</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('stu_contact_information','id='.$list['id']);?>">联系信息</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('stu_study_rank','uid='.$list['uid']);?>">学业排名信息</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a href="<?php echo U('stu_reward_punishment','uid='.$list['uid']);?>">奖惩情况信息</a>
			</li>
			<li <?php if(($id) == "2"): ?>class="active"<?php endif; ?>>
				<a class="btn" href="<?php echo U('stu_work','uid='.$list['uid']);?>">任职情况信息</a>
			</li>
		</ul>
-->
	</div>
</div>
<br/>

			<!--内容开始-->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane" id="stu_rewa">
			  		

<!-- 子导航 -->

<!-- 数据表格 -->
    <div class="data-table table-responsive my-notice-table">
		<table class="table table-bordered table-hover">
		<tr class="info">
			<td>学期</td>
			<td>奖惩情况</td>
		</tr>
		 <?php if(is_array($jc)): $i = 0; $__LIST__ = $jc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($data["xq"]); ?></td>
            <td><?php echo ($data["jcqk"]); ?></td>
           </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
	</div>


			    </div>
			    <div role="tabpanel" class="tab-pane" id="stu_sskh">
			  		

<!-- 子导航 -->

<!-- 数据表格 -->
    <div class="data-table table-responsive my-notice-table">
		<table class="table table-bordered table-hover">
		<tr class="info">
			<td>时间</td>
			<td>宿舍情况</td>
		</tr>
		 <?php if(is_array($ss)): $i = 0; $__LIST__ = $ss;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($data["time"]); ?></td>
            <td><?php echo ($data["sfdb"]); ?></td>
           </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
	</div>


			    </div>
				<div role="tabpanel" class="tab-pane" id="stu_work">
				  	


<!-- 数据表格 -->
    <div class="data-table table-responsive my-notice-table">
		<table class="table table-bordered table-hover">
		<tr class="info">
			<td>学期</td>
			<td>任职情况</td>
		</tr>
		 <?php if(is_array($rz)): $i = 0; $__LIST__ = $rz;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($data["xq"]); ?></td>
            <td><?php echo ($data["rzqk"]); ?></td>
           </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
	</div>


				</div>

				<div role="tabpanel" class="tab-pane" id="stu_stud">
				    






    <div class="table-responsive my-notice-table">
		<table class="table table-bordered table-hover">
		<thead>
			<tr class="info">
				<td>学期</td>
				<td>智育排名</td>
				<td>智育百分比</td>
				<td>德育排名</td>
				<td>德育百分比</td>
				<td>不及格门数</td>
			</tr>
		</thead>
		<tbody>
			 <?php if(is_array($xy)): $i = 0; $__LIST__ = $xy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
			            <td><?php echo ($data["xq"]); ?></td>
			            <td><?php echo ($data["zypm"]); ?></td>
			            <td><?php echo ($data["zybfb"]); ?></td>
			            <td><?php echo ($data["dypm"]); ?></td>
			            <td><?php echo ($data["dybfb"]); ?></td>
			            <td><?php echo ($data["bjg"]); ?></td>
		           </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        </table>
	</div>


				</div>

			    <div role="tabpanel" class="tab-pane" id="stu_cont">
			  	    <div class="data-table">
					    <form class="form-inline" role="form">
						    
			<div class="form-item">					
				<label class="item-label">公寓</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-time"></span>
						<select class="form-control" name="dormitory" disabled="disabled">
	                        <?php if(is_array($dormitory)): foreach($dormitory as $key=>$xbgy): ?><option value="<?php echo ($xbgy["bh"]); ?>" <?php if(($xbgy["bh"]) == $list['xbgydm']): ?>selected<?php endif; ?>><?php echo ($xbgy["mc"]); ?></option><?php endforeach; endif; ?>
						</select>
				</div>
			</div>
			<br/>

			<div>
				<label>寝室号</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control"  name="xbqsh" value="<?php echo ($list["xbqsh"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>家庭地址（县）</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control"  name="zzmm" value="<?php echo ($list["zzmmm"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>家庭住址（村）</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control"  name="csrq" value="<?php echo get_student_code($list['xbtxdzszddm'],'xzqh','TabCodeSys');?>">
				</div>
			</div>
			<br/>
			<div>
				<label>通讯地址（县）</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="zzmm" value="<?php echo ($list["xbtxdzszddm"]); ?>">
				</div>
			</div><!--省市区三级联动-->
			<br/>
			<div>
				<label>村/街道号</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="xxm" value="<?php echo ($list["xxm"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>邮政编码</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="zjxy" value="<?php echo ($list["zjxy"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>电子信箱</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control"  name="dzxx" value="<?php echo ($list["dzxx"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>主页地址</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="zydz" value="<?php echo ($list["zydz"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>联系电话</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="lxdh" value="<?php echo ($list["lxdh"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>手机号码</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="xbsjhm" value="<?php echo ($list["xbsjhm"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>QQ号码</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="xbqq" value="<?php echo ($list["xbqq"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>特长</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" name="tc" value="<?php echo ($list["tc"]); ?>">
				</div>
			</div>
			<br/>
			<button type="submit" class="btn btn-default submit-btn ajax-post" target-form="form-horizontal">修改</button>
            <button class="btn btn-default btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>



					    </form>
				    </div>
			    </div>

			    <div role="tabpanel" class="tab-pane" id="stu_natu">
				    <div class="data-table">
				    	<form class="form-inline" role="form">
								
	<!-- 数据表格 -->
 
        <!-- 列表 -->
			<div>					
				<label>性别</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo get_student_code($list['xbm'],'xb','TabCodeSys');?>" name="xbm">
				</div>
			</div>
			<br/>
			<div>
				<label>民族</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="mzm" value="<?php echo get_student_code($list['mzm'],'mz','TabCodeSys');?>">
				</div>
			</div>
			<br/>
			<div class="form-item">
				<div>					
					<label class="item-label">政治面貌</label>
					<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-time"></span>
							<select class="form-control" name="zzmmm" disabled="disabled">
	                            <?php if(is_array($political)): foreach($political as $key=>$zzmm): ?><option value="<?php echo ($zzmm["bh"]); ?>" <?php if(($zzmm["bh"]) == $list['zzmmm']): ?>selected<?php endif; ?>><?php echo ($zzmm["mc"]); ?></option><?php endforeach; endif; ?>
							</select>
					</div>
				</div>
			</div>
			<br/>
			<div>
				<label>出生日期</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="csrq" value="<?php echo ($list["csrq"]); ?>">
				</div>
			</div>
			<br/>
			<div>
				<label>籍贯</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="jgm" value="<?php echo ($list["jgm"]); ?>">
				</div>
			</div>
			<br/>
			<div class="form-item">
				<div>					
					<label class="item-label">血型</label>
					<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-time"></span>
							<select class="form-control" name="xxm" disabled="disabled">
	                            <?php if(is_array($blood_type)): foreach($blood_type as $key=>$xx): ?><option value="<?php echo ($xx["bh"]); ?>" <?php if(($xx["bh"]) == $list['xxm']): ?>selected<?php endif; ?>><?php echo ($xx["mc"]); ?></option><?php endforeach; endif; ?>
							</select>
					</div>
				</div>
			</div>
			<br/>
			<div class="form-item">
				<div>					
					<label class="item-label">宗教信仰</label>
					<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-time"></span>
							<select class="form-control" name="zjxy" disabled="disabled">
                            <?php if(is_array($faith)): foreach($faith as $key=>$zjxy): ?><option value="<?php echo ($zjxy["bh"]); ?>" <?php if(($zjxy["bh"]) == $list['zjxy']): ?>selected<?php endif; ?>><?php echo ($zjxy["mc"]); ?></option><?php endforeach; endif; ?>
							</select>
					</div>
				</div>
			</div>
			<br/>
			<div>
				<label>出生地</label><!-- 省市三级联动 -->
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="csdm" value="<?php echo get_student_code($list['csdm'],'xzqh','TabCodeSys');?>">
				</div>
			</div>
			<br/>
			<div>
				<label>户口所在地</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" name="hkszd" value="<?php echo get_student_code($list['hkszd'],'xzqh','TabCodeSys');?>">
				</div>
			</div>
			<br/>
			<div class="form-item">
				<div>					
					<label class="item-label">户口性质</label>
					<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-time"></span>
							<select class="form-control" name="xxm" disabled="disabled">
	                            <option value="1" <?php if(($$list['hkxzm']) == "1"): ?>selected<?php endif; ?>>农业户口</option>
	                            <option value="2" <?php if(($$list['hkxzm']) == "2"): ?>selected<?php endif; ?>>非农业户口</option>
                            </foreach>
							</select>
					</div>
				</div>
			</div>
			<br/>
	<!--		<div>
				<label>乘坐区间</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["xbccqj"]); ?>">
				</div>
			</div>
			<br/>      -->
			<div class="form-item">
				<div>					
					<label class="item-label">家庭特殊情况</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-time"></span>
						<select class="form-control" name="xbxjzt" disabled="disabled">
                            <option value="1" <?php if(($$list['xbxjzt']) == "1"): ?>selected<?php endif; ?>>无</option>
                            <option value="2" <?php if(($$list['xbxjzt']) == "2"): ?>selected<?php endif; ?>>单亲</option>
                            <option value="5" <?php if(($$list['xbxjzt']) == "5"): ?>selected<?php endif; ?>>父母离异</option>
                            <option value="9" <?php if(($$list['xbxjzt']) == "9"): ?>selected<?php endif; ?>>孤儿</option>
						</select>
					</div>
				</div>
			</div>
			<br/>
	<!--		<div>
				<label>建档情况</label>
				<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list[""]); ?>">
				</div>
			</div>
			<br/>     -->
			<div class="form-item">
				<div>					
					<label class="item-label">健康情况</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-time"></span>
						<select class="form-control" name="jkzkm" disabled="disabled">
                            <option value="1" <?php if(($$list['jkzkm']) == "1"): ?>selected<?php endif; ?>>健康或良好</option>
                            <option value="2" <?php if(($$list['jkzkm']) == "2"): ?>selected<?php endif; ?>>一般或较弱</option>
                            <option value="3" <?php if(($$list['jkzkm']) == "5"): ?>selected<?php endif; ?>>有慢性病</option>
                            <option value="6" <?php if(($$list['jkzkm']) == "9"): ?>selected<?php endif; ?>>残疾</option>
						</select>
					</div>
				</div>
			</div>
			<br/>
			<div class="form-item">
				<div>					
					<label class="item-label">婚姻状况</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-time"></span>
						<select class="form-control" name="hyzkm" disabled="disabled">
                            <option value="1" <?php if(($$list['hyzkm']) == "1"): ?>selected<?php endif; ?>>未婚</option>
                            <option value="2" <?php if(($$list['hyzkm']) == "2"): ?>selected<?php endif; ?>>已婚</option>
                            <option value="3" <?php if(($$list['hyzkm']) == "3"): ?>selected<?php endif; ?>>丧偶</option>
                            <option value="4" <?php if(($$list['hyzkm']) == "4"): ?>selected<?php endif; ?>>离婚</option>
                            <option value="9" <?php if(($$list['hyzkm']) == "9"): ?>selected<?php endif; ?>>其他</option>
						</select>
					</div>
				</div>
			</div>
			<br/>
			<button type="submit" class="btn btn-default submit-btn ajax-post" target-form="form-horizontal">修改</button>
            <button class="btn btn-default btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
			<br/>
    

				    	</form>
				    </div>
			    </div>
				<!-- 数据表格 -->
				<div role="tabpanel" class="tab-pane active" id="stu_acad">
				    <div class="data-table">
				    	<form class="form-inline" role="form">
				    		<div role="tabpanel" class="tab-pane" id="stu_edit">
		    			<div class="form-group">
								<label>照片</label>
									<div class="input-group">
			  						<img src="/xgxt/Public/Admin/phone/<?php echo ($list["xh"]); ?>.jpg" width="80px">
								</div>
							</div>
							<br/>
							<br/>
							<div>
								<label>学号</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-user"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["xh"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>校园卡号</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["uid"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>身份证</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-phone"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["sfzh"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>学生姓名</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["title"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>姓名拼音</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-user"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["name"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>曾用名</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-phone"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["cym"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>入学年月</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["rxny"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>学生类别</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo get_student_code($list['stulbm'],'xslb','TabCodeSys');?>">
								</div>
							</div>
							<br/>
							<div>
								<label>学制</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["xz"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>预计毕业年度</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["xbybynd"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>学籍状况</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo get_student_code($list['xbxjzt'],'xbxjzt','TabCodeSys');?>">
								</div>
							</div>
							<br/>
							<div>
								<label>校区</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo get_student_code($list['xbxq'],'_xbxq');?>">
								</div>
							</div>
							<br/>
							<div>
								<label>院系</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo (get_student_code($list["ystuh"])); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>专业</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo get_student_code($list['zyklm'],'_bzkzy');?>">
								</div>
							</div>
							<br/>
							<div>
								<label>年级</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["nj"]); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>班级</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo (get_class_code($list["category_id"])); ?>">
								</div>
							</div>
							<br/>
							<div>
								<label>生源地</label>
								<div class="input-group">
			  						<span class="input-group-addon glyphicon glyphicon-text-height"></span>
			  						<input type="text" class="form-control" disabled="disabled" value="<?php echo ($list["xbsyddm"]); ?>">
								</div>
							</div>
		    		</div>
		    		<br/>
		    		<button class="btn btn-default btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
				    	</form>
					</div>
				</div>
			</div>
			<!-- 内容结束-->
		</form>
	</div>
	<!-- 全部结束-->

    	</div>	
    	</div>
    </div>

    
    
    
    
    <script src="/xgxt/Public/Admin/scripts/lib/require.js" data-main="/xgxt/Public/Admin/scripts/common"></script>
     
    
</body>
</html>