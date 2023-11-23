<?php

require_once "../../services/subject_service.php";

$subjectService = new subjectService();
$message = $subjectService->removeTeacher($_POST["subjectId"], $_POST["teacherId"]);

$subjectId = $_POST["subjectId"];
if ($message == null) {
    // Shouldnt happen
    $message = "Chyba při odstraňování z databáze.";
}
$message = urlencode($message);
header("Location: ../../views/subject_views/subject_info_teacher.php?message=$message&zkratka=$subjectId");
exit;