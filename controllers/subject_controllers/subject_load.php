<?php

require_once "../../services/subject_service.php";

function loadSubject($zkratka) {
    $subjectService = new subjectService();
    $subjectInfo = $subjectService->getSubjectInfo($zkratka);
    $finalValue = "";
    foreach ($subjectInfo as $item) {
        if ($finalValue == "") {
            $finalValue = '<td><a href="../../views/subject_views/subject_info.php?zkratka='. $item . '">' . $item. '</a></td>';
        }
        else {
            $finalValue = $finalValue . '<td>' . $item . '</td>';
        }
    }
    return $finalValue;
}

