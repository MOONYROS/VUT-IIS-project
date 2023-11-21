<?php
require_once "../../services/activity_service.php";

function listActivity() {
    $activityService = new activityService();
    $activities = $activityService->getAllActivities();
    $finalValue = "";

    foreach($activities as $activity) {
        $finalValue = $finalValue . '<tr>' . formatActivity($activity) . '</tr>';
    }
    return $finalValue;
}

function formatActivity($activity) {
    $finalValue = "";

    $requiredFields = array('predmet', 'typ', 'delka', 'pozadavek', 'opakovani', 'mistnost', 'start');


    foreach ($requiredFields as $item) {
        if ($item == 'mistnost' or $item == 'start') {
            $finalValue = $finalValue . '<td><b>' . "Neprirazeno" . '</b></td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $activity[$item] . '</td>';
        }
    }
    return $finalValue;
}
