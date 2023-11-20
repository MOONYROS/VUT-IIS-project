<?php

require_once "../../controllers/room_controllers/room_load.php";
require_once "../../common.php";
require_once "../../services/room_service.php";

make_header("Info o mistnosti");

$roomService = new roomService();
$infoArray = $roomService->getRoomInfo($_GET["ID_mist"]);
?>

<h2>Edit room: <?php if (isset($infoArray["ID_mist"])) echo $infoArray['ID_mist']; ?></h2>

<form action="../../controllers/room_controllers/room_edit.php" method="post">
    <input type="hidden" name="ID_mist" value="<?php if (isset($infoArray["ID_mist"])) echo $infoArray['ID_mist']; ?>"/>

    <label for="kapacita">Kapacita</label>
    <input type="text" name="kapacita" value="<?php if (isset($infoArray["kapacita"])) echo $infoArray['kapacita']; ?>" id="kapacita"/>
    <br>

    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="poslucharna" <?php if (isset($infoArray["typ"])) echo checkSelect("poslucharna", $infoArray['typ']) ?>>Poslucharna</option>
        <option value="studovna" <?php if (isset($infoArray["typ"])) echo checkSelect("studovna", $infoArray['typ']) ?>>Studovna</option>
        <option value="pracovna" <?php if (isset($infoArray["typ"])) echo checkSelect("pracovna", $infoArray['typ']) ?>>Pracovna</option>
        <option value="chodba" <?php if (isset($infoArray["typ"])) echo checkSelect("chodba", $infoArray['typ']) ?>>Chodba</option>
    </select><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"><?php if (isset($infoArray["popis"])) echo $infoArray['popis']; ?></textarea>
    <br>

    <label for="umisteni">Umisteni</label>
    <input type="text" name="umisteni" value="<?php if (isset($infoArray["umisteni"])) echo $infoArray['umisteni']; ?>" id="umisteni"/>
    <br>

    <input type="submit" value="Ulozit zmeny">
    <input type="submit" formaction="../../controllers/room_controllers/room_delete.php" value="Smazat mistnost">
</form>