{{-- 登入畫面 --}}
@extends("welcome_layout")

@section("title")
	<title>TestModifyPwd</title>
@endsection

@section("content")
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;">Modify Password</h2>

    {{-- 修改密碼 --}}
    <form id="modifyPwdForm" method="post" action="{{ action('WelcomeController@modifyPwd') }}">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
	            <tr>
	            	<th><span style="color:red;">*</span>舊密碼</th>
	            	<td>
	            		<input class="form-control" type="password" name="old_password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th><span style="color:red;">*</span>新密碼</th>
	            	<td>
	            		<input id="password" class="form-control" type="password" name="password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th><span style="color:red;">*</span>新密碼確認</th>
	            	<td>
	            		<input class="form-control" type="password" name="password_confirmation" required>
	            	</td>
	            </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >修改密碼</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  
@endsection