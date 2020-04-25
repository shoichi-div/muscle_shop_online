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




            <h2>目的別おすすめグッズ紹介</h2>

            <h3>目的１：ダイエット</h3>
            <p>おすすめトレーニングメニュー：</p>
            <p> おすすめグッズ：</p>

            <h3>目的２：筋肉量増加</h3>
            <p>おすすめトレーニングメニュー：</p>
            <p>おすすめグッズ：</p>

            <a href="index.php">商品一覧に戻る</a>
    </main>

</body>

</html>