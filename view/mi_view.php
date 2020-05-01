<?php
// クリックジャッキング対策
header('X-FRAME-OPTIONS: DENY');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once VIEW_PATH . 'templates/head.php'; ?>
    <title>MIとは</title>
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
        <div class="bg-light rounded p-3 m-3">
            <article class="ml-2">
                <h2 class="border-bottom border-warning">MIとは</h2>
                <p>MIとは「Muscle Investment」の略で、あなたのこれまでの<span>筋肉投資額</span>です。</p>
                <p>筋トレは最高の自己投資。</p>
                <p>筋肉への投資を続けて最高のリターンを目指しましょう！</p>
                <p>(MI横のボタンで非表示にもできます)</p>
            </article>
        </div>
    </main>
    <?php include_once VIEW_PATH . 'templates/footer.php'; ?>

</html>