<?php

require_once MODEL_PATH . 'common.php';

/**
* ユーザー一覧を取得する
*/
function get_user_data($dbh) {
 
  // SQL生成
  $sql = 'SELECT * FROM ec_user';
  // クエリ実行
  return get_as_array($dbh, $sql);
}


function get_login_user($db)
{
  $login_user_id = get_session('user_id');

  return get_user($db, $login_user_id);
}

function get_user($db, $user_id)
{
  $sql = "
    SELECT
      user_id, 
      name,
      password,
      type
    FROM
      ec_user
    WHERE
      user_id = ?
    LIMIT 1
  ";

  try {
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetch();
    return $rows;
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
  }
  return false;
}

