<?php
// AUTO GENERATED FILE. DO NOT EDIT. CHANGES WILL BE OVERWRITTEN

require "User.php";
require "Session.php";
require "Role.php";
require "Cart.php";
require "Product.php";
require "Cart_Product.php";
require "filter.php";

require "../../config.php";

$pdo = new PDO(
    "mysql:dbname=$DB_DATABASE;host=$DB_HOST;port=$DB_PORT;",
    $DB_USERNAME,
    $DB_PASSWORD,
);

User::$pdo = $pdo;
Session::$pdo = $pdo;
Role::$pdo = $pdo;
Cart::$pdo = $pdo;
Product::$pdo = $pdo;
Cart_Product::$pdo = $pdo;
