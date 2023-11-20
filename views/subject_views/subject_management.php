<?php

require_once "../../common.php";
require_once "../../services/user_service.php";
require_once "../../controllers/subject_controllers/subject_load.php";
require_once "../../services/subject_service.php";

make_header("tvorba predmetu");
?>

<?= toMainPage(); ?>

<h2>
   Vytvořit předmět
</h2>

<form action="../../controllers/subject_controllers/subject_create.php" method="post">
    <label for="nazev">Nazev</label>
    <input type="text" name="nazev" id="nazev"><br>

    <label for="zkratka">Zkratka</label>
    <input type="text" name="zkratka" id="zkratka"><br>

    <label for="anotace">Anotace</label>
    <textarea name="anotace" id="anotace"></textarea><br>

    <label for="pocet_kreditu">Pocet kreditu</label>
    <input type="number" name="pocet_kreditu" id="pocet_kreditu"><br>

    <label for="typ_ukonceni">Typ ukonceni</label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" selected>zapocet</option>
        <option value="klza">kl zapocet</option>
        <option value="zk">zkouska</option>
        <option value="zazk">zapocet zkouska</option>
    </select><br>

    <label for="garant">Garant</label>
    <select name="garant" id="garant">
        <?php
        $userService = new UserService();
        $users = $userService->getUsersByRole("vyuc");
        foreach ($users as $user) {
            echo '<option value="' . $user['ID_Osoba'] . '">' . $user['jmeno'] . " " . $user['prijmeni'] . '</option>';
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Vytvorit predmet">
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
   Správa předmětů
</h2>

<div>
    <table>
        <tr>
            <th>Zkratka</th>
            <th>Nazev</th>
            <th>Anotace</th>
            <th>Pocet kreditu</th>
            <th>Typ ukonceni</th>
            <th>ID Garanta</th>
        </tr>
        <?php
        $servis = new subjectService();
        $zkratky = $servis->getSubjectIDs();
        foreach($zkratky as $zkratka) {
            echo '<tr>' . loadSubject($zkratka) . '</tr>';
        }
        ?>
    </table>
</div>