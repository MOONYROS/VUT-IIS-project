<?php

require_once "../../services/subject_service.php";

$requiredFields = array("zkratka", "nazev", "anotace", "pocet_kreditu", "typ_ukonceni");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new subjectService();
$message = $service->insertNewSubject($toInsert);
header("Location: ../../views/subject_views/subject_management.php?message=$message");
