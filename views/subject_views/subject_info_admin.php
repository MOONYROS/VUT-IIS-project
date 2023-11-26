<?php

require_once "../../controllers/subject_controllers/subject_load.php";
require_once "../../common.php";
require_once "../../services/subject_service.php";
require_once "../../services/user_service.php";

make_header("Info o předmětu");

$subjectService = new subjectService();
$infoArray = $subjectService->getSubjectInfo($_GET["zkratka"]);
if (!$infoArray) {
    $infoArray = $subjectService->getSubjectInfoNoGarant($_GET["zkratka"]);
    $infoArray["garant"] = "Nemá garanta";
}
$teachers = $subjectService->getSubjectTeachers($_GET["zkratka"]);
?>

<script>
    let fields = ['nazev', 'anotace', 'pocet_kreditu'];
</script>

<a class='direct_link' href='subject_management_admin.php'>Zpět k předmětům</a>

<h1>
    Úprava předmětu
</h1>

<h2>
    Upravit předmět: <?= $infoArray['zkratka']; ?>
</h2>

<form action="../../controllers/subject_controllers/subject_edit.php" method="post" onsubmit="return validateForm(fields)">
    <input type="hidden" name="zkratka" value="<?= $infoArray['zkratka']; ?>"/>

    <label for="nazev">Název předmětu<?= requiredField(); ?></label>
    <input type="text" name="nazev" value="<?= $infoArray['nazev']; ?>" id="nazev"/>
    <br>

    <label for="anotace">Anotace předmětu<?= requiredField(); ?></label>
    <textarea name="anotace" id="anotace"><?= $infoArray['anotace']; ?></textarea>
    <br>

    <label for="pocet_kreditu">Počet kreditů<?= requiredField(); ?></label>
    <input type="number" name="pocet kreditu" value="<?= $infoArray['pocet_kreditu']; ?>" id="pocet_kreditu"/>
    <br>

    <label for="typ_ukonceni">Typ ukončení<?= requiredField(); ?></label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" <?= checkSelect("za", $infoArray['typ_ukonceni']) ?>>Zápočet</option>
        <option value="klza" <?= checkSelect("klza", $infoArray['typ_ukonceni']) ?>>Klasifikovaný zápočet</option>
        <option value="zk" <?= checkSelect("zk", $infoArray['typ_ukonceni']) ?>>Zkouška</option>
        <option value="zazk" <?= checkSelect("zazk", $infoArray['typ_ukonceni']) ?>>Zápočet zkouška</option>
    </select><br>

    <label for="garant">Garant<?= requiredField(); ?></label>
    <select name="garant" id="garant">
        <?php
        if ($infoArray["garant"] == "Nemá garanta") {
            echo '<option value="' . 'none' . '"' . ' selected' . '>' . 'Žádný' . '</option>';
        }
        $userService = new userService();
        $users = $userService->getUsersByRole("vyuc");
        foreach ($users as $user) {
            echo '<option value="' . $user['ID_Osoba'] . '"'. checkSelect($infoArray['garant'], $user['ID_Osoba']) .'>' . $user['jmeno'] . " " . $user['prijmeni'] . '</option>';
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Uložit změny">
    <input type="submit" formaction="../../controllers/subject_controllers/subject_delete.php" value="Odstranit předmět" class="btnRemove2">
</form>

<?php
    if (isset($_GET["message"]))
        echo "<br>{$_GET["message"]}";
?>

<h2>
    Karta předmětu
</h2>

<div class="group">
    <h2><?= $_GET["zkratka"] ?> (<?= $infoArray["nazev"] ?>)</h2>
    <p> <?= $infoArray["anotace"] ?> </p>
    <h3> Počet kreditů: <?= $infoArray["pocet_kreditu"] ?></h3>
    <h3> Typ ukončení: <?= $infoArray["typ_ukonceni"] ?></h3>
    <h3> Garant</h3>
    <p> <?php
        if (isset($infoArray["jmeno"])) echo "{$infoArray["jmeno"]} {$infoArray["prijmeni"]}";
        else echo "Předmět nemá garanta.";
        ?> </p>
    <h3> Vyučující</h3>
    <?php
    $finalValue = "";
    foreach ($teachers as $teacher) {
        $finalValue = $finalValue . "{$teacher["jmeno"]} {$teacher["prijmeni"]}<br>";
    }
    echo $finalValue;
    ?>
</div>

<?php
make_footer();
?>
