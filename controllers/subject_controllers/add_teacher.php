<?php

require_once "../../services/subject_service.php";

$subjectService = new subjectService();
$message = $subjectService->addTeacher($_POST["subjectId"], $_POST["teacherId"]);

$subjectId = $_POST["subjectId"];
if ($message == null) {
    // Shouldnt happen
    $message = "Chyba při vkládání do databáze.";
}
$message = urlencode($message);
header("Location: ../../views/subject_views/subject_info_teacher.php?message=$message&zkratka=$subjectId");
exit;