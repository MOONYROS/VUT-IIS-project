<?php

require_once "../../common.php";
require_once "../../services/user_service.php";
require_once "../../services/activity_service.php";

/**
 * @return string All user activities in html table rows.
 */
function loadUserActivities(): string
{
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getUserActivities($_SESSION["user_id"]);
    return getReturnString($activities);
}

/**
 * @param string $day Day within which will be searched for activities.
 * @return string All user activities within $day in html table rows.
 */
function loadUserActivitiesDay(string $day): string
{
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getUserActivitiesDay($_SESSION["user_id"], $day);
    return getReturnString($activities);
}

/**
 * @brief Takes all activity fields and puts them into an html table.
 *
 * @param array $activities Array of database activities.
 * @return string All html table rows containing fields of activities, concatenated.
 */
function getReturnString(array $activities): string
{
    $finalValue = "";
    $uzivatelServis = new userService();
    foreach ($activities as $activity) {
        try {
            $info = $uzivatelServis->getUserInfo($activity["vyucujici"]);
        }
        catch (TypeError) {
            $activity["vyucujici"] = null;
        }
        $activity["delka"] = $activity["start"] + $activity["delka"]; // Tohle je strasna prasarna

        $finalValue = $finalValue . '<tr>';
        if ($activity["vyucujici"] == null) {
            $activity["vyucujici"] = "Nepřiřazeno";
        }
        else {
            $activity["vyucujici"] = $info["jmeno"] . " " . $info["prijmeni"];
        }

        $activity["typ"] = typeText($activity["typ"]);
        $activity["opakovani"] = repetitionText($activity["opakovani"]);

        foreach ($activity as $item) {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
        $finalValue = $finalValue . '</tr>';
    }
    return $finalValue;
}

/**
 * @brief Map activity type from database to more readable format.
 *
 * @param string $type Type from database.
 * @return string Type in more readable form.
 */
function typeText(string $type): string
{
    return match ($type) {
        'cviceni' => 'Cvičení',
        'prednaska' => 'Přednáška',
        'zkouska' => 'Zkouška',
        default => $type,
    };
}

/**
 * @brief Map activity repetition from database to more readable format.
 *
 * @param string $rep Repetition from database.
 * @return string Repetition in more readable form.
 */
function repetitionText(string $rep): string
{
    return match ($rep) {
        'KT' => 'Každý týden',
        'ST' => 'Sudý týden',
        'LT' => 'Lichý týden',
        'JR' => 'Jednorázově',
        default => $rep,
    };
}

/**
 * @brief Takes all activity fields of teacher and puts them into an html table.
 *
 * @param array $activities Array of database activities.
 * @return string All html table rows containing fields of activities, concatenated.
 */
function getTeacherReturnString(array $activities): string
{
    $finalValue = "";
    foreach ($activities as $activity) {
        $finalValue = $finalValue . '<tr>';
        $activity["delka"] = $activity["start"] + $activity["delka"]; // Tohle je strasna prasarna

        $activity["typ"] = typeText($activity["typ"]);
        $activity["opakovani"] = repetitionText($activity["opakovani"]);

        foreach ($activity as $item) {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
        $finalValue = $finalValue . '</tr>';
    }
    return $finalValue;
}

/**
 * @brief Searches for user in database.
 * @return string Name and surname of user.
 */
function getStudentName(): string
{
    $uzivatelServis = new userService();
    $person = $uzivatelServis->getUserInfo($_SESSION["user_id"]);
    return $person["jmeno"] . " " . $person["prijmeni"];
}

/**
 * @return string All user activities in html table rows.
 */
function loadTeacherActivities(): string
{
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivities($_SESSION["user_id"]);
    return getTeacherReturnString($activities);
}

/**
 * @param string $day Day within which will be searched for activities.
 * @return string All teacher activities within specified $day in html table rows.
 */
function loadTeacherActivitiesDay(string $day): string
{
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivitiesDay($_SESSION["user_id"], $day);
    return getTeacherReturnString($activities);
}