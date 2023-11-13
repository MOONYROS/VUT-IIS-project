<?php
require_once "../controllers/load_subject.php";
require_once "../services/subject_service.php";
require_once "../common.php";

make_header("Info o predmetu");

function checkSelect($option, $to_check) {
    if ($option == $to_check)
        return "selected";
    else
        return "";
}

$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($_GET["zkratka"]);
?>

<h2>Edit Subject: <?= $infoArray['zkratka']; ?></h2>

<form>
    <label for="nazev">Nazev predmetu</label>
    <input type="text" value="<?= $infoArray['nazev']; ?>" id="nazev"/>
    <br>

    <label for="anotace">Anotace predmetu</label>
    <textarea name="anotace" id="anotace"><?= $infoArray['anotace']; ?></textarea>
    <br>

    <label for="pocet_kreditu">Nazev predmetu</label>
    <input type="number" value="<?= $infoArray['pocet_kreditu']; ?>" id="pocet_kreditu"/>
    <br>

    <label for="typ_ukonceni">Typ ukonceni</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" <?= checkSelect("za", $infoArray['typ_ukonceni']) ?>>zapocet</option>
        <option value="klza" <?= checkSelect("klza", $infoArray['typ_ukonceni']) ?>>kl zapocet</option>
        <option value="zk" <?= checkSelect("zk", $infoArray['typ_ukonceni']) ?>>zkouska</option>
        <option value="zazk" <?= checkSelect("zazk", $infoArray['typ_ukonceni']) ?>>zapocet zkouska</option>
    </select><br>
</form>