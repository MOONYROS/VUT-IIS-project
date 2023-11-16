<?php
require_once "../services/user_service.php";
require_once "../services/registration_service.php";
require_once "../common.php";

$registrationService = new registrationService();

$old = $registrationService->retrieveRegistered($_SESSION['user_id']);
$new = $registrationService->newlyRegistered($_POST);

$final = $registrationService->unregisterSubject($old, $new);
$final = $registrationService->registerNewSubject($final, $new);

echo "Subjects successfully registered!";
