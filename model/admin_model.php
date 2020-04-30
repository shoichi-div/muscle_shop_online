<?php
//全商品情報の取得
function get_all_items($dbh)
{
    // SQL生成
    $sql =
        'SELECT
    *
    FROM
        ec_item_master
    INNER JOIN
        ec_stock_master
    ON
        ec_item_master.item_id = ec_stock_master.stock_id;';
    // クエリ実行
    return fetch_all_query($dbh, $sql);
}

//新規商品追加
function insert_item($dbh, $name, $price, $stock, $status, $category, $part, $menu, $img_dir)
{
    global $err_msg;
    $new_img_filename = '';
    $pattern = '/^([+]?[0-9]*)$/';
    //現在時刻を取得
    if (empty($name) === TRUE) {
        set_error('名前を入力してください');
    }
    if (empty($price) === TRUE && $price !== '0') {
        set_error('価格を入力してください');
    } else if (preg_match($pattern, $price) === 0) {
        set_error('価格には0以上の整数を入力してください');
    }
    if (empty($stock) === TRUE && $stock !== '0') {
        set_error('個数を入力してください');
    } else if (preg_match($pattern, $stock) === 0) {
        set_error('個数には0以上の整数を入力してください');
    }
    if (empty($category) === TRUE) {
        set_error('カテゴリーを入力してください');
    }
    if (empty($part) === TRUE) {
        set_error('部位を入力してください');
    }
    if (empty($menu) === TRUE) {
        set_error('メニューを入力してください');
    }
    if ($status !== '1' && $status !== '0') {
        set_error('公開ステータス(status)の値は0か1を入力してください');
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
                    set_error('ファイルアップロードに失敗しました');
                }
            } else {
                set_error('ファイルアップロードに失敗しました。再度お試しください。');
            }
        } else {
            set_error('ファイル形式が異なります。画像ファイルはPNGかJPEGのみ利用可能です。');
        }
    } else {
        set_error('ファイルを選択してください');
    }

    if (has_error() === false) {

        $dbh->beginTransaction();
        try {
            //商品情報の登録
            $sql =
                'INSERT INTO
                ec_item_master (name, price, img, status, category, part, menu, create_datetime, update_datetime)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, now(), now());';
            // SQL文を実行する準備
            execute_query($dbh, $sql, array($name, $price, $new_img_filename, $status, $category, $part, $menu));

            $id = $dbh->lastInsertId();

            //在庫数の登録
            $sql =
                'INSERT INTO
                ec_stock_master (stock_id, stock, create_datetime, update_datetime)
            VALUES
                (?, ?, now(), now());';
            execute_query($dbh, $sql, array($id, $stock));

            set_message('商品を追加しました');

            $dbh->commit();
            return true;
        } catch (PDOException $e) {
            //ロールバック
            $dbh->rollBack();
            set_error($e);
            return false;
        }
    }
    return false;
}

function update_item_stock($dbh, $stock_id, $stock)
{
    $now_date = date('Y-m-d H:i:s');
    $sql = "
    UPDATE
      ec_stock_master
    SET
      stock = ?,
      update_datetime = ?
    WHERE
      stock_id = ?
  ";
    try {
        return execute_query($dbh, $sql, array($stock, $now_date, $stock_id));
    } catch (PDOException $e) {
        set_error('更新に失敗しました。');
    }
    return false;
}


//公開ステータス変更
function update_status($dbh, $status, $id)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    if ($status !== '1' && $status !== '0') {
        return 'else';
    } else {
        $sql =
            'UPDATE
                ec_item_master
            SET 
                status = ?,
                update_datetime = ?
            WHERE
                item_id = ? ;';
        return execute_query($dbh, $sql, array($status, $now_date, $id));
    }
}

//商品削除
function delete_item($dbh, $id)
{
    $dbh->beginTransaction();
    try {
        $sql =
            'DELETE FROM
                ec_item_master 
            WHERE
                item_id = ? ;';
        execute_query($dbh, $sql, array($id));

        $sql = 'DELETE FROM ec_stock_master 
                WHERE stock_id = ? ;';
        execute_query($dbh, $sql, array($id));

        //コミット
        $dbh->commit();
        return true;
    } catch (PDOException $e) {
        //ロールバック
        $dbh->rollBack();
        set_error($e);
        return false;
    }
}

//カテゴリ変更
function update_category($dbh, $category, $id)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    //カテゴリー変更
    $sql =
        'UPDATE
            ec_item_master
        SET 
            category = ?,
            update_datetime = ?
            
        WHERE
            item_id = ? ;';
    return execute_query($dbh, $sql, array($category, $now_date, $id));
}

//部位変更
function update_part($dbh, $part, $id)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    $sql =
        'UPDATE
            ec_item_master
        SET 
            part = ?,
            update_datetime = ?
        WHERE
        item_id = ? ;';
    return execute_query($dbh, $sql, array($part, $now_date, $id));
}

//メニュー変更
function update_menu($dbh, $menu, $id)
{
    //現在時刻を取得
    $now_date = date('Y-m-d H:i:s');

    //メニュー変更
    $sql =
        'UPDATE
            ec_item_master
        SET 
            menu = ?,
            update_datetime = ?
        WHERE
            item_id = ? ;';
    return execute_query($dbh, $sql, array($menu, $now_date, $id));
}
