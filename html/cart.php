<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . '/cart_model.php';
require_once MODEL_PATH . '/user_model.php';

$err_msg = array();
$result_msg = '';

try {
    //DB接続
    $dbh = get_db_connect();
    $user_id = get_login_user($dbh);

    session_start();
    if (isset($_SESSION['user_id'])) {
        //ユーザー名取得
        $user_name = user_name($dbh);

        //POSTかどうか
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //受信値を変数に変換
            $process_kind = get_post_data('process_kind');
            $id = get_post_data('id');
            $amount = get_post_data('amount');

            //ログアウト
            if ($process_kind === 'logout') {
                logout();
            }

            //個数変更
            if ($process_kind === 'amount_change') {
                $result_msg = amount_change($dbh, $id, $amount);
            }

            //商品削除
            if ($process_kind === 'delete') {
                $result_msg = delete($dbh, $id);
            }
        }
    } else {
        header('Location: login.php');
        exit;
    }

    //商品一覧取得
    $data = get_user_carts($dbh, $user_id);
} catch (Exception $e) {
    $err_msg[] = $e->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'cart_view.php';
