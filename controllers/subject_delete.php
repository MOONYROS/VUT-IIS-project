<?php

require_once "../services/subject_service.php";

if (isset($_POST["zkratka"])) {
    $service = new subjectService();
    $service->deleteSubject($_POST["zkratka"]);
    header("Location: ../views/subject_management.php");
}