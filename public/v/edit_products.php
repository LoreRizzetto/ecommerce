<?php require_once '../../templates/top.php';
require_once '../../common/session.php'; ?>

<style>
    textarea {
        resize: none;
    }
    textarea:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
<div class="container">
    <div class="row mb-3">
        <div class="col-auto">
            <button style="opacity: 0;" class="disabled form-control btn btn-success w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                    <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                    <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                </svg>
            </button>
        </div>
        <div class="col-3">
            <h3 class="card-title">Nome</h3>
        </div>
        <div class="col">
            <h3 class="card-title">Descrizione</h3>
        </div>
        <div class="col-1">
            <h3 class="card-title">Prezzo</h3>
        </div>
        <div class="col-1">
            <h3 class="card-title">Marca</h3>
        </div>
    </div>
    <?php
    $i = "1";
    foreach (Product::select() as $product) {
        $product_name = htmlentities($product->getNome());
        $product_desc = htmlentities($product->getDescrizione());
        $product_brand = htmlentities($product->getMarca());
        echo <<<EOF
            <form class="row pb-2" method="POST" action="../a/edit_product.php">
                <input type="hidden" name="product_id" value="{$product->getId()}">
                <div class="col-auto">
                    <button class="form-control btn btn-success w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy-fill" viewBox="0 0 16 16">
                          <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"/>
                          <path d="M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"/>
                        </svg>
                    </button>
                </div>
                <div class="col-3">
                    <textarea name="product_name" class="form-control border-0 p-0">$product_name</textarea>
                </div>
                <div class="col">
                    <textarea name="product_desc" class="form-control border-0 p-0">$product_desc</textarea>
                </div>
                <div class="col-1">
                    <textarea name="product_price" class="form-control border-0 p-0">{$product->getPrezzo()}</textarea>
                </div>
                <div class="col-1">
                    <textarea name="product_brand" class="form-control border-0 p-0">{$product}</textarea>
                </div>
            </form>
        EOF;
    }
    ?>
</div>

<?php require_once '../../templates/bottom.php'; ?>
