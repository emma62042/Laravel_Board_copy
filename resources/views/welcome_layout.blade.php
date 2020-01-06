{{-- 每頁都要出現的東西 --}}
<!DOCTYPE html>
<html lang="tw">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- 掛載CSS樣式 -->
        <link rel="stylesheet" href="/css/rwd_table.css"/><!-- table rwd -->
	    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css"/>
	    <link rel="stylesheet" href="/css/background.css"/><!-- background css -->

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
	    		//由controller發送alert
	    		var msg = "{{ session('alert') }}";
			    var exist = "{{ session('alert') != null }}";
			    if(exist){
			    	alert(msg);
			    };

			    //所有表單的前端required驗證
	    		$(".form1").validate();

	    		//註冊頁面驗證:帳號重複、密碼重複驗證
            	$("#signupForm").validate({
	            	//debug:true,
	            	rules:{
	            		id:{ 
	                        remote:{
	                            url:"{{ action('WelcomeController@signup') }}",
	                            type:"post",
	                            data:{
	                            	id:function(){
	                                	return $("#id").val();
	                            	},
	                            	checkid:function(){
	                                	return "1";
	                            	},
	                            	_token:function() {
	                            		return "{{ csrf_token() }}";
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
	            
	            //修改密碼頁面驗證:密碼重複驗證
            	$("#modifyPwdForm").validate({
	            	//debug:true,
	            	rules:{
	                	password_confirmation:{
					    	equalTo: "#password"
					    }
	        		},
	        		messages:{
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
        @yield("title")
    </head>
	<body>
		<div class="container">
			{{-- 最上排登入登出 --}}
			<div class="sign d-flex justify-content-end">
				<ul class="list-inline">
					@if(session("login_id"))
						<li class="list-inline-item">welcome {{ session("login_name") }} (id = {{ session("login_id") }})</li>
						<li class="list-inline-item">
							<button class="btn btn-dark" onclick="location.href='{{ action('WelcomeController@logout') }}'">
								Logout
							</button>
						</li>
					@else
						<li class="list-inline-item">
							<button class="btn btn-primary" onclick="location.href='{{ action('WelcomeController@loginView') }}'">
								Login
							</button>
						</li>
					@endif
				</ul>
			</div>

			{{-- center 88 留言板 Card --}}
			<div class="card text-white bg-secondary mb-3">
				<div class="card-body">
					<a class="display-4 text-decoration-none text-reset" href="/welcome">CENTER 88 留言板</a>
				</div>
			</div>


			{{-- 導覽列 --}}
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
    			<a class="navbar-brand">留言板</a>
    			{{-- 搜尋功能用get --}}
    			<form class="form-inline mr-auto" action="{{ action('WelcomeController@searchMsg') }}" method="get">
					<input class="form-control mr-sm-2" type="search" placeholder="Search title or msg" name="searchInput" value="{{ isset($searchInput) ? $searchInput : '' }}">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
				{{-- 會員功能:新增留言 --}}
    			@if(session("login_id"))
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
				@endif
			</nav>

			{{-- 一些alert，顯示在content上面 --}}
			@if(session("success") != "" || (isset($success) && $success != ""))
		      	<div class="alert alert-success" role="alert" style="text-align:center; margin:5px;">
		          	<span>
		          		{!! isset($success) && $success != "" ? $success : "" !!}
		          		{!! (session("success") != "") ? session("success") : "" !!}
		          	</span>
		        </div>	
		    @endif
		    @if(session("fail") != "" || (isset($fail) && $fail != "") || $errors->any()) {{-- 輸出ERROR ALERT --}}
		        <div class="alert alert-danger" role="alert" style="text-align:center; margin:5px;">
		        	<ul class="list-unstyled">
		        		@if($errors->any())
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						@endif
						<li>
							<span>
								{!! isset($fail) && $fail != "" ? $fail : "" !!}
				          		{!! (session("fail") != "") ? session("fail") : "" !!}
				          	</span>
				        </li>
					</ul>
		        </div>
		    @endif

		    {{-- 主要顯示區間content --}}	
			<div class="content">
				@yield("content")
	    	</div>
	    </div>
	</body>
</html>