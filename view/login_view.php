<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>ログイン</title>
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

<body>
    <?php include_once VIEW_PATH . 'templates/header.php'; ?>
    <main class="w-50 bg-light rounded p-3 my-3 mx-auto">
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>

        <h2>ログイン</h2>

        <form method="post" action="login_process.php" class="login_form mx-auto">
            <div class="form-group">
                <label for="name">ユーザー名:</label>
                <input type="text" id="name" name="user_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">パスワード:</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <input type="submit" name="login" value="ログイン" class="btn btn-warning mt-2 form-control">
            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
        </form>
        <form action="register.php" class="mx-auto">
            <input type="submit" name="register" value="新規会員登録" class="btn btn-warning mt-2 form-control">
            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
        </form>
        <form method="post" action="login_process.php" class="mx-auto">
            <input type="submit" name="test_login" value="簡単ログイン" class="btn btn-warning mt-2 form-control">
            <input type="hidden" name="user_name" value="testuser">
            <input type="hidden" name="user_kind" value="guest">
            <input type="hidden" name="token" value="<?php print htmlspecialchars($token); ?>">
        </form>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>