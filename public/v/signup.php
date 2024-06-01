<?php require_once '../../templates/top.php'; ?>

<div class="h-100 d-flex align-items-center justify-content-center">
    <div class="border border-secondary">
        <form class="m-3" method="POST" action="../a/signup.php">
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email</label>
                <input class="form-control" id="emailInput" name="email" placeholder="you@example.com" required type="email"></input>
            </div>

            <div class="mb-3">
                <label for="confirmEmailInput" class="form-label">Conferma email</label>
                <input class="form-control" id="confirmEmailInput" name="confirmemail" placeholder="you@example.com" required type="email"></input>
            </div>

            <div class="mb-3">
                <label for="passwordInput" class="form-label">Password</label>
                <input class="form-control" id="passwordInput" name="password" type="password" placeholder="password" required></input>
            </div>

            <div class="mb-3 text-danger">
                <?= htmlentities($_GET["error"] ?? "");?>
            </div>

            <button class="btn btn-success">Sign Up</button>
        </form>
    </div>
</div>

<?php require_once '../../templates/bottom.php'; ?>
