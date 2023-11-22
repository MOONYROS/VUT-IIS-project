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

make_header("správa výukových aktitit");
?>

<?= toMainPage(); ?>

<h2>
    Přidat výukovou aktivitu
</h2>

<form action="../../controllers/activity_controllers/activity_create.php" method="post">
    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="prednaska" selected>Prednaska</option>
        <option value="cviceni">Cviceni</option>
        <option value="zkouska">Zkouska</option>
    </select>
    <br>

    <label for="delka">Delka v hodinach</label>
    <input type="number" name="delka" id="delka"><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"></textarea>
    <br>

    <label for="opakovani">Opakovani</label>
    <select id="opakovani" name="opakovani">
        <option value="JR" selected>Jednorazove</option>
        <option value="KT">Kazdy tyden</option>
        <option value="ST">Sudy tyden</option>
        <option value="LT">Lichy tyden</option>
    </select>
    <br>

    <label for="pozadavek">Pozadavek</label>
    <textarea name="pozadavek" id="pozadavek"></textarea>
    <br>

    <label for="predmet">Predmet</label>
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

    <input type="submit" value="Pridat vyukovou aktivitu">
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
    Správa výukových aktivit
</h2>

<div>
    <table>
        <tr>
            <th>ID</th>
            <th>Typ</th>
            <th>Delka</th>
            <th>Popis</th>
            <th>Pozadavek</th>
            <th>Opakovani</th>
            <th>Mistnost</th>
            <th>Predmet</th>
            <th>Start</th>
        </tr>
        <?php
        $servis = new activityService();
        $activities = array();
        foreach ($subjects as $subject){
            if ($isAdmin) {
                $activities = $servis->getActivityIDs($subject);
                foreach($activities as $activity) {
                    echo '<tr>' . loadActivity($activity) . '</tr>';
                }
            }
            else {
                $activities = $servis->getActivityIDs($subject['zkratka']);
                foreach($activities as $activity) {
                    echo '<tr>' . loadActivity($activity) . '</tr>';
                }
            }
        }
        ?>
    </table>
</div>