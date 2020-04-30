<?php
//購入テーブルのデータ取得
function get_purchase_data($dbh, $user_name, $user_id)
{
    $sql =
        "SELECT
            purchase_history.buy_id,
            purchase_history.update,
            sum(purchase_detail.amount * purchase_detail.price) as total_price
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
        GROUP BY
        	purchase_history.buy_id;";
    return fetch_all_query($dbh, $sql, array($user_name, $user_id));
}