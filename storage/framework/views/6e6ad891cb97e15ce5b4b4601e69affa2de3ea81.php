
<!DOCTYPE html>
<html lang="tw">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        
	    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css"/>
	    <link rel="stylesheet" href="/open-iconic-master/font/css/open-iconic-bootstrap.css"/>
	    <link rel="stylesheet" href="/gijgo/css/gijgo.min.css"/> 
	    <link rel="stylesheet" href="/css/rwd_table.css"/> 
	    <link rel="stylesheet" href="/css/background.css"/> 

	    
	    <script src="/js/jquery-3.4.1.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/jquery.validate.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/localization/messages_zh_TW.js"></script>

	    
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script> 
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.js"></script>
	    <script src="/gijgo/js/gijgo.min.js"></script> 

	    
	    <script>
	    	$(document).ready(function(){
	    		//由controller發送alert
	    		var msg = "<?php echo e(session('alert')); ?>";
			    var exist = "<?php echo e(session('alert') != null); ?>";
			    if(exist){
			    	alert(msg);
			    };

			    //所有表單的前端required驗證
	    		$(".form1").validate();

	    		//註冊頁面驗證:帳號重複、密碼重複驗證
            	$("#signupForm").validate({
	            	rules:{
	            		id:{ 
	                        remote:{
	                            url:"<?php echo e(action('WelcomeController@signup')); ?>",
	                            type:"post",
	                            data:{ //post到signup的request
	                            	id:function(){
	                                	return $("#id").val();
	                            	},
	                            	checkid:function(){
	                                	return "1";
	                            	},
	                            	_token:function() {
	                            		return "<?php echo e(csrf_token()); ?>";
	                            	},
								}
							}  
						},
	                	password_confirmation:{
					    	equalTo: "#password"
					    },
	        		},
	        		messages:{
	        			id:{
	        				remote:"帳號已有人使用!"
	        			},
	    				password_confirmation:{
	    					equalTo:"密碼驗證不符!" //同rule的function名稱 ex. equalTo/remote/required...
	    				},
	    			}
	            });
	            
	            //修改密碼頁面驗證:密碼重複驗證
            	$("#modifyPwdForm").validate({
	            	//debug:true,
	            	rules:{
	                	password_confirmation:{
					    	equalTo: "#password"
					    },
	        		},
	        		messages:{
	        			password_confirmation:{
	    					equalTo:"密碼驗證不符!"
	    				},
	    			}
	            });

	            //日期選單gijgo datepicker
	            $("#birtydaypicker").datepicker({
	            	format: 'yyyy-mm-dd',
	            	minDate: "1900-01-01",
		            uiLibrary: "bootstrap4",
		            /*icons: {
		           		rightIcon: "<span class='oi oi-calendar' title='calendar'></span>"
		   			},*/
		        });

		        //刪除確認
		        $(".form_del").submit(function(){
					if(confirm("確定要刪除嗎?"))
						return true;
					else
						return false;
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
							<button class="btn btn-dark" onclick="location.href='<?php echo e(action('WelcomeController@logout')); ?>'">
								Logout
							</button>
						</li>
					<?php else: ?>
						<li class="list-inline-item">
							<button class="btn btn-primary" onclick="location.href='<?php echo e(action('WelcomeController@loginView')); ?>'">
								Login
							</button>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			
			<div class="card text-white bg-secondary mb-3">
				<div class="card-body">
					<a class="display-4 text-decoration-none text-reset" href="/welcome">CENTER 88 留言板</a>
				</div>
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
		        			<li class="nav-item"><a class="nav-link" href="/welcome/modifyPwd">修改密碼</a></li>
		        			<li class="nav-item"><a class="nav-link" href="/welcome/modifyInfo">修改會員資料</a></li>
		        			<li class="nav-item"><a class="nav-link" href="/welcome/myMsg">我的留言</a></li>
		                </ul>
		            </div>
				<?php endif; ?>
			</nav>

			
			<?php if(session("success") != "" || (isset($success) && $success != "")): ?>
		      	<div class="alert alert-success" role="alert" style="text-align:center; margin:5px;">
		          	<span>
		          		<?php echo isset($success) && $success != "" ? $success : ""; ?>

		          		<?php echo (session("success") != "") ? session("success") : ""; ?>

		          	</span>
		        </div>	
		    <?php endif; ?>
		    <?php if(session("fail") != "" || (isset($fail) && $fail != "") || $errors->any()): ?> 
		        <div class="alert alert-danger" role="alert" style="text-align:center; margin:5px;">
		        	<ul class="list-unstyled">
		        		<?php if($errors->any()): ?>
							<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><?php echo e($error); ?></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						<li>
							<span>
								<?php echo isset($fail) && $fail != "" ? $fail : ""; ?>

				          		<?php echo (session("fail") != "") ? session("fail") : ""; ?>

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