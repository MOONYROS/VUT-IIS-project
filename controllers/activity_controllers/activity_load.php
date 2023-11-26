<?php

require_once "../../services/activity_service.php";
require_once "schedule_controller.php";

function loadActivity($ID) {
    $activityService = new activityService();
    $activityInfo = $activityService->getActivityInfo($ID);
    $finalValue = "";
    foreach ($activityInfo as $item) {
        if ($finalValue == "") {
            $finalValue = '<td><a href="../../views/activity_views/activity_info.php?ID_Aktiv='. $item . '">' . $item. '</a></td>';
        }
        else {
            $item = typeText($item);
            $item = repetitionText($item);

            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }
    return $finalValue;
}
