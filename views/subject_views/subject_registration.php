<?php

require_once "../../common.php";
require_once "../../controllers/subject_controllers/check_registered.php";
require_once "../../controllers/subject_controllers/subject_load.php";
require_once "../../services/subject_service.php";

make_header("Registrace předmetů");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<h1>
    Registrace předmětů
</h1>

<form action="../../controllers/subject_controllers/register_subjects.php" method="post">
    <?php
    $servis = new subjectService();
    $zkratky = $servis->getSubjectIDs();
    foreach($zkratky as $zkratka) {
        echo '<label id="registration" for="' . $zkratka . '">' . $zkratka . '</label>
              <input type="checkbox" id="' . $zkratka . '" name="' . $zkratka . '" value="'. $zkratka .'" '. checkRegistered($zkratka) .'><br>';
    }
    ?>
    <input type="submit" value="Potvrdit registraci">
</form>
<p> <?php if (isset($_GET["message"])) echo $_GET["message"]; ?><p>

<h2>
    Registrované předměty
</h2>

<table>
    <tr>
        <th>Zkratka</th>
        <th>Název</th>
        <th>Anotace</th>
        <th>Počet kreditů</th>
        <th>Typ ukončení</th>
    </tr>
    <?php
    global $registeredSubjects;
    foreach($registeredSubjects as $subject) {
        echo '<tr>' . loadSubject($subject, "student") . '</tr>';
    }
    ?>
</table>

<?php
make_footer();
?>
