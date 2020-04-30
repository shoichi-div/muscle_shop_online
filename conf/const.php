<?php

//データベースの接続情報
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');
define('DSN', 'mysql:dbname=' . DB_NAME . ';host=localhost;charset=utf8');


define('HTML_CHARACTER_SET', 'UTF-8');

define('VIEW_PATH', '../view/');
define('MODEL_PATH', '../model/');

define('SIGNUP_URL', '/register.php');
define('HOME_URL', './index.php');
define('ADMIN_URL', './admin.php');
define('HISTORY_URL', './history.php');
define('LOGIN_URL', './login.php');
define('LOGOUT_URL', './logout.php');
define('CART_URL', './cart.php');
define('USER_URL', './user.php');

define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');


define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 100);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);

define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 100);

define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);

define('PERMITTED_ITEM_STATUSES', array(
    'open' => 1,
    'close' => 0,
));

define('PERMITTED_IMAGE_TYPES', array(
    IMAGETYPE_JPEG => 'jpg',
    IMAGETYPE_PNG => 'png',
));


$img_dir = './assets/images/';
