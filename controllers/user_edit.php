<?php

require "../services/account_service.php";

$requiredFields = array("jmeno", "prijmeni", "email", "heslo", "telefon", "role", "ID_Osoba");
$toInsert = array();

foreach($requiredFields as $field) {
    if ($field == "heslo") {
        $toInsert[] = password_hash($_POST[$field], PASSWORD_DEFAULT);
    }
    else {
        $toInsert[] = $_POST[$field];
    }
}

$service = new AccountService();
$service->updateUser($toInsert);
