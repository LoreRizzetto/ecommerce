<?php
require_once "../../common/session.php";
require_admin();
global $CURRENT_USER;

if (
    !isset($_POST["product_id"])
    || !isset($_POST["product_name"])
    || !isset($_POST["product_desc"])
    || !isset($_POST["product_price"])
    || !isset($_POST["product_brand"])
) {
    echo "Missing parameters";
    die();
}

$product = Product::select(Filter::id()->eq($_POST["product_id"]))[0];
$product->setNome($_POST["product_name"]);
$product->setDescrizione($_POST["product_desc"]);
$product->setPrezzo($_POST["product_price"]);
$product->setMarca($_POST["product_brand"]);
$product->update();

header("Location: /v/edit_products.php");

