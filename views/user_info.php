<?php
require_once "../common.php";
require_once "../controllers/user_load.php";
require_once "../services/user_service.php";

make_header("uprava osoby");

$userService = new UserService();
$infoArray = $userService->getUserInfo($_GET["ID"]);
?>

<h2>Edit User: <?= $infoArray['jmeno'] . " " . $infoArray['prijmeni']; ?></h2>

<form action="../controllers/user_edit.php" method="post">
    <input type="hidden" name="ID_Osoba" value="<?= $infoArray['ID_Osoba']; ?>"/>
    <input type="hidden" name="heslo" value="<?= $infoArray['heslo']; ?>"/>

    <label for="jmeno">Jmeno</label>
    <input type="text" name="jmeno" value="<?= $infoArray['jmeno']; ?>" id="jmeno"/>
    <br>

    <label for="prijmeni">Prijmeni</label>
    <input type="text" name="prijmeni" value="<?= $infoArray['prijmeni']; ?>" id="prijmeni"/>
    <br>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?= $infoArray['email']; ?>" id="email"/>
    <br>

    <label for="telefon">Telefon</label>
    <input type="tel" name="telefon" value="<?= $infoArray['telefon']; ?>" id="telefon"/>
    <br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="admi" <?= checkSelect("admi", $infoArray['role']) ?>>Admin</option>
        <option value="stud" <?= checkSelect("stud", $infoArray['role']) ?>>Student</option>
        <option value="vyuc" <?= checkSelect("vyuc", $infoArray['role']) ?>>Vyucujici</option>
        <option value="rozv" <?= checkSelect("rozv", $infoArray['role']) ?>>Rozvrhar</option>
        <option value="gara" <?= checkSelect("gara", $infoArray['role']) ?>>Garant</option>
    </select><br>

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../controllers/user_delete.php" value="Smazat uzivatele">
</form>
