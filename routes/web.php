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

Route::get("/", "WelcomeController@index");
Route::resource("/welcome", "WelcomeController", ["except" => ["show"]]);//except method post+key預設是show,為了delete

//搜尋
Route::get("/welcome/searchMsg", "WelcomeController@searchMsg");

//登入
Route::get("/welcome/login", "WelcomeController@loginView");
Route::post("/welcome/login", "WelcomeController@login");

//登出
Route::get("/welcome/logout", "WelcomeController@logout");

//註冊
Route::get("/welcome/signup", "WelcomeController@signupView");
Route::post("/welcome/signup", "WelcomeController@signup");

//修改密碼
Route::get("/welcome/modifyPwd", "WelcomeController@modifyPwdView");
Route::post("/welcome/modifyPwd", "WelcomeController@modifyPwd");

//修改會員資料
Route::get("/welcome/modifyInfo", "WelcomeController@modifyInfoView");
Route::post("/welcome/modifyInfo", "WelcomeController@modifyInfo");

//我的留言
Route::get("/welcome/myMsg", "WelcomeController@myMsg");
//------------------------------------------------------------------------------------------------------------
//Route::resource("/todo", "TodoController", ["except" => ["show"]]); //except method get+key預設是show
//Route::get("/todo/delete", "TodoController@delete");
//Route::post("/todo/up1date", "TodoController@up1date");
?>
