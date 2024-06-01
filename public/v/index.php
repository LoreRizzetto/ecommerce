<?php require_once '../../templates/top.php'; ?>

    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 gy-4">
            <?php foreach (Product::select() as $product): ?>
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top" src="https://placehold.co/250x300" alt="Product image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlentities($product->getNome()); ?></h5>
                            <p class="card-text"><?= htmlentities($product->getDescrizione()); ?></p>
                            <a href="product.php?id=<?= $product->getId(); ?>" class="btn btn-primary">See</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php require_once '../../templates/bottom.php'; ?>