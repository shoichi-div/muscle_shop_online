<?php
require_once '../conf/const.php';

require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'login_model.php';

$err_msg = array();

try{
    //DB接続
    $dbh = get_db_connect();
    
    //受信値を変数に変換
    $user_name = get_post_data('user_name');
    $password = get_post_data('password');
    
    //POSTかどうか
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //ユーザー照合
        user_check($dbh, $user_name, $password);
    }
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'login_view.php';