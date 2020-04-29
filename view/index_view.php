<!DOCTYPE html>
<html lang="ja">

<head>
    <title>MUSCLE SHOP ONLINE</title>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <style>
        .itemlist {
            border: 1px solid #000;
            background-color: #ee7800;
            display: flex;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>

        <!--MI表示-->
        <?php foreach ($mi_data as $mdt) { ?>
            <p>
                <?php if ($mdt['mi_status'] !== 0) { ?>
                    あなたのMI<sup>※</sup>は<span><?php print htmlspecialchars($mdt['mi']); ?></span>です！
                <?php } ?>
                <form method="post" action="michange">
                    <input type="hidden" name="mi_status" value="<?php if ($mdt['mi_status'] === 1) {
                                                                        print 0;
                                                                    } else if ($mdt['mi_status'] === 0) {
                                                                        print 1;
                                                                    } ?>">
                    <label><input type="submit" value="<?php if ($mdt['mi_status'] === 1) {
                                                            print htmlspecialchars("MI表示→非表示");
                                                        } else if ($mdt['mi_status'] === 0) {
                                                            print htmlspecialchars("MI非表示→表示");
                                                        } ?>"></label>
                </form>
                <a href="mi.php"><sup>※</sup>MIとは</a>
            </p>
        <?php } ?>

        <h2>商品一覧</h2>
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
        <section id="purpose">
            <a href="./purpose.php">筋トレが初めての方はこちら!(目的別おすすめグッズ)</a>
        </section>

        <form method="post" action="index_serch.php">
            カテゴリ:<select name="category">
                <option value="ALL">ALL</option>
                <option value="ウエイト" <?php if ($category === '%ウエイト%') { ?> selected <?php } ?>>ウエイト</option>
                <option value="自重補助" <?php if ($category === '%自重補助%') { ?> selected <?php } ?>>自重補助</option>
                <option value="その他" <?php if ($category === '%その他%') { ?> selected <?php } ?>>その他</option>
            </select>
            部位:<select name="part">
                <option value="ALL">ALL</option>
                <option value="腕" <?php if ($part === '%腕%') { ?> selected <?php } ?>>腕</option>
                <option value="肩" <?php if ($part === '%肩%') { ?> selected <?php } ?>>肩</option>
                <option value="胸" <?php if ($part === '%胸%') { ?> selected <?php } ?>>胸</option>
                <option value="腹" <?php if ($part === '%腹%') { ?> selected <?php } ?>>腹</option>
                <option value="背中" <?php if ($part === '%背中%') { ?> selected <?php } ?>>背中</option>
                <option value="下半身" <?php if ($part === '%下半身%') { ?> selected <?php } ?>>下半身</option>
            </select>
            <label for="keyword">キーワード：</label><input type="text" name="keyword" id="keyword" value="<?php print htmlspecialchars($word); ?>">
            <input type="hidden" name="token" value="<?php print htmlspecialchars($token) ?>">
            <input type="submit" value="検索">
        </form>

        <?php foreach ($item_data as $dt) { ?>
            <section class="itemlist">
                <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                <ul>
                    <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                    <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                    <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                    <li>価格：<?php print htmlspecialchars($dt['price']); ?>円</li>
                    <li>
                        <form method="post" action="index_add_cart.php">
                            個数：<input type="text" name="amount" value="1">個
                            <input type="hidden" name="item_id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                            <?php if ($dt['stock'] > 0) { ?>
                                <input type="hidden" name="stock" value="<?php print htmlspecialchars($dt['stock']); ?>">
                                <input type="hidden" name="token" value="<?php print htmlspecialchars($token) ?>">
                                <input type="submit" name="item" value="カートに追加">
                            <?php } else { ?>
                                <p>売り切れ</p>
                            <?php } ?>
                        </form>
                    </li>
                </ul>
            </section>
        <?php } ?>
    </main>

</body>

</html>