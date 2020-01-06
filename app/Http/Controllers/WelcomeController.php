<?php
/**
 * 使用者資料建立
 * @author center69-陳煜珊
 * @history
 * 	    center69-陳煜珊 2019/06/05 增加註解及驗證
 *      center88-吳宜芬 2019/12/31 修改及增加註解
 *      center88-吳宜芬 2020/01/06 新增刪除修改會回到前一個頁面，其他的回到index
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

class WelcomeController extends Controller {
    /**
     * [index]--resource自帶的呼叫function
     * 首頁畫面
     * @param  Request $request [nothing]
     * @return  view:index.blade.php
     *          1.login_id、login_name:登入有id跟name
     *          2.dataList:全部留言
     *          3.success、fail:如果有成功或失敗的alert，用model傳出
     */
    public function index(Request $request) {
        #param
        $view = "welcome_index";

        #取出全部的留言
        $dataList = Boards::findAll();//way 1-自行定義的查詢function
        //要用哪一種都可以，依照自己的需求選擇
        //$dataList = DB::select("nickname", "email")->get();//way2-使用Laravel的SQL ORM方法
        //$dataList = DB::table("Users")->get();
        //$dataList = DB::all();//way3-使用Laravel的ORM方法
        
        #傳遞到顯示的blade
        $model["login_id"] = $request->session()->get("login_id");
        $model["login_name"] = $request->session()->get("login_name");
        $model["dataList"] = $dataList;
        return view($view, $model);
    }
    
    /**
     * [create 新增]--resource自帶的呼叫function
     * 直接送到 edit
     * @param  Request $request [nothing]
     * @return  送到edit
     *          1.$request:目前都沒有
     *          2.不帶key值(用來判斷新增key=null或修改key=id)
     */
    public function create(Request $request) {
        return $this->edit($request, null);//null=>create 沒有key，所以不需要帶入值
    }
    
    /**
     * [edit 修改]--resource自帶的呼叫function
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
        if(session()->has("login_id")){
            #param
            $view = "welcome_create";
            #傳遞到顯示的blade
            $model["msg_id"] = $key;
            if ($key != NULL) {
                $data = Boards::find($key);
                $model["title"] = $data->title;
                $model["msg"] = $data->msg;
            }
            return view($view, $model);
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }
    
    /**
     * [update 新增修改]--resource自帶的呼叫function
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
            "Title"=>["required", "min:3", "max:255"],
            "Msg"=>["required", "min:3"]
        ]);
        #取得傳遞過來的資料
        $title = ($request->has("Title")) ? $request->input("Title") :NULL;
        $msg = ($request->has("Title")) ? $request->input("Msg") :NULL;
        
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
            $data->user_id = $request->session()->has("login_id") ? $request->session()->get("login_id") : 3 ;
        }

        #save
        $data->save(); //新增和修改的儲存ORM相同

        #傳遞到顯示的blade
        if($key == "new_a_msg"){
            $model["success"] = "Create Finish!";
        }else{
            $model["success"] = "Edit Finish!";
        }

        //回到新增修改頁面的上一頁
        return Redirect::to($request->input("backUrl"))->with($model); //放$model到session裡
    }

    /**
     * [destroy 刪除]--resource自帶的呼叫function
     * 刪除留言，需要msg_id
     * @param  Request $request [nothing]
     * @param  [type]  $key     [msg_id]
     * @return view:welcome_index.blade.php
     *         <放入session>
     *         1.success:回傳刪除成功訊息
     */
    public function destroy(Request $request, $key) { //要收到他傳過來的東西
        $data = Boards::find($key);
        $data->delete();
        $model["success"] = "Delete Success!";
        //DB::delete("delete from todos where id= ?", [$request->id]);
        return redirect()->back()->with($model); //回到刪除頁面的上一頁
    }
    
    /**
     * [searchMsg 查詢]
     * 搜尋標題或內容
     * 跟首頁共用頁面
     * @param  Request $request ["searchInput"]
     * @return view:welcome_index.blade.php
     *         1.searchList:回傳搜尋結果陣列
     *         2.searchInput:儲存剛剛打的搜尋字串
     */
    public function searchMsg(Request $request) {
        #param
        $view = "welcome_index";

        #取出search的留言
        $searchList = Boards::searchMsg($request);//way 1-自行定義的查詢function
        $model["searchList"] = $searchList;
        $model["searchInput"] = $request->input("searchInput");

        return view($view, $model);
    }

