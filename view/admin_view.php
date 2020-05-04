<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>商品管理画面</title>
    <style>
        body {
            background-image: url(./assets/images/texture.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <main class="mx-5">
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>

        <!-- 新規商品登録 -->
        <div class="bg-light rounded py-1 my-3">
            <h2 class="m-3">新規商品登録</h2>
            <form method='post' enctype="multipart/form-data" action="admin_insert_item.php" class="form-group pl-5">
                <label for="name ">名前：</label><input type="text" name="name" class="form-control w-75 " id="name">
                <label for="price ">価格：</label><input type="text" name="price" class="form-control w-75 " id="price">
                <label for="stock ">在庫数：</label><input type="text" name="stock" class="form-control w-75 " id="stock">
                <label for="category ">カテゴリ：</label><input type="text" name="category" class="form-control w-75 " id="category">
                <label for="part ">部位：</label><input type="text" name="part" class="form-control w-75 " id="part">
                <label for="menu ">メニュー：</label><input type="text" name="menu" class="form-control w-75 " id="menu">
                <input type="file" name="img" class="form-control-file w-75 mt-2">
                <div class="mt-2">公開ステータス:
                    <select class="btn btn-warning" name="status">
                        <option value="1">公開</option>
                        <option value="0">非公開</option>
                    </select>
                </div>
                <div><input class="btn btn-warning mt-2 " type="submit" value="商品追加"></div>
                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
            </form>
        </div>

        <div class="bg-light rounded p-3 mb-3">
            <h2>商品一覧</h2>
            <table class="table table-bordered text-center">
                <thead class="thead-light">
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
                </thead>


                <?php foreach ($items as $dt) { ?>
                    <tr>
                        <!--商品画像-->
                        <td><img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>"></td>
                        <!--商品名-->
                        <td><?php print htmlspecialchars($dt['name']); ?></td>
                        <!--価格-->
                        <td>
                            <form method="post" action="admin_price_change.php" class="form-group">
                                <input class="form-control" type="text" name="price" value="<?php print htmlspecialchars($dt['price']) ?>">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['stock_id']) ?>">
                                <input type="hidden" name="item_id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <div><input class="btn btn-warning mt-2" type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--在庫数-->
                        <td>
                            <form method="post" action="admin_stock_change.php" class="form-group">
                                <input class="form-control" type="text" name="stock" value="<?php print htmlspecialchars($dt['stock']) ?>">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['stock_id']) ?>">
                                <input type="hidden" name="stock_id" value="<?php print htmlspecialchars($dt['stock_id']); ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <div><input class="btn btn-warning mt-2" type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--カテゴリ-->
                        <td>
                            <form method="post" action="admin_category_change.php" class="form-group">
                                <select name="category" class="form-cotrol">
                                    <option value="ウエイト" <?php if ($dt['category'] === 'ウエイト') { ?> selected <?php } ?>>ウエイト</option>
                                    <option value="自重補助" <?php if ($dt['category'] === '自重補助') { ?> selected <?php } ?>>自重補助</option>
                                    <option value="その他" <?php if ($dt['category'] === 'その他') { ?> selected <?php } ?>>その他</option>
                                </select>
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <div><input class="btn btn-warning mt-2 form-control" type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--部位-->
                        <td>
                            <form method="post" action="admin_part_change.php" class="form-group">
                                <input type="text" name="part" value="<?php print htmlspecialchars($dt['part']) ?>" class="form-cotrol">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <div><input class="btn btn-warning mt-2 form-control" type="submit" value="変更"></div>
                            </form>
                        </td>
                        <!--メニュー-->
                        <td>
                            <form method="post" action="admin_menu_change.php" class="form-group">
                                <input type="text" name="menu" value="<?php print htmlspecialchars($dt['menu']) ?>" class="form-cotrol">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <div><input class="btn btn-warning mt-2 form-control" type="submit" value="変更"></div>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="admin_status_change.php" class="form-group">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="hidden" name="status" value="<?php if ($dt['status'] === 1) {
                                                                                print 0;
                                                                            } else if ($dt['status'] === 0) {
                                                                                print 1;
                                                                            } ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <label><input class="btn btn-warning mt-2 form-control" type="submit" value="<?php if ($dt['status'] === 1) {
                                                                                                                    print htmlspecialchars("公開→非公開");
                                                                                                                } else if ($dt['status'] === 0) {
                                                                                                                    print htmlspecialchars("非公開→公開");
                                                                                                                } ?>"></label>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="admin_delete.php" class="form-group">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']) ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <input class="btn btn-warning mt-2 form-control" type="submit" value="削除">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>