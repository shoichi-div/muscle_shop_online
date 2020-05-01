<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . '/cart_model.php';
require_once MODEL_PATH . '/user_model.php';

$dbh = get_db_connect();
session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$user = get_login_user($dbh);


//受信値を変数に変換
$id = get_post_data('id');
$amount = get_post_data('amount');


$cart = get_user_carts($dbh, $user['user_id']);

$token = get_csrf_token();

//viewファイル読み込み
include_once VIEW_PATH . 'cart_view.php';
