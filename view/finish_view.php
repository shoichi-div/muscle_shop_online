<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>購入結果</title>

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
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>
</html>