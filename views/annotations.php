<?php

require_once "../common.php";
require_once "../services/subject_service.php";

make_header("Anotace");
?>

<a class='direct_link' href='../index.php'>Zpět k přihlášení</a>

<h1>Prohlížení anotací předmětů</h1>

<?php

$subjectService = new subjectService();
$subjectIDs = $subjectService->getSubjectIDs();

foreach ($subjectIDs as $subject) {
    $subjectInfo = $subjectService->getSubjectInfo($subject);
    if (!$subjectInfo) {
        $subjectInfo = $subjectService->getSubjectInfoNoGarant($subject);
    }
    echo '<div class="group"><h2>' . $subjectInfo['nazev'] . ' (' . $subjectInfo['zkratka'] . ')</h2>';
    echo '<p>'. $subjectInfo['anotace'] .'</p></div>';
}

make_footer();
?>
