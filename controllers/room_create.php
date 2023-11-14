<?php

require "../services/room_service.php";

$requiredFields = array("ID_mist", "kapacita", "typ", "popis", "umisteni");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new roomService();
$service->insertNewRoom($toInsert);