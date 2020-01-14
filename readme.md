<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

Laravel_Board
===

## Beginners Guide
center88留言板 with Laravel+Bootstrap

## 2019/12/25
*  laravel上課
1. 建立laravel專案、複製煜珊範例
2. 修改煜珊範例，index view的foreach多一個括號
3. 跑laravel範例create按鈕出現一些問題，詳情請看工作紀錄
4. 看laravel初學者教學

## 2019/12/26
*  開始修改煜珊的範例程式
1. 實作Edit的部分
2. 利用有沒有key值判斷是新增還是修改，新增的話new Boards()，修改的話Boards::find($key);從資料表中找到同pk的值
3. 實作Delete的部分(use post)，在route裡加上post('/welcome/delete',...@delete)，form那邊method用post，裡面的input設hidden，用$request傳送msg_id進去delete() function
4. 實作Delete的部分(use delete(in resource))
5. 試著將留言版的表跟User的表做join拿出UserName

## 2019/12/27
*  實作login view , welcome_login.blade.php
1. 實作login及後端驗證
2. 實作signup，帳號重複/確認密碼不同，後端驗證
3. laravel layout學習

## 2019/12/30
*  加入Bootstrap
1. 下載Bootstrap已編譯 css js，檔名bootstrap-4.4.1-dist
2. 使用bootstrap 網格div
3. 複製Bootstrap_board裡的nav(詳細請看Bootstrap_board專案)
4. 修改首頁表格在小螢幕太大的問題，bootstrap本身沒有解決這個問題，上網查，利用([Bootstrap 的 RWD 表格](https://dotblogs.com.tw/f2e/2016/02/22/111826))([實現Table表格也支援RWD](https://www.minwt.com/webdesign-dev/html/14066.html))來實作,在public/css裡加上rwd_table.css
5. 修改各個頁面的class->bootstrap style
6. 首頁加上bootstrap頁碼按鈕

## 2019/12/31
*  補註解+分頁功能+搜尋
1. 補齊上面那堆的註解
2. 把errors顯示加進layout的alert框裡
3. 做分頁功能:從laravel說明網站打[paginaton](https://laravel.tw/docs/5.3/pagination)就有
4. 改分頁樣式(詳情見工作紀錄)
5. 自己加了一個complicated-bootstrap-4.blade，把bootstrap-4.blade的上一頁下一頁換成simple-bootstrap-4.blade的上一頁下一頁樣式
6. 實作搜尋功能(有問題看工作紀錄)
7. 搜尋的分頁:appends(array("searchInput"=>$searchInput))

## 2020/1/2
*  學習jQuery+前後端確認密碼相同驗證+密碼加密
1. 註冊加上jQuery validated驗證
2. laravel validated改中文警告([中文警告github](https://github.com/caouecs/Laravel-lang/tree/master/src/zh-TW))([修改教學](https://blog.csdn.net/qq_38365479/article/details/80340342))
3. laravel 後端 validated 驗證密碼==確認密碼([laravel confirmed](https://laravel.com/docs/4.2/validation#rule-confirmed))([教學](https://stackoverflow.com/questions/42623841/laravel-password-password-confirmation-validation/42624039))
4. jQuery validated 帳號加上remote用get連到signupView做驗證(用post會有問題:419 unknown status)，驗證有無重複帳號
5. 密碼加密，使用PHP password_hash([Laravel Hash](https://laravel.com/docs/5.5/hashing))([PHP 5.5 Hash](https://learnku.com/articles/5156/using-password-hash-to-hash-passwords))，目前用php 5.5的，laravel還在研究

## 2020/1/3
*  看laravel教學
1. 解決jQuery validated不能用post, error419的問題:要加{{ csrf_token() }}。
2. 加上create/edit頁面會員已登入驗證
3. 首頁表格非會員不得修改刪除
4. 加入會員密碼修改功能

## 2020/1/6
*  完成留言板，code review準備
1. 加入會員資料修改功能
2. 完成我的留言功能
3. 註冊加入生日  
    ([日期選單git](https://github.com/smalot/bootstrap-datetimepicker))  
    ([gijgo日期<比較直覺>](https://gijgo.com/datepicker/configuration/icons.rightIcon))  
    ([iconic](https://github.com/iconic/open-iconic))  
4. 日期格式轉換  
    SQL存的date是yyyy-mmm-dd  
    gijgo的date是mm/dd/yyyy  
    ([mm/dd/yyyy to yyyy-mm-dd](https://stackoverflow.com/questions/3288257/how-to-convert-mm-dd-yyyy-to-yyyy-mm-dd))  
    ([yyyy-mm-dd to mm/dd/yyyy](https://stackoverflow.com/questions/2487921/convert-a-date-format-in-php))
5. 改掉Users表裡的UserName->nickname跟UserEmail->email
6. 整理註解

## 2020/1/7
*  發現"back()"如果發生錯誤回到create view 就回不去上一頁了
1. 改掉create回上頁，直接回首頁
2. 加上註解，去掉註解的程式
3. 整理註解
4. gijgo的日期格式轉換其實用format就好([gijgo格式轉換](https://gijgo.com/datepicker/configuration/minDate))
5. 生日可null

## 2020/1/8
*  搞懂navbar
1. flex-grow-0的問題
2. 重頭念bootstrap
3. center 88 留言板 Card+media 
4. navbar加入dropdown | dropdown 按第一次沒反應，要第二次以後才正常([解決方案](https://cheaster.blogspot.com/2018/10/bootstrap-4-dropdown.html))基本上就是bootstrap.min.js 跟 bootstrap.js 不能重複載入
5. 加入不能修改他人留言

## 2020/1/9
*  code review
1. 留言有空白格在index顯示要保留
2. code review有被稱讚，也一些問題
3. WelcomeController改名BoardController
4. 加上UsersController，把會員移過去


## 2020/1/10
*  修改code
1. 把signup跟modifyPwd併進controller@update裡，用id區分
2. 加入model["xxx"]預設值
3. 修改Model裡的function參數帶預設值，修改function名稱
4. 將script移到各自view底下
5. 去掉不特定from validate
6. 刪除留言的from class="form_del" 因為delete按鈕是迴圈產生的，用id作為javascript的key會造成只有第一個按鈕接收到，所以改用class
7. 改成signup跟modifyInfo用同一個view

## 2020/1/13
*  耍費

## 2020/1/14
*  修改code
1. 修改signup的validate remote傳值的值，單純字串不用function

##
未做工作:  
* Laravel本身的登入
* controller 分成board / user √
* 送到model 的參數要有預設值跟確認有值 √
* 變數命名規則要照專案風格
* href要用action, 避免專案名稱更改,url失效 √
* script如果是for各自的view, 寫在各自的view最下面 √
* form要驗證最好用id, 不跟其他人的form名字衝突 √
* model function 用 findByUser, findBySearch... √
* search跟index的controller function寫同一個 √
* git 學習

___

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
