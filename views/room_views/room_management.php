<?php

require_once "../../common.php";
require_once "../../controllers/room_controllers/room_load.php";
require_once "../../services/room_service.php";

make_header("správa místností");
?>

<?= toMainPage(); ?>

<h2>
    Přidat místnost
</h2>

<form action="../../controllers/room_controllers/room_create.php" method="post">
    <label for="ID_mist">Nazev</label>
    <input type="text" name="ID_mist" id="ID_mist"><br>

    <label for="kapacita">Kapacita</label>
    <input type="text" name="kapacita" id="kapacita"><br>

    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="poslucharna" selected>Poslucharna</option>
        <option value="studovna">Studovna</option>
        <option value="pracovna">Pracovna</option>
        <option value="chodba">Chodba</option>
    </select><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"></textarea><br>

    <label for="umisteni">Umisteni</label>
    <input type="text" name="umisteni" id="umisteni"><br>

    <input type="submit" value="Pridat mistnost">
</form>
<br>
<div>
    <?php
        if (isset($_GET["message"])) {
            echo $_GET["message"];
        }
    ?>
</div>

<h2>
    Správa místností
</h2>

<div>
    <table>
        <tr>
            <th>Název</th>
            <th>Kapacita</th>
            <th>Typ</th>
            <th>Popis</th>
            <th>Umisteni</th>
        </tr>
        <?php

        $servis = new roomService();
        $rooms = $servis->getRoomIDs();
        foreach($rooms as $room) {
            echo '<tr>' . loadRoom($room) . '</tr>';
        }
        ?>
    </table>
</div>