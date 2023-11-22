<?php

function loadRoomDayActivities($room, $day): string {
    $activityService = new activityService();
    $activities = $activityService->getRoomDayActivity($room, $day);
    $finalValue = "";

    foreach ($activities as $activity) {
        $finalValue .= '<tr>
            <td>'. $activity['predmet'] .'</td>
            <td>'. $activity['typ'] .'</td>
            <td>'. $activity['start'] .'-'. $activity['start'] + $activity['delka'] .'</td>
            <td>'. $activity['opakovani'] .'</td>
            <td>'. $activity['pozadavek'] .'</td>
            </tr>';
    }

    return $finalValue;
}
