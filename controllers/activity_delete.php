<?php

require_once "../services/activity_service.php";

if (isset($_POST["ID_Aktiv"])) {
    $service = new activityService();
    $message = $service->deleteActivity($_POST["ID_Aktiv"]);
    header("Location: ../views/activity_management.php?message=$message");
}
