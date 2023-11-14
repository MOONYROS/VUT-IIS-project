<?php
require_once "../controllers/subject_load.php";
require_once "../services/subject_service.php";
require_once "../common.php";

make_header("Info o predmetu");

$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($_GET["zkratka"]);
?>

<h2>Edit Subject: <?php if (isset($infoArray["zkratka"])) echo $infoArray['zkratka']; ?></h2>

<form action="../controllers/subject_edit.php" method="post">
    <input type="hidden" name="zkratka" value="<?php if (isset($infoArray["zkratka"])) echo $infoArray['zkratka']; ?>"/>

    <label for="nazev">Nazev predmetu</label>
    <input type="text" name="nazev" value="<?php if (isset($infoArray["zkratka"])) echo $infoArray['zkratka']; ?>" id="nazev"/>
    <br>

    <label for="anotace">Anotace predmetu</label>
    <textarea name="anotace" id="anotace"><?php if (isset($infoArray["zkratka"])) echo $infoArray['zkratka']; ?></textarea>
    <br>

    <label for="pocet_kreditu">Pocet kreditu</label>
    <input type="number" name="pocet kreditu" value="<?php if (isset($infoArray["zkratka"])) echo $infoArray['zkratka']; ?>" id="pocet_kreditu"/>
    <br>

    <label for="typ_ukonceni">Typ ukonceni</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" <?php if (isset($_GET["typ_ukonceni"])) checkSelect("za", $infoArray['typ_ukonceni']) ?>>zapocet</option>
        <option value="klza" <?php if (isset($_GET["typ_ukonceni"])) checkSelect("za", $infoArray['typ_ukonceni']) ?>>kl zapocet</option>
        <option value="zk" <?php if (isset($_GET["typ_ukonceni"])) checkSelect("za", $infoArray['typ_ukonceni']) ?>>zkouska</option>
        <option value="zazk" <?php if (isset($_GET["typ_ukonceni"])) checkSelect("za", $infoArray['typ_ukonceni']) ?>>zapocet zkouska</option>
    </select><br>

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../controllers/subject_delete.php" value="Odstranit predmet">
</form>

