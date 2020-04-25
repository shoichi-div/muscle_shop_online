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

        span {
            border-bottom: 3px solid #ee8700;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <?php include_once VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>
        <!--エラーがあれば表示-->
        <?php if (count($err_msg) > 0) { ?>
            <ul>
                <?php foreach ($err_msg as $value) { ?>
                    <li><?php print $value; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <h2>MIとは</h2>
        <p>MIとは「Muscle Investment」の略で、あなたのこれまでの<span>筋肉投資額</span>です。</p>
        <p>筋トレは最高の自己投資。</p>
        <p>筋肉への投資を続けて最高のリターンを目指しましょう！</p>
        <p>(MI横のボタンで非表示にもできます)</p>
        <a href="index.php">商品一覧に戻る</a>
    </main>

</html>