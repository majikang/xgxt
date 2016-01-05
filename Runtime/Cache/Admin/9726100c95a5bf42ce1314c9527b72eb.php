<?php if (!defined('THINK_PATH')) exit();?><label class="item-label">选择需要分配的角色</label></br>
                <select name="group_id">
                <option class="auth_groups" value="0">无</option>
                    <?php if(is_array($auth_groups)): $i = 0; $__LIST__ = $auth_groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option class="auth_groups" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            <input type="hidden" name="batch" value="true">
        <div class="form-item">