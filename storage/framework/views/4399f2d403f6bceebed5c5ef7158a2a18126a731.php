<?php $__env->startSection("title"); ?>
	<title>TestModifyInfo</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 style="text-align:center;">Modify Info</h2>

    
    <form class="form1" name="form1" method="post" action="<?php echo e(action('WelcomeController@modifyInfo')); ?>">
        <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
	            <tr>
	            	<th><span style="color:red;">*</span>修改email</th>
	            	<td>
	            		<input class="form-control" type="email" name="UserEmail" value="<?php echo e($UserEmail); ?>" required>
	            	</td>
	            </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >修改資料</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>