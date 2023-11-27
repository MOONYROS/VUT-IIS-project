<?php
require_once "../../services/subject_service.php";

/**
 * @brief Takes all teacher requests from database and makes html table from them.
 *
 * @param string $subject Subject ID.
 * @return string Table rows that include requests, concatenated.
 */
function listRequests(string $subject): string
{
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
