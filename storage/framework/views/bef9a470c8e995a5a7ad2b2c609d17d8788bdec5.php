<?php $__env->startSection("title"); ?>
    <title>TestSys</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;"><?php echo e(isset($searchList) ? "Search result" : (isset($myList) ? "My Msg" : "All the Msg")); ?></h2>
  	
  	
    <?php ($msgList = isset($searchList) ? $searchList : (isset($myList) ? $myList : $dataList)); ?>
    <?php if(sizeof($msgList) > 0): ?>
        <table class="table table-striped table-bordered table-rwd">
        	
        	<tr class="tr-only-hide">
        		<th scope="col" class="text-nowrap">#</th>
        		<th scope="col" class="text-nowrap">Msg id</th>
        		<th scope="col" class="text-nowrap">Title</th>
        		<th scope="col" class="text-nowrap">Msg</th>
        		
        		<th scope="col" class="text-nowrap">最後修改時間▽</th>
        		<th scope="col" class="text-nowrap">作者</th>
                <?php if(session("login_id")): ?>
            		<th scope="col" class="text-nowrap">修改</th>
            		<th scope="col" class="text-nowrap">刪除</th>
                <?php endif; ?>
        	</tr>
        	<?php $__currentLoopData = $msgList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        		<tr>
                    <?php ($msg_number = ($msgList->currentPage()-1)*$msgList->perPage()+$key+1); ?> 
                    
        			<td data-th="#" scope="col" class="text-nowrap"><?php echo e($msg_number); ?></td>
        			<td data-th="Msg id" scope="col" class="text-nowrap"><?php echo e($row->msg_id); ?></td>
        			<td data-th="Title" scope="col" class="text-nowrap"><?php echo e($row->title); ?></td>
        			<td data-th="Msg" class="text-break"><?php echo nl2br($row->msg); ?></td>
        			
        			<td data-th="最後修改時間"><?php echo e($row->updated_at); ?></td>
        			<td data-th="作者" scope="col" class="text-nowrap"><?php echo e($row->nickname."(".$row->user_id.")"); ?></td>
                    <?php if(session("login_id")): ?>
            			<td data-th="修改">
                            <?php if(session("login_id") == $row->user_id): ?>
                				<button class="btn btn-secondary" onclick="location.href='<?php echo e(action('WelcomeController@edit', ['id'=>$row->msg_id])); ?>'">
                	 				Edit
                 				</button>
                            <?php endif; ?>
             			</td>
    					<form class="form_del" method="post" action="<?php echo e(action('WelcomeController@destroy', ['id'=>$row->msg_id])); ?>" >
    						<td data-th="刪除">
                                <?php if(session("login_id") == $row->user_id): ?>
                 					<input name="_method" type="hidden" value="delete">
        							<input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>" /> 
        							<button class="btn btn-secondary" type="submit">Delete</button>
                                <?php endif; ?>
                 			</td>
             			</form>
                    <?php endif; ?>
        		</tr>
        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        
        
        
            
            
        <?php echo isset($searchList) ? $msgList->appends(array("searchInput"=>$searchInput))->links("vendor.pagination.complicated-bootstrap-4") : $msgList->links("vendor.pagination.complicated-bootstrap-4"); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>