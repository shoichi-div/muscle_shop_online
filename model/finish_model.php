<?php

//mi更新
function mi_update($dbh, $user_name, $total){
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
    //mi値確認
    $sql = 'SELECT mi FROM ec_user WHERE user_name = ?;';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    
    $mi = $rows[0]['mi'] + $total;
    
    //在庫数更新
    $sql = 'UPDATE ec_user SET mi = ?, update_datetime = ? WHERE user_name = ? ;';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $mi, PDO::PARAM_INT);
    $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $user_name, PDO::PARAM_STR);
    $stmt->execute();
}

//商品購入
function buy($dbh) {
    global $err_msg;
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
    
     //商品一覧を取得
    // SQL生成
    $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_cart ON ec_item_master.item_id = ec_cart.item_id
    INNER JOIN ec_stock_master ON ec_cart.item_id = ec_stock_master.stock_id WHERE status = 1 AND stock > 0;';
    // クエリ実行
    $rows = get_as_array($dbh, $sql);
    
    foreach($rows as $row){
        $id = $row['item_id'];
        $amount = $row['amount'];
        $status = $row['status'];
        
        //在庫数確認
        $sql = 'SELECT stock FROM ec_stock_master WHERE stock_id = ?;';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        // レコードの取得
        $stk = $stmt->fetchAll();
        $stock = $stk[0]['stock'];
        
        if($amount > $stock){
            $err_msg[] = '在庫数が足りません';
        }
        if($status !== 1){
            $err_msg[] = 'ステータスが不正です';
        }
        
        if(count($err_msg) === 0){
        
            //購入数確認
            $sql = 'SELECT amount FROM ec_cart WHERE item_id = ?;';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            // レコードの取得
            $amt = $stmt->fetchAll();
            $amount = $amt[0]['amount'];
            
            $stock = $stock - $amount;
            
            
            //在庫数更新
            $sql = 'UPDATE ec_stock_master SET stock = ?, update_datetime = ? WHERE stock_id = ? ;';
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $stock, PDO::PARAM_INT);
            $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
            $stmt->bindValue(3, $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        $err_msg = array();
    }
    
    
        //カートテーブルの中身削除
        $sql = 'DELETE FROM ec_cart ;';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
    
    return $rows;
}

//購入履歴への新規登録
function add_history($dbh, $user_id)
{
    $sql = 'INSERT INTO purchase_history (`user_id`,  `create`, `update`)
                VALUES(?, now(), now());';
    execute_query($dbh, $sql, array($user_id));
}

//購入明細への新規登録
function add_detail($dbh, $rows)
{
    //buy_idを取得
    $id = $dbh>lastInsertId();
    //購入明細の更新
    foreach ($rows as $row) {
        $sql = 'INSERT INTO purchase_detail (buy_id, item_id, amount, price)
                VALUES(?, ?, ?, ?);';
        execute_query($dbh, $sql, array($id, $row['item_id'], $row['amount'], $row['price']));
    }
}
