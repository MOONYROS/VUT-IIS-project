<?php

require_once "../../common.php";
require_once "../../services/registration_service.php";

$registrationService = new registrationService();

$old = $registrationService->retrieveRegistered($_SESSION['user_id']);
$new = $registrationService->newlyRegistered($_POST);

$final = $registrationService->unregisterSubject($old, $new);
$final = $registrationService->registerNewSubject($final, $new);

$message = urlencode("Předměty úspěšně registrovány!");
header("Location: ../../views/subject_views/subject_registration.php?message=$message");
exit;
