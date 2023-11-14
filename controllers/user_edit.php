<?php

require "../services/user_service.php";

$requiredFields = array("jmeno", "prijmeni", "email", "heslo", "telefon", "role", "ID_Osoba");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new UserService();
$message = $service->updateUser($toInsert);
header("Location: ../views/user_management.php?message=$message");
