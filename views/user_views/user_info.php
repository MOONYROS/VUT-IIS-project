<?php

require_once "../../common.php";
require_once "../../controllers/user_controllers/user_load.php";
require_once "../../services/user_service.php";

make_header("Úprava osoby");

$userService = new userService();
$infoArray = $userService->getUserInfo($_GET["ID"]);
?>

<a class='direct_link' href='user_management.php'>Zpět k uživatelům</a>

<script>
    let fields = ['jmeno', 'prijmeni', 'email', 'heslo', 'telefon'];
</script>

<h2>Upravit uživatele:
    <?php 
        if (isset($infoArray["jmeno"]) && isset($infoArray["prijmeni"]))
            echo $infoArray['jmeno'] . " " . $infoArray['prijmeni']; 
    ?>
</h2>

<form action="../../controllers/user_controllers/user_edit.php" method="post" onsubmit="return validateForm(fields);">
    <input type="hidden" name="ID_Osoba" value="<?php if (isset($infoArray["ID_Osoba"])) echo $infoArray['ID_Osoba']; ?>">

    <label for="jmeno">Jméno</label>
    <input type="text" name="jmeno" value="<?php if (isset($infoArray["jmeno"])) echo $infoArray['jmeno']; ?>" id="jmeno">
    <br>

    <label for="prijmeni">Příjmení</label>
    <input type="text" name="prijmeni" value="<?php if (isset($infoArray["prijmeni"])) echo $infoArray['prijmeni']; ?>" id="prijmeni">
    <br>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?php if (isset($infoArray["email"])) echo $infoArray['email']; ?>" id="email">
    <br>

    <label for="heslo">Heslo</label>
    <input type="password" name="heslo" id="heslo">
    <br>

    <label for="telefon">Telefon</label>
    <input type="tel" name="telefon" value="<?php if (isset($infoArray["telefon"])) echo $infoArray['telefon']; ?>" id="telefon">
    <br>

    <label for="role">Role</label>
    <select id="role" name="role">
        <option value="admi" <?php if (isset($infoArray["role"])) echo checkSelect("admi", $infoArray['role']) ?>>Admin</option>
        <option value="stud" <?php if (isset($infoArray["role"])) echo checkSelect("stud", $infoArray['role']) ?>>Student</option>
        <option value="vyuc" <?php if (isset($infoArray["role"])) echo checkSelect("vyuc", $infoArray['role']) ?>>Vyučující</option>
        <option value="rozv" <?php if (isset($infoArray["role"])) echo checkSelect("rozv", $infoArray['role']) ?>>Rozvrhář</option>
    </select>
    <br>

    <input type="submit" value="Uložit změny">
    <input type="submit" formaction="../../controllers/user_controllers/user_delete.php" value="Smazat uzivatele" class="btnRemove2" id="deleteButton">
</form>

<?php
make_footer();
?>
