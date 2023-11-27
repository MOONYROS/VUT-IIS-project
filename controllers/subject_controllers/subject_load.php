<?php

require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

/**
 * @brief Load subject from database and make html table row from its fields based on provided user $role.'
 *
 * @param string $abbreviation Subject ID.
 * @param string $role User role in information system.
 * @return string Html table row with subject fields, concatenated.
 */
function loadSubject(string $abbreviation, string $role): string
{
    $subjectService = new subjectService();
    $subjectInfo = $subjectService->getSubjectInfo($abbreviation);
    if ($subjectInfo) {
        $subjectInfo = replaceIdWithName($subjectInfo);
    }
    else {
        $subjectInfo = $subjectService->getSubjectInfoNoGarant($abbreviation);
        unset($subjectInfo["anotace"]);
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
            $item = endingText($item);
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }

    return $finalValue;
}

/**
 * @brief Get path of subject information for different roles.
 * @param string $role User role.
 * @return string Relative path to view.
 */
function getViewPath(string $role): string
{
    return match ($role) {
        'admin' => "../../views/subject_views/subject_info_admin.php",
        'teacher' => "../../views/subject_views/subject_info_teacher.php",
        default => "../../views/subject_views/annotation.php",
    };
}

/**
 * @brief Auxiliary function for displaying subject garant information.
 * Replaces it's ID with name and surname.
 *
 * @param array $subjectInfo Array with subject fields from database.
 * @return array Changed subject information array.
 */
function replaceIdWithName(array $subjectInfo): array
{
    $subjectInfo["garant"] = $subjectInfo["jmeno"] . " " . $subjectInfo["prijmeni"];
    unset($subjectInfo["jmeno"]);
    unset($subjectInfo["prijmeni"]);
    unset($subjectInfo["anotace"]);
    return $subjectInfo;
}

/**
 * @brief Determines whether user is a teacher of any subject.
 *
 * @param string $teacherId Teacher ID.
 * @param array $teachers Array of all teachers from database.
 * @return bool
 */
function isTeacher(string $teacherId, array $teachers): bool
{
    foreach ($teachers as $teacher) {
        if ($teacherId == $teacher["ID_Osoba"]) {
            return true;
        }
    }
    return false;
}

/**
 * @brief Maps subject ending to a better-readable format.
 *
 * @param string $type Type from database.
 * @return string Type in better format for user.
 */
function endingText(string $type): string
{
    return match ($type) {
        'za' => 'Zápočet',
        'zazk' => 'Zápočet a zkouška',
        'zk' => 'Zkouška',
        'klza' => 'Klasifikovaný zápočet',
        default => $type,
    };
}