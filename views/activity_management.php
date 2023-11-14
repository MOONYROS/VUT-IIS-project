<?php
require "../common.php";
make_header("správa výukových aktitit");
?>

<h2>
    Přidat výukovou aktivitu
</h2>

<form action="../controllers/activity_create.php" method="post">
    <label for="typ">Typ</label>
    <select id="typ" name="typ">
        <option value="prednaska" selected>Prednaska</option>
        <option value="cviceni">Cviceni</option>
        <option value="zkouska">Zkouska</option>
    </select><br>

    <label for="delka">Delka</label>
    <input type="number" name="delka" id="delka"><br>

    <label for="popis">Popis</label>
    <textarea name="popis" id="popis"></textarea><br>

    <label for="opakovani">Opakovani</label>
    <select id="opakovani" name="opakovani">
        <option value="JR" selected>Jednorazove</option>
        <option value="KT">Kazdy tyden</option>
        <option value="ST">Sudy tyden</option>
        <option value="LT">Lichy tyden</option>
    </select><br>

    <label for="mistnost">Mistnost</label>
    <input type="text" name="mistnost" id="mistnost"><br>

    <label for="predmet">Predmet</label>
    <input type="text" name="predmet" id="predmet"><br>

    <input type="submit" value="Pridat vyukovou aktivitu">
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
    Správa výukových aktivit
</h2>

<div>
    <table>
        <tr>
            <th>ID</th>
            <th>Typ</th>
            <th>Delka</th>
            <th>Popis</th>
            <th>Opakovani</th>
            <th>Mistnost</th>
            <th>Predmet</th>
        </tr>
        <?php
        require_once "../services/activity_service.php";
        require "../controllers/activity_load.php";
        $servis = new activityService();
        $activities = $servis->getActivityIDs();
        foreach($activities as $activity) {
            echo '<tr>' . loadActivity($activity) . '</tr>';
        }
        ?>
    </table>
</div>