<?php

require_once "../../common.php";
require_once "../../controllers/activity_controllers/schedule_controller.php";

make_header("Zobrazit rozvrh");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<h1>
    Individuální rozvrh
</h1>

<h2>
    Rozvrh uživatele: <?= getStudentName(); ?>
</h2>

<form action="<?= $_SERVER["PHP_SELF"] ?>" method="get">
    <label for="day">Den:</label>
    <select id="day" name="day">
        <option value="tyden" <?= checkSelect($_GET["day"], "tyden"); ?> >Celý týden</option>
        <option value="po" <?= checkSelect($_GET["day"], "po"); ?>>Pondělí</option>
        <option value="ut" <?= checkSelect($_GET["day"], "ut"); ?>>Úterý</option>
        <option value="st" <?= checkSelect($_GET["day"], "st"); ?>>Středa</option>
        <option value="ct" <?= checkSelect($_GET["day"], "ct"); ?>>Čtvrtek</option>
        <option value="pa" <?= checkSelect($_GET["day"], "pa"); ?>>Pátek</option>
    </select>
    <input type="submit" value="Potvrdit">
</form>

<table>
    <tr>
        <th>Den</th>
        <th>Předmět</th>
        <th>Typ</th>
        <th>Od</th>
        <th>Do</th>
        <th>Místnost</th>
        <th>Opakování</th>
        <th>Vyučující</th>
    </tr>
<?php
if (isset($_GET["day"]) and $_GET["day"] != "tyden") {
    echo loadUserActivitiesDay($_GET["day"]);
}
else {
    echo loadUserActivities();
}
?>
</table>

<?php
make_footer();
?>

