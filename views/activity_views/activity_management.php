<?php

require_once "../../common.php";
require_once "../../controllers/activity_controllers/activity_load.php";
require_once "../../services/activity_service.php";
require_once "../../services/room_service.php";
require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

$userService = new userService();
$isAdmin = false;

if ($userService->getRole($_SESSION['user_id']) == 'admi') {
    $isAdmin = true;
}

$subjectService = new subjectService();

make_header("Správa výukových aktivit");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<script>
    let fields = ['delka', 'popis'];
</script>

<h1>
    Správa výukových aktivit
</h1>

<h2>
    Vytvořit výukovou aktivitu
</h2>

<form action="../../controllers/activity_controllers/activity_create.php" method="post" onsubmit="return validateForm(fields);">
    <label for="typ">Typ<?= requiredField(); ?></label>
    <select id="typ" name="typ">
        <option value="prednaska" selected>Přednáška</option>
        <option value="cviceni">Cvičení</option>
        <option value="zkouska">Zkouška</option>
    </select>
    <br>

    <label for="delka">Délka v hodinách<?= requiredField(); ?></label>
    <input type="number" name="delka" id="delka"><br>

    <label for="popis">Popis<?= requiredField(); ?></label>
    <textarea name="popis" id="popis"></textarea>
    <br>

    <label for="opakovani">Opakováni<?= requiredField(); ?></label>
    <select id="opakovani" name="opakovani">
        <option value="JR" selected>Jednorázově</option>
        <option value="KT">Každý týden</option>
        <option value="ST">Sudý týden</option>
        <option value="LT">Lichý týden</option>
    </select>
    <br>

    <label for="pozadavek">Požadavek</label>
    <textarea name="pozadavek" id="pozadavek"></textarea>
    <br>

    <label for="predmet">Předmět<?= requiredField(); ?></label>
    <select id="predmet" name="predmet">
        <?php
        if ($isAdmin) {
            $subjects = $subjectService->getSubjectIDs();
            foreach ($subjects as $subject) {
                echo "<option value='" . $subject . "'>" . $subject . "</option>";
            }
        }
        else {
            $subjects = $subjectService->getGarantedSubjects($_SESSION['user_id']);
            foreach ($subjects as $subject) {
                echo "<option value='" . $subject['zkratka'] . "'>" . $subject['zkratka'] . "</option>";
            }
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Přidat výukovou aktivitu">
</form>
<br>
<div>
    <?php
    if (isset($_GET["message"])) {
        echo $_GET["message"];
    }
    ?>
</div>

<h2>
    Tabulka výukových aktivit
</h2>

<div>
    <table>
        <tr>
            <th>Předmět</th>
            <th>Typ</th>
            <th>Vyučující</th>
            <th>Popis</th>
            <th>Opakování</th>
            <th>Den</th>
            <th>Start</th>
            <th>Délka</th>
            <th>Místnost</th>
            <th>Úprava</th>
        </tr>
        <?php
        $servis = new activityService();
        $activities = array();
        foreach ($subjects as $subject){
            if ($isAdmin) {
                $activities = $servis->getActivityIDs($subject);
                foreach($activities as $activity) {
                    echo '<tr>' . loadActivity($activity['ID_Aktiv']) . '</tr>';
                }
            }
            else {
                $activities = $servis->getActivityIDs($subject['zkratka']);
                foreach($activities as $activity) {
                    echo '<tr>' . loadActivity($activity['ID_Aktiv']) . '</tr>';
                }
            }
        }
        ?>
    </table>
</div>

<?php
make_footer();
?>
