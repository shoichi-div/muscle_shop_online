<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'register_model.php';

$err_msg = array();
$result = '';
$result_msg = '';
$user_name = 'a';

try{
    //DB接続
    $dbh = get_db_connect();
    
    //POSTかどうか
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //受信値を変数に変換
        list($user_name, $password) = insert_value();
        

        
        //ユーザー登録
        $result_msg = register_user($dbh, $user_name, $password);
    }
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'register_view.php';