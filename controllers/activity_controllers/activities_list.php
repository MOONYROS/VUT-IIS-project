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

    $requiredFields = array('predmet', 'typ', 'delka', 'pozadavek', 'opakovani', 'mistnost', 'den', 'start');


    foreach ($requiredFields as $item) {
        if (($item == 'mistnost' or $item == 'start' or $item == 'den') and ($activity[$item] == null)) {
                $finalValue = $finalValue . '<td><b>' . "Neprirazeno" . '</b></td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $activity[$item] . '</td>';
        }
    }
    return $finalValue . '<td><a href="../../views/scheduler_views/activity_scheduling.php?id=' . $activity['ID_Aktiv'] . '">Editovat</a></td>';
}
