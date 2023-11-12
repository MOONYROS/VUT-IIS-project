<?php

require "account_service.php";

$requiredFields = array("jmeno", "prijmeni", "email", "telefon", "role");
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
$service->insertNewAccount($toInsert);
