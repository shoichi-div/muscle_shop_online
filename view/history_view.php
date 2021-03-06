<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include VIEW_PATH . 'templates/head.php'; ?>
    <title>購入履歴</title>
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
            <h1>購入履歴</h1>

            <?php if (count($purchase_data) > 0) { ?>
                <table class="table table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>注文番号</th>
                            <th>購入日時</th>
                            <th>合計金額</th>
                            <th>購入明細</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($purchase_data) as $data) { ?>
                            <tr>
                                <td><?php print htmlspecialchars($data['buy_id']); ?></td>

                                <td><?php print htmlspecialchars($data['update']); ?></td>

                                <td><?php print htmlspecialchars(separate_number($data['total_price'])); ?>円</td>

                                <td>
                                    <form method="post" action="detail.php">
                                        <input type="submit" value="購入明細を見る" class="btn btn-warning">
                                        <input type="hidden" name="buy_id" value="<?php print htmlspecialchars($data['buy_id']); ?>">
                                        <input type="hidden" name="total" value="<?php print htmlspecialchars($data['total_price']); ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>購入履歴はありません。</p>
            <?php } ?>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>