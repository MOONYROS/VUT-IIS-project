<?php

require "../services/subject_service.php";

$requiredFields = array("nazev", "anotace", "pocet_kreditu", "typ_ukonceni", "zkratka");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new subjectService();
$service->updateSubject($toInsert);
