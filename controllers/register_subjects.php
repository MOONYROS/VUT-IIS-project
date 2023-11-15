<?php
require_once "../services/user_service.php";
require_once "../services/registration_service.php";
require_once "../common.php";

//echo $_SESSION['user_id'];
$registrationService = new registrationService();
$predmety = "";

$old = $registrationService->retrieveRegistered($_SESSION['user_id']);
$new = $registrationService->newlyRegistered($_POST);

$final = $registrationService->unregisterSubject($old, $new);
$final = $registrationService->registerNewSubject($final, $new);

foreach ($final as $predmet) {
    $predmety = $predmety . $predmet;
}

echo $predmety;
