<?php

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


function get_errors()
{
  $errors = get_session('__errors');
  if ($errors === '') {
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}

function set_message($message)
{
  $_SESSION['__messages'][] = $message;
}

function get_messages()
{
  $messages = get_session('__messages');
  if ($messages === '') {
    return array();
  }
  set_session('__messages',  array());
  return $messages;
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

function set_session($name, $value)
{
  $_SESSION[$name] = $value;
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

// トークンの生成
function get_csrf_token()
{
  // get_random_string()はユーザー定義関数。
  $token = get_random_str(30);
  // set_session()はユーザー定義関数。
  set_session('csrf_token', $token);
  return $token;
}

// トークンのチェック
function is_valid_csrf_token($token)
{
  if ($token === '') {
    return false;
  }
  // get_session()はユーザー定義関数
  return $token === get_session('csrf_token');
}

//ランダムな文字列生成
function get_random_str($length)
{
  return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
}


function has_error()
{
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX)
{
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string)
{
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string)
{
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format)
{
  return preg_match($format, $string) === 1;
}


function is_valid_upload_image($image)
{
  if (is_uploaded_file($image['tmp_name']) === false) {
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if (isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false) {
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}
