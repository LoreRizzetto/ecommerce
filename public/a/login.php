<?php
require_once "../../common/session.php";

if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    http_response_code(400);
    header("Location: ../v/login.php?error=" . urlencode("Credentials weren't supplied"));
    die();
}

if (count(
    $users = User::select(
        Filter::email()->eq($_POST["email"]),
        limit: 1
    )
    ) >= 1) {
    $user = $users[0];
    if (password_verify($_POST["password"], $user->getPassword())){
        Session::create(
            [
                "ip"=>$_SERVER["REMOTE_ADDR"],
                "data_login"=> date('Y-m-d H:i:s'),
                "user_id"=>$user->getId(),
            ]
        );
        $_SESSION["current_user"] = $user;
        header("Location: /");
        die();
    }
}

header("Location: ../v/login.php?error=" . urlencode("Invalid credentials"));
die();