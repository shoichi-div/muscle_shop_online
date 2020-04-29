<?php
require_once MODEL_PATH . 'cart_model.php';

function mi_status_check()
{
    $str = get_post_data('mi_status');
    return $str;
}

function mi_change($dbh, $mi_status, $user_name)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if ($mi_status !== '1' && $mi_status !== '0') {
        $err_msg[] = 'miステータスの値は0か1を入力してください';
    } else {

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

function mi_check($dbh, $user_name)
{
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
function serch_value()
{
    if ($_POST['category'] === 'ALL') {
        $category = '%';
    } else {
        $category　= "%" . get_post_data('category') . "%";
    }
    if ($_POST['part'] === 'ALL') {
        $part = '%';
    } else {
        $part = "%" . get_post_data('part') . "%";
    }
    if ($_POST['keyword'] === 'ALL') {
        $keyword = '%';
    } else if ($_POST['keyword'] !== '') {
        $keyword = "%" . get_post_data('keyword') . "%";
    } else {
        $keyword = '';
    }

    $word = get_post_data('keyword');
    return array($category, $part, $keyword, $word);
}

//商品一覧を取得
function get_item_data($dbh)
{

    // SQL生成
    $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_stock_master ON ec_item_master.item_id = ec_stock_master.stock_id WHERE status = 1';
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
