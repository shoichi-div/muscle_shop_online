<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'index_model.php';
require_once MODEL_PATH . 'user_model.php';

//DB接続
$dbh = get_db_connect();

session_start();

if (is_logined() === false) {
    redirect_to(LOGIN_URL);
}

list($category, $part, $keyword, $word) = serch_value();
$sort = get_get_data('sort');

if (get_get_data('get_kind') === 'serch') {
    $item_data = get_data_serched($dbh, $category, $part, $keyword);
} else if (get_get_data('get_kind') === 'sort') {
    $item_data = sort_items($dbh, $sort);
} else {
    $item_data = get_item_data($dbh);
}


$user = get_login_user($dbh);

$token = get_csrf_token();

//viewファイル読み込み
include_once VIEW_PATH . 'index_view.php';
