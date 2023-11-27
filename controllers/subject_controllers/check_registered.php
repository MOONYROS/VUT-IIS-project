<?php

require_once "../../services/registration_service.php";

$registrationService = new registrationService();
$registeredSubjects = $registrationService->retrieveRegistered($_SESSION['user_id']);

/**
 * @brief Auxiliary function for html checkboxes, returns "checked for every subject that student has registered.
 *
 * @param string $zkratka Subject ID.
 * @return string "checked" if student has $zkratka already registered.
 */
function checkRegistered(string $zkratka): string
{
    global $registeredSubjects;
    if (in_array($zkratka, $registeredSubjects)) {
        return "checked";
    }
    else {
        return "";
    }
}
