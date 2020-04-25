<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'finish_model.php';
require_once MODEL_PATH . 'cart_model.php';
require_once MODEL_PATH . 'user_model.php';

$err_msg = array();
$result_msg ='';

try{
    //DB接続
    $dbh = get_db_connect();

    $user = get_login_user($dbh);

    $carts = get_user_carts($dbh, $user['user_id']);
    
    session_start();
    if(isset($_SESSION['user_id'])){
        //ユーザー名取得
        $user_name = user_name($dbh);
        
        //POSTかどうか
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //トランザクション開始
            $dbh->beginTransaction();
            try {
            
                //受信値を変数に変換
                list($process_kind, $total) = insert_value();
                
                //ログアウト
                if($process_kind === 'logout'){
                    logout();
                }
                
                //個数変更
                if($process_kind === 'buy'){
                    if($user_name !== 'admin'){
                        mi_update($dbh, $user_name, $total);
                    }
                    $data = buy($dbh);
                }else{
                    $err_msg[] = '正規のアクセスではありません';
                }
                
                //コミット
                $dbh->commit();
            } catch (PDOException $e){
                //ロールバック
                $dbh->rollback();
                //例外をスロー
                throw $e;
            }
        
        }else{
            $err_msg[] = '正規のアクセスではありません';
        }
    
    }else{
        header('Location: login.php');
        exit;
    }
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//トランザクション開始
$dbh->beginTransaction();
try {
    //購入履歴・購入明細テーブルの更新
    add_history($dbh, $user['user_id']);
    add_detail($dbh, $carts);

    // delete_user_carts($db, $carts[0]['user_id']);


    // $total_price = sum_carts($carts);

    //コミット
    $dbh->commit();
} catch (PDOException $e) {
    //ロールバック
    $dbh->rollBack();
    set_error($e);
}


//viewファイル読み込み
include_once VIEW_PATH . 'finish_view.php';