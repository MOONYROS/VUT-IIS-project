<?php

require_once "../../services/subject_service.php";

if (isset($_POST["zkratka"])) {
    $service = new subjectService();
    $message = $service->deleteSubject($_POST["zkratka"]);
    header("Location: ../../views/subject_views/subject_management_admin.php?message=$message");
}