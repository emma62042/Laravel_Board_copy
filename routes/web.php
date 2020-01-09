<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
|--------------------------------------------------------------------------
| resource
|--------------------------------------------------------------------------
| index 	| 首頁:顯示所有留言
| create 	| 新增:to edit with key=null
| store 	| 
| show 		| 
| edit 		| 修改:呼叫新增與修改的View
| update  	| 執行新增與修改
| destroy 	| 刪除:執行刪除留言
*/

Route::get("/", "BoardController@index");
Route::resource("/board", "BoardController", ["except" => ["show"]]); //except method get+key預設是show


//登入
Route::get("/board/login", "BoardController@loginView");
Route::post("/board/login", "BoardController@login");

//登出
Route::get("/board/logout", "BoardController@logout");

//註冊
Route::get("/board/signup", "BoardController@signupView");
Route::post("/board/signup", "BoardController@signup");

//修改密碼
Route::get("/board/modifyPwd", "BoardController@modifyPwdView");
Route::post("/board/modifyPwd", "BoardController@modifyPwd");

//修改會員資料
Route::get("/board/modifyInfo", "BoardController@modifyInfoView");
Route::post("/board/modifyInfo", "BoardController@modifyInfo");

//我的留言
Route::get("/board/myMsg", "BoardController@myMsg");
//------------------------------------------------------------------------------------------------------------
//Route::resource("/todo", "TodoController", ["except" => ["show"]]); //except method get+key預設是show
//Route::get("/todo/delete", "TodoController@delete");
//Route::post("/todo/up1date", "TodoController@up1date");
?>
