<?php

require_once "../../controllers/room_controllers/room_load.php";
require_once "../../common.php";
require_once "../../services/room_service.php";

make_header("Info o místnosti");

$roomService = new roomService();
$infoArray = $roomService->getRoomInfo($_GET["ID_mist"]);
?>

<script>
    let fields = ['kapacita', 'popis', 'umisteni'];
</script>

<a class='direct_link' href="room_management.php">Zpět k místnostem</a>

<h1>
    Úprava místnosti
</h1>

<h2>
    Místnost: <?php if (isset($infoArray["ID_mist"])) echo $infoArray['ID_mist']; ?>
</h2>

<form action="../../controllers/room_controllers/room_edit.php" method="post" onsubmit="return validateForm(fields)">
    <input type="hidden" name="ID_mist" value="<?php if (isset($infoArray["ID_mist"])) echo $infoArray['ID_mist']; ?>"/>

    <label for="kapacita">Kapacita<?= requiredField(); ?></label>
    <input type="number" name="kapacita" value="<?php if (isset($infoArray["kapacita"])) echo $infoArray['kapacita']; ?>" id="kapacita"/>
    <br>

    <label for="typ">Typ<?= requiredField(); ?></label>
    <select id="typ" name="typ">
        <option value="poslucharna" <?php if (isset($infoArray["typ"])) echo checkSelect("poslucharna", $infoArray['typ']) ?>>Poslucharna</option>
        <option value="studovna" <?php if (isset($infoArray["typ"])) echo checkSelect("studovna", $infoArray['typ']) ?>>Studovna</option>
        <option value="pracovna" <?php if (isset($infoArray["typ"])) echo checkSelect("pracovna", $infoArray['typ']) ?>>Pracovna</option>
        <option value="chodba" <?php if (isset($infoArray["typ"])) echo checkSelect("chodba", $infoArray['typ']) ?>>Chodba</option>
    </select><br>

    <label for="popis">Popis<?= requiredField(); ?></label>
    <textarea name="popis" id="popis"><?php if (isset($infoArray["popis"])) echo $infoArray['popis']; ?></textarea>
    <br>

    <label for="umisteni">Umístění<?= requiredField(); ?></label>
    <input type="text" name="umisteni" value="<?php if (isset($infoArray["umisteni"])) echo $infoArray['umisteni']; ?>" id="umisteni"/>
    <br>

    <input type="submit" value="Uložit změny">
    <input type="submit" formaction="../../controllers/room_controllers/room_delete.php" value="Smazat místnost" class="btnRemove2">
</form>

<?php
make_footer();
?>
