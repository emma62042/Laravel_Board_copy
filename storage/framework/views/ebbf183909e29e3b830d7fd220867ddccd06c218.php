<?php $__env->startSection("title"); ?>
    <title>TestSignup</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
  	<h2 style="text-align:center;">Signup註冊</h2>

  	
  	<form id="signupForm" method="post" action="<?php echo e(action('WelcomeController@signup')); ?>">
      	<input name="_token" id="token" type="hidden" value="<?php echo e(csrf_token()); ?>">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
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
		        		<input class="form-control" type="text" name="UserName" placeholder="未輸入將以id為暱稱" value="<?php echo e(isset($fail) ? $id : old('UserName')); ?>">
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="UserEmail" value="<?php echo e(old('UserEmail')); ?>" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>生日</th>
		        	<td>
		        		<input id="birtydaypicker" name="birtydaypicker" value="01/31/1995">
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