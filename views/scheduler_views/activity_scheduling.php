<?php

require_once "../../common.php";
require_once "../../services/activity_service.php";
require_once "../../services/room_service.php";
require_once "../../controllers/scheduler_controllers/activity_load_specific.php";

make_header("Zaradit vyukovou aktivitu.");

$activityService = new activityService();
$activity = $activityService->getActivityInfo($_GET['id']);

$roomService = new roomService();
$rooms = $roomService->getRoomIDs();

?>

<h1>
    Zařadit výukovou aktivitu
</h1>

<h2>
    Vybraná výuková aktivita
</h2>

<h3>
    <?= $activity['predmet'] ?> <?= $activity['typ'] ?>
</h3>

<ul>
    <li><b>Delka:</b> <?= $activity['delka']?> hodiny</li>
    <li><b>Opakovani:</b> <?= $activity['opakovani']?></li>
    <li><b>Pozadavek:</b>
        <br>
        <?= $activity['pozadavek']?>
    </li>
</ul>

<form action="../../controllers/scheduler_controllers/activity_schedule.php" method="post">

    <input type="hidden" name="ID_Aktiv" value="<?= $_GET['id'] ?>"/>

    <label for="mistnost">Mistnost</label>
    <select name="mistnost" id="mistnost">
        <?php
        foreach ($rooms as $room) {
            echo '<option value="'. $room .'">' . $room .'</option>';
        }
        ?>
    </select>
    <br>

    <label for="den">Den</label>
    <select name="den" id="den">
        <option value="PO">Pondělí</option>
        <option value="UT">Úterý</option>
        <option value="ST">Středa</option>
        <option value="CT">Čtvrtek</option>
        <option value="PA">Pátek</option>
    </select>
    <br>

    <label for="start">Začátek</label>
    <input type="number" min="8" max="20" name="start" id="start" />
    <br>

    <input type="submit" value="Potvrdit" />
</form>

<h2>
    Rozvrh místností a dnů
</h2>

<form method="post">
    <label for="selectedRoom">Místnost:</label>
    <select name="selectedRoom" id="selectedRoom">
        <?php foreach ($rooms as $room) {
            echo '<option value="'. $room .'">' . $room .'</option>';
        } ?>
    </select>

    <label for="selectedDay">Den:</label>
    <select name="selectedDay" id="selectedDay">
        <option value="PO">Pondělí</option>
        <option value="UT">Úterý</option>
        <option value="ST">Středa</option>
        <option value="CT">Čtvrtek</option>
        <option value="PA">Pátek</option>
    </select>

    <input type="submit" name="submit" value="Zobrazit rozvrh" />
</form>

<?php
if (isset($_POST['submit'])) { ?>
    <table>
        <tr>
            <th>Předmět</th>
            <th>Typ</th>
            <th>Od-do</th>
            <th>Opakování</th>
            <th>Požadavek</th>
        </tr>
    <?php
    echo loadRoomDayActivities($_POST['selectedRoom'], $_POST['selectedDay']);
} ?>
    </table>

<?php
make_footer();
