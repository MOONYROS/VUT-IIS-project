<?php

require_once "../../services/user_service.php";

$requiredFields = array("jmeno", "prijmeni", "email", "heslo", "telefon", "role");
$toInsert = array();

foreach($requiredFields as $field) {
    if ($field == "heslo") {
        $toInsert[] = password_hash($_POST[$field], PASSWORD_DEFAULT);
    }
    else {
        $toInsert[] = $_POST[$field];
    }
}

$service = new userService();
$message = $service->insertNewUser($toInsert);
header("Location: ../../views/user_views/user_management.php?message=$message");
