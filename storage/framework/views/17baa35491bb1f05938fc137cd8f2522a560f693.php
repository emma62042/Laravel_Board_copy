<?php $__env->startSection("title"); ?>
	<title>TestModifyPwd</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 style="text-align:center;">Modify Password</h2>

    
    <form id="modifyPwdForm" method="post" action="<?php echo e(action('WelcomeController@modifyPwd')); ?>">
        <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
	            <tr>
	            	<th><span style="color:red;">*</span>舊密碼</th>
	            	<td>
	            		<input class="form-control" type="password" name="old_password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th><span style="color:red;">*</span>新密碼</th>
	            	<td>
	            		<input class="form-control" type="password" name="password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th><span style="color:red;">*</span>新密碼確認</th>
	            	<td>
	            		<input class="form-control" type="password" name="password_confirmation" required>
	            	</td>
	            </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >修改密碼</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>