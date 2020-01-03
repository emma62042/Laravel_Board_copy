{{--註冊畫面--}}
@extends("welcome_layout")

@section("title")
    <title>TestSignup</title>
@endsection
@section("content")
  	<h2 style="text-align:center;">Signup註冊</h2>

  	{{--註冊表單--}}
  	<form id="signupForm" method="post" action="{{ action('WelcomeController@signup') }}">
      	<input name="_token" id="token" type="hidden" value="{{ csrf_token() }}">
      	<div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
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
		        		<input class="form-control" type="text" name="UserName" placeholder="未輸入將以id為暱稱" value="{{ isset($fail) ? $id : old('UserName') }}">
		        	</td>
		        </tr>
		        <tr>
		        	<th><span style="color:red;">*</span>E-mail</th>
		        	<td>
		        		<input class="form-control" type="text" name="UserEmail" value="{{ old('UserEmail') }}" required>
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