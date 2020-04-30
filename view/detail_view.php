<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
    <title>購入明細</title>
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
    <main>
        <div class="bg-light rounded p-3 m-3">
            <h1>購入明細</h1>
            <p>注文番号：<?php print htmlspecialchars($buy_id); ?></p>
            <p>合計金額：<?php print htmlspecialchars(separate_number($total_price)); ?></p>

            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>商品名</th>
                        <th>購入時の価格</th>
                        <th>個数</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchase_detail as $dt) { ?>
                        <tr>
                            <td><?php print htmlspecialchars($dt['name']); ?></td>

                            <td><?php print htmlspecialchars(separate_number($dt['price'])); ?></td>

                            <td><?php print htmlspecialchars(separate_number($dt['amount'])); ?></td>

                            <td><?php print htmlspecialchars(separate_number($subtotal[$dt['item_id']])); ?>円</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>