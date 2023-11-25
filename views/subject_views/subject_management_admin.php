<?php

require_once "../../common.php";
require_once "../../services/user_service.php";
require_once "../../controllers/subject_controllers/subject_load.php";
require_once "../../services/subject_service.php";

make_header("Tvorba předmětu");
?>

<a class='direct_link' href='../main_page.php'>Zpět na hlavní obrazovku</a>

<script>
    let fields = ['nazev', 'zkratka', 'anotace', 'pocet_kreditu'];
</script>

<h2>
   Vytvořit předmět
</h2>

<form action="../../controllers/subject_controllers/subject_create.php" method="post" onsubmit="return validateForm(fields)">
    <label for="nazev">Název<?= requiredField(); ?></label>
    <input type="text" name="nazev" id="nazev"><br>

    <label for="zkratka">Zkratka<?= requiredField(); ?></label>
    <input type="text" name="zkratka" id="zkratka"><br>

    <label for="anotace">Anotace<?= requiredField(); ?></label>
    <textarea name="anotace" id="anotace"></textarea><br>

    <label for="pocet_kreditu">Počet kreditů<?= requiredField(); ?></label>
    <input type="number" name="pocet_kreditu" id="pocet_kreditu"><br>

    <label for="typ_ukonceni">Typ ukončení<?= requiredField(); ?></label>
    <select id="typ_ukonceni" name="typ_ukonceni">
        <option value="za" selected>Zápočet</option>
        <option value="klza">Klasifikovaný zápočet</option>
        <option value="zk">Zkouška</option>
        <option value="zazk">Zápočet zkouška</option>
    </select><br>

    <label for="garant">Garant<?= requiredField(); ?></label>
    <select name="garant" id="garant">
        <?php
        $userService = new userService();
        $users = $userService->getUsersByRole("vyuc");
        foreach ($users as $user) {
            echo '<option value="' . $user['ID_Osoba'] . '">' . $user['jmeno'] . " " . $user['prijmeni'] . '</option>';
        }
        ?>
    </select>
    <br>

    <input type="submit" value="Vytvořit předmět">
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
            <th>Název</th>
            <th>Počet kreditů</th>
            <th>Typ ukončení</th>
            <th>Garant</th>
        </tr>
        <?php
        $servis = new subjectService();
        $zkratky = $servis->getSubjectIDs();
        foreach($zkratky as $zkratka) {
            echo '<tr>' . loadSubject($zkratka, "admin") . '</tr>';
        }
        ?>
    </table>
</div>

<?php
make_footer();
?>
