{{-- 首頁 --}}
@extends("welcome_layout")

@section("title")
    <title>TestSys</title>
@endsection

@section("content")
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;">{{ isset($searchList) ? "Search result" : (isset($myList) ? "My Msg" : "All the Msg")}}</h2>
  	
  	{{-- 首頁顯示所有留言/如果有搜尋陣列searchList, 用搜尋陣列 --}}
    @php($msgList = isset($searchList) ? $searchList : (isset($myList) ? $myList : $dataList))
    @if(sizeof($msgList) > 0)
        <table class="table table-striped table-bordered table-rwd">
        	{{-- tr-only-hide,RWD在變成小螢幕時用到 --}}
        	<tr class="tr-only-hide">
        		<th scope="col" class="text-nowrap">#</th>
        		<th scope="col" class="text-nowrap">Msg id</th>
        		<th scope="col" class="text-nowrap">Title</th>
        		<th scope="col" class="text-nowrap">Msg</th>
        		{{-- <th>創建時間</th> --}}
        		<th scope="col" class="text-nowrap">最後修改時間▽</th>
        		<th scope="col" class="text-nowrap">作者</th>
                @if(session("login_id"))
            		<th scope="col" class="text-nowrap">修改</th>
            		<th scope="col" class="text-nowrap">刪除</th>
                @endif
        	</tr>
        	@foreach($msgList as $key=>$row)
        		<tr>
                    @php ($msg_number = ($msgList->currentPage()-1)*$msgList->perPage()+$key+1) {{-- 計算留言編號 --}}
                    {{-- data-th,RWD在變成小螢幕時用到 --}}
        			<td data-th="#" scope="col" class="text-nowrap">{{ $msg_number }}</td>
        			<td data-th="Msg id" scope="col" class="text-nowrap">{{ $row->msg_id }}</td>
        			<td data-th="Title" scope="col" class="text-nowrap">{{ $row->title }}</td>
        			<td data-th="Msg" class="text-break">{!! nl2br($row->msg) !!}</td> {{-- 加上text-break自動換行 --}}
        			<td data-th="最後修改時間">{{ $row->updated_at }}</td>
        			<td data-th="作者" scope="col" class="text-nowrap">{{ $row->nickname."(".$row->user_id.")" }}</td>
                    @if(session("login_id"))
            			<td data-th="修改">
                            @if(session("login_id") == $row->user_id)
                				<button class="btn btn-secondary" onclick="location.href='{{ action('WelcomeController@edit', ['id'=>$row->msg_id]) }}'">
                	 				Edit
                 				</button>
                            @endif
             			</td>
    					<form class="form_del" method="post" action="{{ action('WelcomeController@destroy', ['id'=>$row->msg_id]) }}" >
    						<td data-th="刪除">
                                @if(session("login_id") == $row->user_id)
                 					<input name="_method" type="hidden" value="delete">
                                    {{-- 保護您的應用程式不受到 CSRF (跨網站請求偽造) 攻擊 --}}
        							<input name="_token" type="hidden" value="{{ csrf_token() }}" /> 
        							<button class="btn btn-secondary" type="submit">Delete</button>
                                @endif
                 			</td>
             			</form>
                    @endif
        		</tr>
        	@endforeach
        </table>

        {{-- 分頁頁碼 Laravel寫好了 按鈕+功能, links括號裡是頁碼的php, 目前用預設的, 在resourse/view/vendor裡 --}}
        {{-- links("vendor.pagination.檔名") --}}
        {{-- 好像也可以自己做css, 還沒研究 --}}
            {{-- 搜尋模式:因為"用get", 要加上appends(array("searchInput" => $searchInput)), 網址列才可以保留搜尋的get --}}
            {{-- ex. http://localhost:8000/welcome/searchMsg?searchInput=測試&page=2 --}}
        {!! isset($searchList) ? $msgList->appends(array("searchInput"=>$searchInput))->links("vendor.pagination.complicated-bootstrap-4") : $msgList->links("vendor.pagination.complicated-bootstrap-4") !!}
    @endif
@endsection
