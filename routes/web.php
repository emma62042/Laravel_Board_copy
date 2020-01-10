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

Route::resource("/users", "UsersController", ["except" => ["show"]]); //except method get+key預設是show
//登入
Route::post("/users/login", "UsersController@login");

//修改密碼View
Route::get("/users/modifyPwd", "UsersController@modifyPwdView");

//我的留言View
Route::get("/users/myMsg", "UsersController@myMsg");

//------------------------------------------------------------------------------------------------------------
//Route::resource("/todo", "TodoController", ["except" => ["show"]]); //except method get+key預設是show
//Route::get("/todo/delete", "TodoController@delete");
//Route::post("/todo/up1date", "TodoController@up1date");
?>
