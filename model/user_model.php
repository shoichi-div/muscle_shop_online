<?php
require_once MODEL_PATH . 'common.php';

function get_user($dbh, $user_id)
{
  $sql = "
    SELECT
      user_id, 
      user_name,
      password,
      mi,
      mi_status
    FROM
      ec_user
    WHERE
      user_id = ?
  ";
  try {
    return fetch_query($dbh, $sql, array($user_id));
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
    return false;
  }
}

function get_all_users($dbh)
{
  $sql = "
    SELECT
      user_id, 
      user_name,
      password,
      mi,
      mi_status,
      create_datetime
    FROM
      ec_user
  ";
  try {
    return fetch_all_query($dbh, $sql);
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
    return false;
  }
}

function get_user_by_name($dbh, $name)
{
  $sql = "
    SELECT
      user_id, 
      user_name,
      password
    FROM
      ec_user
    WHERE
      user_name = ?
  ";

  try {
    return fetch_query($dbh, $sql, array($name));
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
    return false;
  }
}

function login_as($dbh, $name, $password)
{
  $user = get_user_by_name($dbh, $name);
  if ($user === false || password_verify($password, $user['password']) === false) {
    return false;
  }
  set_session('user_id', $user['user_id']);
  return $user;
}

function get_login_user($dbh)
{
  $login_user_id = get_session('user_id');

  return get_user($dbh, $login_user_id);
}

function regist_user($dbh, $name, $password, $password_confirmation, $name_data)
{
  if (is_valid_user($name, $password, $password_confirmation) === false) {
    return false;
  }
  if (is_unique_user($name, $name_data) === false) {
    return false;
  }
  return insert_user($dbh, $name, $password);
}

function is_admin($user)
{
  return $user['user_name'] === 'admin';
}

function is_valid_user($name, $password, $password_confirmation)
{
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($name);
  $is_valid_password = is_valid_password($password, $password_confirmation);
  return $is_valid_user_name && $is_valid_password;
}

function is_valid_user_name($name)
{
  $is_valid = true;
  if (is_valid_length($name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false) {
    set_error('ユーザー名は' . USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  if (is_alphanumeric($name) === false) {
    set_error('ユーザー名は半角英数字で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_password($password, $password_confirmation)
{
  $is_valid = true;
  if (is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false) {
    set_error('パスワードは' . USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  if (is_alphanumeric($password) === false) {
    set_error('パスワードは半角英数字で入力してください。');
    $is_valid = false;
  }
  if ($password !== $password_confirmation) {
    set_error('パスワードがパスワード(確認用)と一致しません。');
    $is_valid = false;
  }
  return $is_valid;
}

// 既存のユーザーか確認
function is_unique_user($name, $name_data)
{
  if ($name === $name_data['name']) {
    set_error('既に存在するユーザー名です。');
    $is_unique = false;
  } else {
    $is_unique = true;
  }
  return $is_unique;
}

function insert_user($dbh, $name, $password)
{
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO
            ec_user (`user_name`, `password`, create_datetime, update_datetime)
          VALUES (?, ?, now(), now());";
  return execute_query($dbh, $sql, array($name, $hash));
}
