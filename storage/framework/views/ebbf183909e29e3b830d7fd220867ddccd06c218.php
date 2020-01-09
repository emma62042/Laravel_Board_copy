<?php $__env->startSection("title"); ?>
    <title>TestSignup</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content-title"); ?>
    Signup註冊
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
  	
  	<form id="signupForm" method="post" action="<?php echo e(action('WelcomeController@signup')); ?>">
      	<input name="_token" id="token" type="hidden" value="<?php echo e(csrf_token()); ?>">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-10 col-lg-6">
		      	<tr>
		        	<th><span style="color:red;">*</span>帳號</th>
		        	<td>
		        		<input class="form-control" type="text" id="id" name="id" value="<?php echo e(isset($fail) ?  $id : old('id')); ?>" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>密碼</th>
		        	<td>
		        		<input class="form-control" type="password" id="password" name="password" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>確認密碼</th>
		        	<td>
		        		<input class="form-control" type="password" name="password_confirmation" placeholder="請再輸入一次密碼" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>暱稱</th>
		        	<td>
		        		<input class="form-control" type="text" name="nickname" placeholder="未輸入將以id為暱稱" value="<?php echo e(isset($fail) ? $id : old('nickname')); ?>">
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="email" value="<?php echo e(old('email')); ?>" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>生日</th>
		        	<td>
		        		
		        		<input id="birtydaypicker" name="birtydaypicker" value="<?php echo e(isset($birthday) ? $birthday : ((old('birtydaypicker') != NULL) ? old('birtydaypicker') : '1995-01-31')); ?>"> 
		        	</td>
		        </tr>
		        <tr>
		        	<td colspan="2" align="center">
		        		<button class="btn btn-secondary" type="submit" >註冊</button>
		        	</td>
		        </tr>
	      	</table>
	    </div>
	</form>     
<?php $__env->stopSection(); ?>
<?php echo $__env->make("welcome_layout", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>