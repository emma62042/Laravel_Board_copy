{{-- 註冊畫面 --}}
@extends("welcome_layout")

@section("title")
    <title>TestSignup</title>
@endsection

@section("content-title")
    Signup註冊
@endsection

@section("content")
  	{{-- 註冊表單 --}}
  	<form id="signupForm" method="post" action="{{ action('UsersController@update', ['id'=>'signup']) }}">
      	<input name="_token" id="token" type="hidden" value="{{ csrf_token() }}">
      	<input name="_method" type="hidden" value="put">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-10 col-lg-6">
		      	<tr>
		        	<th><span style="color:red;">*</span>帳號</th>
		        	<td>
		        		<input class="form-control" type="text" id="id" name="id" value="{{ isset($fail) ?  $id : old('id') }}" required>
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
		        		<input class="form-control" type="text" name="nickname" placeholder="未輸入將以id為暱稱" value="{{ isset($fail) ? $id : old('nickname') }}">
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="email" value="{{ old('email') }}" required>
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
		        	<td colspan="2" align="center">
		        		<button class="btn btn-secondary" type="submit" >註冊</button>
		        	</td>
		        </tr>
	      	</table>
	    </div>
	</form>    
@endsection

@section("script")
	<script>
		$(document).ready(function(){//加在各自的VIEW
			//註冊頁面驗證:帳號重複、密碼重複驗證
        	$("#signupForm").validate({
            	rules:{
            		id:{ 
                        remote:{
                            url:"{{ action('UsersController@create') }}",
                            type:"get",
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