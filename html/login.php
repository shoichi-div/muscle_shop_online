<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'common.php';
require_once MODEL_PATH . 'user_model.php';

$dbh = get_db_connect();

session_start();

$token = get_csrf_token();

//viewファイル読み込み
include_once VIEW_PATH . 'login_view.php';