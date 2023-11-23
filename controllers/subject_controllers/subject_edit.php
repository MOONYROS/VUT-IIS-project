<?php

require_once "../../services/subject_service.php";

$requiredFields = array("nazev", "anotace", "pocet_kreditu", "typ_ukonceni", "garant",  "zkratka");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[$field] = $_POST[$field];
}

$service = new subjectService();
$service->updateSubject($toInsert);
$subjectId = urlencode("{$_POST["zkratka"]}");
header("Location: ../../views/subject_views/subject_info_admin.php?zkratka=$subjectId");
