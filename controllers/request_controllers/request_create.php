<?php
require_once "../../services/subject_service.php";

if (isset($_POST['ID_Osoba']) and isset($_POST['zkratka']) and isset($_POST['zadost'])) {
    $subjectService = new subjectService();
    $subjectService->createRequest($_POST['ID_Osoba'], $_POST['zkratka'], $_POST['zadost']);
    header("Location: ../../views/request_views/request_management.php");
}
else {
    header("Location: ../../views/request_views/request_management.php?message=Nepodařilo se zpracovat zprávu");
}
