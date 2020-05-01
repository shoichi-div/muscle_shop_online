<?php

function delete_cart($dbh, $cart_id)
{
  $sql = "
    DELETE FROM
      ec_cart
    WHERE
      id = ?
  ";
  try {
    return execute_query($dbh, $sql, array($cart_id));
  } catch (PDOException $e) {
    set_error('更新に失敗しました。');
  }
  return false;
}

function get_user_carts($dbh, $user_id)
{
    $sql =
        "SELECT
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.status,
        ec_item_master.img,
        ec_item_master.part,
        ec_item_master.menu,
        ec_stock_master.stock,
        ec_cart.id,
        ec_cart.user_id,
        ec_cart.amount
    FROM
        ec_cart
    INNER JOIN
        ec_item_master
    ON
        ec_cart.item_id = ec_item_master.item_id
    INNER JOIN
        ec_stock_master
    ON
        ec_stock_master.stock_id = ec_item_master.item_id
    WHERE
      ec_cart.user_id = ?
  ";
    try {
        return fetch_all_query($dbh, $sql, array($user_id));
    } catch (PDOException $e) {
        set_error('データ取得に失敗しました。');
    }
    return false;
}

function get_user_cart($dbh, $user_id, $item_id)
{
  $sql = 
    "SELECT
        ec_item_master.item_id,
        ec_item_master.name,
        ec_item_master.price,
        ec_item_master.status,
        ec_item_master.img,
        ec_stock_master.stock,
        ec_cart.id,
        ec_cart.user_id,
        ec_cart.amount
    FROM
        ec_cart
    INNER JOIN
        ec_item_master
    ON
        ec_cart.item_id = ec_item_master.item_id
    INNER JOIN
        ec_stock_master
    ON
        ec_stock_master.stock_id = ec_item_master.item_id
    WHERE
      ec_cart.user_id = ?
    AND
      ec_item_master.item_id = ?;
  ";
  try {
    return fetch_query($dbh, $sql, array($user_id, $item_id));
  } catch (PDOException $e) {
    set_error('データ取得に失敗しました。');
  }
  return false;
}


function add_cart($dbh, $user_id, $item_id, $amount){
    $cart = get_user_cart($dbh, $user_id, $item_id);
    if ($cart === false) {
        return insert_cart($dbh, $item_id, $user_id, $amount);
    }
    return update_cart_amount($dbh, $cart['id'], $cart['amount'] + $amount);
}

function insert_cart($dbh, $item_id, $user_id, $amount)
{
    $sql = "
    INSERT INTO
      ec_cart(
        item_id,
        user_id,
        amount
      )
    VALUES(?, ?, ?);
  ";
    try {
        return execute_query($dbh, $sql, array($item_id, $user_id, $amount));
    } catch (PDOException $e) {
        set_error('更新に失敗しました。');
    }
    return false;
}

function update_cart_amount($dbh, $cart_id, $amount)
{
    $sql = "
    UPDATE
      ec_cart
    SET
      amount = ?
    WHERE
      id = ?
  ";
    try {
        return execute_query($dbh, $sql, array($amount, $cart_id));
    } catch (PDOException $e) {
        set_error('更新に失敗しました。');
    }
    return false;
}

function purchase_carts($dbh, $carts)
{
    if (validate_cart_purchase($carts) === false) {
        return false;
    }
    foreach ($carts as $cart) {
        if (update_item_stock($dbh, $cart['item_id'], $cart['stock'] - $cart['amount']) === false) {
            set_error($cart['name'] . 'の購入に失敗しました。');
        }
    }
    return true;
}

function validate_cart_purchase($carts)
{
    if (count($carts) === 0) {
        set_error('カートに商品が入っていません。');
    }
    foreach ($carts as $cart) {
        if (is_open($cart) === false) {
            set_error($cart['name'] . 'は現在購入できません。');
        }
        if ($cart['stock'] - $cart['amount'] < 0) {
            set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
        }
    }
    if (has_error() === true) {
        return false;
    }
    return true;

}

function delete_user_carts($dbh, $user_id)
{
    $sql = "
    DELETE FROM
      ec_cart
    WHERE
      user_id = ?
  ";
    try {
        return execute_query($dbh, $sql, array($user_id));
    } catch (PDOException $e) {
        set_error('更新に失敗しました。');
    }
    return false;
}


function sum_carts($carts)
{
    $total_price = 0;
    foreach ($carts as $cart) {
        $total_price += $cart['price'] * $cart['amount'];
    }
    return $total_price;
}

