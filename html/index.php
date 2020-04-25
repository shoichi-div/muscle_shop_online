<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'itemlist_model.php';
require_once MODEL_PATH . 'user_model.php';

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
        $user_id = get_login_user($dbh);
    
        //POSTかどうか
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            //処理分け
            $process_kind = process();
            
            if($process_kind === 'logout'){
                logout();
            }
            
            else if($process_kind === 'mi_change'){
                $mi_status = mi_status_check();
                mi_change($dbh, $mi_status, $user_name);
            }
    
            if($process_kind === 'serch'){
                //受信値を変数に変換
                list($category, $part, $keyword, $word) = serch_value();
                //検索時の商品一覧取得
                $data = get_data_serch($dbh, $category, $part, $keyword);
            }
            
            if($process_kind === 'cart'){
                //受信値を変数に変換
                list($id, $amount, $stock) = cart_value();
                //商品をカートに追加
                list($result_msg, $data) = cart($dbh, $id, $amount, $user_id, $stock);
            }
            
        }
        //mi値取得
        $mi_data = mi_check($dbh, $user_name);
        
        
        //全公開商品一覧取得
        if($process_kind === '' || $process_kind ==='mi_change'){
            $data = get_data($dbh);
        }
        
    
    }else{
        redirect_to(HOME_URL);
        exit;
    }
    
    
}catch (Exception $e) {
    $err_msg[] = $e ->getMessage();
}

//viewファイル読み込み
include_once VIEW_PATH . 'itemlist_view.php';