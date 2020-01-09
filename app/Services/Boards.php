<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;
use App\Services\Users;

class Boards extends BaseModel {
    protected $connection = "TestDb"; //資料庫名
    protected $primaryKey = "msg_id"; //PK欄位
    protected $table = "Boards"; //資料表名
    protected $fillable = [	"msg_id", "title", "msg", "user_id", "created_at", "updated_at",];//指定了可以被批量賦值的欄位(不一定要加)
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     * [findAll]
     * 查詢Boards join Users表, join條件是u.id == b.user_id
     * 取出全部結果
     * 用b.updated_at降序
     * 用->paginate(5)分頁，1頁5個留言
     * @return $dataList
     */
    public static function findAll(){
        $data = DB::table("Boards as b")
        ->join("Users as u", "u.id", "=", "b.user_id")
        ->select("b.msg_id", "b.title", "b.msg", "b.created_at", "b.updated_at", "b.user_id", "u.nickname")
        ->orderBy("b.updated_at", "desc");

        return $data->paginate(5);
    }

    /**
     * [searchMsg]
     * 搜尋標題或內容
     * 用->paginate(5)分頁，1頁5個留言
     * @param  Request $request ["searchInput"]
     * @return $searchList
     */
    public static function findBySearch($searchInput){
        $data = DB::table("Boards as b")
        ->join("Users as u", "u.id", "=", "b.user_id")
        ->select("b.msg_id", "b.title", "b.msg", "b.created_at", "b.updated_at", "b.user_id", "u.nickname")
        ->where("b.title", "LIKE", "%".$searchInput."%")
        ->orWhere("b.msg", "like", "%".$searchInput."%")
        ->orderBy("b.updated_at", "desc");

        return $data->paginate(5);
    }

    /**
     * [myMsg]
     * 我的留言
     * 用->paginate(5)分頁，1頁5個留言
     * @param  $login_id [session("login_id")]
     * @return $myList
     */
    public static function myMsg($login_id){
        $data = DB::table("Boards as b")
        ->join("Users as u", "u.id", "=", "b.user_id")
        ->select("b.msg_id", "b.title", "b.msg", "b.created_at", "b.updated_at", "b.user_id", "u.nickname")
        ->where("b.user_id", "=", $login_id)
        ->orderBy("b.updated_at", "desc");

        return $data->paginate(5);
    }
}
?>