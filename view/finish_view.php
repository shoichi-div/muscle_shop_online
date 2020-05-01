<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>購入結果</title>
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
    <?php include_once VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>
        <div class="bg-white rounded m-3 p-3">
            <h2>
                ご購入ありがとうございます！<br>
                到着を楽しみにお待ちください。
            </h2>

            <?php $total = 0; ?>
            <section class="container-fluid">
                <div class="row">
                    <?php foreach ($carts as $dt) { ?>
                        <?php $subtotal =  $dt['price'] * $dt['amount']; ?>
                        <div class="bg-light rounded d-flex col-lg-5 p-2 mx-auto my-2">
                            <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                            <ul>
                                <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                                <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                                <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                                <li>価格：<?php print htmlspecialchars($dt['price']); ?></li>
                                <li>個数：<?php print htmlspecialchars($dt['amount']); ?>個</li>
                                <li>小計：<?php print htmlspecialchars($subtotal); ?>円</li>
                            </ul>
                        </div>
                        <?php $total = $total + $subtotal; ?>
                    <?php } ?>
                </div>
                <p>合計金額：<?php print htmlspecialchars($total); ?>円</p>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>