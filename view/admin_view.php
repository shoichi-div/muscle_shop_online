<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
    <style>
        h2 {
            display: block;
            border-bottom: 1px solid #000;
        }

        img {
            object-fit: contain;
        }

        li {
            list-style: none;
        }

        th,
        td {
            border: 1px solid #000;
        }

        header a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline #000;
        }

        header ul {
            padding: 0;
            float: right;
            overflow: hidden;
            display: flex;
        }

        #cart:hover {
            background-color: #74d9e8;
        }

        .welcome {
            font-size: 26px;
        }

        .logo {
            margin-right: 50px;
        }

        header-right {
            display: inline-block;
            height: 30px;
            line-height: 30px;
        }
    </style>

</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>
        <!--エラーがあれば表示-->
        <?php if (count($err_msg) > 0) { ?>
            <ul>
                <?php foreach ($err_msg as $value) { ?>
                    <li><?php print $value; ?></li>
                <?php } ?>
            <?php } else { ?>
                <li><?php print $result_msg; ?></li>
            <?php } ?>
            </ul>

            <a href="user.php">ユーザー管理ページへ移動</a>
            <a href="index.php">商品一覧ページへ移動</a>

            <h2>新規商品追加</h2>

            <form method='post' enctype="multipart/form-data">
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
                <input type="hidden" name="process_kind" value="insert_item">
                <div><input type="submit" value="商品追加"></div>
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


                <?php foreach ($data as $dt) { ?>
                    <tr>
                        <!--商品画像-->
                        <td><img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>"></td>
                        <!--商品名-->
                        <td><?php print htmlspecialchars($dt['name']); ?></td>
                        <!--価格-->
                        <td><?php print htmlspecialchars($dt['price']); ?>円</td>
                        <!--在庫数-->
                        <td>
                            <form method="post">
                                <label><input type="text" name="stock" value="<?php print htmlspecialchars($dt['stock']) ?>">個</label>
                                <input type="hidden" name="process_kind" value="stock_number_change">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['stock_id']) ?>">
                                <div><input type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--カテゴリ-->
                        <td>
                            <form method="post">
                                <label><input type="text" name="category" value="<?php print htmlspecialchars($dt['category']) ?>"></label>
                                <input type="hidden" name="process_kind" value="category_change">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <div><input type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--部位-->
                        <td>
                            <form method="post">
                                <label><input type="text" name="part" value="<?php print htmlspecialchars($dt['part']) ?>"></label>
                                <input type="hidden" name="process_kind" value="part_change">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <div><input type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--メニュー-->
                        <td>
                            <form method="post">
                                <label><input type="text" name="menu" value="<?php print htmlspecialchars($dt['menu']) ?>"></label>
                                <input type="hidden" name="process_kind" value="menu_change">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <div><input type="submit" value="変更"></div>
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="process_kind" value="status_change">
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
                            </form>
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="process_kind" value="delete">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="submit" value="削除">
                            </form>
                        </td>

                    </tr>
                <?php } ?>


            </table>
    </main>
</body>

</html>