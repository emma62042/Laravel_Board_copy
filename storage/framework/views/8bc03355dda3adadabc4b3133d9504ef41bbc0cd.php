<?php $__env->startSection("title"); ?>
	<title>TestLogin</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <h2 style="text-align:center;">Login</h2>

    
    <form class="form1" name="form1" method="post" action="<?php echo e(action('WelcomeController@login')); ?>">
        <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
	            <tr>
	            	<th>帳號</th>
	            	<td>
	            		<input class="form-control" type="text" name="id" value="<?php echo e(old('id')); ?>" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th>密碼</th>
	            	<td>
	            		<input class="form-control" type="password" name="password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >登入</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  

       
    <div style="text-align:center; margin:5px;">
        <button class="btn btn-secondary" onclick="location.href='<?php echo e(action('WelcomeController@signupView')); ?>'">
        	去註冊→
        </button>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>