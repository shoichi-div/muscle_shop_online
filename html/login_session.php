<?php
//設定ファイル読み込み
require_once '../conf/const.php';
//関数ファイル読み込み
require_once MODEL_PATH . 'common.php';

//DB接続
$dbh = get_db_connect();
$err_msg = array();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

session_start();
//ログイン確認
//POST値取得
$user_name = get_post_data('user_name');
$password  = get_post_data('password');

if ($user_name === 'admin' && $password === 'admin') {
    //セッション変数にuser_idを保存
    $_SESSION['user_id'] = $user_name;
    //管理ユーザーでログイン時管理画面へリダイレクト
    header('Location: admin.php');
    exit;
}

//パスワードをCookieに保存
setcookie('password', $password, time() + 60 * 60);
//ユーザー名の取得
$sql = 'SELECT * FROM ec_user WHERE user_name = ? AND password = ?;';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(1, $user_name, PDO::PARAM_STR);
$stmt->bindValue(2, $password, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->fetchAll();

//登録データを取得できたか確認
if (isset($rows[0]['user_id']) === TRUE) {
    //セッション変数にuser_idを保存
    $_SESSION['user_id'] = $rows[0]['user_id'];
    //商品一覧へリダイレクト
    header('Location: index.php');
    exit;
} else {
    // $err_msg[] = 'ユーザー名またはパスワードが一致しません';
    //ログインページへリダイレクト
    include_once('./login.php');
    exit;
}
