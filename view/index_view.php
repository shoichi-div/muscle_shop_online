<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <title>Market</title>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
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
    <main class="m-3">
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
        <div class="bg-light rounded p-3">
            <h2>商品一覧</h2>
            <!--MI表示-->
            <?php if ($user['mi_status'] !== 0) { ?>
                あなたのMI<sup>※</sup>は<span class="text-warning font-weight-bold"><?php print htmlspecialchars(separate_number($user['mi'])); ?></span>です！
            <?php } ?>
            <form method="post" action="index_mi_status_change.php">
                <label><input class="btn btn-warning" type="submit" value="<?php if ($user['mi_status'] === 1) {
                                                                                print htmlspecialchars("MI表示→非表示");
                                                                            } else if ($user['mi_status'] === 0) {
                                                                                print htmlspecialchars("MI非表示→表示");
                                                                            } ?>"></label>
                <input type="hidden" name="mi_status" value="<?php if ($user['mi_status'] === 1) {
                                                                    print 0;
                                                                } else if ($user['mi_status'] === 0) {
                                                                    print 1;
                                                                } ?>">
                <input type="hidden" name="token" value="<?php print htmlspecialchars($token) ?>">
            </form>
            <a href="mi.php"><sup>※</sup>MIとは</a>
        </div>
        <div class="d-flex">
            <section class="bg-light d-inline-block rounded my-3 p-3 mr-5">
                <h3>商品検索</h3>
                <form method="get">
                    <label for="category">カテゴリ:</label>
                    <select class="btn btn-warning" name="category" id="category">
                        <option value="ALL">ALL</option>
                        <option value="ウエイト" <?php if ($category === '%ウエイト%') { ?> selected <?php } ?>>ウエイト</option>
                        <option value="自重補助" <?php if ($category === '%自重補助%') { ?> selected <?php } ?>>自重補助</option>
                        <option value="その他" <?php if ($category === '%その他%') { ?> selected <?php } ?>>その他</option>
                    </select>
                    <label for="part">部位:</label>
                    <select class="btn btn-warning" name="part" id="part">
                        <option value="ALL">ALL</option>
                        <option value="腕" <?php if ($part === '%腕%') { ?> selected <?php } ?>>腕</option>
                        <option value="肩" <?php if ($part === '%肩%') { ?> selected <?php } ?>>肩</option>
                        <option value="胸" <?php if ($part === '%胸%') { ?> selected <?php } ?>>胸</option>
                        <option value="腹" <?php if ($part === '%腹%') { ?> selected <?php } ?>>腹</option>
                        <option value="背中" <?php if ($part === '%背中%') { ?> selected <?php } ?>>背中</option>
                        <option value="下半身" <?php if ($part === '%下半身%') { ?> selected <?php } ?>>下半身</option>
                    </select>
                    <label for="keyword">キーワード：</label>
                    <input type="text" name="keyword" id="keyword" value="<?php print htmlspecialchars($word); ?>">
                    <input type="hidden" name="get_kind" value="<?php print 'serch' ?>">
                    <input class="btn btn-warning" type="submit" value="検索">
                </form>
            </section>
            <section class="bg-light d-inline-block rounded my-3 p-3">
                <h3 class="text-center">並び順</h3>
                <form method="get" name="sort_form">
                    <select class="btn btn-warning" name="sort">
                        <option name="option" value="new" <?php if ($sort === 'new' || $sort === '') { ?>selected<?php } ?>>新しい順</option>
                        <option name="option" value="low" <?php if ($sort === 'low') { ?>selected<?php } ?>>価格の安い順</option>
                        <option name="option" value="high" <?php if ($sort === 'high') { ?>selected<?php } ?>>価格の高い順</option>
                    </select>
                    <!-- 選んだ方式で並べ替えを実施 -->
                    <script>
                        document.sort_form.addEventListener('change', function() {
                            document.sort_form.submit();
                        }, false);
                    </script>
                    <input type="hidden" name="get_kind" value="<?php print 'sort' ?>">
                </form>
            </section>
        </div>


        <section class="container-fluid item_wrapper">
            <div class="row">
                <?php foreach ($item_data as $dt) { ?>
                    <div class="col-lg-5 bg-light rounded d-flex p-2 mx-auto my-2">
                        <img src="<?php print htmlspecialchars($img_dir . $dt['img']); ?>">
                        <ul>
                            <li>商品名：<?php print htmlspecialchars($dt['name']); ?></li>
                            <li>鍛えられる部位：<?php print htmlspecialchars($dt['part']); ?></li>
                            <li>筋トレメニュー：<?php print htmlspecialchars($dt['menu']); ?></li>
                            <li>価格：<?php print htmlspecialchars(separate_number($dt['price'])); ?>円</li>
                            <li>
                                <form method="post" action="index_add_cart.php">
                                    個数：<input type="text" name="amount" value="1">個
                                    <input type="hidden" name="item_id" value="<?php print htmlspecialchars($dt['item_id']); ?>">
                                    <?php if ($dt['stock'] > 0) { ?>
                                        <input type="hidden" name="stock" value="<?php print htmlspecialchars(separate_number($dt['stock'])); ?>">
                                        <input type="hidden" name="token" value="<?php print htmlspecialchars($token) ?>">
                                        <input class="btn btn-warning" type="submit" name="item" value="カートに追加">
                                    <?php } else { ?>
                                        <p>売り切れ</p>
                                    <?php } ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>