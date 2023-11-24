<?php

require_once "../../services/subject_service.php";
require_once "../../common.php";
require_once "../../controllers/subject_controllers/subject_load.php";

make_header("Správa předmětů");

$subjectService = new subjectService();
$garantedSubjects = $subjectService->getGarantedSubjects($_SESSION["user_id"]);

echo toMainPage();

if (!$garantedSubjects) {
    echo "<p>" . "Nejste garantem žádného předmětu." . "</p>";
}
else { ?>
    <table>
        <tr>
            <th>Zkratka</th>
            <th>Název</th>
            <th>Počet kreditů</th>
            <th>Zakončení</th>
            <th>Garant</th>
        </tr>
        <?php
        foreach($garantedSubjects as $subject) {
            echo '<tr>' . loadSubject($subject["zkratka"], "teacher") . '</tr>';
        }
        ?>
    </table>
<?php }
make_footer();
?>