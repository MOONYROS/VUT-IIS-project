<?php

require 'common.php';
require 'services/account_service.php';

$email = $_POST['email'];
$heslo = $_POST['heslo'];

$service = new AccountService();
$user = $service->verifyLogin($email, $heslo);

if ($user) {
    $_SESSION['user_id'] = $user['ID_Osoba'];
    // Přesměrování na chráněnou stránku nebo dashboard
    header("Location: main_page.php");
    exit;
}
else {
    // Přihlášení selhalo, vrátit zpět na přihlašovací stránku s chybovou zprávou
    header("Location: index.php?error=1");
    exit;
}
