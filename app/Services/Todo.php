<?php

namespace app\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\BaseModel;
class Todo extends BaseModel {
    protected $table = "todos";
    protected $connection = 'TestDb';
    protected $primaryKey = 'id';
    protected $fillable = [	"title" ];
    
    public $incrementing = true; //primaryKey非自動遞增設為false
    public $timestamps = true; //時間戳記非自動產生設定為false
    
    /**
     *  查詢資料表的所有資料
     * @abstract 思考看看，加上查詢的條件應該要如何寫
     * @author center69-陳煜珊
     * @return $dataList
     */
    public static function findAll(){
        $data = DB::table("todos")
                ->select("id","title");
        return $data->get();
    }
    public static function findUser($id){
        $data = DB::table("todos")
                ->select("title")
                ->where("id", $id);
        return $data->first();
    }
    public static function deleteMsg($id){
        $data = DB::table("todos")
        ->select("title")
        ->where("id", $id);
        return $data->first();
    }
    /*public static function updateMsg($key, $title){
        $data = DB::table("todos")
        ->where("id", $key)
        ->update(["title" => $title]);
        echo $model->id;
        die;
        $data = DB::table("todos")
                ->where("id", $model->id)
                ->update(["title" => $model->title]);
        //return $data;
    }*/
    //
}
