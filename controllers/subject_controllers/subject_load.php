<?php

require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

function loadSubject($abbreviation, $role) {
    $subjectService = new subjectService();
    $subjectInfo = $subjectService->getSubjectInfo($abbreviation);
    if ($subjectInfo) {
        $subjectInfo = replaceIdWithName($subjectInfo);
    }
    else {
        $subjectInfo = $subjectService->getSubjectInfoNoGarant($abbreviation);
        $subjectInfo["garant"] = "Nemá garanta";
    }

    $finalValue = "";
    foreach ($subjectInfo as $item) {
        $viewPath = getViewPath($role);
        if ($finalValue == "") {
            $link = '<a href="' . $viewPath . '?zkratka=' . $item . '">' . $item . '</a>';
            $finalValue = $finalValue . '<td>' . $link . '</td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }

    return $finalValue;
}

function getViewPath($role) {
    return match ($role) {
        'admin' => "../../views/subject_views/subject_info_admin.php",
        'teacher' => "../../views/subject_views/subject_info_teacher.php",
        default => "../../views/subject_views/annotation.php",
    };
}

function replaceIdWithName($subjectInfo) {
    $subjectInfo["garant"] = $subjectInfo["jmeno"] . " " . $subjectInfo["prijmeni"];
    unset($subjectInfo["jmeno"]);
    unset($subjectInfo["prijmeni"]);
    unset($subjectInfo["anotace"]);
    return $subjectInfo;
}

function isTeacher($teacherId, $teachers) {
    foreach ($teachers as $teacher) {
        if ($teacherId == $teacher["ID_Osoba"]) {
            return true;
        }
    }
    return false;
}