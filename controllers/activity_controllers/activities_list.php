<?php
require_once "../../services/activity_service.php";
require_once "../../services/user_service.php";
require_once "schedule_controller.php";

/**
 * @brief Get activities and make table row of each.
 *
 * @return string Table body with all activities.
 */
function listActivity(): string
{
    $activityService = new activityService();
    $activities = $activityService->getAllActivities();
    $finalValue = "";

    foreach ($activities as $activity) {
        $finalValue = $finalValue . '<tr>' . formatActivity($activity) . '</tr>';
    }
    return $finalValue;
}

/**
 * @brief Divide all activity fields and make table row out of it.
 *
 * @param array $activity Activity fields.
 * @return string Divided activity fields for one row of table.
 */
function formatActivity(array $activity): string
{
    $userService = new userService();

    $finalValue = "";

    $requiredFields = array('predmet', 'typ', 'delka', 'pozadavek', 'opakovani', 'mistnost', 'den', 'start', 'vyucujici');


    foreach ($requiredFields as $item) {
        if ($item == 'typ') {
            $activity[$item] = typeText($activity[$item]);
        }
        if ($item == 'opakovani') {
            $activity[$item] = repetitionText($activity[$item]);
        }

        if (($item == 'mistnost' or $item == 'start' or $item == 'den' or $item == 'vyucujici') and ($activity[$item] == null)) {
            $finalValue = $finalValue . '<td><b>' . "Nepřiřazeno" . '</b></td>';
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
