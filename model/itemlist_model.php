<?php
require_once MODEL_PATH . 'cart_model.php';

//処理の判断
function process(){
    $process_kind = get_post_data('process_kind');
    return $process_kind;
}

function mi_status_check(){
    $str = get_post_data('mi_status');
    return $str;
}

function mi_change($dbh, $mi_status, $user_name){
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
    
    if ($mi_status !== '1' && $mi_status !== '0'){
        $err_msg[] = 'miステータスの値は0か1を入力してください';
    }else{
    
        //mi_status更新
        // SQL生成
        $sql = "UPDATE ec_user SET mi_status = ?, update_datetime = ? WHERE user_name = ? ";
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $mi_status, PDO::PARAM_STR);
        $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
        $stmt->bindValue(3, $user_name, PDO::PARAM_STR);
        $stmt->execute();
    }
}
    
function mi_check($dbh, $user_name){
    //値を取得
    // SQL生成
    $sql = 'SELECT * FROM ec_user WHERE user_name = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll();

return $rows;
}
    

//受信値を変数に変換
function serch_value(){
    if($_POST['category'] === 'ALL'){
        $category = '%';
    }else{
        $category     = "%".get_post_data('category')."%";
    }
    if($_POST['part'] === 'ALL'){
        $part = '%';
    }else{
        $part     = "%".get_post_data('part')."%";
    }
    if($_POST['keyword'] === 'ALL'){
        $keyword = '%';
    }else if($_POST['keyword'] !== ''){
        $keyword     = "%".get_post_data('keyword')."%";
    }else{
        $keyword = '';
    }
    $word          = get_post_data('keyword');
    
    return array($category, $part, $keyword, $word);
}

function cart_value(){
    $id            = get_post_data('id');
    $amount       = get_post_data('amount');
    $stock       = get_post_data('stock');
    
    return array($id, $amount, $stock);
}


//商品一覧を取得
function get_data($dbh) {
 
  // SQL生成
  $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_stock_master ON ec_item_master.item_id = ec_stock_master.stock_id WHERE status = 1';
  // クエリ実行
  return get_as_array($dbh, $sql);
}

//商品一覧を取得
function get_data_serch($dbh, $category, $part, $keyword) {
try{
    if($keyword !== ''){
        $category = $category.'';
        // SQL生成
        $sql = "SELECT * FROM ec_item_master INNER JOIN ec_stock_master ON ec_item_master.item_id = ec_stock_master.stock_id 
        WHERE status = 1 AND category LIKE ? AND part LIKE ? AND name LIKE ? ";
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $category, PDO::PARAM_STR);
        $stmt->bindValue(2, $part, PDO::PARAM_STR);
        $stmt->bindValue(3, $keyword, PDO::PARAM_STR);
        $stmt->execute();
        // レコードの取得
        $rows = $stmt->fetchAll();
    }else{
        // SQL生成
        $sql = "SELECT * FROM ec_item_master INNER JOIN ec_stock_master ON ec_item_master.item_id = ec_stock_master.stock_id 
        WHERE status = 1 AND category LIKE ? AND part LIKE ? ";
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $category, PDO::PARAM_STR);
        $stmt->bindValue(2, $part, PDO::PARAM_STR);
        $stmt->execute();
        // レコードの取得
        $rows = $stmt->fetchAll();
    }
} catch (PDOException $e) {
    throw $e;
}
     
return $rows;
}

//カートに商品を追加
function cart($dbh, $id, $amount, $user_id, $stock){
    global $err_msg;
    $result_msg = '';
    $overlap = 0;
    $rows2 = array();
    $pattern = '/^([+]?[1-9][0-9]*)$/';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if(preg_match($pattern, $amount) === 0) {
        $err_msg[] = '個数には1以上の整数を入力してください';
    }
    
    

    $rows1 = get_user_carts($dbh, $user_id);
    
    
    foreach($rows1 as $row){
        
        //既にカートに入っている商品を追加した場合、個数のみ変更
        if($id == $row['item_id']){
            $amount = $amount + $row['amount'];
            if($stock < $amount){
                $err_msg[] = '購入数が在庫を超えています。残りの在庫は'.$stock.'個です';
            }
    
            if(count($err_msg) === 0){
                //在庫数変更
                $sql = 'UPDATE ec_cart SET 
                amount = ?, update_datetime = ?
                WHERE item_id = ? ;';
                // SQL文を実行する準備
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $amount, PDO::PARAM_INT);
                $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
                $stmt->bindValue(3, $id, PDO::PARAM_INT);
                $stmt->execute();
                
                $overlap = 1;
                $result_msg = '既に同じ商品がカートにあるため、個数を更新しました';
            }
        }
    }
       if(count($err_msg) === 0){
           if($overlap === 0){
                //商品情報の登録
                $sql = 'INSERT INTO ec_cart (item_id, amount, user_id, create_datetime, update_datetime) VALUES(?, ?, ?, now(), now());';
                // SQL文を実行する準備
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->bindValue(2, $amount, PDO::PARAM_INT);
                $stmt->bindValue(3, $user_id, PDO::PARAM_INT);
                // SQLを実行
                $stmt->execute();
                $result_msg = 'カートに以下の商品を追加しました！';
           }
        }
        
        
        
        //購入商品情報取得
        // SQL生成
        $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_cart ON ec_item_master.item_id = ec_cart.item_id WHERE ec_item_master.item_id = ?;';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        // レコードの取得
        $rows2 = $stmt->fetchAll();
        
    return array($result_msg, $rows2);
}















