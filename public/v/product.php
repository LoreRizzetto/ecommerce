<?php require_once '../../templates/top.php';
require_once '../../common/session.php';

if (!isset($_GET["id"]) || count($products = Product::select(Filter::id()->eq(0 + $_GET["id"]), limit: 1)) == 0) {
    header("Location: /");
    die();
};

$product = $products[0];
?>

    <div class="container">
        <div class="row">
            <div class="col-auto">
                <img src="https://placehold.co/300x400"></img>
            </div>
            <div class="col">
                <h1><?= htmlentities($product->getNome()) ?></h1>
                <p>
                    <?= htmlentities($product->getDescrizione()) ?>
                </p>
                <form action="../a/add_product.php" method="POST">
                    <input name="product_id" type="hidden" value="<?= $product->getId() ?>">
                    <label class="me-3">
                        <input name="product_qty" type="number" min="1" max="99" value="1" size="2">
                        x <?= $product->getPrezzo(); ?>€
                    </label>
                    <button class="btn btn-success" type="submit">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
    <!--
      TODO find better placement for btn and fix margins
    -->

<?php require_once '../../templates/bottom.php'; ?>