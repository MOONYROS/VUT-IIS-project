<?php

require_once "../../services/activity_service.php";

$requiredFields = array('mistnost', 'den', 'start', 'vyucujici', 'ID_Aktiv');
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new activityService();
$service->scheduleActivity($toInsert);

header("Location: ../../views/scheduler_views/schedule_activities.php");
