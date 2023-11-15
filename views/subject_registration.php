<?php
require "../common.php";
require_once "../controllers/check_registered.php";

make_header("Registrace predmetu");
?>

<?= toMainPage(); ?>

<h2>
    Registrace předmětů
</h2>

<form action="../controllers/register_subjects.php" method="post">
    <?php
    require_once "../services/subject_service.php";
    $servis = new subjectService();
    $zkratky = $servis->getSubjectIDs();
    foreach($zkratky as $zkratka) {
        echo '<label for="' . $zkratka . '">' . $zkratka . '</label>
              <input type="checkbox" id="' . $zkratka . '" name="' . $zkratka . '" value="'. $zkratka .'" '. checkRegistered($zkratka) .'><br>';
    }
    ?>
    <input type="submit" value="Potvrdit registraci">
</form>

<h2>
    Registrovane predmety
</h2>

<table>
    <tr>
        <th>Zkratka</th>
        <th>Nazev</th>
        <th>Anotace</th>
        <th>Pocet kreditu</th>
        <th>Typ ukonceni</th>
    </tr>
    <?php
    require "../controllers/subject_load.php";
    global $registeredSubjects;
    foreach($registeredSubjects as $subject) {
        echo '<tr>' . loadSubject($subject) . '</tr>';
    }
    ?>
</table>

