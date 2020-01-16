<?php
//center88 test 中文測試123
//本機測試

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;
use App\Services\Users; 
use App\Services\Boards;

//大括號右邊 有空白
class UsersController extends Controller
{
    /**
     * [index 登入]
     * >>按鈕在layout sign
     * 導向至login view
     * @return view:User/index_login.blade.php
     */
    public function index() {
        return view("User/index_login");
    }

    /**
     * [login]
     * >>按鈕在login submit
     * 從login view接收post回來的資料，判斷登入成功與否
     * @param  Request $request ["id", "password"]
     * @return 登入成功:
     *             view:welcome_index.blade.php
     *             1.success:回傳登入成功訊息
     *             <放入session>
     *             1.login_id:會員帳號
     *             2.login_name:會員暱稱
     *         登入失敗:
     *             view:User/index_login.blade.php
     *             1.fail:回傳登入失敗訊息
     */
    public function login(Request $request) { //要收到他傳過來的東西
        #後端驗證
        request()->validate([
            "id"=>["required"],
            "password"=>["required"]
        ]);

        $id = $request->has("id") ? $request->input("id") : "";
        $password = $request->has("password") ? $request->input("password") : "";
        $userData = Users::login($id, $password); //id+驗證
        
        //登入成功
        if(isset($userData) && $userData != NULL) { 
            $model["success"] = "login success!";
            $request->session()->put("login_id", $userData->id);
            $request->session()->put("login_name", $userData->nickname);
            return Redirect::to("board")->with($model);
        }else{
            $view = "User/index_login";
            $model["id"] = $request->has("id") ? $request->input("id") : "";
            $model["fail"] = "login fail! 帳號或密碼不相符";
            return view($view, $model);
        }
    }

    public function checkIdJquery(Request $request) {
        #前端帳號驗證jQuery validate remote "#signupForm" url 
        $id = $request->has("id") ? $request->input("id") : "";
        $check = Users::checkIfNewId($id);//bool用check
        if($check){
            return "true";//jquery validate 的接收只能接收這個
        }else{
            return "false";
        }
    }

    /**
     * [create 註冊]
     * >>按鈕在login 最下面
     * 導向至signup view
     * @return view:User/create_signup.blade.php
     */
    public function create(Request $request) {
        return view("User/create_signup");//view的名字跟function得名字
    }

    /**
     * [signup]
     * >>按鈕在signup submit
     * 從login view接收post回來的資料，判斷註冊成功與否
     * 檢查:id不重複,password確認
     * 存入資料庫
     * @param  Request $request ["id", "password", "ck_password", "nickname", "email"]
     * @return 註冊成功:
     *             view:welcome_index.blade.php
     *             1.success:回傳註冊成功訊息
     *         註冊失敗:
     *             view:User/create_signup.blade.php
     *             1.fail:回傳註冊失敗訊息
     *             2.id:上次輸入的id
     *             3.nickname:上次輸入的nickname
     *             4.email:上次輸入的email
     */
    public function signup(Request $request) { //要收到他傳過來的東西
        #後端驗證
        request()->validate([
            "id"=>["required"],
            "password"=>["required", "confirmed"], //confirmed laravel自己的確認密碼, 會檢查name=password跟password_confirmation有沒有相等
            "email"=>["required", "email"],
        ]);

        
        $id = $request->has("id") ? $request->input("id") : "";
        $check = Users::checkIfNewId($id);

        #帳號確認完成，開始註冊
        //true:new一個帳號，密碼加密，save
        //else:可保留資訊保留，回傳錯誤訊息
        if($check == true && $request->input("password") == $request->input("password_confirmation")){
            $data = new Users();
            $data->id = $request->input("id");
            $data->password = password_hash($request->input("password"), PASSWORD_BCRYPT); //加密
            $data->nickname = ($request->input("nickname") != "") ? $request->input("nickname") : $request->input("id");
            $data->email = $request->input("email");
            $data->birthday = $request->input("birtydaypicker", NULL);
            $data->sex = $request->input("sex", NULL);
            $data->save();
            $model["success"] = "signup success!<br/>請登入";
            return view("User/index_login", $model);
        }else{
            $view = "User/create_signup";
            $model["fail"] = "signup fail!";
            $model["id"] = $request->has("id") ? $request->input("id") : "";
            $model["nickname"] = $request->has("nickname") ? $request->input("nickname") : "";
            $model["email"] = $request->has("email") ? $request->input("email") : "";
            $model["birthday"] = $request->has("birtydaypicker") ? $request->input("birtydaypicker") : "";
            if($check != NULL){
                $model["fail"] .= "<br/>帳號已被使用";
            }
            if($request->input("password") != $request->input("password_confirmation")){
                $model["fail"] .= "<br/>確認密碼不相符";
            }
            return view($view, $model);
        }
        
    }

