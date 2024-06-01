<?php require_once "../../common/session.php"; global $CURRENT_USER; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg m-2">
            <a class="navbar-brand" href="/"><img src="https://placehold.co/50x50"></img></a>
            <a class="navbar-brand" href="/"><h2>Ecommerce</h2></a>

            <?php if ($CURRENT_USER !== null):  ?>
                <div class="ms-auto navbar-nav">
                    <span class="align-self-center me-2">
                    Logged in as: <?= htmlentities($CURRENT_USER->getEmail()); ?>
                    </span>
                    <?php if (is_admin()): ?>
                        <a class="btn btn-outline-success me-2" href="../v/edit_products.php">Edit products</a>
                    <?php endif ?>
                    <a class="btn btn-outline-success me-2" href="../v/cart.php">Cart</a>
                    <a class="btn btn-outline-danger" href="../a/logout.php">Logout</a>
                </div>
            <?php else: ?>
                <div class="ms-auto navbar-nav">
                    <a class="btn btn-outline-success me-2" href="signup.php">Sign up</a>
                    <a class="btn btn-outline-success" href="login.php">Login</a>
                </div>
            <?php endif; ?>
    </nav>
