<?php
require_once "../../services/subject_service.php";

function listRequests($subject) {
    $subjectService = new subjectService();
    $requests = $subjectService->getRequestsBySubject($subject);
    $finalValue = '';

    foreach ($requests as $request) {
        $finalValue .= '<tr>
                        <td>' . $request['jmeno'] . '</td>
                        <td>' . $request['prijmeni'] . '</td>
                        <td>' . $request['zadost'] . '</td></tr>';
    }

    return $finalValue;
}
