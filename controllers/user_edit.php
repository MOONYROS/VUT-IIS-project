<?php

require "../services/account_service.php";

$requiredFields = array("jmeno", "prijmeni", "email", "heslo", "telefon", "role", "ID_Osoba");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new AccountService();
$service->updateUser($toInsert);
