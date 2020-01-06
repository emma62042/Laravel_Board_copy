{{-- 修改會員資料畫面 --}}
@extends("welcome_layout")

@section("title")
	<title>TestModifyInfo</title>
@endsection

@section("content")
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;">Modify Info</h2>

    {{-- 修改會員資料 --}}
    <form class="form1" name="form1" method="post" action="{{ action('WelcomeController@modifyInfo') }}">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <div class="row justify-content-md-center">
	        <table class="table table-striped table-bordered col col-md-6">
	            <tr>
	            	<th><span style="color:red;">*</span>修改email</th>
	            	<td>
	            		<input class="form-control" type="email" name="email" value="{{ $email }}" required>
	            	</td>
	            </tr>
	            <tr>
		        	<th>修改生日</th>
		        	<td>
		        		{{-- 使用gijgo的datepicker,header有jquery --}}
		        		<input id="birtydaypicker" name="birtydaypicker" value="{{ $birthday }}">
		        	</td>
		        </tr>
	            <tr>
	            	<td colspan="2" align="center">
	            		<button class="btn btn-secondary" type="submit" >修改資料</button>
	            	</td>
	            </tr>
	        </table>
	    </div>
    </form>  
@endsection