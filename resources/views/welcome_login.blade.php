{{-- 登入畫面 --}}
@extends("welcome_layout")

@section("title")
	<title>TestLogin</title>
@endsection

@section("content-title")
    Login
@endsection

@section("content")
	{{-- 登入輸入帳號密碼 --}}
    <form class="form1" name="form1" method="post" action="{{ action('BoardController@login') }}">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-10 col-lg-6">
	            <tr>
	            	<th>帳號</th>
	            	<td>
	            		<input class="form-control" type="text" name="id" value="{{ isset($id) ? $id : old('id') }}" required>
	            	</td>
	            </tr>
	            <tr>
	            	<th>密碼</th>
	            	<td>
	            		<input class="form-control" type="password" name="password" required>
	            	</td>
	            </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >登入</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  

    {{-- 無帳號去註冊→ --}}   
    <div style="text-align:center; margin:5px;">
        <button class="btn btn-secondary" onclick="location.href='{{ action('BoardController@signupView') }}'">
        	去註冊→
        </button>
    </div>

@endsection