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

$userService = new UserService();
if ($userService->getRole($_SESSION['user_id']) == 'admi') {
    $isAdmin = true;
}

make_header("Info o vyukove aktivite");

?>

<h2>Edit activity: <?php if (isset($infoArray["ID_Aktiv"])) echo $infoArray['ID_Aktiv']; ?></h2>

<form action="../../controllers/activity_controllers/activity_edit.php" method="post">
    <input type="hidden" name="ID_Aktiv" value="<?php if (isset($infoArray["ID_Aktiv"])) echo $infoArray['ID_Aktiv']; ?>"/>

    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="prednaska" <?php if (isset($infoArray["typ"])) echo checkSelect("prednaska", $infoArray['typ']) ?>>Prednaska</option>
        <option value="cviceni" <?php if (isset($infoArray["typ"])) echo checkSelect("cviceni", $infoArray['typ']) ?>>Cviceni</option>
        <option value="zkouska" <?php if (isset($infoArray["typ"])) echo checkSelect("zkouska", $infoArray['typ']) ?>>Zkouska</option>
    </select><br>

    <label for="delka">Delka</label>
    <input type="text" name="delka" value="<?php if (isset($infoArray["delka"])) echo $infoArray['delka']; ?>" id="delka"/>
    <br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"><?php if (isset($infoArray["popis"])) echo $infoArray['popis']; ?></textarea>
    <br>

    <label for="opakovani">Opakovani</label>
    <select id="opakovani" name="opakovani">
        <option value="JR" <?php if (isset($infoArray["typ"])) echo checkSelect("JR", $infoArray['typ']) ?>>Jednorazove</option>
        <option value="KT" <?php if (isset($infoArray["typ"])) echo checkSelect("KT", $infoArray['typ']) ?>>Kazdy tyden</option>
        <option value="ST" <?php if (isset($infoArray["typ"])) echo checkSelect("ST", $infoArray['typ']) ?>>Sudy tyden</option>
        <option value="LT" <?php if (isset($infoArray["typ"])) echo checkSelect("LT", $infoArray['typ']) ?>>Lichy tyden</option>
    </select><br>

    <label for="mistnost">Mistnost</label>
    <select id="mistnost" name="mistnost">
        <?php
        foreach ($roomIDs as  $ID) {
            echo "<option value='$ID' " . checkSelect($ID, $infoArray['mistnost']) . ">$ID</option>";
        }
        ?>
    </select>
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

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../../controllers/activity_controllers/activity_delete.php" value="Smazat vyukovou aktivitu">
</form>