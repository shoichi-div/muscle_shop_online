<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>カート</title>
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
    <?php include_once VIEW_PATH . '/templates/header_logined.php'; ?>
    <main>
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
        <div class="bg-white rounded m-3 p-3">
            <?php if (empty($cart)) { ?>
                <p>カートに商品が入っていません</p>
            <?php } else { ?>
                <h2 class="ml-2">カート内の商品</h2>

                <?php $total = 0; ?>
                <section class="container-fluid">
                    <div class="row">
                        <?php foreach ($cart as $dt) { ?>
                            <?php $subtotal =  $dt['price'] * $dt['amount']; ?>
                            <div class="col-lg-5 bg-light rounded p-2 mx-auto my-2 row">
                                <img class="col-md-5" src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                                <ul class="col-md-5">
                                    <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                                    <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                                    <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                                    <li>価格：<?php print htmlspecialchars(separate_number($dt['price'])); ?>円</li>
                                    <li>
                                        <form method="post" action="cart_change_amount.php">
                                            個数：<input type="text" name="amount" value="<?php print htmlspecialchars(separate_number($dt['amount'])); ?>">個
                                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['id']); ?>">
                                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                            <input class="btn btn-warning" type="submit" value="個数変更">
                                        </form>
                                    </li>
                                    <li>小計：<?php print htmlspecialchars(separate_number($subtotal)); ?>円</li>
                                    <li>
                                        <form method="post" action="cart_delete.php">
                                            <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['id']); ?>">
                                            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                                            <input class="btn btn-warning" type="submit" value="商品削除">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <?php $total = $total + $subtotal; ?>
                        <?php } ?>
                    </div>
                </section>
                <p class="ml-4">合計金額：<?php print htmlspecialchars(separate_number($total)); ?>円</p>
                <form class="ml-4" method="post" action="finish.php">
                    <input type="hidden" name="total" value="<?php print htmlspecialchars($total); ?>">
                    <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
                    <input class="btn btn-warning" type="submit" value="購入">
                </form>
            <?php } ?>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>