<?php

require_once "../common.php";
require_once "../services/subject_service.php";

make_header("Anotace");
?>

<?= toSelectedPage('/../index.php', 'Zpět k přihlášení'); ?>

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
