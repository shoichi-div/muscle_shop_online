<?php

//mi更新
function update_mi($dbh, $mi, $user_id, $total)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    $sql =
        'UPDATE
            ec_user
        SET
            mi = ?,
            update_datetime = ?
        WHERE
            user_id = ? ;';
    return execute_query($dbh, $sql, array($mi + $total, $now_date, $user_id));
}

//購入履歴への新規登録
function add_history($dbh, $user_id)
{
    $sql = 'INSERT INTO
                purchase_history (`user_id`,  `create`, `update`)
            VALUES (?, now(), now());';
    return execute_query($dbh, $sql, array($user_id));
}

//購入明細への新規登録
function add_detail($dbh, $rows)
{
    //buy_idを取得
    $id = $dbh->lastInsertId();
    //購入明細の更新
    foreach ($rows as $row) {
        $sql = 'INSERT INTO 
                    purchase_detail (buy_id, item_id, amount, price)
                VALUES(?, ?, ?, ?);';
        execute_query($dbh, $sql, array($id, $row['item_id'], $row['amount'], $row['price']));
    }
    return true;
}
