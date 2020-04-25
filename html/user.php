<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

$err_msg = array();
$result_msg = '';
$process_kind = '';
$data = array();


try{
    //DB接続
    $dbh = get_db_connect();
    
    session_start();
    if($_SESSION['user_id'] === 'admin'){
        //ユーザー名取得
        $user_name = user_name($dbh);
        
        //POSTかどうか
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //受信値を変数に変換
            $process_kind = insert_value();
    
             //ログアウト
            if($process_kind === 'logout'){
                logout();
            }
        }    
            //商品の一覧を取得
            $data = get_data($dbh);
        
    
    }else{
        header('Location: login.php');
        exit;
    }    
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'user_view.php';