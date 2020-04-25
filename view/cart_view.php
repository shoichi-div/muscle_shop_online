<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
    <style>
        header {
            border-bottom: solid 2px #ee7800;
            display: flex;
        }

        h1 {
            color: #000;
            font-size: 20px;
            font-weight: normal;
            margin: 0;
        }

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

        header a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline #000;
        }

        #cart:hover {
            background-color: #74d9e8;
        }

        header ul {
            list-style: none;
            padding: 0;
            float: right;
            overflow: hidden;
            display: flex;
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

        .itemlist {
            border: 1px solid #000;
            background-color: #ee7800;
            display: flex;
        }
    </style>

</head>

<body>
    <?php include_once VIEW_PATH . '/templates/header_logined.php'; ?>
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

            <?php if (empty($data)) { ?>
                <p>カートに商品が入っていません</p>
            <?php } else { ?>

                <h2>カート内の商品</h2>

                <?php $total = 0; ?>
                <?php foreach ($data as $dt) { ?>
                    <?php $subtotal =  $dt['price'] * $dt['amount']; ?>
                    <section class="itemlist">
                        <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                        <ul>
                            <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                            <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                            <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                            <li>価格：<?php print htmlspecialchars($dt['price']); ?>円</li>
                            <li>
                                <form method="post">
                                    個数：<input type="text" name="amount" value="<?php print htmlspecialchars($dt['amount']); ?>">個
                                    <input type="hidden" name="process_kind" value="amount_change">
                                    <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                                    <input type="submit" value="個数変更">
                                </form>
                            </li>
                            <li>小計：<?php print htmlspecialchars($subtotal); ?>円</li>
                            <li>
                                <form method="post">
                                    <input type="hidden" name="process_kind" value="delete">
                                    <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                                    <input type="submit" value="商品削除">
                                </form>
                            </li>
                        </ul>
                    </section>
                    <?php $total = $total + $subtotal; ?>
                <?php } ?>
                <p>
                    合計金額：<?php print htmlspecialchars($total); ?>円
                    <form method="post" action="finish.php">
                        <input type="hidden" name="process_kind" value="buy">
                        <input type="hidden" name="total" value="<?php print htmlspecialchars($total); ?>">
                        <input type="submit" value="購入">
                    </form>
                </p>
            <?php } ?>
            <a href="index.php">商品一覧に戻る</a>

    </main>

</body>

</html>