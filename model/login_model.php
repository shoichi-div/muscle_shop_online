<?php
//ユーザー照合
function user_check($dbh, $user_name, $password){
    global $err_msg;
    $err = 0;
    //ユーザー情報取得
    $sql = 'SELECT * FROM ec_user';
    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    // SQLを実行
    $stmt->execute();
    // レコードの取得
    $rows = $stmt->fetchAll();
    
    foreach($rows as $row){
        if ($user_name === 'admin' && $password === 'admin'){
            header( "Location: admin.php" ) ;
        }else if($row['user_name'] === $user_name && $row['password'] === $password){
            header( "Location: itemlist.php" ) ;
        }else{
            $err += 1;
        }
    }
    if ($err !== 0){
        $err_msg[] = 'ユーザー名もしくはパスワードが誤っています。';
    }
}