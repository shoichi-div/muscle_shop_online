<?php

//受信値を変数に変換
// function insert_value()
// {
//   $process_kind = get_post_data('process_kind');
//   $id           = get_post_data('id');
//   $amount       = get_post_data('amount');
//   $total        = get_post_data('total');

//   return array($process_kind, $id, $amount,$total);
// }

/**
 * 特殊文字をHTMLエンティティに変換する
 * @param str $str 変換前文字
 * @return str 変換後文字
 */
function entity_str($str)
{
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

/**
 * 特殊文字をHTMLエンティティに変換する（２次配列の値）
 * @param array $assoc_array 変換前配列
 * @return array 変換後配列
 */
function entity_assoc_array($assoc_array)
{

  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      //特殊文字をHTMLエンティティに変換
      $assoc_array[$key][$keys] = entity_str($values);
    }
  }

  return $assoc_array;
}

function get_db_connect()
{
  // MySQL用のDSN文字列
  $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET;

  try {
    // データベースに接続
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：' . $e->getMessage());
  }
  return $dbh;
}

/**
 * クエリを実行しその結果を配列で取得する
 *
 * @param obj  $dbh DBハンドル
 * @param str  $sql SQL文
 * @return array 結果配列データ
 */
function get_as_array($dbh, $sql)
{

  try {
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
  } catch (PDOException $e) {
    throw $e;
  }

  return $rows;
}


//ログアウト
function logout()
{
  session_start();
  $session_name = session_name();
  //セッション変数をすべて削除
  $_SESSION = array();

  //Cookieに保存されているセッションIDを削除
  if (isset($_COOKIE[$session_name])) {
    $params = session_get_cookie_params();

    // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
    setcookie(
      $session_name,
      '',
      time() - 42000,
      $params["path"],
      $params["domain"],
      $params["secure"],
      $params["httponly"]
    );
  }
  // セッションIDを無効化
  session_destroy();
  // ログアウトの処理が完了したらログインページへリダイレクト
  header('Location: login.php');
  exit;
}

//POST値を変数化
function get_post_data($key)
{
  $str = '';
  if (isset($_POST[$key]) === TRUE) {
    $str = $_POST[$key];
  }
  return $str;
}

//ユーザー名取得
function user_name($dbh)
{
  $user_name = '';

  if ($_SESSION['user_id'] === 'admin') {
    $user_name = 'admin';
  } else {
    // SQL生成
    $sql = 'SELECT user_name FROM ec_user WHERE user_id = ?';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $_SESSION['user_id'], PDO::PARAM_INT);

    // SQLを実行
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $user_name = $rows[0]['user_name'];
  }


  return $user_name;
}

function is_logined()
{
  return get_session('user_id') !== '';
}

function get_session($name)
{
  if (isset($_SESSION[$name]) === true) {
    return $_SESSION[$name];
  };
  return '';
}

function redirect_to($url)
{
  header('Location: ' . $url);
  exit;
}

function set_error($error)
{
  $_SESSION['__errors'][] = $error;
}

function fetch_query($dbh, $sql, $params = array())
{
  try {
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    return $statement->fetch();
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
  }
  return false;
}

function fetch_all_query($dbh, $sql, $params = array())
{
  try {
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
  }
  return false;
}

function execute_query($dbh, $sql, $params = array())
{
  try {
    $statement = $dbh->prepare($sql);
    return $statement->execute($params);
  } catch (PDOException $e) {
    set_error('更新に失敗しました。');
  }
  return false;
}