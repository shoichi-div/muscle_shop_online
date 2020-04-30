<?php
require_once MODEL_PATH . 'cart_model.php';

function update_mi_status($dbh, $mi_status, $user_id)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if ($mi_status !== '1' && $mi_status !== '0') {
        return 'else';
    } else {

        //mi_status更新
        // SQL生成
        $sql =
            "UPDATE
                ec_user
            SET
                mi_status = ?,
                update_datetime = ?
            WHERE
                user_id = ? ";
        return execute_query($dbh, $sql, array($mi_status, $now_date, $user_id));
    }
}

//受信値を変数に変換
function serch_value()
{
    if (get_get_data('category') === 'ALL') {
        $category = '%';
    } else {
        $category  = "%" . get_get_data('category') . "%";
    }
    if (get_get_data('part') === 'ALL') {
        $part = '%';
    } else {
        $part = "%" . get_get_data('part') . "%";
    }
    if (get_get_data('keyword') === 'ALL') {
        $keyword = '%';
    } else if (get_get_data('keyword') !== '') {
        $keyword = "%" . get_get_data('keyword') . "%";
    } else {
        $keyword = '';
    }

    $word = get_get_data('keyword');
    return array($category, $part, $keyword, $word);
}

//商品一覧を取得
function get_item_data($dbh)
{

    // SQL生成
    $sql = 'SELECT
                *
            FROM
                ec_item_master
            INNER JOIN
                ec_stock_master
            ON
                ec_item_master.item_id = ec_stock_master.stock_id
            WHERE
                status = 1';
    // クエリ実行
    return fetch_all_query($dbh, $sql);
}

//商品一覧を取得
function get_data_serched($dbh, $category, $part, $keyword)
{
    if ($keyword !== '') {
        $category = $category . '';
        // SQL生成
        $sql =
            "SELECT
                *
            FROM
                ec_item_master
            INNER JOIN
                ec_stock_master
            ON
                ec_item_master.item_id = ec_stock_master.stock_id 
            WHERE
                ec_item_master.status = 1
            AND
                ec_item_master.category
            LIKE
                ?
            AND
                ec_item_master.part
            LIKE
                ?
            AND
                ec_item_master.name
            LIKE
                ? ";
        return fetch_all_query($dbh, $sql, array($category, $part, $keyword));
    } else {
        // SQL生成
        $sql =
            "SELECT
                *
            FROM
                ec_item_master
            INNER JOIN
                ec_stock_master
            ON
                ec_item_master.item_id = ec_stock_master.stock_id 
            WHERE
                ec_item_master.status = 1
            AND
                ec_item_master.category
            LIKE
                ?
            AND
                ec_item_master.part
            LIKE
                ? ";
        return fetch_all_query($dbh, $sql, array($category, $part));
    }
}

function is_open($item)
{
    return $item['status'] === 1;
}

function sort_items($dbh, $str)
{
    $sql =  "SELECT
                ec_item_master.name,
                ec_item_master.img,
                ec_item_master.price,
                ec_item_master.item_id,
                ec_stock_master.stock
            FROM
                ec_item_master
            INNER JOIN
                ec_stock_master
            ON
                ec_item_master.item_id = ec_stock_master.stock_id
            ORDER BY
                CASE ?
                    WHEN '' THEN ec_item_master.create_datetime
                END DESC,
                CASE ?
                    WHEN 'new' THEN ec_item_master.create_datetime
                END DESC,
                CASE ?
                    WHEN 'high' THEN ec_item_master.price
                END DESC,
                CASE ?
                    WHEN 'low' THEN ec_item_master.price
                END ASC;";
    return fetch_all_query($dbh, $sql, array($str, $str, $str, $str));
}
