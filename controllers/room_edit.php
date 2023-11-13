<?php

require "../services/room_service.php";

$requiredFields = array("kapacita", "typ", "popis", "umisteni", "ID_mist");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new roomService();
$service->updateRoom($toInsert);