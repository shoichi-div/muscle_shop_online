<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>ユーザー管理画面</title>
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
    <?php include_once VIEW_PATH . 'templates/header_logined.php'; ?>
    <main>
        <?php include_once VIEW_PATH . 'templates/messages.php'; ?>
        <div class="bg-light rounded m-3 p-3">
            <h2>ユーザー一覧</h2>
            <table class="table table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>ユーザー名</th>
                        <th>パスワード</th>
                        <th>MI</th>
                        <th>登録日時</th>
                    </tr>


                    <?php foreach ($user_data as $dt) { ?>
                        <tr>
                            <td><?php print htmlspecialchars($dt['user_name']); ?></td>
                            <td><?php print htmlspecialchars($dt['password']); ?></td>
                            <td><?php print htmlspecialchars($dt['mi']); ?></td>
                            <td><?php print htmlspecialchars($dt['create_datetime']); ?></td>
                        </tr>
                    <?php } ?>
                </thead>
            </table>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>
</body>

</html>