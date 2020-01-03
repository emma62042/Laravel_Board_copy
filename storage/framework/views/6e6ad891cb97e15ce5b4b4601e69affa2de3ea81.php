
<!DOCTYPE html>
<html lang="tw">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- 掛載CSS樣式 -->
        <link rel="stylesheet" href="/css/rwd_table.css"/>
	    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css"/>

	    <!-- 掛載JS樣式 -->
	    <script src="/js/jquery-3.4.1.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/jquery.validate.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/localization/messages_zh_TW.js"></script>

	    <!-- bootstarp有用到jQuery的js, 所以要放在jquery後面 -->
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script> 
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.js"></script>

	    <!-- 前端驗證 jquery validated -->
	    <script>
	    	$(document).ready(function(){
	    		$(".form1").validate();
            	$("#signupForm").validate({
	            	//debug:true,
	            	rules:{
	            		id:{ 
	                        remote:{
	                            url:"<?php echo e(action('WelcomeController@signupView')); ?>",
	                            type:"post",
	                            data:{
	                            	id:function(){
	                                	return $("#id").val();
	                            	},
	                            	checkid:function(){
	                                	return "1";
	                            	},
	                            	_token:function() {
	                            		return "<?php echo e(csrf_token()); ?>";
	                            	}
								}
							}  
						},
	                	password_confirmation:{
					    	equalTo: "#password"
					    }
	        		},
	        		messages:{
	        			id:{
	        				remote:"帳號已有人使用!"
	        			},
	    				password_confirmation:{
	    					equalTo:"密碼驗證不符!" //同rule的function名稱 ex. equalTo/remote/required...
	    				}
	    			}
	            });
            });
        </script>
        <style>
        	.error{
	        	color:red;
	        }
        </style>
	    
        <?php echo $__env->yieldContent("title"); ?>
    </head>
	<body>
		<div class="container">
			
			<div class="sign d-flex justify-content-end">
				<ul class="list-inline">
					<?php if(session("login_id")): ?>
						<li class="list-inline-item">welcome <?php echo e(session("login_name")); ?> (id = <?php echo e(session("login_id")); ?>)</li>
						<li class="list-inline-item">
							<button class="btn btn-dark"  onclick="location.href='<?php echo e(action('WelcomeController@logout')); ?>'">
								Logout
							</button>
						</li>
					<?php else: ?>
						<li class="list-inline-item">
							<button class="btn btn-primary"  onclick="location.href='<?php echo e(action('WelcomeController@loginView')); ?>'">
								Login
							</button>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			
			<div class="jumbotron">
				<a class="display-4 text-decoration-none text-reset" href="/welcome">CENTER 88 留言板</a>
			</div>

			
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
    			<a class="navbar-brand">留言板</a>
    			
    			<form class="form-inline mr-auto" action="<?php echo e(action('WelcomeController@searchMsg')); ?>" method="get">
					<input class="form-control mr-sm-2" type="search" placeholder="Search title or msg" name="searchInput" value="<?php echo e(isset($searchInput) ? $searchInput : ''); ?>">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
				
    			<?php if(session("login_id")): ?>
					<a class="navbar-brand">會員專區</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    			<span class="navbar-toggler-icon"></span>
		    		</button>
		    		<div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
		            	<ul class="navbar-nav text-right">
		        			<li class="nav-item"><a class="nav-link" href="/welcome/create">新增留言</a></li>
		                </ul>
		            </div>
		        <?php else: ?>
		        	<div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
		            	<ul class="navbar-nav text-right">
		        			<li class="nav-item"><a class="nav-link" href="/welcome/create">未登入留言</a></li>
		                </ul>
		            </div>
				<?php endif; ?>
			</nav>

			
			<?php if(isset($success) && $success != ''): ?>
		      	<div class="alert alert-success" role="alert" style="text-align:center; margin:5px;">
		          	<span>
		          		<?php echo (isset($success) && $success != '') ?$success :''; ?>

		          	</span>
		        </div>	
		    <?php endif; ?>
		    <?php if((isset($fail) && $fail != '') || $errors->any()): ?> 
		        <div class="alert alert-danger" role="alert" style="text-align:center; margin:5px;">
		        	<ul class="list-unstyled">
		        		<?php if($errors->any()): ?>
							<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><?php echo e($error); ?></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						<li>
							<span>
				          		<?php echo (isset($fail) && $fail != '') ?$fail :''; ?>

				          	</span>
				        </li>
					</ul>
		        </div>
		    <?php endif; ?>

		    	
			<div class="content">
				<?php echo $__env->yieldContent("content"); ?>
	    	</div>
	    </div>
	</body>
</html>