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

        th,
        td {
            border: 1px solid #000;
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
            <?php } else { ?>
                <li><?php print $result_msg; ?></li>
            <?php } ?>
            </ul>

            <a href="admin.php">商品管理ページへ移動</a>

            <h2>ユーザー一覧</h2>

            <table>
                <tr>
                    <th>ユーザー名</th>
                    <th>パスワード</th>
                    <th>MI</th>
                    <th>登録日時</th>
                </tr>


                <?php foreach ($data as $dt) { ?>
                    <tr>
                        <td><?php print htmlspecialchars($dt['user_name']); ?></td>
                        <td><?php print htmlspecialchars($dt['password']); ?></td>
                        <td><?php print htmlspecialchars($dt['mi']); ?></td>
                        <td><?php print htmlspecialchars($dt['update_datetime']); ?></td>
                    </tr>
                <?php } ?>
            </table>
            <a href="itemlist.php">商品一覧に移動</a>
    </main>
</body>

</html>