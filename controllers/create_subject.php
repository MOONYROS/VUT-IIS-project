<?php

require "../services/subject_service.php";

$requiredFields = array("zkratka", "nazev", "anotace", "pocet_kreditu", "typ_ukonceni");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new subjectService();
$service->insertNewSubject($toInsert);