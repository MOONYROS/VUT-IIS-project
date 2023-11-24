<?php
require_once "../../services/activity_service.php";
require_once "../../services/user_service.php";




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
    $userService = new userService();

    $finalValue = "";

    $requiredFields = array('predmet', 'typ', 'delka', 'pozadavek', 'opakovani', 'mistnost', 'den', 'start', 'vyucujici');


    foreach ($requiredFields as $item) {
        if (($item == 'mistnost' or $item == 'start' or $item == 'den' or $item == 'vyucujici') and ($activity[$item] == null)) {
            $finalValue = $finalValue . '<td><b>' . "Neprirazeno" . '</b></td>';
        }
        elseif ($item == 'vyucujici' and $activity[$item] != null) {
            $user = $userService->getUserInfo($activity[$item]);
            $finalValue = $finalValue . '<td>' . $user['jmeno'] . " " . $user['prijmeni'] . '</td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $activity[$item] . '</td>';
        }
    }
    return $finalValue . '<td><a href="../../views/scheduler_views/activity_scheduling.php?id=' . $activity['ID_Aktiv'] . '">Editovat</a></td>';
}
