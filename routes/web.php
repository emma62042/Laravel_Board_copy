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
Route::post("/welcome/delete", "WelcomeController@delete");
// Route::get("/welcome/login", function(){
//     return view("welcome_login");
// });
Route::get("/welcome/login", "WelcomeController@loginView");
Route::post("/welcome/login", "WelcomeController@login");

Route::get("/welcome/logout", 'WelcomeController@logout');
// Route::get("/welcome/signup", function(){
//     return view("welcome_signup");
// });
Route::get("/welcome/signup", "WelcomeController@signupView");
Route::post("/welcome/signup", "WelcomeController@signup");
Route::get("/welcome/idcheck", "WelcomeController@idcheck");

Route::get("/welcome/searchMsg", "WelcomeController@searchMsg");
//------------------------------------------------------------------------------------------------------------
Route::resource("/todo", "TodoController", ["except" => ["show"]]); //except method get+key預設是show
Route::get("/todo/delete", "TodoController@delete");
//Route::post("/todo/up1date", "TodoController@up1date");

