<?php

namespace app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;

class Users extends BaseModel {
    protected $connection = "TestDb"; //資料庫名
    protected $primaryKey = "id"; //PK欄位
    protected $table = "Users"; //資料表名
    protected $fillable = [	"id","UserName","UserEmail", "created_at", "updated_at",];//指定了可以被批量賦值的欄位(不一定要加)
    //$fillable would give you protection there 防止使用者直接改himl的input欄位造成id跳號，不在$fillable裡但是被create那會ignore, 用在Boards::create()
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     *  查詢資料表的所有資料
     * @abstract 思考看看，加上查詢的條件應該要如何寫
     * @author center69-陳煜珊
     * @return 先沒有用到
     */
    public static function findAll(){
        $data = DB::table("Users")
        ->select("id", "UserName", "UserEmail");
        
        return $data->get();
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
    public static function login(Request $request){
        $data = DB::table("Users")
                ->where("id", "=", $request->id)
                ->first();
        //解密
        if(password_verify($request->input("password"), $data->password)){
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
    public static function idCheck($id){
        $data = DB::table("Users")
                ->where("id", "=", $id);
        return $data->first();
    }
    
}
?>
