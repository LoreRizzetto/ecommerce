<?php
require_once "../../common/session.php";
require_auth();
global $CURRENT_USER;

if (!isset($_POST["product_id"]) || !isset($_POST["product_qty"])) {
    echo "Invalid parameters. Expected product_id and product_qty";
    die();
}

if ($_POST["product_qty"] <= 0) {
    echo "Invalid quantity";
    die();
}

$carts = Cart::select(
    Filter::user_id()->eq($CURRENT_USER->getId())
);

if (count($carts)) {
    $cart = $carts[0];
} else {
    $cart = Cart::create([
        "user_id" => $CURRENT_USER->getId()
    ]);
}

$cart_products = Cart_Product::select(
    Filter::cart_id()->eq($cart->getId())
        ->and(Filter::product_id()->eq($_POST["product_id"]))
);

if (count($cart_products)) {
    $cart_product = $cart_products[0];
    $cart_product->update([
        "qty" => $cart_product->getQty() + $_POST["product_qty"]]);
} else {
    Cart_Product::create([
        "cart_id" => $cart->getId(),
        "product_id" => $_POST["product_id"],
        "qty" => $_POST["product_qty"]
    ]);
}

header("Location: /v/cart.php");
