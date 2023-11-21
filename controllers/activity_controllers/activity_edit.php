<?php

require_once "../../services/activity_service.php";

$requiredFields = array("typ", "delka", "popis", "opakovani", "pozadavek", "predmet", "ID_Aktiv");
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new activityService();
$message = $service->updateActivity($toInsert);
header("Location: ../../views/activity_views/activity_management.php?message=$message");
