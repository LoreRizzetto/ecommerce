<?php
require_once '../../db/init.php';

session_start();
$CURRENT_USER = null;

if (isset($_SESSION["current_user"])) {
    $CURRENT_USER = $_SESSION["current_user"];
}

function require_auth(): void {
    global $CURRENT_USER;

    if ($CURRENT_USER === null) {
        header("Location: /v/login.php");
        die();
    }
}

function is_admin(): bool {
    global $CURRENT_USER;
    return Role::select(Filter::id()->eq($CURRENT_USER->getRole_id()))[0]->getNome() === "ADMIN";
}

function require_admin(): void {
    global $CURRENT_USER;
    require_auth();

    if (!is_admin()) {
        http_send_status(403);
        echo "Unauthorized";
        die();
    }
}
