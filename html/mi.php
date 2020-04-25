<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';

$err_msg = array();

try{
    //DB接続
    $dbh = get_db_connect();
    
    session_start();
    if(isset($_SESSION['user_id'])){
        //ユーザー名取得
        $user_name = user_name($dbh);
        //POSTかどうか
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //商品一覧取得
            $data = get_data_serch($dbh, $category, $part, $keyword);
        }
        
    }else{
        header('Location: login.php');
        exit;
    }  
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'mi_view.php';