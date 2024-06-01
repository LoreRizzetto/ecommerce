<?php
require_once '../../templates/top.php';
require_once '../../common/session.php';
require_auth();
global $CURRENT_USER;

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
);
?>

    <style>
        /* Chrome, Safari, Edge, Opera */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

    <div class="h-100 d-flex align-items-center justify-content-center">

        <div class="container">
            <ul class="list-group fs-2">
                <?php
                $totale = 0;
                foreach ($cart_products as $cart_product) :
                    $product = Product::select(
                        Filter::id()->eq($cart_product->getProduct_id())
                    )[0];

                    $subtotale = $product->getPrezzo() * $cart_product->getQty();
                    $totale += $subtotale;
                    ?>

                    <li class="list-group-item p-0">
                        <div class="row">
                            <div class="d-inline m-3 me-0 col">
                                <div class="container">
                                    <form class="row" method="POST" action="../a/change_product.php">
                                        <input type="hidden" name="product_id" value="<?= $cart_product->getProduct_id(); ?>">
                                        <button class="x-delete-btn form-control btn btn-danger rounded-0 rounded-start w-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                            </svg>
                                        </button>
                                        <input class="form-control text-center rounded-0 w-auto" type="number"
                                               name="product_qty" value="<?= $cart_product->getQty(); ?>" min="0" max="99">
                                        <button class="form-control btn btn-success rounded-0 rounded-end w-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                                                <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                                                <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                                            </svg>
                                        </button>
                                        <span class="ms-4 col-auto"><?= htmlentities($product->getNome()); ?></span>
                                    </form>
                                </div>
                            </div>
                            <div class="d-inline m-3 ms-0 col-auto text-right border-start border-secondary">
                                <?= $subtotale; ?>€
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>

                <li class="list-group-item p-0">
                    <div class="row">
                        <div class="d-inline m-3 me-0 col">
                            <b>Totale</b>
                        </div>
                        <div class="d-inline m-3 ms-0 col-auto text-right border-start border-secondary">
                            <b><?= $totale; ?>€</b>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <script>
        function click_deletebtn(e) {
            e.preventDefault();
            this.parentElement.querySelector("input[name=product_qty]").value = 0;
        }

        for (let obj of document.getElementsByClassName("x-delete-btn")) {
            obj.onclick = click_deletebtn;
        }
    </script>

<?php require_once '../../templates/bottom.php'; ?>