//------------------------會員↓-----------------------------------------------------------------------------------------

    /**
     * [loginView 登入]
     * 導向至login view
     * @return view:welcome_login.blade.php
     */
    public function loginView() {
        return view("welcome_login");
    }
    
    /**
     * [login]
     * 從login view接收post回來的資料，判斷登入成功與否
     * @param  Request $request ["id", "password"]
     * @return 登入成功:
     *             view:welcome_index.blade.php
     *             1.success:回傳登入成功訊息
     *             <放入session>
     *             1.login_id:會員帳號
     *             2.login_name:會員暱稱
     *         登入失敗:
     *             view:welcome_login.blade.php
     *             1.fail:回傳登入失敗訊息
     */
    public function login(Request $request) { //要收到他傳過來的東西
        #後端驗證
        request()->validate([
            "id"=>["required"],
            "password"=>["required"]
        ]);

        $view = "welcome_login";
        $data = Users::login($request->input("id"), $request->input("password")); //id+驗證
        //$data = Users::idCheck($request->input("id")); //id驗證
        //password解密驗證
        //if($data && password_verify($request->input("password"), $data->password)){
        if($data){
            $model["success"] = "login success!";
            $request->session()->put("login_id", $data->id);
            $request->session()->put("login_name", $data->nickname);
            return Redirect::to("welcome")->with($model);
        }else{
            $model["id"] = $request->input("id");
            $model["fail"] = "login fail! 帳號或密碼不相符";
        }
        return view($view, $model);
    }

    /**
     * [logout 登出]
     * 登出,需要login_id,從session拿
     * @param  Request $request [nothing]
     * @return view:welcome_index.blade.php
     *         1.success:回傳登出成功訊息
     */
    public function logout(Request $request) { //要收到他傳過來的東西
        $request->session()->forget("login_id", "login_name");
        $model["success"] = "logout success!";
        return Redirect::to("welcome")->with($model);
    }
    
    /**
     * [signupView 註冊]
     * 導向至signup view
     * >>前端帳號驗證jQuery validate remote url
     * >>$request->input("checkid")=="1"進入驗證
     * >>無重複帳號回傳ture
     * @return view:welcome_signup.blade.php
     */
    public function signupView() {
        return view("welcome_signup");
    }

    /**
     * [signup]
     * 從login view接收post回來的資料，判斷註冊成功與否
     * 檢查:id不重複,password確認
     * 存入資料庫
     * @param  Request $request ["id", "password", "ck_password", "nickname", "email"]
     * @return 註冊成功:
     *             view:welcome_index.blade.php
     *             1.success:回傳註冊成功訊息
     *         註冊失敗:
     *             view:welcome_signup.blade.php
     *             1.fail:回傳註冊失敗訊息
     *             2.id:上次輸入的id
     *             3.nickname:上次輸入的nickname
     *             4.email:上次輸入的email
     */
    public function signup(Request $request) { //要收到他傳過來的東西
        #前端帳號驗證jQuery validate remote url
        if($request->input("checkid")=="1"){
            $check = Users::idCheck($request->input("id"));
            if($check){
                return "false";
            }else{
                return "true";
            }
        }

        #後端驗證
        request()->validate([
            "id"=>["required"],
            "password"=>["required", "confirmed"], //confirmed laravel自己的確認密碼, 會檢查name=password跟password_confirmation有沒有相等
            "email"=>["required", "email"],
        ]);

        $view = "welcome_signup";
        $check = Users::idCheck($request->input("id"));

        #帳號確認完成，開始註冊
        if($check == NULL && $request->input("password") == $request->input("password_confirmation")){
            $data = new Users();
            $data->id = $request->input("id");
            //$data->password = $request->input("password");
            $data->password = password_hash($request->input("password"), PASSWORD_BCRYPT);
            $data->nickname = ($request->input("nickname") != "") ? $request->input("nickname") : $request->input("id");
            $data->email = $request->input("email");
            $data->birthday = date("Y-m-d", strtotime($request->input("birtydaypicker"))); //mm/dd/yyyy to yyyy-mm-dd
            $data->save();
            $model["success"] = "signup success!<br/>請登入";
            return view("welcome_login", $model);
        }else{
            $model["fail"] = "signup fail!";
            $model["id"] = $request->input("id");
            $model["nickname"] = $request->input("nickname");
            $model["email"] = $request->input("email");
            if($check != NULL){
                $model["fail"] .= "<br/>帳號已被使用";
            }
            if($request->input("password") != $request->input("password_confirmation")){
                $model["fail"] .= "<br/>確認密碼不相符";
            }
        }
        return view($view, $model);
    }

    /**
     * [modifyPwdView 修改密碼]
     * 導向至modifyPwd view
     * @return view:welcome_modifyPwd.blade.php
     */
    public function modifyPwdView() {
        if(session()->has("login_id")){
            return view("welcome_modifyPwd");
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }

    /**
     * [modifyPwd]
     * 確認密碼並修改密碼
     * @param  Request $request ["old_password", "password", "password_confirmation"]
     * @return 成功:
     *             view:welcome_index.blade.php
     *             1.success:回傳改密碼成功訊息
     *         失敗:
     *             view:不動
     *             1.fail:回傳註冊失敗訊息
     */
    public function modifyPwd(Request $request) {
        #後端驗證
        request()->validate([
            "old_password"=>["required"],
            "password"=>["required", "confirmed"], //confirmed laravel自己的確認密碼, 會檢查name=password跟password_confirmation有沒有相等
        ]);

        #param
        $view = "welcome_modifypwd";
        $data = Users::login(session("login_id"), $request->input("old_password"));
        if($data){
            $data = Users::find(session("login_id"));
            $data->password = password_hash($request->input("password"), PASSWORD_BCRYPT);
            $data->save();
            $model["success"] = "修改密碼成功!!";
            return Redirect::to("welcome")->with($model);
        }else{
            $model["fail"] = "修改密碼失敗!";
            if($data == NULL){
                $model["fail"] .= "<br/>舊密碼錯誤";
            }
            if($request->input("password") != $request->input("password_confirmation")){
                $model["fail"] .= "<br/>確認密碼不相符";
            }
        }
        return view($view, $model);
    }

    /**
     * [modifyInfoView 修改會員資料]
     * @return view:welcome_modifyInfo.blade.php
     *         1.email:會員email
     *         2.birthday:會員生日
     */
    public function modifyInfoView() {
        if(session()->has("login_id")){
            $data = Users::find(session("login_id"));
            $model["email"] = $data->email;
            $model["birthday"] = date("m/d/Y", strtotime($data->birthday)); // yyyy-mm-dd to mm/dd/yyyy 
            return view("welcome_modifyinfo", $model);
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }

    /**
     * [modifyInfo]
     * @param  Request $request ["email", "birthday"]
     * @return view:welcome_index.blade.php
     *         1.success:回傳成功訊息
     */
    public function modifyInfo(Request $request) {
        #後端驗證
        request()->validate([
            "email"=>["required", "email"],
        ]);

        #param
        $view = "welcome_modifyinfo";
        $data = Users::find(session("login_id"));
        $data->email = $request->input("email");
        $data->birthday = date("Y-m-d", strtotime($request->input("birtydaypicker"))); // mm/dd/yyyy to yyyy-mm-dd
        $data->save();
        $model["success"] = "修改Email成功!!";
        return Redirect::to("welcome")->with($model);
    }

    /**
     * [myMsg 我的留言]
     * 跟首頁共用頁面
     * @param  Request $request [nothing]
     * @return view:welcome_index.blade.php
     *         1.myList:回傳我的留言結果陣列
     */
    public function myMsg(Request $request) {
        #會員已登入確認
        if(session()->has("login_id")){
            #param
            $view = "welcome_index";

            #取出會員id的留言
            $myList = Boards::myMsg(session("login_id"));//way 1-自行定義的查詢function
            $model["myList"] = $myList;

            return view($view, $model);
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }
}
?>