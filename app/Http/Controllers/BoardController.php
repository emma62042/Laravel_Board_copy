<?php
/**
 * 使用者資料建立
 * @author center69-陳煜珊
 * @history
 * 	    center69-陳煜珊 2019/06/05 增加註解及驗證
 *      center88-吳宜芬 2019/12/31 修改及增加註解
 *      center88-吳宜芬 2020/01/06 加註解
 * ----------------------------------------------------------------
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;
use App\Services\Users; 
use App\Services\Boards;

class BoardController extends Controller {
    /**
     * [index]--resource自帶的呼叫function
     * 首頁畫面:顯示所有留言
     * 搜尋畫面:搜尋標題或內容
     * >>按鈕在layout navbar
     * @param  Request $request [nothing / "searchInput"]
     * @return  view:welcome_index.blade.php
     *          1.dataList:全部留言
     *          2.searchList:回傳搜尋結果陣列
     *          3.searchInput:儲存剛剛打的搜尋字串
     */
    public function index(Request $request) {
        #param
        $view = "welcome_index";

        if($request->has("searchInput")){
            #搜尋:取出search的留言
            $searchInput = $request->has("searchInput") ? $request->input("searchInput") : "";
            $searchList = Boards::findBySearch($searchInput);
            $model["searchList"] = isset($searchList) ? $searchList : "";
            $model["searchInput"] = isset($searchInput) ? $searchInput : "";
        }else{
            #首頁:取出全部的留言
            $dataList = Boards::findAll();//way 1-自行定義的查詢function
            #傳遞到顯示的blade
            $model["dataList"] = $dataList;
        }
        //要用哪一種都可以，依照自己的需求選擇
        //$dataList = DB::select("nickname", "email")->get();//way2-使用Laravel的SQL ORM方法
        //$dataList = DB::table("Users")->get();
        //$dataList = DB::all();//way3-使用Laravel的ORM方法
        
        return view($view, $model);
    }
    
    /**
     * [create 新增]--resource自帶的呼叫function
     * >>按鈕在layout navbar
     * 直接送到 edit
     * @param  Request $request [nothing]
     * @return  送到edit
     *          1.$request:nothing
     *          2.不帶key值(用來判斷新增key=null或修改key=id)
     */
    public function create(Request $request) {
        return $this->edit($request, null); //key=null : create 沒有key，所以不需要帶入值
    }
    
    /**
     * [edit 修改]--resource自帶的呼叫function
     * >>按鈕在index table
     * 要進入須先登入
     * 未登入顯示alert並保持原頁面不跳頁
     * 判斷是新增或修改留言，並傳送要顯示的標題、留言，導向至create view
     * @param  Request $request [nothing]
     * @param  [type]  $key     [新增:null/修改:msg_id]
     * @return  view:welcome_create.blade.php
     *          1.msg_id:給view決定要顯示的標題跟title,msg
     *          2.title:修改留言模式顯示原本的title
     *          3.msg:修改留言模式顯示原本的msg
     */
    public function edit(Request $request, $key) {
        if(Users::checkIfLogined()){
            #param
            $view = "welcome_create";
            #傳遞到顯示的blade
            $model["msg_id"] = $key;
            if ($key != NULL) {
                $data = Boards::find($key);
                if($data->user_id == session("login_id")){
                    $model["title"] = isset($data->title) ? $data->title : "";
                    $model["msg"] = isset($data->msg) ? $data->msg : "";
                }else{
                    return redirect()->back()->with("alert", "請勿修改他人留言!"); //保持原頁面，傳送alert msg
                }
            }
            return view($view, $model);
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }
    
    /**
     * [update 新增修改]--resource自帶的呼叫function
     * >>按鈕在create submit
     * 從create view接收post回來的資料，判斷是新增或修改留言
     * 並寫入標題、留言、作者進資料庫，
     * 將一些alert放入session, 導向至index view
     * 
     * @param  Request $request ["Title", "Msg"]
     * @param  [type]  $key     [新增:new_a_msg/修改:msg_id]
     * @return  view:welcome_index.blade.php
     *          <放入session>
     *          1.success:回傳新增/修改成功訊息
     */
    public function update(Request $request, $key) {
        #後端確認input有值、最短最長
        request()->validate([
            "Title"=>["required", "min:2", "max:255"],
            "Msg"=>["required", "min:2"]
        ]);
        #取得傳遞過來的資料
        $title = ($request->has("Title")) ? $request->input("Title") :NULL;
        $msg = ($request->has("Msg")) ? $request->input("Msg") :NULL;
        
        #builder
        if($key == "new_a_msg"){
            $data = new Boards();
        }else{ 
            $data = Boards::find($key);
        }
        
        #put data
        if($title != "" && $msg != ""){
            $data->title = $title;
            $data->msg = $msg;
            $data->user_id = $request->session()->get("login_id");
        }

        #save
        $data->save(); //新增和修改的儲存ORM相同

        #傳遞到顯示的blade
        if($key == "new_a_msg"){
            $model["success"] = "Create Finish!";
        }else{
            $model["success"] = "Edit Finish!";
        }
        return Redirect::to("board")->with($model); //放$model到session裡
    }

    /**
     * [destroy 刪除]--resource自帶的呼叫function
     * >>按鈕在index table
     * 刪除留言，需要msg_id
     * @param  Request $request [nothing]
     * @param  [type]  $key     [msg_id]
     * @return view:welcome_index.blade.php
     *         <放入session>
     *         1.success:回傳刪除成功訊息
     */
    public function destroy(Request $request, $key) { //要收到他傳過來的東西
        $data = Boards::find($key);
        if($data->user_id == session("login_id")){
            $data->delete();
            $model["success"] = "Delete Success!";
            return redirect()->back()->with($model); //回到刪除頁面的上一頁
        }else{
            return redirect()->back()->with("alert", "請勿修改他人留言!"); //保持原頁面，傳送alert msg
        }
    }
}
?>