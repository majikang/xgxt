<?php if (!defined('THINK_PATH')) exit();?><i id="norequirejs"></i>
<?php if(is_array($tree)): $i = 0; $__LIST__ = $tree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i; if($list["pid"] == 0): ?><tr class="info ">
        <td class="authMngr-fahr-checkbox">
	<?php else: ?>
		<tr class="s<?php echo ($list["pid"]); ?>">
        <td class="authMngr-son-checkbox"><?php endif; ?>
    	<input class="cate_id" type="checkbox" name="cid[]" value="<?php echo ($list["id"]); ?>">
    </td>
    <?php if($list["pid"] == 0): ?><td class="f<?php echo ($list["id"]); ?>">
	<?php else: ?>    	
		<td><?php endif; ?>
	        <strong><?php echo ($list["title"]); ?></strong>
	    </td>
    </tr>
    <?php if(!empty($list['_'])): echo R('AuthManager/tree', array($list['_'])); endif; ?>
            <script type="text/javascript" src="/xgxt/Public/Admin/scripts/lib/jquery-2.1.1.min.js"></script>
			<script type="text/javascript">
			$(function(){ 
			var id=<?php echo ($list["id"]); ?>;
					
			$(".f"+id).on("click",function(){ 
				$(".s"+id).slideToggle();
		});


			});
				
			</script><?php endforeach; endif; else: echo "" ;endif; ?>