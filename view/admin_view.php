<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>

        <a href="user.php">ユーザー管理ページへ移動</a>
        <a href="index.php">商品一覧ページへ移動</a>

        <h2>新規商品追加</h2>

        <form method='post' enctype="multipart/form-data" action="admin_insert_item.php">
            <div>名前 ：<input type="text" name="name"></div>
            <div>価格 ：<input type="text" name="price"></div>
            <div>個数 ：<input type="text" name="stock"></div>
            <div>カテゴリ：<input type="text" name="category"></div>
            <div>部位 ：<input type="text" name="part"></div>
            <div>メニュー：<input type="text" name="menu"></div>
            <div><input type="file" name="img"></div>
            <select name="status">
                <option value="1">公開</option>
                <option value="0">非公開</option>
            </select>
            <div><input type="submit" value="商品追加"></div>
            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
        </form>

        <h2>商品情報変更</h2>
        <p>商品一覧</p>

        <table>
            <tr>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>カテゴリー</th>
                <th>部位</th>
                <th>メニュー</th>
                <th>公開ステータス</th>
                <th>商品削除</th>
            </tr>


            <?php foreach ($items as $dt) { ?>
                <tr>
                    <!--商品画像-->
                    <td><img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>"></td>
                    <!--商品名-->
                    <td><?php print htmlspecialchars($dt['name']); ?></td>
                    <!--価格-->
                    <td><?php print htmlspecialchars($dt['price']); ?>円</td>
                    <!--在庫数-->
                    <td>
                        <form method="post" action="admin_stock_change.php">
                            <label><input type="text" name="stock" value="<?php print htmlspecialchars($dt['stock']) ?>">個</label>
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['stock_id']) ?>">
                            <div><input type="submit" value="変更"></div>
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                            <input type="hidden" name="stock_id" value="<?php print htmlspecialchars($dt['stock_id']); ?>">
                        </form>
                    </td>
                    <!--カテゴリ-->
                    <td>
                        <form method="post" action="admin_category_change">
                            <label><input type="text" name="category" value="<?php print htmlspecialchars($dt['category']) ?>"></label>
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                            <div><input type="submit" value="変更"></div>
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                        </form>
                    </td>
                    <!--部位-->
                    <td>
                        <form method="post" action="admin_part_change">
                            <label><input type="text" name="part" value="<?php print htmlspecialchars($dt['part']) ?>"></label>
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                            <div><input type="submit" value="変更"></div>
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                        </form>
                    </td>
                    <!--メニュー-->
                    <td>
                        <form method="post" action="admin_menu_change">
                            <label><input type="text" name="menu" value="<?php print htmlspecialchars($dt['menu']) ?>"></label>
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                            <div><input type="submit" value="変更"></div>
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="admin_status_change">
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                            <input type="hidden" name="status" value="<?php if ($dt['status'] === 1) {
                                                                            print 0;
                                                                        } else if ($dt['status'] === 0) {
                                                                            print 1;
                                                                        } ?>">
                            <label><input type="submit" value="<?php if ($dt['status'] === 1) {
                                                                    print htmlspecialchars("公開→非公開");
                                                                } else if ($dt['status'] === 0) {
                                                                    print htmlspecialchars("非公開→公開");
                                                                } ?>"></label>
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                        </form>
                    </td>
                    <td>
                        <form method="post" action="admin_delete">
                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                            <input type="submit" value="削除">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>

</html>