<?php
require "../common.php";
make_header("správa místností");
?>

<h2>
    Přidat místnost
</h2>

<form action="../controllers/create_room.php" method="post">
    <label for="ID_mist">Nazev</label>
    <input type="text" name="ID_mist" id="ID_mist"><br>

    <label for="kapacita">Kapacita</label>
    <input type="text" name="kapacita" id="kapacita"><br>

    <label for="typ">Typ</label>
    <input type="text" name="typ" id="typ"><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"></textarea><br>

    <label for="umisteni">Umisteni</label>
    <input type="text" name="umisteni" id="umisteni"><br>

    <input type="submit" value="Pridat mistnost">
</form>