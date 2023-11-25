<?php

require_once "../../common.php";
require_once "../../controllers/activity_controllers/schedule_controller.php";

make_header("Zobrazit rozvrh");
?>

<?= toMainPage(); ?>

<h2>Rozvrh studenta: <?= getStudentName(); ?></h2>

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
        <th>Predmet</th>
        <th>Typ</th>
        <th>Od</th>
        <th>Do</th>
        <th>Mistnost</th>
        <th>Opakovani</th>
        <th>Vyucujici</th>
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