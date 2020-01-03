{{--首頁--}}
@extends("welcome_layout")

@section("title")
    <title>TestSys</title>
@endsection

@section("content")
    <h2 class="display-4" style="text-align:center; margin-bottom:30px;">{{ isset($searchList) ? "Search result" : "All the Msg" }}</h2>
  	
  	{{--首頁顯示所有留言/如果有搜尋陣列searchList, 用搜尋陣列--}}
    @php($msgList = isset($searchList) ? $searchList : $dataList)
    @if(sizeof($msgList) > 0)
        <table class="table table-striped table-bordered table-rwd">
        	{{--tr-only-hide,RWD在變成小螢幕時用到--}}
        	<tr class="tr-only-hide">
        		<th>#</th>
        		<th>Msg id</th>
        		<th>Title</th>
        		<th>Msg</th>
        		{{--<th>創建時間</th>--}}
        		<th>最後修改時間▽</th>
        		<th>作者</th>
        		<th>修改</th>
        		<th>刪除</th>
        	</tr>
        	@foreach($msgList as $key=>$row)
        		<tr>
                    @php ($msg_number = ($msgList->currentPage()-1)*$msgList->perPage()+$key+1) {{--計算留言編號--}}
                    {{--data-th,RWD在變成小螢幕時用到--}}
        			<td data-th="#">{{ $msg_number }}</td>
        			<td data-th="Msg id">{{ $row->msg_id }}</td>
        			<td data-th="Title">{{ $row->title }}</td>
        			<td data-th="Msg" class="text-break">{!! nl2br($row->msg) !!}</td>{{--加上text-break自動換行--}}
        			{{--<td data-th="創建時間">{{ $row->created_at }}</td>--}}
        			<td data-th="最後修改時間">{{ $row->updated_at }}</td>
        			<td data-th="作者">{{ $row->UserName."(".$row->user_id.")" }}</td>
        			<td data-th="修改">
        				<button class="btn btn-secondary" onclick="location.href='{{ action('WelcomeController@edit', ['id'=>$row->msg_id]) }}'">
        	 				Edit
         				</button>
         			</td>
         			<!-- 
         			<td>
         				<form class="form_del0" method="post" action="{{ action('WelcomeController@delete') }}" >
         					<input name="msg_id" type="hidden" value="{{ $row->msg_id }}" />
							<input name="_token" type="hidden" value="{{ csrf_token() }}" /> {{-- 保護您的應用程式不受到 CSRF (跨網站請求偽造) 攻擊 --}}
							<button type="submit">Delete</button>
						</form>
         			</td>
         			 -->
					<form class="form_del" method="post" action="{{ action('WelcomeController@destroy', ['id'=>$row->msg_id]) }}" >
						<td data-th="刪除">
         					<input name="_method" type="hidden" value="delete">
							<input name="_token" type="hidden" value="{{ csrf_token() }}" /> {{-- 保護您的應用程式不受到 CSRF (跨網站請求偽造) 攻擊 --}}
							<button class="btn btn-secondary" type="submit">Delete</button>
             			</td>
         			</form>
        		</tr>
        	@endforeach
        </table>

        {{--分頁頁碼 Laravel寫好了 按鈕+功能, links括號裡是頁碼的php, 目前用預設的, 在resourse/view/vendor裡--}}
        {{--links("vendor.pagination.檔名")--}}
        {{--好像也可以自己做css, 還沒研究--}}
            {{--搜尋模式:因為用get, 要加上appends(array("searchInput" => $searchInput)), 網址列才可以保留搜尋的get--}}
            {{--ex. http://localhost:8000/welcome/searchMsg?searchInput=測試&page=2 --}}
        {!! isset($searchList) ? $msgList->appends(array("searchInput"=>$searchInput))->links("vendor.pagination.complicated-bootstrap-4") : $msgList->links("vendor.pagination.complicated-bootstrap-4") !!}
    @endif
@endsection
