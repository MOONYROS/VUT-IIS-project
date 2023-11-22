<?php

require_once "../../services/activity_service.php";

$requiredFields = array('mistnost', 'den', 'start', 'ID_Aktiv');
$toInsert = array();

foreach($requiredFields as $field) {
    $toInsert[] = $_POST[$field];
}

$service = new activityService();
$message = $service->scheduleActivity($toInsert);
header("Location: ../../views/scheduler_views/schedule_activities.php");
