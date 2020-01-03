<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Todo;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller {
    public function index() {
        $model["todos"] = Todo::all();
        return view('todo.index',$model);
    }
    public function create() {
        return view('todo.create',['id'=>null]);
    }
    public function edit(Request $request, $key) {
        $title = Todo::findUser($key);
        //echo $title;
        return view('todo.create',['id'=>$key, 'title'=>$title->title]);
    }
    public function update(Request $request, $key) { //要收到他傳過來的東西
        if($key == "new_a_id"){
            $todo = new Todo();//用Services/Todo.php
            $todo->title = $request->todotxt;
            $todo->save();//save的話不用設定$fillable
        }else{
            //$model["title"] = $request->todotxt;
            //$model["id"] = $key;
            //Todo::updateMsg($model);
            //Todo::updateMsg($key, $request->todotxt);
            $todo = Todo::find($key);
            $todo->title = $request->todotxt;
            $todo->save();
        }
        //$todo = Todo::create($request->all());//用Services/Todo.php裡的BaseModel來做,要設定$fillable=批量賦值
        //$todo = Todo::create(['title' =>$request->todotxt]);
        //User::create(['name' =>$request->name,'sex'=>$request->sex]);
        return redirect('todo'); //回到首頁的網址
    }
    
    public function delete(Request $request) { //要收到他傳過來的東西
        $todo = Todo::find($request->id);
        $todo->delete();
        //DB::delete('delete from todos where id= ?', [$request->id]);
        return redirect('todo'); //回到首頁的網址
    }
    
}
