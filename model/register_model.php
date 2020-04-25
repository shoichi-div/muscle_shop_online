<?php

//受信値を変数に変換
function insert_value(){
    $user_name = get_post_data('user_name');
    $password = get_post_data('password');
    
    return array($user_name, $password);
}

//ログインor新規会員登録を判断
function action(){
    $action = 'login.php';
    if (empty($POST_['login']) !== 1) {
        $action = 'itemlist.php';
    } else if (empty($POST_['login']) !== 1) {
        $action = 'register.php';
    }
    return $action;
}

//ID、パスワードをDBに保存
function register_user($dbh, $user_name, $password){
    global $err_msg;
    $result_msg = '';
    $user = array();
    $pattern = '/^[0-9a-zA-Z]*$/';
    
    if (empty($user_name) === TRUE){
            $err_msg[] = 'ユーザー名を入力してください';
    }else if(preg_match($pattern, $user_name) === 0 || mb_strlen($user_name) < 6) {
        $err_msg[] = 'ユーザー名は6文字以上の半角英数字で入力してください';
    }
    if (empty($password) === TRUE){
        $err_msg[] = 'パスワードを入力してください';
    }else if(preg_match($pattern, $password) === 0 || mb_strlen($password) < 6) {
        $err_msg[] = 'パスワードは6文字以上の半角英数字で入力してください';
    }
    
    //重複ユーザー確認
    $sql = 'SELECT * FROM ec_user';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    
    foreach($rows as $row){
        if($row['user_name'] === $user_name){
            $err_msg[] = 'そのユーザー名は既に使われています';
        }
    }
        
    
    if(count($err_msg) === 0){
        //ユーザー情報の登録
        $sql = 'INSERT INTO ec_user (user_name, password, create_datetime, update_datetime) VALUES(?, ?, now(), now());';
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $password, PDO::PARAM_INT);
    
        // SQLを実行
        $stmt->execute();
        
        $result_msg = '登録が完了しました！';
        
        return $result_msg;
    }
    
    
}