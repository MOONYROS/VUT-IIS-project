<?php

require_once "../../services/activity_service.php";
require_once "../../services/user_service.php";
require_once "schedule_controller.php";

/**
 * @brief Get all activity fields from database and table row from it.
 *
 * @param string $ID Activity ID.
 * @return string Activity fields as table row items concatenated.
 */
function loadActivity(string $ID): string
{
    $activityService = new activityService();
    $activityInfo = $activityService->getActivityInfo($ID);

    $name = "";
    $surname = "";

    if ($activityInfo['vyucujici'] !== null) {
        $userService = new userService();
        $user = $userService->getUserInfo($activityInfo['vyucujici']);
        $name = $user['jmeno'];
        $surname = $user['prijmeni'];
    }

    return '<td>' . $activityInfo['predmet'] . '</td>' .
        '<td>' . typeText($activityInfo['typ']) . '</td>' .
        '<td>' . $name . " " . $surname . '</td>' .
        '<td>' . $activityInfo['popis'] . '</td>' .
        '<td>' . repetitionText($activityInfo['opakovani']) . '</td>' .
        '<td>' . $activityInfo['den'] . '</td>' .
        '<td>' . $activityInfo['start'] . '</td>' .
        '<td>' . $activityInfo['delka'] . '</td>' .
        '<td>' . $activityInfo['mistnost'] . '</td>' .
        '<td><a href="../../views/activity_views/activity_info.php?ID_Aktiv=' . $ID . '">Upravit</a></td>';
}