    /**
     * [modifyPwdView 修改密碼]
     * >>按鈕在layout navbar
     * 導向至modifyPwd view
     * @return view:User/modifyPwd.blade.php
     */
    public function modifyPwdView() {
        if(Users::checkIfLogined()){
            return view("User/modifyPwd");
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }

    /**
     * [modifyPwd]
     * >>按鈕在modifyPwd submit
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
        $login_id = session("login_id") != NULL ? session("login_id") : "";
        $old_password = $request->has("old_password") ? $request->input("old_password") : "";
        $userData = Users::login($login_id, $old_password); //id+驗證
        if(isset($userData) && $userData != NULL) {
            $userData = Users::find($login_id);
            $userData->password = password_hash($request->input("password"), PASSWORD_BCRYPT); //加密
            $userData->save();
            $model["success"] = "修改密碼成功!!";
            return Redirect::to("board")->with($model);
        }else{
            $view = "User/modifyPwd";
            $model["fail"] = "修改密碼失敗!";
            if($userData == NULL){
                $model["fail"] .= "<br/>舊密碼錯誤";
            }
            if($request->input("password") != $request->input("password_confirmation")){
                $model["fail"] .= "<br/>確認密碼不相符";
            }
            return view($view, $model);
        }
    }

    /**
     * [edit 修改會員資料]
     * >>按鈕在layout navbar
     * @return view:welcome_modifyInfo.blade.php
     *         1.email:會員email
     *         2.birthday:會員生日
     */
    public function edit($id)
    {
        if(Users::checkIfLogined()){
            $login_id = session("login_id") != NULL ? session("login_id") : "";
            $userData = Users::find($login_id);//if no data
            if(isset($userData) && $userData != NULL) {
                $model["action"] = "edit";
                $model["userData"] = $userData;
                //可以直接傳data過去
                return view("User/create_signup", $model);
            }else{
                return redirect()->back()->with("alert", "無此會員資料!"); //保持原頁面，傳送alert msg
            }
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }

    /**
     * [update]
     * >>按鈕在modifyInfo submit
     * @param  Request $request ["email", "birthday"]
     * @return view:welcome_index.blade.php
     *         1.success:回傳修改資料成功訊息
     */
    public function update(Request $request, $id)
    {
        if($id == "signup") {
            return $this->signup($request);
        }elseif($id == "modifyPwd") {
            return $this->modifyPwd($request);
        }elseif($id == "modifyInfo") {
            #後端驗證 
            request()->validate([
                "email"=>["required", "email"],
            ]);

            #param
            $login_id = (session("login_id") != NULL) ? session("login_id") : "";
            $userData = Users::find($login_id);
            if(isset($userData) && $userData != NULL) {
                $request->session()->put("login_name", $request->input("nickname"));
                $userData->nickname = $request->input("nickname");
                $userData->email = $request->input("email");
                $userData->birthday = $request->input("birtydaypicker", "");
                $userData->sex = $request->input("sex", "");
                $userData->save();
                $model["success"] = "修改會員資料成功!!";
                return Redirect::to("board")->with($model);
            }
        }
        return Redirect::to("board");
    }

    /**
     * [myMsg 我的留言]
     * >>按鈕在layout navbar
     * 跟首頁共用頁面
     * @param  Request $request [nothing]
     * @return view:welcome_index.blade.php
     *         1.myList:回傳我的留言結果陣列
     */
    public function myMsg(Request $request) {
        #會員已登入確認
        if(Users::checkIfLogined()){
            #param
            $view = "welcome_index";

            #取出會員id的留言
            $login_id = session("login_id") != NULL ? session("login_id") : "";
            $myList = Boards::findByLoginUser($login_id);//way 1-自行定義的查詢function
            $model["myList"] = isset($myList) ? $myList : array() ;//類型要注意

            return view($view, $model);
        }else{
            return redirect()->back()->with("alert", "請先登入!"); //保持原頁面，傳送alert msg
        }
    }

    /**
     * [destroy 登出]
     * >>按鈕在layout sign
     * 登出,需要login_id,從session拿
     * @param  Request $request [nothing]
     * @return view:welcome_index.blade.php
     *         1.success:回傳登出成功訊息
     */
    public function destroy($id) {
        session()->forget("login_id", "login_name");
        $model["success"] = "logout success!";
        return Redirect::to("board")->with($model);
    }

}
