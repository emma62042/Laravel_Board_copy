{{-- 新增/修改留言畫面 --}}
@extends("welcome_layout")

@section("title")
    <title>TestCreate</title>
@endsection

@section("content-title")
    {{ ($msg_id != "") ? "Update" : "Create" }} Msg
@endsection

@section("content")
    {{-- 留言輸入框，修改留言時會秀出之前的留言 --}}
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                <form class="form1 col col-lg-8 col-md-12" name="form1" method="post" action="{{ ($msg_id != '') ? action('BoardController@update', ['msg_id'=>$msg_id]) : 'new_a_msg' }}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input name="_method" type="hidden" value="put">
                    <div class="form-group">
                        <label for="Title"><span style="color:red;">*</span>Title</label>
                        <input type="text" class="form-control" name="Title" placeholder="請輸入標題" value="{{ (isset($title)) ? $title : old('Title') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="Msg"><span style="color:red;">*</span>Msg</label>
                        <textarea type="text" class="form-control" name="Msg" style="height:100px;" placeholder="請輸入留言" required>{{ isset($msg) ? $msg : old("Msg") }}</textarea>
                    </div>
                    <div class="form-group row justify-content-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

