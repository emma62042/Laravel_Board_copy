<?php $__env->startSection("title"); ?>
	<title>TestLogin</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content-title"); ?>
    Login
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
	
    <form name="form1" method="post" action="<?php echo e(action('UsersController@login')); ?>">
        <input name="_token" type="hidden" value="<?php echo e(csrf_token()); ?>">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-10 col-lg-6">
	            <tr>
	            	<th>帳號</th>
	            	<td>
	            		<input class="form-control" type="text" name="id" value="<?php echo e(isset($id) ? $id : old('id')); ?>" required>
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
        <button class="btn btn-secondary" onclick="location.href='<?php echo e(action('UsersController@create')); ?>'">
        	去註冊→
        </button>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>