<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once '../model/common.php';

$err_msg = array();
$result_msg = '';
$process_kind = '';
$mi_data = array();
$data = array();
$mi_check = 1;
$category = '';
$part = '';
$word = '';

try{
    //DB接続
    $dbh = get_db_connect();

    session_start();
    if(isset($_SESSION['user_id'])){
        //ユーザー名取得
        $user_name = user_name($dbh);
    
       
    }else{
        header('Location: login.php');
        exit;
    }
    
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once '../view/purpose_view.php';