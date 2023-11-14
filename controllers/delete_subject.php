<?php

require_once "../services/subject_service.php";

echo "jsem tu";
if (isset($_POST["zkratka"])) {
    echo "jsem tu 2";
    $service = new subjectService();
    $service->deleteSubject($_POST["zkratka"]);
    header("Location: ../views/subject_management.php");
}