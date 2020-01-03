@if(isset($todos))
    @foreach($todos as $row)
    	{{ $row->id.".".$row->title }}
    	<a href="{{ action('TodoController@delete', ['id'=>$row->id]) }}">Delete</a>
    	<a href="{{ action('TodoController@edit', ['id'=>$row->id]) }}">Update</a>
    	<br/>
    @endforeach
@endif
<a href="todo/create">
	Create
</a>
