<?php

require_once '../common.php';
require_once "../services/user_service.php";


$email = $_POST['email'];
$heslo = $_POST['heslo'];

$service = new userService();
$user = $service->verifyLogin($email, $heslo);

if ($user) {
    $_SESSION['user_id'] = $user['ID_Osoba'];
    $_SESSION['logout_time'] = time();
    // Přesměrování na chráněnou stránku nebo dashboard
    header("Location: ../views/main_page.php");
    exit;
}
else {
    // Přihlášení selhalo, vrátit zpět na přihlašovací stránku s chybovou zprávou
    $email = urlencode($_POST["email"]);
    $message = urlencode("Přihlášení selhalo.");
    header("Location: ../index.php?error=1&email={$email}&message={$message}");
    exit;
}
