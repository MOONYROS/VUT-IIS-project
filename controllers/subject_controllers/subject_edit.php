<?php

require_once "../../services/subject_service.php";

if ($_POST["garant"] == "none") {
    $message = urlencode("Zvolte garanta předmětu.");
    header("Location: ../../views/subject_views/subject_info_admin.php?zkratka={$_POST["zkratka"]}&message=$message");
    exit;
}

$requiredFields = array("nazev", "anotace", "pocet_kreditu", "typ_ukonceni", "garant",  "zkratka");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[$field] = $_POST[$field];
}

$service = new subjectService();

$subjectInfo = $service->getSubjectInfo($_POST["zkratka"]);
if (!$subjectInfo) {
    $subjectInfo = $service->getSubjectInfoNoGarant($_POST["zkratka"]);
    $subjectInfo["garant"] = $_POST["garant"];
}
$currentGarant = $subjectInfo["garant"];
$teachers = $service->getSubjectTeachers($_POST["zkratka"]);
if (count($teachers) == 1) {
    $service->updateGarant($_POST["zkratka"], $currentGarant, $_POST["garant"]);
}
$message = $service->updateSubject($toInsert);


$subjectId = urlencode("{$_POST["zkratka"]}");
header("Location: ../../views/subject_views/subject_info_admin.php?zkratka=$subjectId&message=$message");
