{{-- 每頁都要出現的東西 --}}
<!DOCTYPE html>
<html lang="tw">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        {{-- 掛載CSS樣式 --}}
        
	    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css"/>
	    <link rel="stylesheet" href="/open-iconic-master/font/css/open-iconic-bootstrap.css"/>
	    <link rel="stylesheet" href="/gijgo/css/gijgo.min.css"/> {{-- gijgo datepicker css --}}
	    <link rel="stylesheet" href="/css/rwd_table.css"/> {{-- table rwd --}}
	    <link rel="stylesheet" href="/css/background.css"/> {{-- background css --}}

	    {{-- 掛載JS樣式 --}}
	    <script src="/js/jquery-3.4.1.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/jquery.validate.min.js"></script>
	    <script src="/js/jquery-validation-1.19.1/dist/localization/messages_zh_TW.js"></script>

	    {{-- bootstarp有用到jQuery的js, 所以要放在jquery後面 --}}
	    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script> 
	    <script src="/gijgo/js/gijgo.min.js"></script> {{-- gijgo datepicker js --}}

	    {{-- 前端驗證 jquery validated --}}
	    <script>
	    	$(document).ready(function(){//加在各自的VIEW
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
	            	rules:{
	            		id:{ 
	                        remote:{
	                            url:"{{ action('WelcomeController@signup') }}",
	                            type:"post",
	                            data:{ //post到signup的request
	                            	id:function(){
	                                	return $("#id").val();
	                            	},
	                            	checkid:function(){
	                                	return "1";
	                            	},
	                            	_token:function() {
	                            		return "{{ csrf_token() }}";
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
        @yield("title")
    </head>
	<body>
		<div class="container">
			{{-- 最上排登入登出 --}}
			<div class="sign d-flex justify-content-end">
				<ul class="list-inline mt-1">
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

			{{-- center 88 留言板 Card+media --}}
			<div class="card text-white bg-secondary mb-3">
				<div class="card-body">
					<div class="media">
						<img class="mr-3" src="/img/post-it.png" style="width: 10%; height: 10%;" alt="Generic placeholder image">
						<div class="align-self-center media-body">
							<a class="display-4 text-decoration-none text-reset" href="/welcome">CENTER 88 留言板</a>
						</div>
					</div>
				</div>
			</div>

			{{-- 導覽列 --}}
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
    			<a class="navbar-brand">搜尋</a>
    			{{-- 搜尋功能(用get) --}}
    			<form class="form-inline mr-auto" action="{{ action('WelcomeController@searchMsg') }}" method="get">
    				<div class="input-group">
						<input class="form-control" type="search" placeholder="Search title or msg" name="searchInput" value="{{ isset($searchInput) ? $searchInput : '' }}">
						<div class="input-group-append">
							<button class="btn btn-outline-success" type="submit">Search</button>
						</div>
					</div>
				</form>
				{{-- 會員功能:新增留言|修改密碼|修改會員資料|我的留言 --}}
    			@if(session("login_id"))
    				<a class="navbar-brand ml-auto">會員專區</a> {{-- ml-auto:把會員專區的brand margin-left all --}}
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    			<span class="navbar-toggler-icon"></span>
		    		</button>
		    		{{-- flex-grow-0:原本navbar-collapse預設flex-grow-1填滿,讓navbar-brand在最左邊,如果要把navbar-brand放右邊要取消flex-grow-1 --}}
		    		<div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent"> 
		            	<ul class="navbar-nav text-right"> {{-- text-right:下放選單 字在右邊 --}}
							<li class="nav-item"><a class="nav-link" href="/welcome/create">新增留言</a></li>
							<li class="nav-item dropdown"> {{-- 下拉選單 --}}
								<a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown">修改資料</a>
								<div class="dropdown-menu text-lg-left text-md-right" aria-labelledby="navbarDropdown">
								    <a class="dropdown-item" href="/welcome/modifyPwd">修改密碼</a>
								    <a class="dropdown-item" href="/welcome/modifyInfo">修改會員資料</a>
								</div>
							</li>
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
				<h2 class="display-4" style="text-align:center; margin-bottom:30px;">
					@yield("content-title")
				</h2>
				@yield("content")
	    	</div>
	    </div>
	</body>
</html>