<?php

require_once "../services/activity_service.php";


function loadActivity($ID) {
    $activityService = new activityService();
    $activityInfo = $activityService->getActivityInfo($ID);
    $finalValue = "";
    foreach ($activityInfo as $item) {
        if ($finalValue == "") {
            $finalValue = '<td><a href="../views/activity_info.php?ID_Aktiv='. $item . '">' . $item. '</a></td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }
    return $finalValue;
}
