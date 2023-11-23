<?php
require_once "../../services/subject_service.php";

function listRequests() {
    $subjectService = new subjectService();
    $requests = $subjectService->getRequests();
    $finalValue = '';

    foreach ($requests as $request) {
        $finalValue .= '<tr><td>' . $request['zkratka'] . '</td>
                        <td>' . $request['jmeno'] . '</td>
                        <td>' . $request['prijmeni'] . '</td>
                        <td>' . $request['zadost'] . '</td></tr>';
    }

    return $finalValue;
}
