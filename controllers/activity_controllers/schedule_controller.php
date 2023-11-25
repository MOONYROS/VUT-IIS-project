<?php

require_once "../../services/user_service.php";
require_once "../../services/activity_service.php";

function loadUserActivities() {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getUserActivities($_SESSION["user_id"]);
    return getReturnString($activities);
}

function loadUserActivitiesDay($day) {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getUserActivitiesDay($_SESSION["user_id"], $day);
    return getReturnString($activities);
}

function getReturnString($activities): string
{
    $finalValue = "";
    foreach ($activities as $activity) {
        $finalValue = $finalValue . '<tr>';
        $activity["delka"] = $activity["start"] + $activity["delka"]; // Tohle je strasna prasarna
        foreach ($activity as $item) {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
        $finalValue = $finalValue . '</tr>';
    }
    return $finalValue;
}

function getStudentName(): string {
    $uzivatelServis = new userService();
    $person = $uzivatelServis->getUserInfo($_SESSION["user_id"]);
    return $person["jmeno"] . " " . $person["prijmeni"];
}

function loadTeacherActivities() {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivities($_SESSION["user_id"]);
    return getReturnString($activities);
}

function loadTeacherActivitiesDay($day) {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivitiesDay($_SESSION["user_id"], $day);
    return getReturnString($activities);
}