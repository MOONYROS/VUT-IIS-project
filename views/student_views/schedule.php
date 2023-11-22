<?php

require_once "../../common.php";
require_once "../../controllers/activity_controllers/schedule_controller.php";

make_header("Anotace");
?>

<h2>Rozvrh studenta: <?= getStudentName(); ?></h2>

<form action="/controllers/activity_controllers/schedule_controller.php" method="get">
    <label for="day">Den:</label>
    <select id="day" name="day">
        <option value="tyden" selected>Celý týden</option>
        <option value="pondeli">Pondělí</option>
        <option value="utery">Úterý</option>
        <option value="streda">Středa</option>
        <option value="ctvrtek">Čtvrtek</option>
        <option value="patek">Pátek</option>
    </select>
    <input type="submit" value="Potvrdit">
</form>

<?php
make_footer();
?>