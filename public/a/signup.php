<?php
require_once "../../common/session.php";

if (!isset($_POST["email"]) || !isset($_POST["confirmemail"]) || !isset($_POST["password"])) {
    header("Location: ../v/signup.php?error=" . urlencode("Credentials weren't supplied"));
    die();
}

if ($_POST["email"] != $_POST["confirmemail"]) {
    header("Location: ../v/signup.php?error=" . urlencode("Emails differ"));
    die();
}

$user = User::create(
    [
        "email" => $_POST["email"],
        "password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
        "role_id" => Role::select(Filter::nome()->eq("USER"), limit: 1)[0]->getId(),
    ]
);

Session::create(
    [
        "ip"=>$_SERVER["REMOTE_ADDR"],
        "data_login"=> date('Y-m-d H:i:s'),
        "user_id"=>$user->getId(),
    ]
);
$_SESSION["current_user"] = $user;
header("Location: /");