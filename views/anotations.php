<?php

require_once "../common.php";
require_once "../services/subject_service.php";

make_header("Anotace");
?>

<a class='direct_link' href='../index.php'>Zpět k přihlášení</a>

<h1>Prohlizeni anotaci predmetu</h1>

<?php

$subjectService = new subjectService();
$subjectIDs = $subjectService->getSubjectIDs();

foreach ($subjectIDs as $subject) {
    $subject = $subjectService->getSubjectInfo($subject);
    echo '<div class="group"><h2>' . $subject['nazev'] . ' (' . $subject['zkratka'] . ')</h2>';
    echo '<p>'. $subject['anotace'] .'</p></div>';
}

make_footer();
?>
