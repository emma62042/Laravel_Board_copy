<?php $__env->startSection("title"); ?>
    <title>TestSys</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;"><?php echo e(isset($searchList) ? "Search result" : "All the Msg"); ?></h2>
  	
  	
    <?php ($msgList = isset($searchList) ? $searchList : $dataList); ?>
    <?php if(sizeof($msgList) > 0): ?>
        <table class="table table-striped table-bordered table-rwd">
        	
        	<tr class="tr-only-hide">
        		<th>#</th>
        		<th>Msg id</th>
        		<th>Title</th>
        		<th>Msg</th>
        		
        		<th>最後修改時間▽</th>
        		<th>作者</th>
        		<th>修改</th>
        		<th>刪除</th>
        	</tr>
        	<?php $__currentLoopData = $msgList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        		<tr>
                    <?php ($msg_number = ($msgList->currentPage()-1)*$msgList->perPage()+$key+1); ?> 
                    
        			<td data-th="#"><?php echo e($msg_number); ?></td>
        			<td data-th="Msg id"><?php echo e($row->msg_id); ?></td>
        			<td data-th="Title"><?php echo e($row->title); ?></td>
        			<td data-th="Msg" class="text-break"><?php echo nl2br($row->msg); ?></td>
        			
        			<td data-th="最後修改時間"><?php echo e($row->updated_at); ?></td>
        			<td data-th="作者"><?php echo e($row->UserName."(".$row->user_id.")"); ?></td>
        			<td data-th="修改">
        				<button class="btn btn-secondary" onclick="location.href='<?php echo e(action('WelcomeController@edit', ['id'=>$row->msg_id])); ?>'">
        	 				Edit
         				</button>
         			</td>
         			<!-- 
         			<td>
         				<form class="form_del0" method="post" action="<?php echo e(action('WelcomeController@delete')); ?>" >
         					<input name="msg_id" type="hidden" value="<?php echo e($row->msg_id); ?>" />
							<input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>" /> 
							<button type="submit">Delete</button>
						</form>
         			</td>
         			 -->
					<form class="form_del" method="post" action="<?php echo e(action('WelcomeController@destroy', ['id'=>$row->msg_id])); ?>" >
						<td data-th="刪除">
         					<input name="_method" type="hidden" value="delete">
							<input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>" /> 
							<button class="btn btn-secondary" type="submit">Delete</button>
             			</td>
         			</form>
        		</tr>
        	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

        
        
        
            
            
        <?php echo isset($searchList) ? $msgList->appends(array("searchInput"=>$searchInput))->links("vendor.pagination.complicated-bootstrap-4") : $msgList->links("vendor.pagination.complicated-bootstrap-4"); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>