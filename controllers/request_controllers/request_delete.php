<?php
require_once "../../services/subject_service.php";

if (isset($_POST['ID_Osoba']) and isset($_POST['zkratka'])) {
    $subjectService = new subjectService();
    $message = $subjectService->deleteRequest($_POST['ID_Osoba'], $_POST['zkratka']);
    header("Location: ../../views/request_views/request_management.php?message=$message");
}
else {
    header("Location: ../../views/request_views/request_management.php?message=Nepodařilo se odeslat požadavek pro smazání.");
}
