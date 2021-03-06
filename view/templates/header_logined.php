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
                    <a class="nav-link" href="<?php print(HOME_URL); ?>">マーケット</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php print(CART_URL); ?>">カート</a>
                </li>
                <li>
                    <a class="nav-link" href="<?php print(HISTORY_URL); ?>">購入履歴</a>
                </li>
                <?php
                $user = get_login_user($dbh);
                if (is_admin($user) === true) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php print(ADMIN_URL); ?>">商品管理画面</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php print(USER_URL); ?>">ユーザー管理画面</a>
                    </li>

                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php print(LOGOUT_URL); ?>">ログアウト</a>
                </li>
            </ul>
        </div>
        <p>ようこそ、<?php print($user['user_name']); ?>さん。</p>
    </nav>
</header>