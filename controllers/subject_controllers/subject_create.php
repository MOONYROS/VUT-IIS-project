<?php

require_once "../../services/subject_service.php";

$requiredFields = array("zkratka", "nazev", "anotace", "pocet_kreditu", "typ_ukonceni", "garant");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[$field] = $_POST[$field];
}

$service = new subjectService();
$message = $service->insertNewSubject($toInsert);
header("Location: ../../views/subject_views/subject_management_admin.php?message=$message");
