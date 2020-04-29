<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
    <style>
        header {
            /*height: 80px;*/
            border-bottom: solid 2px #ee7800;
            display: flex;
        }

        h1 {
            color: #000;
            font-size: 20px;
            font-weight: normal;
            margin: 0;
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
    <?php include_once VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>

                <h2>
                    ご購入ありがとうございます！<br>
                    到着を楽しみにお待ちください。
                </h2>

                <?php $total = 0; ?>
                <?php foreach ($carts as $dt) { ?>
                    <?php $subtotal =  $dt['price'] * $dt['amount']; ?>
                    <section class="itemlist">
                        <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                        <ul>
                            <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                            <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                            <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                            <li>価格：<?php print htmlspecialchars($dt['price']); ?></li>
                            <li>個数：<?php print htmlspecialchars($dt['amount']); ?>個</li>
                            <li>小計：<?php print htmlspecialchars($subtotal); ?>円</li>
                        </ul>
                    </section>
                    <?php $total = $total + $subtotal; ?>
                <?php } ?>
                <p>
                    合計金額：<?php print htmlspecialchars($total); ?>円
                </p>
            <a href="index.php">商品一覧に戻る</a>

    </main>

</body>

</html>