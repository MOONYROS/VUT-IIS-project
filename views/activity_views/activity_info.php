<?php

require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../services/room_service.php";
require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

$subjectService = new subjectService();
$subjects = $subjectService->getGarantedSubjects($_SESSION['user_id']);

$roomService = new roomService();
$roomIDs = $roomService->getRoomIDs();

$activityService = new activityService();
$infoArray = $activityService->getActivityInfo($_GET["ID_Aktiv"]);

$isAdmin = false;

$userService = new userService();
if ($userService->getRole($_SESSION['user_id']) == 'admi') {
    $isAdmin = true;
}

make_header("Úprava výukové aktivity");

?>

<a class='direct_link' href="activity_management.php">Zpět k aktivitám</a>

<script>
    let fields = ['delka', 'popis'];
</script>

<h1>
    Úprava aktivity
</h1>

<h2>
    Upravit aktivitu: <?= $infoArray['typ'] . " " . $infoArray['predmet']; ?>
</h2>

<form action="../../controllers/activity_controllers/activity_edit.php" method="post" onsubmit="return validateForm(fields);">
    <input type="hidden" name="ID_Aktiv" value="<?php if (isset($infoArray["ID_Aktiv"])) echo $infoArray['ID_Aktiv']; ?>"/>

    <label for="typ">Typ<?= requiredField(); ?></label>
    <select id="typ" name="typ">
        <option value="prednaska" <?php if (isset($infoArray["typ"])) echo checkSelect("prednaska", $infoArray['typ']) ?>>Přednáška</option>
        <option value="cviceni" <?php if (isset($infoArray["typ"])) echo checkSelect("cviceni", $infoArray['typ']) ?>>Cvičení</option>
        <option value="zkouska" <?php if (isset($infoArray["typ"])) echo checkSelect("zkouska", $infoArray['typ']) ?>>Zkouška</option>
    </select><br>

    <label for="delka">Délka<?= requiredField(); ?></label>
    <input type="text" name="delka" value="<?php if (isset($infoArray["delka"])) echo $infoArray['delka']; ?>" id="delka"/>
    <br>

    <label for="popis">Popis<?= requiredField(); ?></label>
    <textarea name="popis" id="popis"><?php if (isset($infoArray["popis"])) echo $infoArray['popis']; ?></textarea>
    <br>

    <label for="opakovani">Opakování<?= requiredField(); ?></label>
    <select id="opakovani" name="opakovani">
        <option value="JR" <?php if (isset($infoArray["opakovani"])) echo checkSelect("JR", $infoArray['opakovani']) ?>>Jednorázově</option>
        <option value="KT" <?php if (isset($infoArray["opakovani"])) echo checkSelect("KT", $infoArray['opakovani']) ?>>Každý týden</option>
        <option value="ST" <?php if (isset($infoArray["opakovani"])) echo checkSelect("ST", $infoArray['opakovani']) ?>>Sudý týden</option>
        <option value="LT" <?php if (isset($infoArray["opakovani"])) echo checkSelect("LT", $infoArray['opakovani']) ?>>Lichý týden</option>
    </select><br>

    <label for="pozadavek">Požadavek</label>
    <textarea name="pozadavek" id="pozadavek"><?= $infoArray['pozadavek']; ?></textarea>
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

    <input type="submit" value="Uložit změny">
    <input type="submit" formaction="../../controllers/activity_controllers/activity_delete.php" value="Smazat výukovou aktivitu" class="btnRemove2">
</form>

<?php
make_footer();
?>
