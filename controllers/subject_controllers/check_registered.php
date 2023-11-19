<?php

require_once "../../services/registration_service.php";

$registrationService = new registrationService();
$registeredSubjects = $registrationService->retrieveRegistered($_SESSION['user_id']);

function checkRegistered($zkratka): string {
    global $registeredSubjects;
    if (in_array($zkratka, $registeredSubjects)) {
        return "checked";
    }
    else {
        return "";
    }
}
