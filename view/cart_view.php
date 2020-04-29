<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
    <style>
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
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
        <?php if (empty($cart)) { ?>
            <p>カートに商品が入っていません</p>
        <?php } else { ?>

            <h2>カート内の商品</h2>

            <?php $total = 0; ?>
            <?php foreach ($cart as $dt) { ?>
                <?php $subtotal =  $dt['price'] * $dt['amount']; ?>
                <section class="itemlist">
                    <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                    <ul>
                        <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                        <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                        <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                        <li>価格：<?php print htmlspecialchars($dt['price']); ?>円</li>
                        <li>
                            <form method="post" action="cart_change_amount.php">
                                個数：<input type="text" name="amount" value="<?php print htmlspecialchars($dt['amount']); ?>">個
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['id']); ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                <input type="submit" value="個数変更">
                            </form>
                        </li>
                        <li>小計：<?php print htmlspecialchars($subtotal); ?>円</li>
                        <li>
                            <form method="post" action="cart_delete.php">
                                <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['id']); ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
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
                    <input type="hidden" name="total" value="<?php print htmlspecialchars($total); ?>">
                    <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                    <input type="submit" value="購入">
                </form>
            </p>
        <?php } ?>
        <a href="index.php">商品一覧に戻る</a>

    </main>

</body>

</html>