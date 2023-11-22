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

<script src="../../controllers/scheduler_controllers/activity_save_form_values.js"></script>

<!-- THIS PART OF CODE IS CREATED DUE TO TRANSFER TO JAVASCRIPT-->
<input type="hidden" id="tryMistnost" value="<?= isset($activity['mistnost']) ? $activity['mistnost'] : ''; ?>">
<input type="hidden" id="tryDen" value="<?= isset($activity['den']) ? $activity['den'] : ''; ?>">
<input type="hidden" id="tryStart" value="<?= isset($activity['start']) ? $activity['start'] : ''; ?>">

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
            echo '<option value="'. $room .'"' . checkSelect($room, $activity['mistnost']) . '>' . $room .'</option>';
        }
        ?>
    </select>
    <br>

    <label for="den">Den</label>
    <select name="den" id="den">
        <option value="PO" <?= checkSelect("PO", $activity['den']) ?>>Pondělí</option>
        <option value="UT" <?= checkSelect("UT", $activity['den']) ?>>Úterý</option>
        <option value="ST" <?= checkSelect("ST", $activity['den']) ?>>Středa</option>
        <option value="CT" <?= checkSelect("CT", $activity['den']) ?>>Čtvrtek</option>
        <option value="PA" <?= checkSelect("PA", $activity['den']) ?>>Pátek</option>
    </select>
    <br>

    <label for="start">Začátek</label>
    <input type="number" min="8" max="20" name="start" id="start" value="<?php if (isset($activity['start'])) {echo $activity['start'];}  ?>" />
    <br>

    <input type="submit" value="Potvrdit" />
</form>

<h2>
    Rozvrh místností a dnů
</h2>

<form method="post" onclick="saveFormValues()">
    <label for="selectedRoom">Místnost:</label>
    <select name="selectedRoom" id="selectedRoom">
        <?php foreach ($rooms as $room) {
            if (isset($_POST['selectedRoom'])) {
                echo '<option value="'. $room .'"' . checkSelect($room, $_POST['selectedRoom']) . '>' . $room .'</option>';
            }
            else {
                echo '<option value="'. $room .'">' . $room .'</option>';
            }
        } ?>
    </select>

    <label for="selectedDay">Den:</label>
    <select name="selectedDay" id="selectedDay">
        <option value="PO" <?php if (isset($_POST['selectedDay'])) echo checkSelect("PO", $_POST['selectedDay']); ?>>Pondělí</option>
        <option value="UT" <?php if (isset($_POST['selectedDay'])) echo checkSelect("UT", $_POST['selectedDay']); ?>>Úterý</option>
        <option value="ST" <?php if (isset($_POST['selectedDay'])) echo checkSelect("ST", $_POST['selectedDay']); ?>>Středa</option>
        <option value="CT" <?php if (isset($_POST['selectedDay'])) echo checkSelect("CT", $_POST['selectedDay']); ?>>Čtvrtek</option>
        <option value="PA" <?php if (isset($_POST['selectedDay'])) echo checkSelect("PA", $_POST['selectedDay']); ?>>Pátek</option>
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
