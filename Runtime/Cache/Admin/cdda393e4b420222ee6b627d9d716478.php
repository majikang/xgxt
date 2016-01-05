<?php if (!defined('THINK_PATH')) exit();?>           <div class="category auth-category">
                <div class="hd cf">
                    <div class="fold">折叠</div>
                    <div class="order">选择</div>
                    <div class="name">班级名称</div>
                </div>
                <?php echo R('AuthManager/tree', array($group_list));?>
            </div>