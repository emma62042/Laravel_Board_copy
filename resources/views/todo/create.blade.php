<form name="form1" method="post" action="{{ ($id != '') ? action('TodoController@update', ['id'=>$id]) : 'new_a_id' }}">{{-- action=key --}}
    {{ csrf_field() }}
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input name="_method" type="hidden" value="put">
    <table border='1' style="margin:0px auto;">
        <tr>
        	<th>Title</th>
        	<td>
        		<input type="text" name="todotxt" placeholder="Title" value="{{ isset($title)?$title:'' }}">
        	</td>
        </tr>
        <tr>
        	<td>
        		<button type="submit" >Save</button>
        	</td>
        </tr>
    </table>
</form> 
<!-- 
<form action="/todo" method="post"> {{-- post的話是去store --}}
	{{ csrf_field() }} <!-- 防csrf的東西，不這樣寫就不給用 
	<input type="text" placeholder="請輸入東西" name="todotxt">
	<input type="submit">
</form>    -->