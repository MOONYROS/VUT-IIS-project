<?php

require_once "../../common.php";
require_once "../../controllers/user_controllers/user_load.php";
require_once "../../services/user_service.php";

make_header("uprava osoby");

$userService = new userService();
$infoArray = $userService->getUserInfo($_GET["ID"]);
?>

<h2>Edit User: 
    <?php 
        if (isset($infoArray["jmeno"]) && isset($infoArray["prijmeni"]))
            echo $infoArray['jmeno'] . " " . $infoArray['prijmeni']; 
    ?>
</h2>

<form action="../../controllers/user_controllers/user_edit.php" method="post">
    <input type="hidden" name="ID_Osoba" value="<?php if (isset($infoArray["ID_Osoba"])) echo $infoArray['ID_Osoba']; ?>"/>

    <label for="jmeno">Jmeno</label>
    <input type="text" name="jmeno" value="<?php if (isset($infoArray["jmeno"])) echo $infoArray['jmeno']; ?>" id="jmeno"/>
    <br>

    <label for="prijmeni">Prijmeni</label>
    <input type="text" name="prijmeni" value="<?php if (isset($infoArray["prijmeni"])) echo $infoArray['prijmeni']; ?>" id="prijmeni"/>
    <br>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?php if (isset($infoArray["email"])) echo $infoArray['email']; ?>" id="email"/>
    <br>

    <label for="heslo">Heslo</label>
    <input type="password" name="heslo" value="<?php if (isset($infoArray["heslo"])) echo $infoArray['heslo']; ?>" id="heslo"/>
    <br>

    <label for="telefon">Telefon</label>
    <input type="tel" name="telefon" value="<?php if (isset($infoArray["telefon"])) echo $infoArray['telefon']; ?>" id="telefon"/>
    <br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="admi" <?php if (isset($infoArray["role"])) echo checkSelect("admi", $infoArray['role']) ?>>Admin</option>
        <option value="stud" <?php if (isset($infoArray["role"])) echo checkSelect("stud", $infoArray['role']) ?>>Student</option>
        <option value="vyuc" <?php if (isset($infoArray["role"])) echo checkSelect("vyuc", $infoArray['role']) ?>>Vyucujici</option>
        <option value="rozv" <?php if (isset($infoArray["role"])) echo checkSelect("rozv", $infoArray['role']) ?>>Rozvrhar</option>
        <option value="gara" <?php if (isset($infoArray["role"])) echo checkSelect("gara", $infoArray['role']) ?>>Garant</option>
    </select><br>

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../../controllers/user_controllers/user_delete.php" value="Smazat uzivatele">
</form>
