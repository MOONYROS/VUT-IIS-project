<?php

/**
 * @brief Get activities in a room within specified day and make each activity an html table row.
 *
 * @param string $room Room ID.
 * @param string $day Day of the week.
 * @return string Html table rows with activity fields, concatenated.
 */
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
