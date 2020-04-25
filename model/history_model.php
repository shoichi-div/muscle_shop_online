<?php
//購入テーブルのデータ取得
function get_purchase_data($db, $user_name, $user_id)
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
        	items
         ON
         	purchase_detail.item_id = items.item_id
        WHERE
            CASE WHEN
                ? = 'admin' THEN 1
            ELSE
                purchase_history.user_id = ?
            END
        GROUP BY
        	purchase_history.buy_id;";
    $stmt = $db->prepare($sql);
    return fetch_all_query($db, $sql, array($user_name, $user_id));
}