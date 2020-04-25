<header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="<?php print(HOME_URL); ?>">
            <img class="logo" src="./assets/images/logo.png" alt="サイトのロゴです">
            <h1>あなたの「筋トレ」が見つかるサイト</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="headerNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php print(CART_URL); ?>">カート</a>
                </li>
                <li>
                    <a class="nav-link" href="<?php print(HISTORY_URL); ?>">購入履歴</a>
                </li>
                <?php if ($user_name === 'admin') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php print(ADMIN_URL); ?>">管理画面</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php print(LOGOUT_URL); ?>">ログアウト</a>
                </li>
            </ul>
        </div>
    </nav>
    <p>ようこそ、<?php print($user_name); ?>さん。</p>
</header>