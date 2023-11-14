<?php
require_once "../controllers/subject_load.php";
require_once "../services/subject_service.php";
require_once "../common.php";

make_header("Info o predmetu");

$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($_GET["zkratka"]);
?>

<h2>Edit Subject: <?= $infoArray['zkratka']; ?></h2>

<form action="../controllers/subject_edit.php" method="post">
    <input type="hidden" name="zkratka" value="<?= $infoArray['zkratka']; ?>"/>

    <label for="nazev">Nazev predmetu</label>
    <input type="text" name="nazev" value="<?= $infoArray['nazev']; ?>" id="nazev"/>
    <br>

    <label for="anotace">Anotace predmetu</label>
    <textarea name="anotace" id="anotace"><?= $infoArray['anotace']; ?></textarea>
    <br>

    <label for="pocet_kreditu">Pocet kreditu</label>
    <input type="number" name="pocet kreditu" value="<?= $infoArray['pocet_kreditu']; ?>" id="pocet_kreditu"/>
    <br>

    <label for="typ_ukonceni">Typ ukonceni</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" <?= checkSelect("za", $infoArray['typ_ukonceni']) ?>>zapocet</option>
        <option value="klza" <?= checkSelect("klza", $infoArray['typ_ukonceni']) ?>>kl zapocet</option>
        <option value="zk" <?= checkSelect("zk", $infoArray['typ_ukonceni']) ?>>zkouska</option>
        <option value="zazk" <?= checkSelect("zazk", $infoArray['typ_ukonceni']) ?>>zapocet zkouska</option>
    </select><br>

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../controllers/subject_delete.php" value="Odstranit predmet">
</form>

