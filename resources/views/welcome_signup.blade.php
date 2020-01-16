{{-- 註冊/修改會員資料畫面 --}}
@extends("welcome_layout")

@section("title")
    <title>{{ (isset($action) && $action == "edit") ? "TestModifyInfo" : "TestSignup"}}</title>
@endsection

@section("content-title")
    {{ (isset($action) && $action == "edit") ? "Modify Info" : "Signup註冊"}}
@endsection

@section("content")
  	{{-- 註冊/修改會員資料表單 --}}
  	<form id="signupForm" method="post" action="{{ isset($action) ? action('UsersController@update', ['id'=>'modifyInfo']) : 'signup' }}">
      	<input name="_token" id="token" type="hidden" value="{{ csrf_token() }}">
      	<input name="_method" type="hidden" value="put">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-10 col-lg-6">
	        	@if(!isset($action))
			      	<tr>
			        	<th><span style="color:red;">*</span>帳號</th>
			        	<td>
			        		<input class="form-control" type="text" id="id" name="id" value="{{ isset($id) ?  $id : old('id') }}" required>
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
			    @endif
		        <tr>
		        	<th>暱稱</th>
		        	<td>
		        		<input class="form-control" type="text" name="nickname" placeholder="未輸入將以id為暱稱" value="{{ isset($nickname) ? $nickname : old('nickname') }}">
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="email" value="{{ isset($email) ? $email : old('email') }}" required>
		        	</td>
		        </tr>
		        <tr>
		        	<th>生日</th>
		        	<td>
		        		{{-- 使用gijgo的datepicker,header有jquery --}}
		        		<input id="birtydaypicker" name="birtydaypicker" value="{{ isset($birthday) ? $birthday : ((old('birtydaypicker') != NULL) ? old('birtydaypicker') : '1995-01-31')}}"> 
		        	</td>
		        </tr>
		        <tr>
		        	<th>性別</th>
		        	<td>
		        		<div class="form-check form-check-inline">
		        			<input class="form-check-input" type="radio" name="sex" value="M" {{ (isset($sex) && $sex == "M") ? "checked" : ""}}>
							<label class="form-check-label">
								Male
							</label>
		        		</div>
		        		<div class="form-check form-check-inline">
		        			<input class="form-check-input" type="radio" name="sex" value="F" {{ (isset($sex) && $sex == "F") ? "checked" : ""}}>
							<label class="form-check-label">
								Female
							</label>
		        		</div>
		        	</td>
		        </tr>
		        <tr>
		        	<td colspan="2" align="center">
		        		<button class="btn btn-secondary" type="submit" >{{ (isset($action) && $action == "edit") ? "修改資料" : "註冊"}}</button>
		        	</td>
		        </tr>
	      	</table>
	    </div>
	</form>    
@endsection

@section("script")
	{{-- 前端驗證 jquery validated --}}
	<script>
		$(document).ready(function(){//加在各自的VIEW
			//註冊頁面驗證:帳號重複、密碼重複驗證
        	$("#signupForm").validate({
        		submitHandler:function(form){
        			if(confirm("確定要{{ isset($action) ? '修改' : '註冊' }}嗎?"))
	                    form.submit();
				},
            	rules:{
            		id:{ 
                        remote:{
                            url:"{{ action('UsersController@create') }}",
                            type:"get",
                            data:{ //post到signup的request
                            	id:function(){
                                	return $("#id").val();
                            	},
                            	checkid:"1",
                            	_token:"{{ csrf_token() }}",
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

            //日期選單gijgo datepicker
            $("#birtydaypicker").datepicker({
            	format: 'yyyy-mm-dd',
            	minDate: "1900-01-01",
	            uiLibrary: "bootstrap4",
	            /*icons: {
	           		rightIcon: "<span class='oi oi-calendar' title='calendar'></span>"
	   			},*/
	        });
		});
	</script>
@endsection