<?php
require_once "../common.php";
require_once "../services/subject_service.php";

make_header("Anotace");
?>

<a href="../index.php">Zpet k prihlaseni</a>

<h1>Prohlizeni anotaci predmetu</h1>

<?php

$subjectService = new subjectService();
$subjectIDs = $subjectService->getSubjectIDs();

foreach ($subjectIDs as $subject) {
    $subject = $subjectService->getSubjectInfo($subject);
    echo '<h2>' . $subject['nazev'] . ' (' . $subject['zkratka'] . ')</h2>';
    echo '<p>'. $subject['anotace'] .'</p>';
}

make_footer();
