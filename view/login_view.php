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
    </style>

</head>

<body class="">
    <?php include_once VIEW_PATH . 'templates/header.php'; ?>
    <main class="w-50 bg-light mt-5 mx-auto">
        <?php if (count($err_msg) > 0) { ?>
            <ul>
                <?php foreach ($err_msg as $value) { ?>
                    <li><?php print $value; ?></li>
                <?php } ?>
            </ul>
        <?php } ?>
        <h1 class="p-3">ログイン</h1>

        <div class="text-center ml-4 p-3 d-flex">
            <form method="post" action="./login_session.php">
                <div>ユーザー名:<input type="text" name="user_name"></div>
                <div>パスワード:<input type="password" name="password"></div>
                <input type="submit" name="login" value="ログイン" class="btn btn-warning mt-2">
            </form>
            <form action="register.php">
                <input type="submit" name="register" value="新規会員登録" class="btn btn-warning m-2">
            </form>
        </div>




    </main>

</body>

</html>