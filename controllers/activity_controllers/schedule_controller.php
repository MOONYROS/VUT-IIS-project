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
    $uzivatelServis = new userService();
    foreach ($activities as $activity) {
        $info = $uzivatelServis->getUserInfo($activity["vyucujici"]);
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

function typeText($type) {
    return match ($type) {
        'cviceni' => 'Cvičení',
        'prednaska' => 'Přednáška',
        'zkouska' => 'Zkouška',
        default => $type,
    };
}

function repetitionText($rep) {
    return match ($rep) {
        'KT' => 'Každý týden',
        'ST' => 'Sudý týden',
        'LT' => 'Lichý týden',
        'JR' => 'Jednorázově',
        default => $rep,
    };
}

function getTeacherReturnString($activities): string
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

function getStudentName(): string {
    $uzivatelServis = new userService();
    $person = $uzivatelServis->getUserInfo($_SESSION["user_id"]);
    return $person["jmeno"] . " " . $person["prijmeni"];
}

function loadTeacherActivities() {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivities($_SESSION["user_id"]);
    return getTeacherReturnString($activities);
}

function loadTeacherActivitiesDay($day) {
    $aktivitaServis = new activityService();
    $activities = $aktivitaServis->getTeacherActivitiesDay($_SESSION["user_id"], $day);
    return getTeacherReturnString($activities);
}