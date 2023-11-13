<?php

require "../services/predmet_sluzba.php";

$requiredFields = array("zkratka", "nazev", "anotace", "pocet_kreditu", "typ_ukonceni");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new predmetSluzba();
$service->vlozPredmet($toInsert);