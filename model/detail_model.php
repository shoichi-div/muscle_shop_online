<?php
function get_detail_data($dbh, $user_name, $user_id, $buy_id)
{
    $sql =
        "SELECT
            purchase_detail.buy_id,
            purchase_detail.item_id,
            purchase_detail.amount,
            purchase_detail.price,
            ec_item_master.name
        FROM
            purchase_history
        INNER JOIN
            purchase_detail
        ON
            purchase_history.buy_id = purchase_detail.buy_id
        INNER JOIN
            ec_item_master
        ON
            purchase_detail.item_id = ec_item_master.item_id
        WHERE
            CASE WHEN
                ? = 'admin' THEN 1
            ELSE
                purchase_history.user_id = ?
            END
            AND
                purchase_history.buy_id = ?;";
    return fetch_all_query($dbh, $sql, array($user_name, $user_id, $buy_id));
}

//小計の算出
function calculation_subtotal($rows)
{
    $sum = array();
    foreach ($rows as $row) {
        //購入した商品ごとの小計を計算して$sumに加算 = 合計金額の算出
        $sum[$row['item_id']] = $row['price'] * $row['amount'];
    }
    return $sum;
}
