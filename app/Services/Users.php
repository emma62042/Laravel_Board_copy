<?php

namespace app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;

class Users extends BaseModel {
    protected $connection = "TestDb"; //資料庫名
    protected $primaryKey = "id"; //PK欄位
    protected $table = "Users"; //資料表名
    protected $fillable = [	"id","nickname","email", "created_at", "updated_at",];//指定了可以被批量賦值的欄位(不一定要加)
    //$fillable would give you protection there 防止使用者直接改himl的input欄位造成id跳號，不在$fillable裡但是被create那會ignore, 用在Boards::create()
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     * [loginedCheck]
     * 確認是否登入
     * >問題點:如果想要用redirect()->back()回上一頁(就是同畫面)，寫在這裡會跳不回上一頁
     * 只能指定固定頁面，例如跳回首頁
     * @return [bool] [已登入/未登入]
     */
    public static function checkByLogined(){
        if(session()->has("login_id")){
            return true;
        }else{
            return false;
        }
    }

    /**
     * [login]
     * 登入確認
     * 查詢Users表, 輸入id跟password == Users裡的id跟password
     * 取出第一個回傳
     * 若沒有符合會回傳空值
     * @param  Request $request ["id", "password"]
     * @return $data
     */
    public static function login($id = NULL, $password = NULL){
        $data = DB::table("Users")
                ->where("id", "=", $id)
                ->first();
        //解密
        if(password_verify($password, $data->password)){
            return $data;
        }else{
            return NULL;
        }
    }

    /**
     * [idCheck]
     * 帳號確認
     * 查詢Users表, 輸入id == Users裡的id
     * 取出第一個回傳
     * 符合->用來登入
     * 若沒有符合會回傳空值->用來做帳號確認
     * @param  Request $request [id]
     * @return $data
     */
    public static function checkById($id = NULL){
        $data = DB::table("Users")
                ->where("id", "=", $id);
        return $data->first();
    }
}
?>
