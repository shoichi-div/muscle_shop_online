<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MUSCLE SHOP ONLINE</title>
    <style>
        body {
            background-image: url(./assets/images/login.jpg);
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        h2 {
            display: block;
            border-bottom: 1px solid #000;
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

        header p {
            font-size: 26px;
        }

        .logo {
            flex: 2;
        }

        .header-right {
            display: inline-block;
            text-align: right;
            vertical-align: middle;
            height: 20px;
            flex: 1;
            padding-right: 100px;
        }
    </style>

</head>

<body>
    <?php include_once VIEW_PATH . 'templates/header.php'; ?>
    <main class="w-50 bg-light mt-5 mx-auto">
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

            <h1 class="p-3">新規会員登録</h1>

            <?php if ($result_msg === '登録が完了しました！') { ?>
                <br>
                <p>以下の情報はスクリーンショット、<br>もしくはメモをとって大事に保管してください。</p><br>
                <p>ユーザー名：<?php print htmlspecialchars($user_name); ?><br>
                    パスワード：<?php print htmlspecialchars($password); ?></p>
                <a href="login.php">ログインページへ戻る</a>
            <?php } else { ?>

                <form method="post" class="text-center ml-4 p-3">
                    <div>ユーザー名:<input type="text" name="user_name"></div>
                    <div>パスワード:<input type="password" name="password"></div>
                    <input type="submit" value="登録" class="btn btn-warning mt-2">
                </form>
            <?php } ?>

    </main>

</body>

</html>