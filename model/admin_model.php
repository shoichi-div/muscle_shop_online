<?php

//受信値を変数に変換
function insert_value(){
    $name         = get_post_data('name');
    $process_kind = get_post_data('process_kind');
    $id           = get_post_data('id');
    $price        = get_post_data('price');
    $stock        = get_post_data('stock');
    $status       = get_post_data('status');
    $category     = get_post_data('category');
    $part         = get_post_data('part');
    $menu         = get_post_data('menu');
    
    return array($name, $process_kind, $id, $price, $stock, $status, $category, $part, $menu);
}

/**
* 商品の一覧を取得する
*
* @param obj $dbh DBハンドル
* @return array 商品一覧配列データ
*/
function get_data($dbh) {
 
  // SQL生成
  $sql = 'SELECT * FROM ec_item_master INNER JOIN ec_stock_master ON ec_item_master.item_id = ec_stock_master.stock_id';
  // クエリ実行
  return get_as_array($dbh, $sql);
}

//新規商品追加
function insert_item($dbh, $name, $price, $stock, $status, $category, $part, $menu, $img_dir){
    global $err_msg;
    $result_msg = '';
    $new_img_filename = '';
    $pattern = '/^([+]?[0-9]*)$/';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
    
        if (empty($name) === TRUE){
            $err_msg[] = '名前を入力してください';
        }
        if (EMPTY($price) === TRUE && $price !== '0'){
            $err_msg[] = '価格を入力してください';
        }else if(preg_match($pattern, $price) === 0) {
            $err_msg[] = '価格には0以上の整数を入力してください';
        }
        if (empty($stock) === TRUE && $stock !== '0'){
            $err_msg[] = '個数を入力してください';
        }else if(preg_match($pattern, $stock) === 0) {
            $err_msg[] = '個数には0以上の整数を入力してください';
        }
        if (empty($category) === TRUE){
            $err_msg[] = 'カテゴリーを入力してください';
        }
        if (EMPTY($part) === TRUE){
            $err_msg[] = '部位を入力してください';
        }
        if (empty($menu) === TRUE){
            $err_msg[] = 'メニューを入力してください';
        }
        if ($status !== '1' && $status !== '0'){
            $err_msg[] = '公開ステータス(status)の値は0か1を入力してください';
        }
    
        if (is_uploaded_file($_FILES['img']['tmp_name']) === TRUE) {
            // 画像の拡張子を取得
            $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            // 指定の拡張子であるかどうかチェック
            if ($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg') {
                // 保存する新しいファイル名の生成（ユニークな値を設定する）
                $new_img_filename = sha1(uniqid(mt_rand(), true)) . '.' . $extension;
                // 同名ファイルが存在するかどうかチェック
                if (is_file($img_dir . $new_img_filename) !== TRUE) {
                    // アップロードされたファイルを指定ディレクトリに移動して保存
                    if (move_uploaded_file($_FILES['img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                        $err_msg[] = 'ファイルアップロードに失敗しました';
                    }
                } else {
                    $err_msg[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                }
            } else {
                $err_msg[] = 'ファイル形式が異なります。画像ファイルはPNGかJPEGのみ利用可能です。';
            }
        } else {
            $err_msg[] = 'ファイルを選択してください';
        }
        
        if (count($err_msg) ===0) {
        
            //商品情報の登録
            $sql = 'INSERT INTO ec_item_master (name, price, img, status, category, part, menu, create_datetime, update_datetime) VALUES(?, ?, ?, ?, ?, ?, ?, now(), now());';
            // SQL文を実行する準備
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $name, PDO::PARAM_STR);
            $stmt->bindValue(2, $price, PDO::PARAM_INT);
            $stmt->bindValue(3, $new_img_filename, PDO::PARAM_STR);
            $stmt->bindValue(4, $status, PDO::PARAM_INT);
            $stmt->bindValue(5, $category, PDO::PARAM_STR);
            $stmt->bindValue(6, $part, PDO::PARAM_STR);
            $stmt->bindValue(7, $menu, PDO::PARAM_STR);
        
            // SQLを実行
            $stmt->execute();
        
            $id = $dbh->lastInsertId();
        
            //在庫数の登録
            $sql = 'INSERT INTO ec_stock_master (stock_id, stock, create_datetime, update_datetime) VALUES(?, ?, now(), now());';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->bindValue(2, $stock, PDO::PARAM_STR);
            $stmt->execute();
        
            $result_msg = '商品を追加しました';
        }
        
    return $result_msg;
}

//在庫数変更
function stock_number_change($dbh, $stock, $id){
    global $err_msg;
    $result_msg = '';
    $pattern = '/^([+]?[0-9]*)$/';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if(preg_match($pattern, $stock) === 0) {
        $err_msg[] = '在庫数には0以上の整数を入力してください';
    }
    
    if (count($err_msg) === 0){
    

    //在庫数変更
    $sql = 'UPDATE ec_stock_master SET 
            stock = ?, update_datetime = ?
            WHERE stock_id = ? ;';
            

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $stock, PDO::PARAM_INT);
    $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = '在庫数を変更しました';
    }
    
return $result_msg;
}

//公開ステータス変更
function status_change($dbh, $status, $id){
    global $err_msg;
    $result_msg = '';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
    if ($status !== '1' && $status !== '0'){
            $err_msg[] = '公開ステータス(status)の値は0か1を入力してください';
    }
    
    if (count($err_msg) === 0){
        //ステータス変更
        $sql = 'UPDATE ec_item_master SET 
                status = ?, update_datetime = ?
                WHERE item_id = ? ;';
    
    
        // SQL文を実行する準備
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $status, PDO::PARAM_INT);
        $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
        $stmt->bindValue(3, $id, PDO::PARAM_INT);
        $stmt->execute();

        $result_msg = '公開ステータスを変更しました';
    }


    

return $result_msg;
}

//商品削除
function delete($dbh, $id){
    global $err_msg;
    $result_msg ="";
    
    $sql = 'DELETE FROM ec_item_master 
            WHERE item_id = ? ;';


    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $sql = 'DELETE FROM ec_stock_master 
            WHERE stock_id = ? ;';


    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = '商品を削除しました';
    
    return $result_msg;
}

//カテゴリ変更
function category_change($dbh, $category, $id){
    global $err_msg;
    $result_msg = '';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');


    //カテゴリー変更
    $sql = 'UPDATE ec_item_master SET 
            category = ?, update_datetime = ?
            WHERE item_id = ? ;';
            

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $category, PDO::PARAM_STR);
    $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = 'カテゴリーを変更しました';
    
    return $result_msg;
}

//部位変更
function part_change($dbh, $part, $id){
    global $err_msg;
    $result_msg = '';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');


    //部位変更
    $sql = 'UPDATE ec_item_master SET 
            part = ?, update_datetime = ?
            WHERE item_id = ? ;';
            

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $part, PDO::PARAM_STR);
    $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = '部位を変更しました';
    
    return $result_msg;
}

//メニュー変更
function menu_change($dbh, $menu, $id){
    global $err_msg;
    $result_msg = '';
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');
print $menu;


    //メニュー変更
    $sql = 'UPDATE ec_item_master SET 
            menu = ?, update_datetime = ?
            WHERE item_id = ? ;';
            

    // SQL文を実行する準備
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $menu, PDO::PARAM_STR);
    $stmt->bindValue(2, $now_date, PDO::PARAM_STR);
    $stmt->bindValue(3, $id, PDO::PARAM_INT);
    $stmt->execute();

    $result_msg = 'メニューを変更しました';
    
    return $result_msg;
}
