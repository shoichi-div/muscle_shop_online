<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'admin_model.php';

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
            list($name, $process_kind, $id, $price, $stock, $status, $category, $part, $menu) = insert_value();
    
            try {
                //ログアウト
                if($process_kind === 'logout'){
                    logout();
                }
                
                //商品追加
                if ($process_kind === 'insert_item') {
                    $result_msg = insert_item($dbh, $name, $price, $stock, $status, $category, $part, $menu, $img_dir);
                }
                
        
                //在庫数変更
                if ($process_kind === 'stock_number_change') {
                    $result_msg = stock_number_change($dbh, $stock, $id);
                }
            
                //ステータス変更
                if ($process_kind === 'status_change') {
                    $result_msg = status_change($dbh, $status, $id);
                }
                
                 //カテゴリ変更
                if ($process_kind === 'category_change') {
                    $result_msg = category_change($dbh, $category, $id);
                }
            
                //部位変更
                if ($process_kind === 'part_change') {
                    $result_msg = part_change($dbh, $part, $id);
                }
                
                //メニュー変更
                if($process_kind === 'menu_change'){
                    $result_msg = menu_change($dbh, $menu, $id);
                }
                
                //商品削除
                if($process_kind === 'delete'){
                    $result_msg = delete($dbh, $id);
                }
            
                
        } catch (PDOException $e) {
            throw $e;
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
include_once VIEW_PATH . 'admin_view.php';