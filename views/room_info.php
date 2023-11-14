<?php
require_once "../controllers/load_room.php";
require_once "../services/room_service.php";
require_once "../common.php";

make_header("Info o mistnosti");

$roomService = new roomService();
$infoArray = $roomService->getRoomInfo($_GET["ID_mist"]);
?>

<h2>Edit room: <?= $infoArray['ID_mist']; ?></h2>

<form action="../controllers/room_edit.php" method="post">
    <input type="hidden" name="ID_mist" value="<?= $infoArray['ID_mist']; ?>"/>

    <label for="kapacita">Kapacita</label>
    <input type="text" name="kapacita" value="<?= $infoArray['kapacita']; ?>" id="kapacita"/>
    <br>

    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="poslucharna" <?= checkSelect("poslucharna", $infoArray['typ']) ?>>Poslucharna</option>
        <option value="studovna" <?= checkSelect("studovna", $infoArray['typ']) ?>>Studovna</option>
        <option value="pracovna" <?= checkSelect("pracovna", $infoArray['typ']) ?>>Pracovna</option>
        <option value="chodba" <?= checkSelect("chodba", $infoArray['typ']) ?>>Chodba</option>
    </select><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"><?= $infoArray['popis']; ?></textarea>
    <br>

    <label for="umisteni">Umisteni</label>
    <input type="text" name="umisteni" value="<?= $infoArray['umisteni']; ?>" id="umisteni"/>
    <br>

    <input type="submit" value="Ulozit zmeny">
</form>
