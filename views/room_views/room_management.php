<?php

require_once "../../common.php";
require_once "../../controllers/room_controllers/room_load.php";
require_once "../../services/room_service.php";

make_header("Správa místností");
?>

<script>
    let fields = ['ID_mist', 'kapacita', 'popis', 'umisteni'];
</script>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<h1>
    Správa místností
</h1>

<h2>
    Přidat místnost
</h2>

<form action="../../controllers/room_controllers/room_create.php" method="post" onsubmit=" return validateForm(fields)">
    <label for="ID_mist">Název<?= requiredField(); ?></label>
    <input type="text" name="ID_mist" id="ID_mist"><br>

    <label for="kapacita">Kapacita<?= requiredField(); ?></label>
    <input type="text" name="kapacita" id="kapacita"><br>

    <label for="typ">Typ<?= requiredField(); ?></label>
    <select id="typ" name="typ">
        <option value="poslucharna" selected>Posluchárna</option>
        <option value="studovna">Studovna</option>
        <option value="pracovna">Pracovna</option>
        <option value="chodba">Chodba</option>
    </select><br>

    <label for="popis">Popis<?= requiredField(); ?></label>
    <textarea name="popis" id="popis"></textarea><br>

    <label for="umisteni">Umístení<?= requiredField(); ?></label>
    <input type="text" name="umisteni" id="umisteni"><br>

    <input type="submit" value="Přidat místnost">
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
    Tabulka mísností
</h2>

<div>
    <table>
        <tr>
            <th>Název</th>
            <th>Kapacita</th>
            <th>Typ</th>
            <th>Popis</th>
            <th>Umístění</th>
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

<?php
make_footer();
?>
