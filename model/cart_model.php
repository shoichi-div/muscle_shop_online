<?php

//商品一覧を取得
function get_cart_data($dbh) {
 
  // SQL生成
  $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_cart ON ec_item_master.item_id = ec_cart.item_id;';
  // クエリ実行
  return get_as_array($dbh, $sql);
}


//商品削除
function delete($dbh, $id){
    global $err_msg;
    $result_msg ="";
    
    $sql = 'DELETE FROM ec_cart 
            WHERE item_id = ? ;';


    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = '選択された商品をカート内から削除しました';
    
    return $result_msg;
}

//個数変更
function amount_change($dbh, $id, $amount){
    global $err_msg;
    $result_msg = '';
    $pattern = '/^([+]?[1-9][0-9]*)$/';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if(preg_match($pattern, $amount) === 0) {
        $err_msg[] = '個数には1以上の整数を入力してください';
    }
    
    if (count($err_msg) === 0){
    

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
    
        $result_msg = '個数を変更しました';
    }
    return $result_msg;
}


function get_user_carts($dbh, $user_id)
{
    $sql = "
    SELECT
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.status,
        ec_item_master.img,
        ec_stock_master.stock,
        ec_cart.id,
        ec_cart.user_id,
        ec_cart.amount
    FROM
        ec_cart
    JOIN
        ec_item_master
    ON
        carts.item_id = items.item_id
    FROM
        ec_stock_master
    JOIN
        ec_item_master
    ON
        ec_stock_ master.stock_id = ec_item_master.item_id
    WHERE
      carts.user_id = ?
  ";
    try {
        return fetch_all_query($dbh, $sql, array($user_id));
    } catch (PDOException $e) {
        set_error('データ取得に失敗しました。');
    }
    return false;
}