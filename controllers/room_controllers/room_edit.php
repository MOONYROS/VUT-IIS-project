<?php

require_once "../../services/room_service.php";

$requiredFields = array("kapacita", "typ", "popis", "umisteni", "ID_mist");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new roomService();
$message = $service->updateRoom($toInsert);
header("Location: ../../views/room_views/room_management.php?message=$message");