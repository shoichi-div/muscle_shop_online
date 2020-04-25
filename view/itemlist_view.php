<!DOCTYPE html>
<html lang="ja">

<head>
    <title>MUSCLE SHOP ONLINE</title>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <style>

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

        span {
            color: #ee7800;
            font-size: 24px;
        }

        li {
            list-style: none;
        }

        header a {
            text-decoration: none;
            display: block;
        }

        a:hover {
            text-decoration: underline #000;
        }

        #cart:hover {
            background-color: #74d9e8;
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
    <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
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

            <?php if ($user_name === 'admin') { ?>
                <a href="admin.php">商品管理ページへ移動</a>
            <?php } ?>



            <?php if ($process_kind === '' || $process_kind === 'mi_change') { ?>
                <?php if ($user_name !== 'admin') { ?>
                    <!--MI表示-->
                    <?php foreach ($mi_data as $mdt) { ?>
                        <p>
                            <?php if ($mdt['mi_status'] !== 0) { ?>
                                あなたのMI<sup>※</sup>は<span><?php print htmlspecialchars($mdt['mi']); ?></span>です！
                            <?php } ?>
                            <form method="post">
                                <input type="hidden" name="process_kind" value="mi_change">
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
                <?php } ?>

            <?php } ?>

            <?php if ($process_kind !== 'cart') { ?>

                <h2>商品を検索</h2>
                <section id="purpose">
                    <a href="./purpose.php">筋トレが初めての方はこちら!(目的別おすすめグッズ)</a>
                </section>

                <form method="post">
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
                    キーワード：<input type="text" name="keyword" value="<?php print htmlspecialchars($word); ?>">
                    <input type="hidden" name="process_kind" value="serch">
                    <input type="submit" value="検索">
                </form>

                <?php foreach ($data as $dt) { ?>
                    <section class="itemlist">
                        <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                        <ul>
                            <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                            <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                            <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                            <li>価格：<?php print htmlspecialchars($dt['price']); ?>円</li>
                            <li>
                                <form method="post">
                                    個数：<input type="text" name="amount" value="1">個
                                    <input type="hidden" name="process_kind" value="cart">
                                    <input type="hidden" name="id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                                    <?php if ($dt['stock'] > 0) { ?>
                                        <input type="hidden" name="stock" value="<?php print htmlspecialchars($dt['stock']); ?>">
                                        <input type="submit" name="item" value="カートに追加">
                                    <?php } else { ?>
                                        <p>売り切れ</p>
                                    <?php } ?>
                                </form>
                            </li>
                        </ul>
                    </section>
                <?php } ?>
            <?php } else { ?>

                <?php foreach ($data as $dt) { ?>
                    <section class="itemlist">
                        <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                        <ul>
                            <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                            <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                            <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                            <li>価格：<?php print htmlspecialchars($dt['price']); ?></li>
                            <li>個数：<?php print htmlspecialchars($dt['amount']); ?>個</li>
                        </ul>
                    </section>
                <?php } ?>
                <p><a href="cart.php">カートに移動する</a></p>
                <p><a href="index.php">商品一覧に戻る</a></p>
            <?php } ?>
    </main>

</body>

</html>