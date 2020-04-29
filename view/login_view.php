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
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>

        <h1 class="p-3">ログイン</h1>

        <div class="text-center ml-4 p-3 d-flex">
            <form method="post" action="login_process.php">
                <div><label for="name">ユーザー名:</label><input type="text" id="name" name="user_name"></div>
                <div><label for="password">パスワード:</label><input type="password" id="password" name="password"></div>
                <input type="submit" name="login" value="ログイン" class="btn btn-warning mt-2">
                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
            </form>
            <form action="register.php">
                <input type="submit" name="register" value="新規会員登録" class="btn btn-warning m-5">
                <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
            </form>
        </div>




    </main>

</body>

</html>