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

        .signup_form {
            width: 20em;
        }
    </style>

</head>

<body>
    <?php include_once VIEW_PATH . 'templates/header.php'; ?>
    <main class="w-50 bg-light mt-5 mx-auto">

        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>

        <h1 class="p-3">新規会員登録</h1>

        <?php if ($result_msg === '登録が完了しました！') { ?>
            <br>
            <p>以下の情報はスクリーンショット、<br>もしくはメモをとって大事に保管してください。</p><br>
            <p>ユーザー名：<?php print htmlspecialchars($user_name); ?><br>
                パスワード：<?php print htmlspecialchars($password); ?></p>
            <a href="login.php">ログインページへ戻る</a>
        <?php } else { ?>

            <form method="post" class="signup_form mx-auto p-3" action="register_process.php">
                <div class="form-group">
                    <label for="name">名前: </label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">パスワード: </label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認用）: </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>
                <input type="submit" value="登録" class="btn btn-warning">
                <input type="hidden" name="token" value="<?php print htmlspecialchars($token) ?>">
            </form>
        <?php } ?>

    </main>

</body>

</html>